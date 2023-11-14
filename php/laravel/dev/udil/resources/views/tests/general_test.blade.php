<?php
$uniqid = uniqid();
?>

<div id="test_{{$uniqid}}">

    <form id="form_{{$uniqid}}" >
        @csrf()

        <div class="test-input-parameters">
            @if( isset($form_view_name) && $form_view_name != '' )
            @component('tests.test_forms.' . $form_view_name, [
            'mdc_test_session' => $mdc_test_session,
            'test' => $test,
            'type' => isset($type) ? $type : null,
            ])
            @endcomponent
            @endif
        </div>

        <input type="submit" value="Start Test" class="btn-start-test btn btn-sm btn-block btn-primary">
    </form>

    <div class="loader-image text-center">
        <h3>Please wait...</h3>
        <img style="width: 70px;" src="{{ asset('app_images/loader.gif') }}" alt="">
    </div>

    <div class="error">
        <h4 class="text-danger test-failed">Test Failed</h4>
        <p><b>Failure Remarks</b></p>
        <p class="failure-remarks"></p>
    </div>

    <div class="table-data">
        <p class="text-center"><b>Data</b></p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="api-data">
        <p class="text-center"><b>Response</b></p>
        <pre>
        </pre>
    </div>

    <div class="transaction-status" style="display:none;">

    </div>

    <div class="pass-fail-buttons">
        <h4 class="text-success text-center">Select Test Status Agree (Pass) / Not Agree (Fail)</h4>

        <div class="text-center">
            <div class="form-check form-check-inline">
                <label style="margin-left: 10px; margin-right: 10px;" class="form-check-label">
                    <input class="form-check-input" type="radio" name="test_pass_fail" value="fail"> Not Agree (Fail)
                </label>
                <label style="margin-left: 10px; margin-right: 10px;" class="form-check-label">
                    <input class="form-check-input" type="radio" name="test_pass_fail" value="pass"> Agree (Pass)
                </label>
            </div>

            <div class="row remarks-and-attachment text-left">
                <div class="col-md-6 col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Attachment</label>
                        <input type="file" class="form-control-file" name="attachment" accept=".pdf, image/*">
                    </div>
                </div>
            </div>

            <button type="button" onclick="saveTestStatus(this)" class="btn btn-sm btn-primary btn-set-test-status" data-mdc_test_status_id=""><i class="fa fa-save"></i> Save Test Status</button>
        </div>

    </div>
</div>

<script>
    function showHideRemarksAndAttachment() {
        if ($('[name="test_pass_fail"]:checked').val() == 'fail') {
            $('.remarks-and-attachment').show('fast');
        } else {
            $('.remarks-and-attachment').hide('fast');
        }
    }

    function saveTestStatus(button, dontHideModalAfterSettingStatus) {
        var passFail = $('[name="test_pass_fail"]:checked').val();
        var remarks = $('[name="remarks"]').val();
        var attachment = $('[name="attachment"]').prop('files')[0];

        if(!passFail) {
            alert('Please select test status');
            return;
        }

        if(passFail == 'fail' && remarks == '') {
            alert('Please profide remarks');
            return;
        }

        setTestStatus(passFail, remarks, attachment, button, dontHideModalAfterSettingStatus);
    }

    $(document).ready(function() {

        showHideRemarksAndAttachment();
        $('[name="test_pass_fail"]').change(function() {
            showHideRemarksAndAttachment();
        });

        var mdc_test_session_id = "{{$mdc_test_session->id}}";
        var testId = "{{$test->id}}"
        // alert(testId);
        // alert(mdc_test_session_id);

        $('#form_{{$uniqid}}').show();
        $('#test_{{$uniqid}} .loader-image').hide();
        $('#test_{{$uniqid}} .error').hide();
        $('#test_{{$uniqid}} .pass-fail-buttons').hide();
        $('#test_{{$uniqid}} .table-data').hide();
        $('#test_{{$uniqid}} .api-data').hide();

        if ($('#test_{{$uniqid}} .test-input-parameters').children().length == 0) {
            startTest();
        }

        $('#form_{{$uniqid}}').submit(function(e) {
            e.preventDefault();
            startTest();
        })

        function startTest() {
            $('#form_{{$uniqid}}').hide();
            $('#test_{{$uniqid}} .loader-image').show();

            var formData = new FormData();

            if ($('#form_{{$uniqid}} .test-input-parameters').children().length != 0) {
                formData = new FormData(document.querySelector('#form_{{$uniqid}}'))
            }

            formData.append('test_id', testId);
            formData.append('mdc_test_session_id', mdc_test_session_id);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                type: 'post',
                url: "{{url('start_test')}}",
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(data) {

                if (data['success'] == false) {
                    $('#test_{{$uniqid}} .loader-image').hide('slow');
                    $('#test_{{$uniqid}} .error').show('slow');
                    $('#test_{{$uniqid}} .failure-remarks').html(data.mdc_test_status.remarks);
                } else if (data['success'] == true) {
                    $('#test_{{$uniqid}} .loader-image').hide('slow');

                } else {
                    alert('Response is not in proper format');
                }

                $('#test_{{$uniqid}} .btn-set-test-status').data('mdc_test_status_id', data.mdc_test_status.id);

                var isShowTransactionStatusTable = data.transactionid != null && data.transactionid != '' && "{{$test->testType->idt}}" != "on_demand";

                if (data.show_pass_fail_buttons) {
                    if(!isShowTransactionStatusTable) { // we will show pass fail button after getting status = 5
                        $('#test_{{$uniqid}} .pass-fail-buttons').show();
                    }
                } else {
                    if (data['success'] == true) {
                        $('#test_{{$uniqid}}').append('<h4 class="text-success text-center">Test Passed</h4>');
                    }
                }

                if (isShowTransactionStatusTable) {
                    $('#test_{{$uniqid}} .transaction-status').empty();
                    $('#test_{{$uniqid}} .transaction-status').append('<hr><p class="text-center"><b>Transaction Status</b></p>');
                    $('#test_{{$uniqid}} .transaction-status').append('<div class="transaction-status-table"></div>');
                    $('#test_{{$uniqid}} .transaction-status-table')
                        .load("{{url('transaction-status')}}?transactionid=" + data.transactionid +
                            "&mdc_test_session_id=" + mdc_test_session_id + "&test_id=" + testId);
                    
                    $('#test_{{$uniqid}} .transaction-status').show('fast');
                }

                if (data.data) {
                    $('#test_{{$uniqid}} .table-data').show();
                    $('#test_{{$uniqid}} thead').empty();
                    $('#test_{{$uniqid}} tbody').empty();
                    if (data.data.length == 0) {
                        $('#test_{{$uniqid}} tbody').append('<p class="text-center no-data">No data exists</p>');
                    } else {

                        var headTr = '<tr>';
                        $.each(data.data[0], function(key, value) {
                            headTr += '<th>' + key + '</th>';
                        })
                        headTr += '<tr>';
                        $('#test_{{$uniqid}} thead').append(headTr);

                        $.each(data.data, function(index, row) {
                            var dataTr = '<tr>';
                            $.each(row, function(key, value) {
                                dataTr += '<td>' + value + '</td>';
                            })
                            dataTr += '/<tr>';
                            $('#test_{{$uniqid}} tbody').append(dataTr);
                        })
                    }
                }

                if (data.api_data) {
                    $('#test_{{$uniqid}} .api-data').show();
                    var jsonPretty = JSON.stringify(data.api_data, null, '\t');
                    $('#test_{{$uniqid}} .api-data').find('pre').text(jsonPretty);
                }

            }).fail(function(error) {
                alert('Server error occurred');
            });
        }

    });
</script>