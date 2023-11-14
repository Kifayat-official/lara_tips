<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        Manage Users
        <!-- <a class="btn btn-success pull-right" href="{{url('users/create')}}">
            <i class="fa fa-plus-circle"></i>
            Add New User
        </a> -->
    </h1>
@stop

@section('content')

<div class="box box-primary">
    
    <div class="box-body">
        @component('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('users/datatable'),
            'resource_url' => url('users'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => false, 'title' => 'Is Super Admin', 'data' => 'is_super_admin', 'name' => 'is_super_admin' ],
                [ 'is_data_column' => true, 'title' => 'Role', 'data' => 'role.name', 'name' => 'role.name' ],
                [ 'is_data_column' => true, 'title' => 'Role Level', 'data' => 'role.level', 'name' => 'role.level' ],
                [ 'is_data_column' => false, 'title' => 'Status', 'data' => 'status', 'name' => 'status' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-3' ],
                
            ]
        ])
        @endcomponent
    </div>

</div>
    
@stop
