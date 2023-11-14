<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\MdcTestSession;
use App\CommunicationProfile;
use App\Meter;
use App\Company;
use App\mdcSelection;
use Webpatser\Uuid\Uuid;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class MdcTestSessionController extends CommonController
{
    function __construct() {
        parent::__construct('mdc_test_sessions', '\App\MdcTestSession', ['company', 'meters'],
        [
            'add_permission' => 'add_udil_test',
            'edit_permission' => 'edit_udil_test',
            'delete_permission' => 'delete_udil_test',
            'list_permission' => 'udil_tests_list',
        ]);
    }

    public function dataTable()
    {
        if(\Auth::user()->is_super_admin == 1){
            $data = MdcTestSession::with(['company', 'testProfile'])
            ->select('mdc_test_sessions.*');
        }else{
            $logged_user_role_id = DB::table('users')->where('id',\Auth::user()->id)->value('id');
            if(DB::table('mdc_selections')->where('role_id',$logged_user_role_id)->value('role_id') == null){
                $data = MdcTestSession::with(['company', 'testProfile'])
                ->select('mdc_test_sessions.*');
            }else{
                $mdc_sessions_data= DB::table('mdc_selections')->where('role_id',$logged_user_role_id)->get()->toArray();
                foreach($mdc_sessions_data as $md){
                    $mdc_id_value []= $md->mdc_id;
                }
                $data = MdcTestSession::with(['company', 'testProfile'])
                ->select('mdc_test_sessions.*')->whereIn('id',$mdc_id_value);
            }
        }
        //dd($logged_user);
        $data = $this->applyFilters($data);

        return DataTables::eloquent($data)
            ->addColumn('action', function($row){

                $download_fee_voucher_button = '';

                if($row->fee_voucher != '' && $row->fee_voucher != null)
                {
                    $download_fee_voucher_button = '<a target="_blank" href="' . url('download_fee_voucher') . '/' . $row->fee_voucher . '" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download Fee Voucher</a>';
                }

                $edit_button = $this->generateEditButton($row);
                $delete_button = $this->generateDeleteButton($row);
                $tests_button = '<a class="btn btn-sm btn-warning" href="'. url('tests') . '/' . $row->id .'">
                                    <i class="fa fa-balance-scale"></i>
                                    Tests
                                </a>';

                $export_meters_button = '<a class="btn btn-sm btn-default" href="'. url('export_meters') . '/' . '?mdc_test_session_id=' . $row->id . '">
                                            <i class="fa fa-upload"></i> Export Meters
                                        </a>';

                if( ! Auth::user()->hasPermission('take_test') )
                {
                    $tests_button = '';
                }

                return $download_fee_voucher_button . $export_meters_button . $tests_button . $edit_button . $delete_button;
            })
            ->addColumn('completed', function($row){
                return $row->is_finished == '1' ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
            })
            ->rawColumns(['action', 'completed'])
            ->toJson();
    }

    public function validateRequest($id)
    {
        $profile_type=DB::table('communication_profile_types')->where('id',request()->rd_profile_type)->value('idt');
        if($profile_type == 'database'){
            request()->validate([

                'wr_profile_type' => 'required',
                'wr_protocol' => 'required',
                'rd_profile_type' => 'required',
                'rd_protocol' => 'required',

                'company' => 'required',
                'rep' => 'required',
                'rep_des' => 'required',
                'version' => 'required',
                'rd_host' => 'required',
                'rd_user' => 'required',
                'rd_port' => 'required',
                //'rd_pwd' => 'required',
                'wr_host' => 'required',
                'wr_user' => 'required',
                'wr_code' => 'required',
                'test_profile' => 'required',
                'fee_voucher' => 'mimes:jpeg,bmp,png,gif,svg,pdf|file|max:2048',
                'writing_tests_transaction_timeout_minutes' => 'required|numeric|min:1|max:15'
            ]);
        }else{
            request()->validate([

                'wr_profile_type' => 'required',
                'wr_protocol' => 'required',
                'rd_profile_type' => 'required',
                'rd_protocol' => 'required',

                'company' => 'required',
                'rep' => 'required',
                'rep_des' => 'required',
                'version' => 'required',
                'rd_host' => 'required',
                'rd_user' => 'required',
                //'rd_pwd' => 'required',
                'wr_host' => 'required',
                'wr_user' => 'required',
                'wr_code' => 'required',
                'test_profile' => 'required',
                'fee_voucher' => 'mimes:jpeg,bmp,png,gif,svg,pdf|file|max:2048',
                'writing_tests_transaction_timeout_minutes' => 'required|numeric|min:1|max:15'
            ]);
        }
    }
    public function storeData()
    {
        return $this->saveData(null);
    }

    public function updateData($id)
    {
        return $this->saveData($id);
    }

    public function saveData($id)
    {
        //READ
        $read_communication_profile = new CommunicationProfile();
        $read_communication_profile->communication_profile_type_id = request('rd_profile_type');
        $read_communication_profile->protocol_id = request('rd_protocol');
        $read_communication_profile->host = request('rd_host');
        $read_communication_profile->username = request('rd_user');
        $read_communication_profile->password = request('rd_pwd');
        $read_communication_profile->port = request('rd_port');
        $read_communication_profile->database = request('rd_database');
        $read_communication_profile->code = request('rd_code');
        $read_communication_profile->save();

        //WRITE
        $write_communication_profile = new CommunicationProfile();
        $write_communication_profile->communication_profile_type_id = request('wr_profile_type');
        $write_communication_profile->protocol_id = request('wr_protocol');
        $write_communication_profile->host = request('wr_host');
        $write_communication_profile->username = request('wr_user');
        $write_communication_profile->password = request('wr_pwd');
        $write_communication_profile->database = request('wr_database');
        $write_communication_profile->code = request('wr_code');
        $write_communication_profile->save();

        $mdc_test_session = $id == null ? new MdcTestSession() : MdcTestSession::find($id);

        if($id != null)
        {
            CommunicationProfile::destroy($mdc_test_session->read_profile_id);
            CommunicationProfile::destroy($mdc_test_session->write_profile_id);
            $existing_meters = DB::table('meters')->where('mdc_test_session_id',$id)->get();
            Meter::where('mdc_test_session_id', $id)->delete();
        }

        if(request()->has('fee_voucher') && request()->file('fee_voucher') != null)
        {
            $file_path = 'fee_vouchers';
            $file = request()->file('fee_voucher');
            $new_name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/' . $file_path, $new_name, 'uploads');
            $mdc_test_session->fee_voucher = $file_path . '/' . $new_name;
        }
        else if(request()->has('is_fee_voucher_deleted') && request()->is_fee_voucher_deleted == '1')
        {
            $mdc_test_session->fee_voucher = '';
        }

        $mdc_test_session->company_id = request('company');
        $mdc_test_session->created_by = Auth::user()->id;
        $mdc_test_session->start_datetime = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $mdc_test_session->company_rep = request('rep');
        $mdc_test_session->company_rep_designation = request('rep_des');
        $mdc_test_session->mdc_version = request('version');
        $mdc_test_session->read_profile_id = $read_communication_profile->id;
        $mdc_test_session->write_profile_id = $write_communication_profile->id;
        $mdc_test_session->is_gprs = request('is_gprs');
        $mdc_test_session->is_rf = request('is_rf');
        $mdc_test_session->is_plc = request('is_plc');
        $mdc_test_session->is_wifi = request('is_wifi');
        $mdc_test_session->is_zigbee = request('is_zigbee');
        $mdc_test_session->is_lan = request('is_la');
        $mdc_test_session->test_profile_id = request('test_profile');
        $mdc_test_session->is_transaction_status_api_based = request('is_transaction_status_api_based');
        $mdc_test_session->writing_tests_transaction_timeout_minutes = request('writing_tests_transaction_timeout_minutes');

        $mdc_test_session->mdc_name = request('mdc_name');
        $mdc_test_session->mdc_size = request('mdc_size');
        $mdc_test_session->mdc_os_name_version = request('mdc_os_name_version');
        $mdc_test_session->meter_firmware_version = request('meter_firmware_version');
        $mdc_test_session->meter_firmware_size = request('meter_firmware_size');
        $mdc_test_session->udil_version = request('udil_version');
        $mdc_test_session->tender_number = request('tender_number');

        $mdc_test_session->save();
        if(\Auth::user()->is_super_admin != 1){
                $mdc_select = new mdcSelection();
                $mdc_select->id = Uuid::generate();
                $mdc_select->role_id =\Auth::user()->id;
                $mdc_select->mdc_id = $mdc_test_session->id;
                $mdc_select->save();
        }

        $msn = request('msn');
        if($msn == null)
        {
            throw new \Exception("No meters specified", 1);
        }
        $msn_type = request('msn_type');
        $meter_model = request('meter_model');
        for($i=0; $i < sizeof($msn); $i++) {
			if($msn[$i] != '') {
                $meter = new Meter();
                $meter->msn = $msn[$i];
                $meter->meter_type_id = $msn_type[$i];
                $meter->meter_model = $meter_model[$i];
                $meter->mdc_test_session_id = $mdc_test_session->id;
                if($id == null){
                    $meter->global_device_id = 'm' . (strlen($msn[$i]) > 2 ? substr($msn[$i], 2) : $msn[$i]);
                }else{
                    $existing_meter = $existing_meters->firstWhere('msn', $meter->msn);
                    if($existing_meter != null)
                    {
                        $meter->global_device_id = $existing_meter->global_device_id;
                    }
                    else
                    {
                        $meter->global_device_id = 'm' . (strlen($msn[$i]) > 2 ? substr($msn[$i], 2) : $msn[$i]);
                    }
                }
                $meter->save();
            }
        }

        return $mdc_test_session->id;
    }

    public function downloadFeeVoucher($file_name)
    {
        return Storage::disk('uploads')->download('fee_vouchers/' . $file_name);
    }
}
