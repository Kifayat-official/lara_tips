<?php

$uniqid = uniqid();

?>

@extends('adminlte::page')

@section('content_header')
    <h1>
        {{isset($obj) ? 'Edit' : 'Add'}} UDIL Checklist
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
              <label>Test Profile Name</label>
              <input type="text" class="form-control" name="name" value="{{ isset($obj) ? $obj->name : '' }}" required>
            </div>

            <?php
                $is_checklist_attached = isset($obj) && $obj->checklist_file != '' && $obj->checklist_file != null;
            ?>

            <div class="form-group">
              <label>Checklist File</label> <br>
                <div id="checklist-buttons" class="{{$is_checklist_attached ? '' : 'hidden'}}" style="margin-bottom: 5px" >
                    <a target="_blank" href="{{url('download_checklist')}}/{{isset($obj) ? $obj->checklist_file : ''}}" class="btn btn-primary"><i class="fa fa-download"></i> Download Checklist</a>
                    <button id="btn-delete-checklist" type="button" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete Checklist
                    </button>
                </div>
                
                <input class="{{$is_checklist_attached ? 'hidden' : ''}}" type="file" class="form-control" name="checklist_file" accept=".pdf, .doc, .docx">
                <input name="is_checklist_file_deleted" type="hidden" value="1">
            </div>

            <h4>Select Tests</h4>

            <div class="table-responsive">
                <table id="tests-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> <input class="header-test-checkbox" type="checkbox" name="" checked> Test</th>
                            <th class="col-md-7">Mandatory (Not Null) Columns</th>
                            <th class="col-md-2 text-center"> 
                                Select All Columns
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($additional_data['test_groups'] as $test_group)
                            <tr class="bg-info">
                                <td colspan=4>
                                    <b>{{$test_group->name}}</b>
                                </td>
                            </tr>
                            @foreach($test_group->tests as $test)
                            <tr>
                                <td>
                                    <?php
                                        $checked = isset($obj) ? false : true;
                                        if(isset($obj)) 
                                        {
                                            $profile_test = $obj->tests()->where('test_id', $test->id)->first();
                                            $checked = $profile_test == null ? false : true;
                                        }
                                    ?>

                                    <input class="test-checkbox" type="checkbox" name="tests[]" value="{{$test->id}}" {{ $checked ? 'checked' : '' }} > 
                                
                                     {{$test->name}} <br>
                                    <label class="label label-primary"> {{$test->testType->name}} </label>
                                </td>
                                <td>
                                    <div style="max-height: 300px; overflow: auto;">
                                        @if($test->testType->idt == 'read')
                                        @foreach($test->defaultColumns->groupBy('group') as $group_name => $group_default_columns)
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">{{$group_name}}</h3>
                                                </div>
                                                <div class="box-body">
                                                    @foreach($group_default_columns as $default_column)
                                                    <div class="form-check col-md-6">
                                                        <label style="font-weight: normal;" class="form-check-label">

                                                            <?php
                                                                $mandatoryChecked = isset($obj) ? false : true;
                                                                if(isset($obj))
                                                                {
                                                                    $test_profile_test = \DB::table('test_profile_tests')
                                                                        ->where('test_profile_id', $obj->id)
                                                                        ->where('test_id', $test->id)->first();

                                                                    if($test_profile_test != null)
                                                                    {
                                                                        $test_profile_test_mandatory_column = DB::table('test_profile_mandatory_columns')
                                                                            ->where('test_profile_test_id', $test_profile_test->id)
                                                                            ->where('column_name', $default_column->column_name)
                                                                            ->first();

                                                                        $mandatoryChecked = $test_profile_test_mandatory_column == null ? false : true;
                                                                    }
                                                                    
                                                                }
                                                            ?>

                                                            <input type="checkbox" class="form-check-input mandatory-column-checkbox" name="mandatory_columns[{{$test->id}}][]" 
                                                                value="{{ $default_column->column_name }}" {{ $mandatoryChecked ? 'checked' : '' }} >


                                                            {{ $default_column->column_name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center"> 

                                <input class="columns-checkbox" type="checkbox" > 
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
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

        $('#btn-delete-checklist').click(function(){
            var sure = confirm("Are you sure you want to delete the checklist?");
            if(sure) {
                $('[name="is_checklist_file_deleted"]').val('1');
                $('[name="checklist_file"]').toggleClass('hidden');
                $('#checklist-buttons').toggleClass('hidden');
            }
        });

        
        submitForm({
            formId: "#form_{{$uniqid}}",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_{{$uniqid}}'));
                return formData;
            },
            submitUrl: "{{ isset($obj) ? url('test_profiles') . '/' . $obj->id : url('test_profiles') }}",
            successfulCallback: function() {
                window.location.href = "{{url('test_profiles')}}";
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        
        $('.header-test-checkbox').change(function(){
            $('.test-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.columns-checkbox').change(function(){
            $(this).closest('tr').find('.mandatory-column-checkbox').prop('checked', $(this).prop('checked'));
        });

        setInterval(() => {
            $.each($('#tests-table tr'), function(i, tr){
                // console.log(tr);
                var isTestChecked = $(tr).find('.test-checkbox').prop('checked');
                if(isTestChecked) {
                    $(tr).addClass('bg-success');
                } else {
                    $(tr).removeClass('bg-success');
                }
            })
        }, 500);

    });

</script>
@endsection
