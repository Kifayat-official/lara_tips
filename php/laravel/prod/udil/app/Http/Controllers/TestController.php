<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MdcTestSession;
use App\MdcTestStatus;
use App\Meter;
use Illuminate\Support\Facades\Storage;
use App\Test;
use DB;
use Webpatser\Uuid\Uuid;
use TreeWalker;

class TestController extends Controller
{
    public function showTests($mdc_test_session_id)
    {
        $mdc_test_session = MdcTestSession::with([
            'company',
            'meters',
            'readCommunicationProfile',
            'writeCommunicationProfile',
            'testProfile.tests.testGroup'
        ])->find($mdc_test_session_id);

        if ($mdc_test_session == null) {
            abort(404, 'Test session not found');
        }

        $tests = $mdc_test_session->testProfile->tests()->orderBy('order', 'asc')->get();

        return view('tests.tests', compact('mdc_test_session', 'tests'));
    }

    public function setTestStatus()
    {
        request()->validate([
            'status' => 'required',
            'attachment' => 'mimes:jpeg,bmp,png,gif,svg,pdf|file|max:2048'
        ]);

        $mdc_test_status_id = request()->mdc_test_status_id;
        $mdc_test_status = MdcTestStatus::find($mdc_test_status_id);
        $mdc_test_status->is_pass = request()->status == 'pass' ? 1 : 0;
        $mdc_test_status->remarks = request()->remarks == '' ? null : request()->remarks;

        if( $mdc_test_status->is_pass == 0){
            if (request()->has('attachment')) {

                $file_path = 'test_status_attachments';
                $file = request()->file('attachment');
                $new_name = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/' . $file_path, $new_name, 'uploads');
                $mdc_test_status->attachment = $file_path.'/'.$new_name;
            }
        }else{
            $mdc_test_status->attachment= null;
        }
        $mdc_test_status->save();

        return ['success' => true, 'message' => 'Status updated successfully'];
    }

    public function startTest()
    {
        if(request()->test_id == 'dfad3200-63a3-11ea-bffe-5befb22f361a')
        {
            $current_row = DB::table('meters')->where('mdc_test_session_id',request()->mdc_test_session_id)->get()->toArray();
            foreach($current_row as $curr)
            {
                DB::table('meters')->where('mdc_test_session_id',request()->mdc_test_session_id)
                ->update(
                    ['comm_interval' => request()->communication_interval,
                     'device_type' => request()->device_type,
                     'mdi_reset_date' => request()->mdi_reset_date,
                     'mdi_reset_time' => request()->mdi_reset_time,
                     'sim_number' => request()->sim_number,
                     'sim_id' => request()->sim_id,
                     'phase' => request()->phase,
                     'meter_type' => request()->meter_type,
                     'comm_mode' => request()->communication_mode,
                     'comm_type' => request()->communication_type,
                     'initial_communication_time' => request()->initial_communication_time,
                     'bidirectional_device' => request()->bidirectional_device

                    ]
                );
            }
        }
        $test_id = request()->test_id;
        $mdc_test_session_id = request()->mdc_test_session_id;

        $mdc_test_status = MdcTestStatus::where('test_id', $test_id)
            ->where('mdc_test_session_id', $mdc_test_session_id)
            ->first();

        if ($mdc_test_status == null) {
            $mdc_test_status = new MdcTestStatus();
            $mdc_test_status->test_id = $test_id;
            $mdc_test_status->mdc_test_session_id = $mdc_test_session_id;
            $mdc_test_status->save();
        }

        $test = Test::find($test_id);        
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);

        $is_transaction_status_read_test = $test->idt == 'transaction_status_read';
        if ($is_transaction_status_read_test) {
            return $this->startTransactionStatusReadTest($mdc_test_session, $test, $mdc_test_status);
        }

        if ($test->testType->idt == 'read')  // read tests can DB based or API based
        {
            return $this->startReadTest($mdc_test_session, $test, $mdc_test_status);
        } else    // write tests and on-demand tests are API based
        {
            return $this->startWriteTest($mdc_test_session, $test, $mdc_test_status);
        }
    }

    public function startTransactionStatusReadTest($mdc_test_session, $test, $mdc_test_status)
    {
        try {
            $transaction_id = request()->header['transactionid'];

            $transactionStatusController = new \App\Http\Controllers\TransactionStatusController();
            $data = $transactionStatusController->getTransactionStatus($transaction_id, $mdc_test_session->id, $test->id);

            if ($data['transaction_status_api_response'] != null) {
                $response_array = $data['transaction_status_api_response'];
                $jsonApiResponseValidity = $this->checkJsonApiResponse($response_array, $test);
                $mdc_test_status->remarks = $jsonApiResponseValidity['remarks'];
                $mdc_test_status->is_pass = $jsonApiResponseValidity['is_valid'];
                $mdc_test_status->save();

                return [
                    'success' => $jsonApiResponseValidity['is_valid'],
                    'show_pass_fail_buttons' => $jsonApiResponseValidity['is_valid'],
                    'transactionid' => isset($response_array['transactionid']) ? $response_array['transactionid'] : '',
                    'data' => null,
                    'api_data' => $response_array, //$response_obj,
                    'mdc_test_status' => $mdc_test_status,
                ];
            }

            return [
                'success' => true,
                'show_pass_fail_buttons' => true,
                'data' => $data['transaction_status_table_data'],
                'api_data' => $data['transaction_status_api_response'],
                'mdc_test_status' => $mdc_test_status,
            ];
        } catch (\Exception $ex) {
            $mdc_test_status->remarks = $ex->getMessage();
            $mdc_test_status->save();
            return [
                'success' => false,
                'show_pass_fail_buttons' => false,
                'api_data' => null,
                'mdc_test_status' => $mdc_test_status,
            ];
        }
    }

    public function startWriteTest($mdc_test_session, $test, $mdc_test_status)
    {
        // on-demand and write tests are API based
        if ($mdc_test_session->writeCommunicationProfile->communicationProfileType->idt == 'rest') {
            try {

                    if($test->idt == 'create_device_meter')
                    {
                        foreach(request()->device_identity as $device)
                        {
                            foreach($device as $key=>$value)
                            {
                                if($key == 'dsn'){
                                    $msn = $value;
                                }
                                if($key == 'global_device_id')
                                {
                                    $global_device=$value;
                                }

                            }
                            \App\Meter::where('mdc_test_session_id',$mdc_test_session->id)
                                        ->where('msn',$msn)->update([
                                            'global_device_id' =>  $global_device
                                         ]);
                        }
                    }

                    if($test->idt=='update_wake_up_sim_number'){
                        $current_row = \App\Meter::where('mdc_test_session_id',$mdc_test_session->id)->get()->toArray();
                            foreach($current_row as $curr)
                            {
                                DB::table('meters')->where('mdc_test_session_id',$mdc_test_session->id)
                                ->update(
                                    ['wake_up_1' => request()->wakeup_number_1,
                                    'wake_up_2' => request()->wakeup_number_2,
                                    'wake_up_3' => request()->wakeup_number_3

                                    ]
                                );
                            }
                    }  
                    if($test->idt=='update_mdi_reset_date'){
                        $current_row = \App\Meter::where('mdc_test_session_id',$mdc_test_session->id)->get()->toArray();
                            foreach($current_row as $curr)
                            {
                                DB::table('meters')->where('mdc_test_session_id',$mdc_test_session->id)
                                ->update(
                                    [ 
                                    'mdi_reset_date' => request()->mdi_reset_date,
                                    'mdi_reset_time' => request()->mdi_reset_time,
                                    ]
                                );
                            }
                    }                 
                $response = $this->makeApiRequest($mdc_test_session->writeCommunicationProfile->host . '/' . $test->service, $mdc_test_session->privatekey);
                $response_obj = json_decode($response);
                $response_array = json_decode($response, true);
               
                if ($test->idt == 'authorization_service') {
                    if (isset($response_array['privatekey'])) {
                        $mdc_test_session->privatekey = $response_array['privatekey'];
                        $mdc_test_session->save();
                    }
                }
                
             

                $jsonApiResponseValidity = $this->checkJsonApiResponse($response_array, $test);

                if ($test->testType->idt == 'on_demand' && $response_array['status'] == 0) {
                    // let user decide test status
                    $jsonApiResponseValidity['remarks'] = '';
                    $jsonApiResponseValidity['is_valid'] = true;
                }

                $mdc_test_status->remarks = $jsonApiResponseValidity['remarks'];
                $mdc_test_status->is_pass = $jsonApiResponseValidity['is_valid'];
                $mdc_test_status->save();
              
                return [
                    'success' => $jsonApiResponseValidity['is_valid'],
                    'show_pass_fail_buttons' => $jsonApiResponseValidity['is_valid'],
                    'transactionid' => isset($response_array['transactionid']) ? $response_array['transactionid'] : '',
                    'data' => null,
                    'api_data' => $response_obj,
                    'mdc_test_status' => $mdc_test_status,
                ];
            } catch (\Exception $ex) {
                //return (string) $ex->getResponse()->getBody();
                // throw $ex;
                if($test->idt == 'create_device_meter')
                {
                    foreach(request()->device_identity as $device)
                    {
                        foreach($device as $key=>$value)
                        {
                            if($key == 'dsn'){
                                $msn = $value;
                                $global_device='m' . (strlen($msn) > 2 ? substr($msn, 2) : $msn);

                            }


                        }
                        \App\Meter::where('mdc_test_session_id',$mdc_test_session->id)
                                    ->where('msn',$msn)->update([
                                        'global_device_id' =>  $global_device
                                     ]);
                    }
                }
                $mdc_test_status->remarks = $ex->getMessage();
                $mdc_test_status->is_pass = 0;
                $mdc_test_status->save();
                return [
                    'success' => false,
                    'show_pass_fail_buttons' => false,
                    'data' => null,
                    'mdc_test_status' => $mdc_test_status,
                ];
            }
        }
    }

    private function makeApiRequest($url, $private_key)
    {
        foreach (request()->all() as $key => $value) {
            if (
                ( strpos($key, 'datetime') !== false && $key != 'mdi_reset_date' )
                &&
                $value != null
            ) {
                try {
                    request()->merge([$key => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')]);
                } catch (\Exception $ex) {
                    // do nothing
                }
            }
        }

        $header_items = request()->header;
        $body_items = request()->except('header');
        foreach ($body_items as $index => $body_item) {
            if (is_array($body_item) || is_object($body_item)) {
                $body_items[$index] = json_encode($body_item);
            }
        }

        if (request()->has('add_transactionid') && request()->add_transactionid == 1) {
            // replaced '-' because uuid is 36 characters long but API accepts 32 characters long transactionid
            $header_items['transactionid'] = str_replace('-', '', (string) Uuid::generate(4));
        }

        if (request()->has('add_privatekey') && request()->add_privatekey == 1) {
            $header_items['privatekey'] = $private_key;
        }

        $client = new \GuzzleHttp\Client([
            'headers' => $header_items
        ]);
        
        $r = $client->request('POST', $url, [
            'form_params' => $body_items
        ]);
        $response = $r->getBody()->getContents();        
        return $response;
    }

    public function checkJsonApiResponse($response_array, $test)
    {
        $should_have_keys_in_response = [
            'authorization_service' => [
                'keys' => ['status', 'privatekey', 'message'],
                'data_keys' => null
            ],
            'create_device_meter' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'aux_relay_operations' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'time_synchronization' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'sanctioned_load_control' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'load_shedding_scheduling' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'update_meter_status' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            'on_demand_data_read_inst' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    'current_tariff_register',
                    'signal_strength',
                    'msn',
                    'frequency',
                    'global_device_id',
                    'meter_datetime',
                    'current_phase_a',
                    'current_phase_b',
                    'current_phase_c',
                    'voltage_phase_a',
                    'voltage_phase_b',
                    'voltage_phase_c',
                    'aggregate_active_pwr_pos',
                    'aggregate_active_pwr_neg',
                    'aggregate_active_pwr_abs',
                    'aggregate_reactive_pwr_pos',
                    'aggregate_reactive_pwr_neg',
                    'aggregate_reactive_pwr_abs',
                    'average_pf',
                    'mdc_read_datetime',
                    'db_datetime',
                    'is_synced',
                ]
            ],
            'on_demand_data_read_bill' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    'msn',
                    'global_device_id',
                    'meter_datetime',
                    'active_energy_pos_t1',
                    'active_energy_pos_t2',
                    'active_energy_pos_t3',
                    'active_energy_pos_t4',
                    'active_energy_pos_tl',
                    'active_energy_neg_t1',
                    'active_energy_neg_t2',
                    'active_energy_neg_t3',
                    'active_energy_neg_t4',
                    'active_energy_neg_tl',
                    'active_energy_abs_t1',
                    'active_energy_abs_t2',
                    'active_energy_abs_t3',
                    'active_energy_abs_t4',
                    'active_energy_abs_tl',
                    'reactive_energy_pos_t1',
                    'reactive_energy_pos_t2',
                    'reactive_energy_pos_t3',
                    'reactive_energy_pos_t4',
                    'reactive_energy_pos_tl',
                    'reactive_energy_neg_t1',
                    'reactive_energy_neg_t2',
                    'reactive_energy_neg_t3',
                    'reactive_energy_neg_t4',
                    'reactive_energy_neg_tl',
                    'reactive_energy_abs_t1',
                    'reactive_energy_abs_t2',
                    'reactive_energy_abs_t3',
                    'reactive_energy_abs_t4',
                    'reactive_energy_abs_tl',
                    'active_mdi_pos_t1',
                    'active_mdi_pos_t2',
                    'active_mdi_pos_t3',
                    'active_mdi_pos_t4',
                    'active_mdi_pos_tl',
                    'active_mdi_neg_t1',
                    'active_mdi_neg_t2',
                    'active_mdi_neg_t3',
                    'active_mdi_neg_t4',
                    'active_mdi_neg_tl',
                    'active_mdi_abs_t1',
                    'active_mdi_abs_t2',
                    'active_mdi_abs_t3',
                    'active_mdi_abs_t4',
                    'active_mdi_abs_tl',
                    'cumulative_mdi_pos_t1',
                    'cumulative_mdi_pos_t2',
                    'cumulative_mdi_pos_t3',
                    'cumulative_mdi_pos_t4',
                    'cumulative_mdi_pos_tl',
                    'cumulative_mdi_neg_t1',
                    'cumulative_mdi_neg_t2',
                    'cumulative_mdi_neg_t3',
                    'cumulative_mdi_neg_t4',
                    'cumulative_mdi_neg_tl',
                    'cumulative_mdi_abs_t1',
                    'cumulative_mdi_abs_t2',
                    'cumulative_mdi_abs_t3',
                    'cumulative_mdi_abs_t4',
                    'cumulative_mdi_abs_tl',
                    'mdc_read_datetime',
                    'db_datetime',
                    'is_synced',
                ]
            ],
            'on_demand_data_read_mbil' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    'msn',
                    'global_device_id',
                    'meter_datetime',
                    'active_energy_pos_t1',
                    'active_energy_pos_t2',
                    'active_energy_pos_t3',
                    'active_energy_pos_t4',
                    'active_energy_pos_tl',
                    'active_energy_neg_t1',
                    'active_energy_neg_t2',
                    'active_energy_neg_t3',
                    'active_energy_neg_t4',
                    'active_energy_neg_tl',
                    'active_energy_abs_t1',
                    'active_energy_abs_t2',
                    'active_energy_abs_t3',
                    'active_energy_abs_t4',
                    'active_energy_abs_tl',
                    'reactive_energy_pos_t1',
                    'reactive_energy_pos_t2',
                    'reactive_energy_pos_t3',
                    'reactive_energy_pos_t4',
                    'reactive_energy_pos_tl',
                    'reactive_energy_neg_t1',
                    'reactive_energy_neg_t2',
                    'reactive_energy_neg_t3',
                    'reactive_energy_neg_t4',
                    'reactive_energy_neg_tl',
                    'reactive_energy_abs_t1',
                    'reactive_energy_abs_t2',
                    'reactive_energy_abs_t3',
                    'reactive_energy_abs_t4',
                    'reactive_energy_abs_tl',
                    'active_mdi_pos_t1',
                    'active_mdi_pos_t2',
                    'active_mdi_pos_t3',
                    'active_mdi_pos_t4',
                    'active_mdi_pos_tl',
                    'active_mdi_neg_t1',
                    'active_mdi_neg_t2',
                    'active_mdi_neg_t3',
                    'active_mdi_neg_t4',
                    'active_mdi_neg_tl',
                    'active_mdi_abs_t1',
                    'active_mdi_abs_t2',
                    'active_mdi_abs_t3',
                    'active_mdi_abs_t4',
                    'active_mdi_abs_tl',
                    'cumulative_mdi_pos_t1',
                    'cumulative_mdi_pos_t2',
                    'cumulative_mdi_pos_t3',
                    'cumulative_mdi_pos_t4',
                    'cumulative_mdi_pos_tl',
                    'cumulative_mdi_neg_t1',
                    'cumulative_mdi_neg_t2',
                    'cumulative_mdi_neg_t3',
                    'cumulative_mdi_neg_t4',
                    'cumulative_mdi_neg_tl',
                    'cumulative_mdi_abs_t1',
                    'cumulative_mdi_abs_t2',
                    'cumulative_mdi_abs_t3',
                    'cumulative_mdi_abs_t4',
                    'cumulative_mdi_abs_tl',
                    'longitude',
                    'latitude',
                    'picture_1',
                    'picture_2',
                    'reading_mode',
                    'mdi_reset_datetime',
                    'reset_count',
                    'mdc_read_datetime',
                    'db_datetime',
                    'is_synced',
                ]
            ],
            'on_demand_data_read_lpro' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    'msn',
                    'global_device_id',
                    'meter_datetime',
                    'frequency',
                    'channel_id',
                    'interval',
                    'active_energy_pos_t1',
                    'active_energy_pos_t2',
                    'active_energy_pos_t3',
                    'active_energy_pos_t4',
                    'active_energy_pos_tl',
                    'active_energy_neg_t1',
                    'active_energy_neg_t2',
                    'active_energy_neg_t3',
                    'active_energy_neg_t4',
                    'active_energy_neg_tl',
                    'active_energy_abs_t1',
                    'active_energy_abs_t2',
                    'active_energy_abs_t3',
                    'active_energy_abs_t4',
                    'active_energy_abs_tl',
                    'reactive_energy_pos_t1',
                    'reactive_energy_pos_t2',
                    'reactive_energy_pos_t3',
                    'reactive_energy_pos_t4',
                    'reactive_energy_pos_tl',
                    'reactive_energy_neg_t1',
                    'reactive_energy_neg_t2',
                    'reactive_energy_neg_t3',
                    'reactive_energy_neg_t4',
                    'reactive_energy_neg_tl',
                    'reactive_energy_abs_t1',
                    'reactive_energy_abs_t2',
                    'reactive_energy_abs_t3',
                    'reactive_energy_abs_t4',
                    'reactive_energy_abs_tl',
                    'active_mdi_pos_t1',
                    'active_mdi_pos_t2',
                    'active_mdi_pos_t3',
                    'active_mdi_pos_t4',
                    'active_mdi_pos_tl',
                    'active_mdi_neg_t1',
                    'active_mdi_neg_t2',
                    'active_mdi_neg_t3',
                    'active_mdi_neg_t4',
                    'active_mdi_neg_tl',
                    'active_mdi_abs_t1',
                    'active_mdi_abs_t2',
                    'active_mdi_abs_t3',
                    'active_mdi_abs_t4',
                    'active_mdi_abs_tl',
                    'cumulative_mdi_pos_t1',
                    'cumulative_mdi_pos_t2',
                    'cumulative_mdi_pos_t3',
                    'cumulative_mdi_pos_t4',
                    'cumulative_mdi_pos_tl',
                    'cumulative_mdi_neg_t1',
                    'cumulative_mdi_neg_t2',
                    'cumulative_mdi_neg_t3',
                    'cumulative_mdi_neg_t4',
                    'cumulative_mdi_neg_tl',
                    'cumulative_mdi_abs_t1',
                    'cumulative_mdi_abs_t2',
                    'cumulative_mdi_abs_t3',
                    'cumulative_mdi_abs_t4',
                    'cumulative_mdi_abs_tl',
                    'current_phase_a',
                    'current_phase_b',
                    'current_phase_c',
                    'voltage_phase_a',
                    'voltage_phase_b',
                    'voltage_phase_c',
                    'active_pwr_pos_phase_a',
                    'active_pwr_pos_phase_b',
                    'active_pwr_pos_phase_c',
                    'aggregate_active_pwr_pos',
                    'active_pwr_neg_phase_a',
                    'active_pwr_neg_phase_b',
                    'active_pwr_neg_phase_c',
                    'aggregate_active_pwr_neg',
                    'aggregate_active_pwr_abs',
                    'reactive_pwr_pos_phase_a',
                    'reactive_pwr_pos_phase_b',
                    'reactive_pwr_pos_phase_c',
                    'aggregate_reactive_pwr_pos',
                    'reactive_pwr_neg_phase_a',
                    'reactive_pwr_neg_phase_b',
                    'reactive_pwr_neg_phase_c',
                    'aggregate_reactive_pwr_neg',
                    'aggregate_reactive_pwr_abs',
                    'average_pf',
                    'mdc_read_datetime',
                    'db_datetime',
                    'is_synced',
                ]
            ],
            'on_demand_data_read_evnt' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    'msn',
                    'global_device_id',
                    'event_datetime',
                    'event_code',
                    'event_counter',
                    'event_description',
                    'mdc_read_datetime',
                    'db_datetime',
                    'is_synced',
                ]
            ],
            'transaction_status_read' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "transactionid",
                    "global_device_id",
                    "msn",
                    "type",
                    "command_receiving_datetime",
                    "status_level",
                    "status_1_datetime",
                    "status_2_datetime",
                    "status_3_datetime",
                    "status_4_datetime",
                    "status_5_datetime",
                    "indv_status",
                    "request_cancelled",
                    "request_cancel_reason",
                    "request_cancel_datetime",
                    "response_data",
                ]
            ],
            'transaction_cancel' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'time_of_use_change' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'update_ip_port' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'meter_data_sampling' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'activate_meter_optical_port' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'update_wake_up_sim_number' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'update_device_metadata' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'apms_tripping_events' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "indv_status",
                    "remarks"
                ]
            ],
            'on_demand_parameter_read_auxr' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "auxr_datetime",
                    "auxr_status"
                ]
            ],
            'on_demand_parameter_read_dvtm' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "dvtm_datetime",
                    "dvtm_meter_clock"
                ]
            ],
            'on_demand_parameter_read_sanc' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "sanc_datetime",
                    "sanc_load_limit",
                    "sanc_maximum_retries",
                    "sanc_retry_interval",
                    "sanc_threshold_duration",
                    "sanc_retry_clear_interval"
                ]
            ],
            'on_demand_parameter_read_lsch' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "lsch_datetime",
                    "lsch_start_datetime",
                    "lsch_end_datetime",
                    "lsch_load_shedding_slabs"
                ]
            ],
            'on_demand_parameter_read_tiou' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "tiou_datetime",
                    "tiou_day_profile",
                    "tiou_week_profile",
                    "tiou_season_profile",
                    "tiou_holiday_profile",
                    "tiou_activation_datetime"
                ]
            ],
            "on_demand_parameter_read_ippo" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "ippo_datetime",
                    "ippo_primary_ip_address",
                    "ippo_secondary_ip_address",
                    "ippo_primary_port",
                    "ippo_secondary_port",
                ]
            ],
            "on_demand_parameter_read_mdsm" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "mdsm_datetime",
                    "mdsm_activation_datetime",
                    "mdsm_data_type",
                    "mdsm_sampling_interval",
                    "mdsm_sampling_initial_time",
                ]
            ],
            "on_demand_parameter_read_oppo" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "oppo_datetime",
                    "oppo_optical_port_on_datetime",
                    "oppo_optical_port_off_datetime"
                ]
            ],
            "on_demand_parameter_read_wsim" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "wsim_datetime",
                    "wsim_wakeup_number_1",
                    "wsim_wakeup_number_2",
                    "wsim_wakeup_number_3",
                ]
            ],
            "on_demand_parameter_read_mtst" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "mtst_datetime",
                    "mtst_meter_activation_status"
                ]
            ],
            "on_demand_parameter_read_DMDT" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "dmdt_datetime",
                    "dmdt_communication_mode",
                    "dmdt_bidirectional_device",
                    "dmdt_communication_type",
                    "dmdt_communication_interval",
                    "dmdt_phase",
                    "dmdt_meter_type"
                ]
            ],

            "on_demand_parameter_read_ovfc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "ovfc_datetime",
                    "ovfc_critical_event_threshold_limit",
                    "ovfc_critical_event_log_time",
                    "ovfc_tripping_event_threshold_limit",
                    "ovfc_tripping_event_log_time",
                    "ovfc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_uvfc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "uvfc_datetime",
                    "uvfc_critical_event_threshold_limit",
                    "uvfc_critical_event_log_time",
                    "uvfc_tripping_event_threshold_limit",
                    "uvfc_tripping_event_log_time",
                    "uvfc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_ocfc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "ocfc_datetime",
                    "ocfc_critical_event_threshold_limit",
                    "ocfc_critical_event_log_time",
                    "ocfc_tripping_event_threshold_limit",
                    "ocfc_tripping_event_log_time",
                    "ocfc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_olfc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "olfc_datetime",
                    "olfc_critical_event_threshold_limit",
                    "olfc_critical_event_log_time",
                    "olfc_tripping_event_threshold_limit",
                    "olfc_tripping_event_log_time",
                    "olfc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_pffc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "pffc_datetime",
                    "pffc_critical_event_threshold_limit",
                    "pffc_critical_event_log_time",
                    "pffc_tripping_event_threshold_limit",
                    "pffc_tripping_event_log_time",
                    "pffc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_vufc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "vufc_datetime",
                    "vufc_critical_event_threshold_limit",
                    "vufc_critical_event_log_time",
                    "vufc_tripping_event_threshold_limit",
                    "vufc_tripping_event_log_time",
                    "vufc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_cufc" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "cufc_datetime",
                    "cufc_critical_event_threshold_limit",
                    "cufc_critical_event_log_time",
                    "cufc_tripping_event_threshold_limit",
                    "cufc_tripping_event_log_time",
                    "cufc_enable_tripping"
                ]
            ],

            "on_demand_parameter_read_hapf" => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => [
                    "global_device_id",
                    "msn",
                    "hapf_datetime",
                    "hapf_critical_event_threshold_limit",
                    "hapf_critical_event_log_time",
                    "hapf_tripping_event_threshold_limit",
                    "hapf_tripping_event_log_time",
                    "hapf_enable_tripping"
                ]
            ],
            'parameterization_cancellation' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],

            'update_mdi_reset_date' => [
                'keys' => ['status', 'transactionid', 'data', 'message'],
                'data_keys' => ['global_device_id', 'msn', 'indv_status', 'remarks']
            ],
            
        ];

        // add reading tests keys in $should_have_keys_in_response array
        $reading_tests = \App\Test::whereHas('testType', function ($query) {
            $query->where('idt', '=', 'read');
        })->get();
        foreach ($reading_tests as $reading_test) {
            $should_have_keys_in_response[$reading_test->idt] = [
                'keys' => ['status', 'data', 'message'],
                'data_keys' => $reading_test->defaultColumns->pluck('column_name'),
            ];
        }

        if (!array_key_exists($test->idt, $should_have_keys_in_response)) {
            throw new \Exception("Unable to find key: [" . $test->idt . "] in array [should_have_keys_in_response] in TestController", 1);
        }

        $should_have_keys = $should_have_keys_in_response[$test->idt];

        $is_valid = true;
        $remarks = '';

        foreach ($should_have_keys['keys'] as $key) {
            if (!array_key_exists($key, $response_array)) {
                $is_valid = false;
                $remarks .= 'Key: [' . $key . '] is missing in response <br>';
            }
        }

        if (
            //$response_array['status'] == 1 &&
            $should_have_keys['data_keys'] != null
        ) {
            if (!is_array($response_array['data'])) {
                $is_valid = false;
                $remarks .= 'data is not array';
            } else if (is_array($response_array['data']) && count($response_array['data']) == 0) {
                $is_valid = false;
                $remarks .= 'data is empty';
            } else {
                foreach ($should_have_keys['data_keys'] as $data_key) {
                    foreach ($response_array['data'] as $index => $data_row) {
                        if (!array_key_exists($data_key, $data_row)) {
                            $is_valid = false;
                            $remarks .= 'Key: [' . $data_key . '] is missing in data array at index ' . $index . ' <br>';
                        }
                    }
                }
            }
        }

        return compact('is_valid', 'remarks');
    }

    public function startReadTest($mdc_test_session, $test, $mdc_test_status)
    {  
       // dd('sss');
         // read tests are API based or datbase based
        if ($mdc_test_session->readCommunicationProfile->communicationProfileType->idt == 'database') {
            try {
                //dd($test->defaultColumns->toArray());
                $errors = '';
                $connection = $mdc_test_session->readDatabaseConnection();
                $columnNames = $connection->getSchemaBuilder()->getColumnListing($test->table_name);
                // check column types
                $columnTypes = [];
                //dd($columnNames);
                foreach ($columnNames as $index => $columnName) {
                    $columnName = strtolower($columnName);
                    $columnNames[$index] = $columnName;
                    $columnType = $connection->getSchemaBuilder()->getColumnType($test->table_name, $columnName);
                    $columnTypes[] = $columnType;
                    
                    $defaultCol = $test->defaultColumns->first(function ($item, $index) use ($columnName) {
                        return strtolower($item->column_name) == $columnName;
                    });
                   
                    if ($defaultCol != null) {
                        if (strtolower($defaultCol->column_type_db) != $columnType) {
                            if($defaultCol->column_type_db == 'int' && $columnType == 'integer'){
                                //nothing to do
                            }else if($defaultCol->column_type_db == 'varchar' && $columnType == 'string')
                            {
                                //nothing to do
                            }else{
                                $errors .= 'Type of column [' . $columnName . '] should be [' . $defaultCol->column_type_db . '] but was [' . $columnType . ']</br>';
                            }
                        }
                    }
                    
                }
                
                //check if all columns exist
                $missing_columns = [];
                foreach ($test->defaultColumns as $defaultColumn) {
                    $defaultColumnName = strtolower($defaultColumn->column_name);
                    if (in_array($defaultColumnName, $columnNames) == false) {
                        $missing_columns[] = $defaultColumnName;
                    }
                }
                if (count($missing_columns) > 0) {
                    foreach ($missing_columns as $missing_column) {
                        $errors .= 'Column missing: ' . $missing_column . '<br>';
                    }
                }
                //dd($missing_columns);
                // get data
                $data = $connection
                    ->table($test->table_name)
                    ->whereIn('global_device_id', request()->global_device_id)
                    ->offset(request()->starting_index)
                    ->limit(request()->limit);

                if (in_array('db_datetime', $columnNames)) {
                    $data = $data
			->whereBetween('db_datetime', [
                        \Carbon\Carbon::parse(request()->start_datetime)->format('Y-m-d H:i:s'),
                        \Carbon\Carbon::parse(request()->end_datetime)->format('Y-m-d H:i:s')
                    ]
					
					);

                    $data = $data->orderBy('db_datetime', 'desc');
                }

                if (in_array('event_datetime', $columnNames)) {
		 /*
                    $data = $data->whereBetween('event_datetime', [
                        \Carbon\Carbon::parse(request()->start_datetime)->format('Y-m-d H:i:s'),
                        \Carbon\Carbon::parse(request()->end_datetime)->format('Y-m-d H:i:s')
                    ]);
			//echo 'ddd';
                    $data = $data->orderBy('event_datetime', 'desc');
		*/
                }

                if (strpos($test->idt, 'reading_stored_load_profile_data') !== false) {
                    $channel_id = substr($test->idt, strlen('reading_stored_load_profile_data_')) - 0;
                    $data = $data->where('channel_id', $channel_id);
                }

                $data = $data->get();

                // check that mandatory columns should not be null
                $test_profile_test = DB::table('test_profile_tests')
                    ->where('test_profile_id', $mdc_test_session->testProfile->id)
                    ->where('test_id', $test->id)
                    ->first();

                if ($test_profile_test == null) {
                    throw new Exception("Test not found in Test Profile", 1);
                }

                $test_profile_test_id = $test_profile_test->id;

                $mandatoryColumnNames = DB::table('test_profile_mandatory_columns')
                    ->where('test_profile_test_id', $test_profile_test_id)
                    ->select('column_name')
                    ->get()
                    ->pluck('column_name');

                foreach ($data as $index => $row) {
                    foreach ($mandatoryColumnNames as $mandatoryColumnName) {
                        if (property_exists($row, $mandatoryColumnName) && is_null($row->{$mandatoryColumnName})) {
                            $errors .= 'Value is null or empty for mandatory column [' . $mandatoryColumnName . '] at row index ' . $index . '. <br>';
                        }
                    }
                }

                $mandatory_column_suffix = ' (M)';
                // sort mandatory columns first
                $new_data = [];
                foreach ($data as $index => $row) {
                    $new_data_row = [];
                    foreach ($mandatoryColumnNames as $mandatoryColumnName) {
                        if (in_array($mandatoryColumnName, $columnNames)) {
                            $new_data_row[$mandatoryColumnName . $mandatory_column_suffix] = isset($row->{$mandatoryColumnName}) ? $row->{$mandatoryColumnName} : '';
                        }
                    }

                    foreach ($row as $key => $value) {
                        if (!in_array($key, $mandatoryColumnNames->toArray())) {
                            $new_data_row[$key] = $value;
                        }
                    }

                    $new_data[] = $new_data_row;
                }

                // show these columns first
                // msn, global_device_id, meter_datetime, mdc_datetime, db_datetime
                $important_columns = [
                    'msn', 'global_device_id', 'meter_datetime', 'mdc_datetime', 'db_datetime'
                ];
                $important_columns_first_data = [];
                foreach ($new_data as $index => $row) {
                    $new_data_row = [];

                    foreach ($important_columns as $important_column) {
                        if (in_array($important_column, $columnNames)) {
                            $column_name = in_array($important_column, $mandatoryColumnNames->toArray()) ?
                                $important_column . $mandatory_column_suffix :
                                $important_column;

                            $new_data_row[$column_name] = isset($row->{$column_name}) ? $row->{$column_name} : '';
                        }
                    }

                    foreach ($row as $key => $value) {
                        $new_data_row[$key] = $value;
                    }

                    $important_columns_first_data[] = $new_data_row;
                }

                $new_data = $important_columns_first_data;

                if(count($new_data) == 0)
                {
                    $errors .= 'No data exists <br>';
                }

                if (strlen($errors) > 0) {
                    $mdc_test_status->remarks = $errors;
                    $mdc_test_status->is_pass = 0;
                    $mdc_test_status->save();
                    return [
                        'success' => false,
                        'show_pass_fail_buttons' => false,
                        'data' => $new_data,
                        'mdc_test_status' => $mdc_test_status,
                    ];
                }

                return [
                    'success' => true,
                    'show_pass_fail_buttons' => true,
                    'data' => $new_data,
                    'mdc_test_status' => $mdc_test_status,
                ];
            } catch (\Exception $ex) {

                $mdc_test_status->remarks = $ex->getMessage();
                $mdc_test_status->is_pass = 0;
                $mdc_test_status->save();
                return [
                    'success' => false,
                    'show_pass_fail_buttons' => false,
                    'data' => null,
                    'mdc_test_status' => $mdc_test_status,
                ];
            }
        } else
        if ($mdc_test_session->readCommunicationProfile->communicationProfileType->idt == 'rest') {
            try {
                $response = $this->makeApiRequest($mdc_test_session->readCommunicationProfile->host . '/' . $test->service, $mdc_test_session->privatekey);
                $response_obj = json_decode($response);
                $response_array = json_decode($response, true);

                $jsonApiResponseValidity = $this->checkJsonApiResponse($response_array, $test);

                if ($jsonApiResponseValidity['remarks'] != '') {
                    $mdc_test_status->remarks = $jsonApiResponseValidity['remarks'];
                }
                $mdc_test_status->is_pass = $jsonApiResponseValidity['is_valid'];
                $mdc_test_status->save();

                return [
                    'success' => $jsonApiResponseValidity['is_valid'],
                    'show_pass_fail_buttons' => $jsonApiResponseValidity['is_valid'],
                    'transactionid' => isset($response_array['transactionid']) ? $response_array['transactionid'] : '',
                    'data' => null,
                    'api_data' => $response_obj,
                    'mdc_test_status' => $mdc_test_status,
                ];
            } catch (\Exception $ex) {
                // return (string) $ex->getResponse()->getBody();
                // throw $ex;
                $mdc_test_status->remarks = $ex->getMessage();
                $mdc_test_status->is_pass = 0;
                $mdc_test_status->save();
                return [
                    'success' => false,
                    'show_pass_fail_buttons' => false,
                    'data' => null,
                    'mdc_test_status' => $mdc_test_status,
                ];
            }
        }
    }

    public function loadTestView()
    {
        $mdc_test_session_id = request()->mdc_test_session_id;
        $test_id = request()->test_id;

        $test = Test::find($test_id);
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);

        if ($mdc_test_session->is_finished == 1) {
            return 'Test Finished';
        }

        if ($test->testType->idt == 'read') {
            if ($mdc_test_session->readCommunicationProfile->communicationProfileType->idt == 'database') {
                $form_view_name = 'reading_test_through_database';
                return view('tests.general_test', compact('test', 'mdc_test_session', 'form_view_name'));
            } else {
                $form_view_name = 'reading_test_through_api';
                return view('tests.general_test', compact('test', 'mdc_test_session', 'form_view_name'));
            }
        } else if ($test->testType->idt == 'on_demand') {
            $idt = $test->idt;

            $form_view_name = '';
            $type = '';
            if (strpos($idt, 'on_demand_data_read_') !== false) {
                $form_view_name = 'on_demand_data_read';
                $type = str_replace('on_demand_data_read_', '', $idt);
            } else if (strpos($idt, 'on_demand_parameter_read_') !== false) {
                $form_view_name = 'on_demand_parameter_read';
                $type = str_replace('on_demand_parameter_read_', '', $idt);
            } else {
                $form_view_name = $idt;
            }


            return view('tests.general_test', compact('test', 'mdc_test_session', 'form_view_name', 'type'));
        } else if ($test->testType->idt == 'write') {
            $form_view_name = $test->idt;
            return view('tests.general_test', compact('test', 'mdc_test_session', 'form_view_name'));
        }
    }

    public function finishTestSession()
    {
        $mdc_test_session_id = request()->id;
        \App\MdcTestSession::where('id', $mdc_test_session_id)
            ->update([
                'is_finished' => true,
                'finished_by' => \Auth::user()->id,
            ]);

        return ['success' => true];
    }

    public function exportMeters()
    {
        $mdc_test_session_id = request()->mdc_test_session_id;
        $mdc_test_session = \App\MdcTestSession::find($mdc_test_session_id);

        $data = [
            'company' => $mdc_test_session->company,
            'meters' => $mdc_test_session->meters,
            'read_comm_profile' => $mdc_test_session->readCommunicationProfile,
            'write_comm_profile' => $mdc_test_session->writeCommunicationProfile
        ];
        $data = collect($data);

        $filename = "meteres.json";
        $handle = fopen($filename, 'w+');
        fputs($handle, $data->toJson(JSON_PRETTY_PRINT));
        fclose($handle);
        $headers = array('Content-type' => 'application/json');
        return response()->download($filename, $filename, $headers);
    }
}
