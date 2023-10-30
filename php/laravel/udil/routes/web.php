<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/home', function () {
    return redirect('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', 'DashboardController@showDashboard');

    Route::resource('test_profiles', 'TestProfileController');
    Route::post('test_profiles/datatable', 'TestProfileController@dataTable');

    Route::resource('mdc_test_sessions', 'MdcTestSessionController');
    Route::post('mdc_test_sessions/datatable', 'MdcTestSessionController@dataTable');

    Route::resource('users', 'UserController');
    Route::post('users/datatable', 'UserController@dataTable');

    Route::resource('roles', 'RoleController');
    Route::post('roles/datatable', 'RoleController@dataTable');

    Route::resource('companies', 'CompanyController');
    Route::post('companies/datatable', 'CompanyController@dataTable');

    Route::get('tests/{mdc_test_session_id}', 'TestController@showTests');
    Route::post('start_test', 'TestController@startTest');
    Route::post('set_test_status', 'TestController@setTestStatus');
    Route::get('load-test-view', 'TestController@loadTestView');

    Route::post('finish_test_session', 'TestController@finishTestSession');
    Route::get('export_meters', 'TestController@exportMeters');

    Route::get('transaction-status', 'TransactionStatusController@showTransactionStatusView');
    Route::get('get-transaction-status', 'TransactionStatusController@transactionStatus');

    Route::get('test_report', 'ReportController@showTestReport');
    Route::get('test_report_data', 'ReportController@showTestReportData');

    Route::get('test_certificate', 'ReportController@showTestCertificate');
    Route::get('test_certificate_data', 'ReportController@showTestCertificateData');

    Route::get('test_certificate_report', 'ReportController@showTestCertificateReport');
    Route::get('test_certificate_report_data', 'ReportController@showTestCertificateReportData');

    Route::get('multiple_test', 'ReportController@showMultipleTestsLink');
    Route::post('multiple_test_data', 'ReportController@showMultipleTestsLinkData');
    Route::post('get_certificate_record', 'ReportController@getCertificateRecord');

    Route::get('detailed_test_report', 'ReportController@showDetailedTestReport');
    Route::get('detailed_test_report_data', 'ReportController@showDetailedTestReportData');
    Route::get('complete_test_history', 'ReportController@completeTestHistory');

    Route::get('image/{image}', 'ReportController@displayImage')->name('image.displayImage');

    Route::get('download_checklist/checklists/{file_name}', 'TestProfileController@downloadChecklist');
    Route::get('download_fee_voucher/fee_vouchers/{file_name}', 'MdcTestSessionController@downloadFeeVoucher');

    Route::get('duplicate_test_profile/{test_profile_id}', 'TestProfileController@duplicateTestProfile');

});

