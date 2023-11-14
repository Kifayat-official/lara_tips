<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content')
<div class="box hidden-print">
  <div class="box-header with-border">
    <h3 class="box-title">Multiple Test Linking</h3>
  </div>
    <div class="box-body">
        <form id="form_{{$uniqid}}" action="" method="POST">
            @csrf
            <div class="row" id="dynamic_field">
                <div class="col-md-6">
                    <label for="company">Select Certificate Id</label>
                    <select class="form-control form-control-sm" name="certificate" id="certificate" onChange="getCertificatRecord()">
                        <option value="0">Select Certificate</option>
                        @foreach($mdc_test_session as $test_session)
                            <option data-target="{{ $test_session['id'] }}" data-id="{{ $test_session['id_numeric'] }}" value="{{ $test_session['id'] }}">PITC/INTR/LB/{{ str_pad( $test_session['id_numeric'] ,6,"0",STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="company">Select Report</label>
                    <select class="form-control form-control-sm" name="report_name[]" id="reports">
                        <option value="0" class='select'>Select Report</option>
                    </select>
                </div><br/>                
            </div>
            <div class="text-right" style="padding: 12px;">
                <button type="button" id="add" class="btn btn-info" onClick="AddNewReport()">Add New Report</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table id="table_{{$uniqid}}" class="table table-bordered">
        <thead>            
            <tr>
                <th>Certificate</th>
                <th>Report</th>
            </tr>

            
            

        </thead>

        <tbody id="rpt_list">
        </tbody>
    </table>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
$(document).ready(function(){ 
    var i=1; 

      $('#add').on('click', function(){  
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="dynamic-added"><div class="col-md-6"></div><div class="col-md-5"><label for="company">Select Report</label><select class="form-control form-control-sm" name="report_name[]"> @foreach($mdc_test_session as $key => $test_session)  <option value="{{ $test_session["id"] }}">PITC/INTR/RP/{{ str_pad( $test_session["id_numeric"] ,6,"0",STR_PAD_LEFT) }}</option>  @endforeach </select></div><div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>');  
      }); 

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });
      $('#certificate').on('change', function() {  
        $('#reports').html('');        
       var target=$(this).find(":selected").attr("data-target");
       var id=$(this).find(":selected").attr("data-id");  
       $('.select').hide();    
       $('#reports').append('<option selected value="'+target+'">PITC/INTR/RP/'+id+'</option>');
       $.ajax({
            url: 'get_certificate_record',
            type: 'post',
            data: {
                _token: "{{@csrf_token()}}",
                mdc_test_session_id: target,
            },
        }).done(function(data) {
            $("#rpt_list").html('');
            data.forEach(element => {
                $("#rpt_list").append('<tr class="alert alert-danger"><td>PITC/INTR/LB/'+id+'</td><td>PITC/INTR/RP/'+element.id_numeric+'</td></tr>');
            });
        }).fail(function(error) {
            alert(error);
        });
    });

      submitForm({
            formId: "#form_{{$uniqid}}",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_{{$uniqid}}'));
                return formData;
            },
            submitUrl: "{{ url('multiple_test_data') }}",
            successfulCallback: function() {
                window.location.href = "{{url('multiple_test')}}";
            },
            failureCallback: null,
            alwaysCallback: null,
        });
 
  });
</script>
@endsection