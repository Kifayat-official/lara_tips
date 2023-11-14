
@extends('adminlte::page')

@section('content')

  @component('components.reports_filter', [
    'url' => url('test_report_data'),
    'mdc_test_session' => isset($mdc_test_session) ? $mdc_test_session : null,
    'show_complete_incomplete_selector' => true,
  ])
  @endcomponent

@if( isset($mdc_test_session) )
  <div id="tests_report" class="box">
      <div class="box-header with-border">
          <h3 class="box-title">Tests Report</h3>

      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
      <table>
      <tbody>
        <tr>
          <td>Company: &nbsp;</td>
          <td>{{ $mdc_test_session->company->name }}</td>
        </tr>
        <tr>
        <td>Representative: &nbsp;</td>
        <td>{{ $mdc_test_session->company_rep }}</td>
        </tr>
        <tr>
          <td>Rep. Designation: &nbsp;</td>
          <td>{{ $mdc_test_session->company_rep_designation }}</td>
        </tr>
        <tr>
          <td>MDC Version: &nbsp;</td>
          <td>{{ $mdc_test_session->mdc_version }}</td>
        </tr>
      </tbody>
    </table>
        </div>
        </div>
        <br>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">Sr. No</th>
              <th>Test Type</th>
              <th class="col-md-1">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($mdc_test_session->testProfile->tests as $test)
            <tr>
              <td>{{$loop->index + 1}}</td>
              <td>{{$test->name}}</td>

              <?php
                $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);
              ?>

              @if($mdc_test_status == null)
                <td><i class="fa fa-exclamation" aria-hidden="true"></i></td>
              @elseif($mdc_test_status != null && $mdc_test_status->is_pass == 1)
                <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
              @elseif($mdc_test_status != null && $mdc_test_status->is_pass == 0)
                <td><i class="fa fa-times text-danger" aria-hidden="true"></i></td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
          
      </div>
      <!-- ./box-body -->
  </div>
@endif


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop