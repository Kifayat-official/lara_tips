<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        Manage Companies
        <!-- <a class="btn btn-success pull-right" href="{{url('roles/create')}}">
            <i class="fa fa-plus-circle"></i>
            Add New Role
        </a> -->
    </h1>
@stop

@section('content')

<div class="box box-primary">
    
    <div class="box-body">
        @component('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('companies/datatable'),
            'resource_url' => url('companies'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => true, 'title' => 'Address', 'data' => 'address', 'name' => 'address' ],
                [ 'is_data_column' => true, 'title' => 'Phone', 'data' => 'phone', 'name' => 'phone' ],
                [ 'is_data_column' => true, 'title' => 'Email', 'data' => 'email', 'name' => 'email' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-3' ],
            ]
        ])
        @endcomponent
    </div>

</div>
    
@stop
