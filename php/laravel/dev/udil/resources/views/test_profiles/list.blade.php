<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        Manage UDIL Checklists
        <!-- <a class="btn btn-success pull-right" href="{{url('test_profiles/create')}}">
            <i class="fa fa-plus-circle"></i>
            Add New Test Profile
        </a> -->
    </h1>
@stop

@section('content')

<div class="box box-primary">
    
    <div class="box-body">
        @component('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('test_profiles/datatable'),
            'resource_url' => url('test_profiles'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-4' ],
            ]
        ])
        @endcomponent
    </div>

</div>
    
@stop
