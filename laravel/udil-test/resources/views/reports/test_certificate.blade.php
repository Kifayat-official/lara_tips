@extends('adminlte::page')

@section('content')

@component('components.reports_filter', [
'title' => 'Select',
'url' => url('test_certificate_data'),
'mdc_test_session' => isset($mdc_test_session) ? $mdc_test_session : null,
'show_complete_incomplete_selector' => false,
'completed_tests_only' => true,
'print_report_button_title' => 'Print Certificate',
'show_report_btn_title' => 'Show Certificate',
])
@endcomponent

@if( isset($mdc_test_session) )

<style>
  @page {
    size: A4 landscape;;
    margin: 0
  }
</style>

<?php
$certificate_width = '11.25in';
$certificate_height = '7.9in';
?>

<div class="hidden-print">
  <input id="hide-background" type="checkbox"> Hide certificate background
</div>
<div style="position: relative; width: {{$certificate_width}}; height: {{$certificate_height}}" id="certificate">
  <img class="background-image" style="position: absolute; display: inline-block; width: {{$certificate_width}}; height: {{$certificate_height}}" src="{{asset('app_images/certificate.png')}}" alt="">

  <span style="position: absolute;
    top: 80px;
    left: 710px;
    font-size: 17px;
    font-weight: bold;">PITC/INTR/LB/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}</span>

<span style="position: absolute;
    top: 110px;
    left: 711px;
    font-size: 17px;
    font-weight: bold;">{{ \Carbon\Carbon::parse(now()->toDateString())->format('d-F-Y')}} </span>


<span style="position: absolute;
    top: 405px;
    left: 810px;
    font-size: 17px;
    font-weight: bold;">{{ $mdc_test_session->udil_version }}.</span>



  <span style="position: absolute;
    top: 370px;
    left: 620px;
    font-size: 17px;
    font-weight: bold;">{{$mdc_test_session->tender_number}}</span>

  <span style="position: absolute;
    top: 370px;
    left: 230px;
    font-size: 17px;
    font-weight: bold;">{{ $mdc_test_session->mdc_name }}/{{$mdc_test_session->mdc_version}}</span>

  <p style="position: absolute;
    top: 298px;
    left: 175px;
    font-size: 17px;
    font-weight: bold;">{{ strtoupper($mdc_test_session->company->name) }} </p>
@if( $show_str != '' )
  <span style="position: absolute;
    top: 467px;
    left: 645px;
    font-size: 17px;
    font-weight: bold;">{{ $show_str }}</span>
@else
  <span style="position: absolute;
    top: 467px;
    left: 645px;
    font-size: 17px;
    font-weight: bold;">PITC/INTR/RP/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}</span>
@endif

</div>
@endif


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop
