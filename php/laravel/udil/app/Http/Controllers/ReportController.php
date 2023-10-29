<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\MdcTestSession;
use DataTables;
use PDF;

class ReportController extends Controller
{
    public function showTestReport()
    {
        return view('reports.test_report');
    }

    public function showTestReportData()
    {
        $mdc_test_session_id = request('mdc_test_session_id');
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);

        return view('reports.test_report', compact('mdc_test_session'));
    }

    public function showDetailedTestReport()
    {
        return view('reports.detailed_test_report');
    }

    public function displayImage($imageName)
    {
        // $currentLoggedInUser = request()->user('api')
        if($imageName != null){
            $imageResponse = response()->file(Storage::disk('uploads')->path('test_status_attachments/'.$imageName));
        }else{
            $imageResponse = null;
        }
        return $imageResponse;
    }

    public function showDetailedTestReportData()
    {
        $mdc_test_session_id = request('mdc_test_session_id');
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);
        //dd(base_path('uploads\test_status_attachments\5efca8163f459.png'));
        //dd(Storage::disk('uploads')->exists('test_status_attachmentss'));
        //dd(storage_path('uploads'));
        //dd(Storage::disk('uploads')->getAdapter()->getPathPrefix());
        //dd(response()->file(Storage::disk('uploads')->path('test_status_attachments\5efca8163f459.png')));
        //dd(Storage::disk('uploads')->getDriver()->getAdapter()->applyPathPrefix('test_status_attachment\5efca8163f459.png'));
        //dd(Storage::disk('uploads')->getDriver()->getConfig());

        return view('reports.detailed_test_report', compact('mdc_test_session'));
    }

    public function showTestCertificate()
    {
        return view('reports.test_certificate');
    }

    public function showTestCertificateData()
    {
        $show_str = '';
        $mdc_test_session_id = request('mdc_test_session_id');
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);
        $certificate = \DB::table('test_certificate')->where('cert_id', $mdc_test_session_id)->pluck('test_rpt_id');
        $certificate_list = MdcTestSession::whereIn('id', $certificate)->pluck('id_numeric');
        foreach ($certificate_list as $key => $value) {
           $show_str .= ' PITC/INTR/RP/'.str_pad( $value ,6,"0",STR_PAD_LEFT).',';
        }
        $show_str = rtrim($show_str, ',');
        return view('reports.test_certificate', compact('mdc_test_session', 'show_str'));
    }
    

    public function showTestCertificateReport()
    {
        return view('reports.test_certificate_report');
    }

    public function showTestCertificateReportData()
    {
        $certificate_list = [];
        $mdc_test_session_id = request('mdc_test_session_id');
        $mdc_test_session = MdcTestSession::find($mdc_test_session_id);
        $certificate = \DB::table('test_certificate')->where('cert_id', $mdc_test_session_id)->pluck('test_rpt_id');
        $certificate_count = MdcTestSession::whereIn('id', $certificate)->pluck('id_numeric');
        $certificate_list = MdcTestSession::whereIn('id', $certificate)->get();
        //dd($mdc_test_session->testProfile->tests);
        return view('reports.test_certificate_report', compact('mdc_test_session', 'certificate_count', 'certificate_list'));
    }

    public function showMultipleTestsLink()
    {
       $mdc_test_session = MdcTestSession::select(['id', 'id_numeric', 'company_id'])->where('is_finished', 1)->get();
        
        //$test_rpts = \DB::table('test_certificate')->where(id,$idd)->get();   
        //$test_rpts = MdcTestSession::whereIn('id', $test_rpt)->get();     
        return view('reports.multiple_tests_link', compact('mdc_test_session'));
    }

    public function getCertificateRecord(){
        $mdc_test_session_id = request('mdc_test_session_id');
        $mdc_test_session = \DB::table('test_certificate')
                            ->join('mdc_test_sessions', 'mdc_test_sessions.id', '=', 'test_certificate.test_rpt_id')
                            ->where('test_certificate.cert_id', $mdc_test_session_id)->get();
        return $mdc_test_session;
    }

    public function showMultipleTestsLinkData(Request $request)
    {            
        request()->validate([
            'certificate' => 'required',
            'report_name' => 'required',
        ]);
        if(request()->certificate == 0 && request()->report_name[0] == 0){
            return ['success' => false, 'message' => 'Please select Certificate from Dropdown List'];
        }
        $certificate = request()->certificate;
        $reports = request()->report_name;
        try {
            DB::beginTransaction();
            DB::table('test_certificate')->where('cert_id', $certificate)->delete();
            $data = [];
            foreach($reports as $report){
                // $data[] = [
                //     'cert_id' => $certificate,
                //     'test_rpt_id' => $report
                // ];               
                DB::table('test_certificate')->insert([
                        'cert_id' => $certificate,
                        'test_rpt_id' => $report
                    ]);
            }
            // DB::transaction(function() {
            //     DB::table('test_certificate')->insert($data);
            // });
            DB::commit();
            return ['success' => true, 'message' => 'Saved successfully'];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['success' => false, 'message' => 'Error occurred: ' . $ex->getMessage(), 'exception' => $ex->getTraceAsString()];
        }
    }    

    public function completeTestHistory(Request $request)
    {

        Auth::user()->abortIfDontHavePermission('test_history');
        //$test_logs = \App\TestLog::all();
        if($request->ajax()){
            $data = DB::table('test_logs')
            ->join('users', 'users.id', '=', 'test_logs.created_by')
            ->join('mdc_test_sessions', 'mdc_test_sessions.id', '=', 'test_logs.mdc_test_session_id')
            ->join('test_profiles', 'test_profiles.id', '=', 'mdc_test_sessions.test_profile_id')
            ->join('tests', 'tests.id', '=', 'test_logs.test_id')
            ->select(['users.name', 'test_logs.created_at', 'test_profiles.name as test_profile.name','tests.name as test.name', 'test_logs.is_pass', 'test_logs.remarks', 'test_logs.attachment'])
            ->get();

            return DataTables::of($data)
                    ->editColumn('is_pass', function($data){
                        return $data->is_pass == 1 ? '<label class="label label-success">Passed</label>' :
                            '<label class="label label-danger">Failed</label>';
                    })
                    ->editColumn('attachment', function($data){
                        $content = basename($data->attachment);
                        $url = route('image.displayImage', [$content] );
                        return $content == null ? null :
                               "<img src='$url' width='320px' height='220px' alt='No Image Found'>" ;
                    })
                    ->rawColumns(['is_pass','attachment'])
                    ->make(true);

        }
        //dd($data);
        return view('reports.test_history');

    }
}
