<?php
$uniqid = uniqid();
?>

<div id="test_<?php echo e($uniqid); ?>">

    <form id="form_<?php echo e($uniqid); ?>" >
        <?php echo csrf_field(); ?>

        <div class="test-input-parameters">
            <?php if( isset($form_view_name) && $form_view_name != '' ): ?>
            <?php $__env->startComponent('tests.test_forms.' . $form_view_name, [
            'mdc_test_session' => $mdc_test_session,
            'test' => $test,
            'type' => isset($type) ? $type : null,
            ]); ?>
            <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>
        </div>

        <input type="submit" value="Start Test" class="btn-start-test btn btn-sm btn-block btn-primary">
    </form>

    <div class="loader-image text-center">
        <h3>Please wait...</h3>
        <img style="width: 70px;" src="<?php echo e(asset('app_images/loader.gif')); ?>" alt="">
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

        var mdc_test_session_id = "<?php echo e($mdc_test_session->id); ?>";
        var testId = "<?php echo e($test->id); ?>"
        // alert(testId);
        // alert(mdc_test_session_id);

        $('#form_<?php echo e($uniqid); ?>').show();
        $('#test_<?php echo e($uniqid); ?> .loader-image').hide();
        $('#test_<?php echo e($uniqid); ?> .error').hide();
        $('#test_<?php echo e($uniqid); ?> .pass-fail-buttons').hide();
        $('#test_<?php echo e($uniqid); ?> .table-data').hide();
        $('#test_<?php echo e($uniqid); ?> .api-data').hide();

        if ($('#test_<?php echo e($uniqid); ?> .test-input-parameters').children().length == 0) {
            startTest();
        }

        $('#form_<?php echo e($uniqid); ?>').submit(function(e) {
            e.preventDefault();
            startTest();
        })

        function startTest() {
            $('#form_<?php echo e($uniqid); ?>').hide();
            $('#test_<?php echo e($uniqid); ?> .loader-image').show();

            var formData = new FormData();

            if ($('#form_<?php echo e($uniqid); ?> .test-input-parameters').children().length != 0) {
                formData = new FormData(document.querySelector('#form_<?php echo e($uniqid); ?>'))
            }

            formData.append('test_id', testId);
            formData.append('mdc_test_session_id', mdc_test_session_id);
            formData.append('_token', "<?php echo e(csrf_token()); ?>");

            $.ajax({
                type: 'post',
                url: "<?php echo e(url('start_test')); ?>",
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(data) {

                if (data['success'] == false) {
                    $('#test_<?php echo e($uniqid); ?> .loader-image').hide('slow');
                    $('#test_<?php echo e($uniqid); ?> .error').show('slow');
                    $('#test_<?php echo e($uniqid); ?> .failure-remarks').html(data.mdc_test_status.remarks);
                } else if (data['success'] == true) {
                    $('#test_<?php echo e($uniqid); ?> .loader-image').hide('slow');

                } else {
                    alert('Response is not in proper format');
                }

                $('#test_<?php echo e($uniqid); ?> .btn-set-test-status').data('mdc_test_status_id', data.mdc_test_status.id);

                var isShowTransactionStatusTable = data.transactionid != null && data.transactionid != '' && "<?php echo e($test->testType->idt); ?>" != "on_demand";

                if (data.show_pass_fail_buttons) {
                    if(!isShowTransactionStatusTable) { // we will show pass fail button after getting status = 5
                        $('#test_<?php echo e($uniqid); ?> .pass-fail-buttons').show();
                    }
                } else {
                    if (data['success'] == true) {
                        $('#test_<?php echo e($uniqid); ?>').append('<h4 class="text-success text-center">Test Passed</h4>');
                    }
                }

                if (isShowTransactionStatusTable) {
                    $('#test_<?php echo e($uniqid); ?> .transaction-status').empty();
                    $('#test_<?php echo e($uniqid); ?> .transaction-status').append('<hr><p class="text-center"><b>Transaction Status</b></p>');
                    $('#test_<?php echo e($uniqid); ?> .transaction-status').append('<div class="transaction-status-table"></div>');
                    $('#test_<?php echo e($uniqid); ?> .transaction-status-table')
                        .load("<?php echo e(url('transaction-status')); ?>?transactionid=" + data.transactionid +
                            "&mdc_test_session_id=" + mdc_test_session_id + "&test_id=" + testId);
                    
                    $('#test_<?php echo e($uniqid); ?> .transaction-status').show('fast');
                }

                if (data.data) {
                    $('#test_<?php echo e($uniqid); ?> .table-data').show();
                    $('#test_<?php echo e($uniqid); ?> thead').empty();
                    $('#test_<?php echo e($uniqid); ?> tbody').empty();
                    if (data.data.length == 0) {
                        $('#test_<?php echo e($uniqid); ?> tbody').append('<p class="text-center no-data">No data exists</p>');
                    } else {

                        var headTr = '<tr>';
                        $.each(data.data[0], function(key, value) {
                            headTr += '<th>' + key + '</th>';
                        })
                        headTr += '<tr>';
                        $('#test_<?php echo e($uniqid); ?> thead').append(headTr);

                        $.each(data.data, function(index, row) {
                            var dataTr = '<tr>';
                            $.each(row, function(key, value) {
                                dataTr += '<td>' + value + '</td>';
                            })
                            dataTr += '/<tr>';
                            $('#test_<?php echo e($uniqid); ?> tbody').append(dataTr);
                        })
                    }
                }

                if (data.api_data) {
                    $('#test_<?php echo e($uniqid); ?> .api-data').show();
                    var jsonPretty = JSON.stringify(data.api_data, null, '\t');
                    $('#test_<?php echo e($uniqid); ?> .api-data').find('pre').text(jsonPretty);
                }

            }).fail(function(error) {
                alert('Server error occurred');
            });
        }

    });
</script><?php /**PATH /var/www/html/udil/resources/views/tests/general_test.blade.php ENDPATH**/ ?>