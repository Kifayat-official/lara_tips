<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        {{isset($obj) ? 'Edit' : 'Add'}} User
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

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ isset($obj) ? $obj->name : '' }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ isset($obj) ? $obj->email : '' }}" requried>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" aria-describedby="passwordHelpId" {{ isset($obj) ? '' : 'required' }} autocomplete="new-password">
                @if( isset($obj) )
               <small id="passwordHelpId" class="form-text text-muted">Leave empty if you do not want to change password</small>
                @endif
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" {{ isset($obj) ? '' : 'required' }}>
            </div>

            <div class="form-check {{ Auth::user()->is_super_admin == 0 ? 'hidden' : '' }}">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="is_super_admin" value="1" {{ isset($obj) && $obj->is_super_admin ? 'checked' : '' }}>
                    Is Super Admin (Has all permissions)
                </label>
            </div>

            <br>
            <div class="form-group role-selector">
            <label>Role</label>
                <select id="role_id_selector" class="form-control" name="role">
                    @foreach($additional_data['roles'] as $role)
                    <option value="{{$role->id}}" {{ isset($obj) && $obj->role_id == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mdc-selector">


            </div>

            <br>
            <div class="form-check">
                <label class="form-check-label">
                    <?php
                    $checked = true;
                    if(isset($obj)) {
                        $checked = $obj->status == 1 ? true : false;
                    }
                    ?>
                    <input type="checkbox" class="form-check-input" name="status" value="1" {{ $checked ? 'checked' : '' }}>
                    Status
                </label>
            </div>

            @component('components.submit_button')
            @endcomponent

        </form>
    </div>

</div>

@stop

@section('js')
<script>
    var mdc_array = @json($mdc);
    $(document).ready(function(){
        var formId = "#form_{{$uniqid}}";

        showHideRoleField(formId);

        submitForm({
            formId: "#form_{{$uniqid}}",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_{{$uniqid}}'));
                return formData;
            },
            submitUrl: "{{ isset($obj) ? url('users') . '/' . $obj->id : url('users') }}",
            successfulCallback: function() {
                window.location.href = "{{url('users')}}";
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        $(formId + " [name='is_super_admin']").change(function(){
            showHideRoleField(formId);
        });
    });

    function showHideRoleField(formId) {
        var isSuperAdmin = $(formId + " [name='is_super_admin']").prop('checked');
        if(isSuperAdmin) {
            $(formId + " .role-selector").hide('fast');
            $(formId + " .mdc-selector").hide('fast');
        } else {
            $(formId + " .role-selector").show('fast');
            $(formId + " .mdc-selector").show('fast');
        }
    }

    $("#role_id_selector").change(function(){
        var selectedCountry = $(this).val();
        //alert(mdc_array.length);
        $(".mdc-selector").empty();
        if(mdc_array.length > 0)
        {
            if(_isContains(mdc_array, $(this).val())){
                var tariffHtml = `
                                    <label for="">Select MDC sessions (if none selected than all tests will be shown to user)</label>
                                    <div class="form-group">
                                            @foreach(\App\MdcTestSession::all() as $tariff )
                                                <?php
                                                    $checked = false;
                                                    if(isset($obj)) {
                                                        $checked = in_array($tariff->id, $additional_data['mdc_selection_id_array']) ? true : false;
                                                    }
                                                ?>
                                                <option ></option>
                                                <input type="checkbox" class="meters" name="mdc_session_id[]" value="{{$tariff->id}}" {{ $checked ? 'checked' : '' }}>
                                                {{ \App\Company::where('id',$tariff->company_id)->value('name') }} - {{$tariff->mdc_name}} - {{ $tariff->company_rep }}

                                            @endforeach
                                    </div>`

                $(".mdc-selector").append(tariffHtml);
            }
        }
    }).change();

    function _isContains(json, value) {
        let contains = false;
        Object.keys(json).some(key => {
                contains = typeof json[key] === 'object' ? _isContains(json[key], value) : json[key] === value;
            return contains;
            });
        return contains;
    }
</script>
@endsection
