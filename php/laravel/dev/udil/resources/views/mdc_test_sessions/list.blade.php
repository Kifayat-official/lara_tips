<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        Manage UDIL Tests
        <!-- <a class="btn btn-success pull-right" href="{{url('mdc_test_sessions/create')}}">
            <i class="fa fa-plus-circle"></i>
            Add New MDC Test Session
        </a> -->
        <?php $time_str = rand(100,1000).strtotime("now").rand(100,1000); ?>
        <a class="btn btn-danger pull-right" href="{{env('FIELD_TESTING_URL')}}?udil={{$time_str}}">
            <i class="fa fa-list"></i>
            Field Testing
        </a>
    </h1>
@stop

@section('content')

<div class="box box-primary">
    
    <div class="box-body">

        <?php
            $companies = \App\Company::all();
            $companiesArray = [];
            foreach($companies as $company)
            {
                $companiesArray[$company->id] = $company->name;
            }

            $testProfiles = \App\TestProfile::all();
            $testProfilesArray = [];
            foreach($testProfiles as $testProfile)
            {
                $testProfilesArray[$testProfile->id] = $testProfile->name;
            }
        ?>

        @component('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('mdc_test_sessions/datatable'),
            'resource_url' => url('mdc_test_sessions'),
            'columns' => [

                [ 'is_data_column' => true, 'title' => 'ID', 'data' => 'id_numeric', 'name' => 'id_numeric' ],
                [ 
                    'is_data_column' => true, 
                    'title' => 'Company', 
                    'data' => 'company.name', 
                    'name' => 'company.name',
                    'filter_options' => [
                        'relation_and_column' => 'company.id',
                        'type' => 'select',
                        'select_options' => $companiesArray
                    ]
                ],
                [ 
                    'is_data_column' => true, 
                    'title' => 'Checklist (Test Profile)', 
                    'data' => 'test_profile.name', 
                    'name' => 'testProfile.name',
                    'filter_options' => [
                        'relation_and_column' => 'testProfile.id',
                        'type' => 'select',
                        'select_options' => $testProfilesArray
                    ]
                ],
                [ 'is_data_column' => true, 'title' => 'Company Representative', 'data' => 'company_rep', 'name' => 'company_rep' ],
                [ 'is_data_column' => true, 'title' => 'Rep. Designation', 'data' => 'company_rep_designation', 'name' => 'company_rep_designation' ],
                [ 'is_data_column' => true, 'title' => 'MDC Version', 'data' => 'mdc_version', 'name' => 'mdc_version' ],

                [ 
                    'is_data_column' => false, 
                    'title' => 'Completed', 
                    'data' => 'completed', 
                    'name' => 'completed', 
                    'class' => 'text-center',  
                    'filter_options' => [
                        'relation_and_column' => 'is_finished',
                        'type' => 'select',
                        'select_options' => [
                            '0' => 'No',
                            '1' => 'Yes'
                        ]
                    ]
                ],

                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-5' ],
            ]
        ])
        @endcomponent
    </div>

</div>
    
@stop
