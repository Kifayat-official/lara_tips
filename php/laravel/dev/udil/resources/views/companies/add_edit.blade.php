<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        {{isset($obj) ? 'Edit' : 'Add'}} Company
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
    
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="name" value="{{ isset($obj) ? $obj->name : '' }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ isset($obj) ? $obj->address : '' }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ isset($obj) ? $obj->phone : '' }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ isset($obj) ? $obj->email : '' }}" required>
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
            submitUrl: "{{ isset($obj) ? url('companies') . '/' . $obj->id : url('companies') }}",
            successfulCallback: function() {
                window.location.href = "{{url('companies')}}";
            },
            failureCallback: null,
            alwaysCallback: null,
        });
    });

</script>
@endsection
