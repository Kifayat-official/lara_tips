<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        {{isset($obj) ? 'Edit' : 'Add'}} Role
    </h1>
@stop

@section('content')

<div class="box box-primary">
    
    <div class="box-body">
        <form id="form_{{$uniqid}}" action="" method="POST">
            @csrf
            @if(isset($obj))
            @method('PUT')
            @endif

            <div class="row">
    
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" name="name" value="{{ isset($obj) ? $obj->name : '' }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Level</label>
                        <input type="number" class="form-control" aria-describedby="helpId" name="level" max="{{\Auth::user()->is_super_admin == 1 ? 100 : \Auth::user()->role->level}}" value="{{ isset($obj) ? $obj->level : '' }}" required>
                        <small id="helpId" class="form-text text-muted">
                        Help: If a user has role level 10 then he can assign roles of level 10 or lower to other users.
                        </small>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">
                        Role Permissions
                    </h3>
                </div>

                <div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-md-10">Permission</th>
                                <th class="col-md-2 text-center">Allowed</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($additional_data['permissions']->groupBy('group') as $group => $group_permissions)
                                <tr class="bg-info">
                                    <td colspan="2"><b>{{$group}}</b></td>
                                </tr>
                                @foreach($group_permissions as $permission)
                                    @if(\Auth::user()->hasPermission($permission->idt))
                                    <tr>
                                        <td>{{$permission->name}}</td>
                                        <td class="text-center">

                                            <?php
                                            $checked = false;
                                            if(isset($obj)) {
                                                $role_permission = $obj->permissions->first(function($role_permission, $index) use($permission) {
                                                return $role_permission->id == $permission->id;
                                                });

                                                if($role_permission != null) {
                                                $checked = true;
                                                }
                                            }
                                            ?>

                                            <input type="checkbox" name="permission_id[]" value="{{$permission->id}}" {{ $checked ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>

            @component('components.submit_button')
            @endcomponent

        </form>
    </div>

</div>
    
@stop

@section('js')
<script>
    $(document).ready(function(){
        
        submitForm({
            formId: "#form_{{$uniqid}}",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_{{$uniqid}}'));
                return formData;
            },
            submitUrl: "{{ isset($obj) ? url('roles') . '/' . $obj->id : url('roles') }}",
            successfulCallback: function() {
                window.location.href = "{{url('roles')}}";
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        
        $('.header-test-checkbox').change(function(){
            $('.test-checkbox').prop('checked', $(this).prop('checked'));
        });

    });

</script>
@endsection
