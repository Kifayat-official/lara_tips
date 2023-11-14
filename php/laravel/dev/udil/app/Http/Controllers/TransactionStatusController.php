<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MdcTestSession;
use App\Test;

class TransactionStatusController extends Controller
{
    public function showTransactionStatusView()
    {
        return view('tests.components.transaction_status', 
            [
                'transactionid' => request()->transactionid,
                'mdc_test_session_id' => request()->mdc_test_session_id,
                'mdc_test_session' => \App\MdcTestSession::find(request()->mdc_test_session_id),
                'test_id' => request()->test_id,
            ]
        );
    }

    public function transactionStatus()
    {
        $transactionid = request()->transactionid;
        session(['transactionid' => $transactionid]);
        $mdc_test_session_id = request()->mdc_test_session_id;
        $test_id = request()->test_id;

        return $this->getTransactionStatus($transactionid, $mdc_test_session_id, $test_id);
    }

    public function getTransactionStatus($transactionid, $mdc_test_session_id, $test_id)
    {
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);
        $test = Test::find($test_id);

        $command_receiving_datetime = '2010-10-10 10:10';
        $status_level = 0;
        $status_1_datetime = null;
        $status_2_datetime = null;
        $status_3_datetime = null;
        $status_4_datetime = null;
        $status_5_datetime = null;
        $transaction_status_table_data = null;
        $transaction_status_api_response = null;

        if($mdc_test_session->is_transaction_status_api_based == 0)
        {
            $connection = $mdc_test_session->readDatabaseConnection();
            $transaction_status = $connection
                        ->table('transaction_status')
                        ->where('transactionid', $transactionid)
                        ->first();

            $transaction_status_table_data = $transaction_status;

            if($transaction_status == null) {
                throw new \Exception("Unable to find transaction in database", 1);
            }

            $command_receiving_datetime = $transaction_status->command_receiving_datetime;
            $status_level = $transaction_status->status_level;
            $status_1_datetime = $transaction_status->status_1_datetime;
            $status_2_datetime = $transaction_status->status_2_datetime;
            $status_3_datetime = $transaction_status->status_3_datetime;
            $status_4_datetime = $transaction_status->status_4_datetime;
            $status_5_datetime = $transaction_status->status_5_datetime;
        }
        else
        {
            //throw new \Exception("To be implemented", 1);

            $client = new \GuzzleHttp\Client([
                'headers' => [
                    'transactionid' => $transactionid,
                    'privatekey' => $mdc_test_session->privatekey,
                ]
            ]);
    
            $url = $mdc_test_session->writeCommunicationProfile->host . '/transaction_status';
            $r = $client->request('POST', $url, [
                'form_params' => []
            ]);
            $response = $r->getBody()->getContents();
            $response = json_decode($response, true);

            $transaction_status_api_response = $response;

            $command_receiving_datetime = isset($response['command_receiving_datetime']) ? $response['command_receiving_datetime'] : '';
            $status_level = isset($response['status_level']) ? $response['status_level'] : '';
            $status_1_datetime = isset($response['status_1_datetime']) ? $response['status_1_datetime'] : '';
            $status_2_datetime = isset($response['status_2_datetime']) ? $response['status_2_datetime'] : '';
            $status_3_datetime = isset($response['status_3_datetime']) ? $response['status_3_datetime'] : '';
            $status_4_datetime = isset($response['status_4_datetime']) ? $response['status_4_datetime'] : '';
            $status_5_datetime = isset($response['status_5_datetime']) ? $response['status_5_datetime'] : '';

            if($response && $response['data'] && count($response['data']) > 0)
            {
                $command_receiving_datetime = isset($response['data'][0]['command_receiving_datetime']) ? $response['data'][0]['command_receiving_datetime'] : '';
                $status_level = isset($response['data'][0]['status_level']) ? $response['data'][0]['status_level'] : '';
                $status_1_datetime = isset($response['data'][0]['status_1_datetime']) ? $response['data'][0]['status_1_datetime'] : '';
                $status_2_datetime = isset($response['data'][0]['status_2_datetime']) ? $response['data'][0]['status_2_datetime'] : '';
                $status_3_datetime = isset($response['data'][0]['status_3_datetime']) ? $response['data'][0]['status_3_datetime'] : '';
                $status_4_datetime = isset($response['data'][0]['status_4_datetime']) ? $response['data'][0]['status_4_datetime'] : '';
                $status_5_datetime = isset($response['data'][0]['status_5_datetime']) ? $response['data'][0]['status_5_datetime'] : '';
            }
        }

        return [
            "command_receiving_datetime" => $command_receiving_datetime,
            "status_level" => $status_level,
            "status_1_datetime" => $status_1_datetime,
            "status_2_datetime" => $status_2_datetime,
            "status_3_datetime" => $status_3_datetime,
            "status_4_datetime" => $status_4_datetime,
            "status_5_datetime" => $status_5_datetime,
            "transaction_status_table_data" => $transaction_status_table_data,
            "transaction_status_api_response" => $transaction_status_api_response
        ];
    }
}
