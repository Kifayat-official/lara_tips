@extends('adminlte::page')

@section('content')

@component('components.reports_filter', [
'title' => 'Select',
'url' => url('test_certificate_report_data'),
'mdc_test_session' => isset($mdc_test_session) ? $mdc_test_session : null,
'show_complete_incomplete_selector' => false,
'completed_tests_only' => true,
'print_report_button_title' => 'Print Certificate Report',
'show_report_btn_title' => 'Show Certificate Report',
])
@endcomponent

@if( isset($mdc_test_session) )

<style>

    @page {
        size: A4 portrait;;
        margin: 0.5in
    }

    .border-bottom {
        border-bottom: 1px solid black;
    }

    .attributes-table td {
        padding: 5px;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .tests-table td, th {
        padding: 5px;
        border: 1px solid black;
        border-collapse: collapse;
    }

    th {
        background-color: lightgray;
    }

    p {
        text-align: justify;
    }

    .bold {
        font-weight: bold;
    }

    .underline {
        text-decoration: underline;
    }
	
    .at_footer {page-break-before: always;}
</style>

<?php
    $page_width = '7.7in';
?>

<div id="tests_report" style="width: {{$page_width}}; background-color: white; position: relative;">

    <div style="width: {{$page_width}};
    position: absolute;
    opacity: 0.15;
    top: 400px;">
        <img src="{{asset('app_images/pitc_logo.jpg')}}" style="width: 100%;" >
    </div>

    <table style="width: 100%">
        <tr>
            <td>
                <img src="{{asset('app_images/pitc_logo.jpg')}}" style="width: 100px;" >
            </td>
            <td style="text-align: right;">
                <img src="{{asset('app_images/pitc.png')}}" style="width: 300px" >
            </td>
        </tr>
    </table>

    <br><br><br>
    <table style="width: 100%">
    @if( isset($certificate_count) && count($certificate_count) > 0 )
        @foreach($certificate_count as $key => $value)
        <tr>  
            @if($key == 0)      
            <td class="border-bottom" style="width: 40%;">
                <b>
                    M/s {{$mdc_test_session->company->name}}
                </b>
            </td>
            @else
            <td style="width: 40%;"></td>
            @endif
            <td style="width: 10%;"></td>
            <td style="width: 20%; text-align: right;">Test Report No. &nbsp;</td>
            <td class="border-bottom">
                <b>
                    PITC/INTR/RP/{{ str_pad( $value ,6,"0",STR_PAD_LEFT) }}
                </b>
            </td>
        </tr>
        @endforeach
    @else
        <tr>        
            <td class="border-bottom" style="width: 40%;">
                <b>
                    M/s {{$mdc_test_session->company->name}}
                </b>
            </td>
            <td style="width: 10%;"></td>
            <td style="width: 20%; text-align: right;">Test Report No. &nbsp;</td>
            <td class="border-bottom">
                <b>
                    PITC/INTR/RP/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
                </b>
            </td>
        </tr>
    @endif
        <tr>
            <td class="border-bottom">{{$mdc_test_session->company->address}}&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="border-bottom">Ph: {{$mdc_test_session->company->phone}}&nbsp;, Email: {{$mdc_test_session->company->email}}&nbsp;</td>
            <td></td>
            <td style="text-align: right;">Dated:&nbsp;</td>
            <td style="border-bottom: 1px solid black;position: absolute;width:30.5%;">
                <b>
                    {{ \Carbon\Carbon::parse($mdc_test_session->updated_at)->format('d-M-Y') }}
                </b>
            </td>
        </tr>

    </table>

    <br><br>
    <b>Subject: </b>
    UDIL Compliance Certification No:
    <b>
        PITC/INTR/LB/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
    </b>

    <br><br>
    Reference M/s:
    <b>
        {{$mdc_test_session->company->name}}
    </b>

    <br>
    Letter No.
    <b>
        PITC/INTR/L/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
    </b>
    Dated:
    <b>
    {{ \Carbon\Carbon::parse($mdc_test_session->updated_at)->format('d-M-Y') }}
    </b>

    <br><br>
    <p>
        Attributes of offered Meter Data Collection (MDC) Software and Smart Meter Firmware are as under:
    </p>

    <table class="attributes-table" style="width: 58%">
        <tr><td style="text-align: right; width: 58%;"><b>MDC Name & Version:</b></td><td>{{$mdc_test_session->mdc_name}}/{{ $mdc_test_session->mdc_version }}</td></tr>
        <tr><td style="text-align: right; width: 58%;"><b>MDC Size (MBs):</b></td><td>{{$mdc_test_session->mdc_size}}</td></tr>
        <tr><td style="text-align: right; width: 58%;"><b>OS Name & Version:</b></td><td>{{$mdc_test_session->mdc_os_name_version}}</td></tr>

        <tr>
            <td style="text-align: right; width: 58%;"><b>Smart Meter Serial No(s)/Model:</b></td>
            <td>
                {{ implode(', ', $mdc_test_session->meters->pluck('msn')->toArray() ) }}/{{ implode(', ', $mdc_test_session->meters->pluck('meter_model')->toArray() ) }}
            </td>
        </tr>

        <tr><td style="text-align: right; width: 58%;"><b>Meter Firmware Version:</b></td><td>{{$mdc_test_session->meter_firmware_version}}</td></tr>
        <tr><td style="text-align: right; width: 58%;"><b>Meter Firmware Size:</b></td><td>{{$mdc_test_session->meter_firmware_size}}</td></tr>
        <tr><td style="text-align: right; width: 58%;"><b>UDIL Version:</b></td><td>{{$mdc_test_session->udil_version}}</td></tr>
    </table>

    <br>
    <p>
        The offered MDC have successfully passed UDIL compliance tests in accordance with the above UDIL version and associated checklist as:
    </p>

    <br>
    <table class="tests-table table-responsive" style="width: 100%">        
        @if( isset($certificate_list) && count($certificate_list) > 0 )
            @foreach($certificate_list as $key => $value)
            <thead>
            <tr>
                <th>Sr.</th>
                <th width="15%">Test Category</th>
                <th>Test Name</th>
                <th width="15%">Date & Time</th>
                <th>Service</th>
                <th>Status</th>
                <th>Digital signature of test report</th>
            </tr>
            </thead>    
            <tbody>
            <?php
                $index = 0;
            ?>
            @foreach($value->testProfile->tests as $test)
            <?php
                $mdc_test_status = $value->getMdcTestStatusByTestId($test->id);
                //$index += 1;
            ?>
            @if($test->testType->idt == 'read')
                <tr>
                    <td>{{$index += 1}}</td>
                    <td>{{$test->testType->name}}</td>
                    <td>{{$test->name}}</td>
                    <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                    <td>
                        @if($test->testType->idt == 'read')
                            {{$value->readCommunicationProfile->communicationProfileType->name}}
                        @else
                            {{$value->writeCommunicationProfile->communicationProfileType->name}}
                        @endif

                    </td>
                    <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                    <td>
                        PITC/INTR/RP/{{ str_pad( $value->id_numeric ,6,"0",STR_PAD_LEFT) }}
                    </td>
                </tr>
            @endif
            @endforeach
            @foreach($value->testProfile->tests as $test)
            <?php
                $mdc_test_status = $value->getMdcTestStatusByTestId($test->id);
                //$index += 1;
            ?>
            @if($test->testType->idt == 'write')
                <tr>
                    <td>{{$index += 1}}</td>
                    <td>{{$test->testType->name}}</td>
                    <td>{{$test->name}}</td>
                    <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                    <td>
                        @if($test->testType->idt == 'read')
                            {{$value->readCommunicationProfile->communicationProfileType->name}}
                        @else
                            {{$value->writeCommunicationProfile->communicationProfileType->name}}
                        @endif

                    </td>
                    <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                    <td>
                        PITC/INTR/RP/{{ str_pad( $value->id_numeric ,6,"0",STR_PAD_LEFT) }}
                    </td>
                </tr>
            @endif
            @endforeach
            @foreach($value->testProfile->tests as $test)
            <?php
                $mdc_test_status = $value->getMdcTestStatusByTestId($test->id);
                //$index += 1;
            ?>
            @if($test->testType->idt == 'on_demand')
                <tr>
                    <td>{{$index += 1}}</td>
                    <td>{{$test->testType->name}}</td>
                    <td>{{$test->name}}</td>
                    <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                    <td>
                        @if($test->testType->idt == 'read')
                            {{$value->readCommunicationProfile->communicationProfileType->name}}
                        @else
                            {{$value->writeCommunicationProfile->communicationProfileType->name}}
                        @endif

                    </td>
                    <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                    <td>
                        PITC/INTR/RP/{{ str_pad( $value->id_numeric ,6,"0",STR_PAD_LEFT) }}
                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
            @endforeach
        @else
        <thead>
            <tr>
                <th>Sr.</th>
                <th width="15%">Test Category</th>
                <th>Test Name</th>
                <th width="15%">Date & Time</th>
                <th>Service</th>
                <th>Status</th>
                <th>Digital signature of test report</th>
            </tr>
        </thead>
            <tbody>
                <?php
                    $index = 0;
                ?>
                @foreach($mdc_test_session->testProfile->tests as $test)
                <?php
                    $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);
                    //$index += 1;
                ?>
                @if($test->testType->idt == 'read')
                    <tr>
                        <td>{{$index += 1}}</td>
                        <td>{{$test->testType->name}}</td>
                        <td>{{$test->name}}</td>
                        <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                        <td>
                            @if($test->testType->idt == 'read')
                                {{$mdc_test_session->readCommunicationProfile->communicationProfileType->name}}
                            @else
                                {{$mdc_test_session->writeCommunicationProfile->communicationProfileType->name}}
                            @endif

                        </td>
                        <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                        <td>
                            PITC/INTR/RP/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
                        </td>
                    </tr>
                @endif
                @endforeach
                @foreach($mdc_test_session->testProfile->tests as $test)
                <?php
                    $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);
                    //$index += 1;
                ?>
                @if($test->testType->idt == 'write')
                    <tr>
                        <td>{{$index += 1}}</td>
                        <td>{{$test->testType->name}}</td>
                        <td>{{$test->name}}</td>
                        <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                        <td>
                            @if($test->testType->idt == 'read')
                                {{$mdc_test_session->readCommunicationProfile->communicationProfileType->name}}
                            @else
                                {{$mdc_test_session->writeCommunicationProfile->communicationProfileType->name}}
                            @endif

                        </td>
                        <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                        <td>
                            PITC/INTR/RP/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
                        </td>
                    </tr>
                @endif
                @endforeach
                @foreach($mdc_test_session->testProfile->tests as $test)
                <?php
                    $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);
                    //$index += 1;
                ?>
                @if($test->testType->idt == 'on_demand')
                    <tr>
                        <td>{{$index += 1}}</td>
                        <td>{{$test->testType->name}}</td>
                        <td>{{$test->name}}</td>
                        <td>{{$mdc_test_status != null ? \Carbon\Carbon::parse($mdc_test_status->updated_at)->format('d-M-Y h:i:s A') : '' }}</td>
                        <td>
                            @if($test->testType->idt == 'read')
                                {{$mdc_test_session->readCommunicationProfile->communicationProfileType->name}}
                            @else
                                {{$mdc_test_session->writeCommunicationProfile->communicationProfileType->name}}
                            @endif

                        </td>
                        <td>{{$mdc_test_status != null && $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail'}}</td>
                        <td>
                            PITC/INTR/RP/{{ str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT) }}
                        </td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        @endif        
    </table>

    <br>
	<div class="at_footer">
    <p>
        The authenticity of test report has been verified by Smart Grid Integration & Testing Lab at P­ower Information Technology Company (PITC), Ministry of Energy (Power Division), Govt. of Pakistan. The above successful MDC have been listed on the website www.pitc.com.pk.
    </p>

    <br>
    <p>
        This UDIL compliance certificate is valid only for the functions, successfully tested above,
        against UDIL Version
        <span class="bold underline">&nbsp;&nbsp;{{$mdc_test_session->udil_version}}&nbsp;&nbsp;</span>
        vide checklist
        <span class="bold underline">&nbsp;&nbsp;{{$mdc_test_session->testProfile->name}}&nbsp;&nbsp;</span>
        issued against tender no.
        <span class="bold underline">&nbsp;&nbsp;{{$mdc_test_session->tender_number}}&nbsp;&nbsp;</span>
        using Meter Data Collector (MDC) and Smart Meters provided by
        <span class="bold underline">&nbsp;&nbsp;M/s {{$mdc_test_session->company->name}}&nbsp;&nbsp;</span>
    </p>

    <br>
    <p>
        This certificate is valid with following conditions:
    </p>

    <ol>
        <li>
            <p>
            In case of any degradation, defect or malfunction observed during field performance, this office will review the UDIL compliance approval even during the currency of the purchase order.
            </p>
        </li>
        <li>
            <p>
            Any change or update in the MDC version or firmware by the Smart Meter manufacturer will render this certificate invalid and will require new UDIL compliance certificate.
            </p>
        </li>
        <li>
            <p>
            This UDIL compliance certification / approval does not relieve you from the responsibility towards the quality and field performance of the product.
            </p>
        </li>
    </ol>

    <br><br><br><br><br>
    <table>
        <tr>
            <td width="58%">
                Incharge Smart Grid Integration & Testing Lab <br>
                Deputy Manager (IT), <br>
                PITC <br>
                Dated: ______________________
            </td>
            <td>
                Coordinator Smart Grid Integration & Testing Lab <br>
                Deputy Manager (IT), <br>
                PITC <br>
                Dated: ______________________
            </td>
        </tr>
    </table>
    <br><br><br><br><br>
    <table>
        <tr>
            <td width="71.25%">
                Manager (AMI), <br>
                PITC <br>
                Dated: ______________________
            </td>

            <td>
                Chief Technology Officer,<br>
                PITC <br>
                Dated: ______________________
            </td>
        </tr>
    </table>
	</div>
</div>


@endif


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">



@stop

@section('js')

@stop

