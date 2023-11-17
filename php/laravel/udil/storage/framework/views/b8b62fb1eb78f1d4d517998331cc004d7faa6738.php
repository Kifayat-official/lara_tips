<?php $__env->startSection('content'); ?>

<?php

function isInitializationTest($test)
{
    return $test->idt == 'authorization_service' || $test->idt == 'create_device_meter';
}

$test_number = 0;

?>

<div class="box">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-10">
                <h3 style="margin: 0;">
                    Test Session ID: PITC/INTR/LB/<?php echo e(str_pad( $mdc_test_session->id_numeric ,6,"0",STR_PAD_LEFT)); ?>

                    - <small>(Company: <?php echo e($mdc_test_session->company->name); ?>)</small>
                </h3>
            </div>
            <div class="col-md-2">
                <button id="btn-run-all-tests" onclick="configureAllTests()" class="btn btn-success pull-right" <?php echo e($mdc_test_session->is_finished == 1 ? 'disabled' : ''); ?>>
                    <i class="fa fa-play-circle"></i> Run All Tests
                </button>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php $__currentLoopData = \App\TestGroup::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo e($test_group->name); ?></h3>
            </div>

            <div class="box-body">
                <?php if( count($tests) > 0 ): ?>
                <div class="row tests-container">

                    <div class="col-md-12">
                        <div class="box box-success ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Initialization Tests</h3>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isInitializationTest($test)): ?>
                                    <?php $test_number++;?>
                                    <?php $__env->startComponent('tests.components.test_button', [
                                    'test' => $test,
                                    'mdc_test_session' => $mdc_test_session,
                                    'col_class' => 'col-md-6',
                                    'test_number' => $test_number
                                    ]); ?>
                                    <?php echo $__env->renderComponent(); ?>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box box-success ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Reading Tests</h3>
                            </div>

                            <div class="box-body">
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($test->testType->idt == 'read' && $test->test_group_id == $test_group->id && !isInitializationTest($test)): ?>
                                <?php $test_number++;?>
                                <?php $__env->startComponent('tests.components.test_button', ['test' => $test, 'mdc_test_session' => $mdc_test_session, 'test_number' => $test_number]); ?>
                                <?php echo $__env->renderComponent(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box box-success col-md-6">
                            <div class="box-header with-border">
                                <h3 class="box-title">Writing Tests</h3>
                            </div>

                            <div class="box-body">
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($test->testType->idt == 'write' && $test->test_group_id == $test_group->id && !isInitializationTest($test)): ?>
                                <?php $test_number++;?>
                                <?php $__env->startComponent('tests.components.test_button', ['test' => $test, 'mdc_test_session' => $mdc_test_session, 'test_number' => $test_number]); ?>
                                <?php echo $__env->renderComponent(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box box-success ">
                            <div class="box-header with-border">
                                <h3 class="box-title">On Demand Tests</h3>
                            </div>

                            <div class="box-body">
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($test->testType->idt == 'on_demand' && $test->test_group_id == $test_group->id && !isInitializationTest($test)): ?>
                                <?php $test_number++;?>
                                <?php $__env->startComponent('tests.components.test_button', ['test' => $test, 'mdc_test_session' => $mdc_test_session, 'test_number' => $test_number]); ?>
                                <?php echo $__env->renderComponent(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php else: ?>
                <p>No tests in this group</p>
                <?php endif; ?>
            </div>

            <div class="box-footer text-right">

                <?php if( \Auth::user()->hasPermission('finish_test') ): ?>
                <button onClick="finishTestSession('<?php echo e($mdc_test_session->id); ?>')" class="btn btn-sm btn-primary" <?php echo e(!$mdc_test_session->isAllTestsExecuted() || $mdc_test_session->is_finished == 1 ? 'disabled' : ''); ?>>
                    <i class="fa fa-save"></i>
                    Finish Test
                </button>
                <?php endif; ?>
                <?php if($mdc_test_session->is_finished): ?>
                Test Finished
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
    <!-- ./box-body -->
</div>

<!-- test modal -->
<div id="testModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Test</h4>
            </div>
            <div class="modal-body">

                <div class="loader-image-1 text-center">
                    <h3>Loading Test...</h3>
                    <img style="width: 70px;" src="<?php echo e(asset('app_images/loader.gif')); ?>" alt="">
                </div>

                <div class="test">
                </div>

            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div> -->
        </div>

    </div>
</div>


<!-- configure all tests modal -->
<div class="modal fade" id="configureAllTests">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Configuration for Running Tests</h4>
            </div>
            <div class="modal-body">
                <?php $__env->startComponent('tests.components.select_meters', [
                    'mdc_test_session' => $mdc_test_session    
                ]); ?>
                <?php echo $__env->renderComponent(); ?>

                <hr>
                <h4>Select Tests</h4>

                <div class="row tests-selection">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button onClick="runAllTests()" type="button" class="btn btn-success" <?php echo e($mdc_test_session->is_finished == 1 ? 'disabled' : ''); ?>>
                    <i class="fa fa-play-circle"></i> Run All Tests
                </button>
            </div>
        </div>
    </div>
</div>


<!-- all tests modal -->
<style>
    .all-tests-modal-body,
    .progress-modal-body {
        height: 68vh;
    }
</style>
<div id="alltestsModal" style="z-index: 50000; background-color: black;" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div style="width: 98%;" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div style="height: 80vh; background-color: #e2e2e2 !important; overflow: auto;" class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div style="margin-bottom: 0px;" class="box box-success">
                            <div class="box-header with-border">
                                Progress
                            </div>
                            <div style="overflow: auto;" class="box-body progress-modal-body">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>

                                <p>Current Test:</p>
                                <h2 id="current_test_name" style="margin-top: 0px; margin-bottom: 5px;"></h2>

                                <table id="current_test_progress_table" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="progress_icon col-md-1 text-center"></td> <td>Making Connection with MDC</td>
                                        </tr>

                                        <tr>
                                            <td class="progress_icon col-md-1 text-center"></td> <td>Wakeup/Connection Request Sent</td>
                                        </tr>

                                        <tr>
                                            <td class="progress_icon col-md-1 text-center"></td> <td>Smart Meter Connection Request</td>
                                        </tr>

                                        <tr>
                                            <td class="progress_icon col-md-1 text-center"></td> <td>Connection Established</td>
                                        </tr>

                                        <tr>
                                            <td class="progress_icon col-md-1 text-center"></td> <td>Data Retrieved</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-bottom: 0px;" class="box box-danger">
                            <div class="box-header with-border">
                                Tests
                            </div>
                            <div style="overflow: auto;" class="box-body all-tests-modal-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="location.reload()" type="button" class="btn btn-danger">
                    <i class="fa fa-stop"></i> Stop
                </button>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>

    function finishTestSession(testSessionId) {
        $.ajax({
            type: 'post',
            url: "<?php echo e(url('finish_test_session')); ?>",
            data: {id: testSessionId, _token: "<?php echo e(@csrf_token()); ?>"}
        })
        .done(function(data) {
            location.reload();
        })
        .fail(function(error) {
            if(error.status == 419) {
                alert('Session expired. Please try again');
                location.reload();
            }
        })
    }

    $(document).ready(function() {

        $('.tests-selection').empty().append(
            $('.tests-container').children().clone()
        )

        $.each($('.tests-selection .btn-test'), function(index, btn) {

            var testName = $(btn).data('test_name');
            var testNumber = $(btn).data('test_number');

            $(`<div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input test-checkbox" 
                ${testName != 'Create Device / Meter' ? 'checked' : ''} 
                data-test_number="${testNumber}" data-test_name="${testName}" >
                `+testName+`
              </label>
            </div>`).insertAfter($(btn));
            $(btn).remove();
        });
            

        $('#testModal').on('hidden.bs.modal', function() {
            if (!window.autoTestsLoop) {
                location.reload();
            }
        });

        $('.btn-test').click(function() {
            var button = $(this);
            var testId = $(button).data('test_id');
            var testName = $(button).data('test_name');
            loadTestView("<?php echo e($mdc_test_session->id); ?>", testId, testName);
        });

        function loadTestView(mdcTestSessionId, testId, testName) {

            $('#testModal .loader-image-1').show();
            $('#testModal .test').hide();

            $('#testModal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });

            $('#testModal .modal-title').html(testName);

            $.ajax({
                type: 'get',
                url: "<?php echo e(url('load-test-view')); ?>",
                data: {
                    mdc_test_session_id: mdcTestSessionId,
                    test_id: testId
                },
            }).done(function(data) {

                $('#testModal .test').html(data);

                $('#testModal .loader-image-1').hide();
                $('#testModal .test').show();

            }).fail(function(error) {
                console.log(error);

                var message = error.statusText;
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }

                $('#testModal .test').empty().append('<p>Error: ' + message + '</p>');
                $('#testModal .loader-image-1').hide('fast');
                $('#testModal .test').show('fast');
            });
        }
    });

    function setTestStatus(testStatus, remarks, attachment, button, dontHideModalAfterSettingStatus) {
        var mdc_test_status_id = $(button).data('mdc_test_status_id');

        var fd = new FormData();
        fd.append("_token", "<?php echo e(csrf_token()); ?>");
        fd.append('mdc_test_status_id', mdc_test_status_id);
        fd.append('status', testStatus);
        fd.append('remarks', remarks);
        if (attachment) {
            fd.append('attachment', attachment);
        }

        $.ajax({
            type: 'post',
            url: "<?php echo e(url('set_test_status')); ?>",
            processData: false,
            contentType: false,
            data: fd
        }).done(function(data) {
            if (window.autoTestsLoop) {
                if(!dontHideModalAfterSettingStatus) {
                    $(button).closest('.modal').modal('hide');
                }
            } else {
                Swal.fire({
                    'title': data.success ? 'Done' : 'Error',
                    'text': data.message,
                    'type': data.success ? 'success' : 'error',
                }).then(function() {
                    if(!dontHideModalAfterSettingStatus) {
                        $(button).closest('.modal').modal('hide');
                    }
                });
            }
        }).fail(function(error) {
            if (window.autoTestsLoop) {
                if(!dontHideModalAfterSettingStatus) { 
                    $(button).closest('.modal').modal('hide');
                }
            } else {
                alert('Server error occurred');
                if(!dontHideModalAfterSettingStatus) { 
                    $(button).closest('.modal').modal('hide');
                }
            }
        });
    }

    function setProgress(currentTestIndex, testsCount) {
        var progress = (currentTestIndex - 1) / testsCount * 100;
        if (progress <= 100) {
            progress = Math.round(progress);
            var progressBar = $('#alltestsModal .progress-bar');
            progressBar.css('width', progress + '%');
            progressBar.text(progress + '%');
        }

        $('.all-tests-modal-body tbody td#status_td_test_number_' + currentTestIndex)
            .empty()
            .append(
                $(`
                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                `)
            );

        $('.progress-modal-body #current_test_name').text(
            $('.all-tests-modal-body tbody td#testname_td_test_number_' + currentTestIndex).text()
        )
    }

    function fillAllTestsModalTestsBox() {
        $('.all-tests-modal-body').empty();

        $('.all-tests-modal-body').append(
            $(`
                <table class="table table-bordered">
                    <tbody></tbody>
                </div>
            `)
        );

        $.each($('.btn-test'), function(index, item) {
            var testName = $(item).data('test_name');
            var testNumber = $(item).data('test_number');

            $('.all-tests-modal-body tbody').append(
                $(`
                    <tr>
                        <td class="text-center" id="status_td_test_number_${testNumber}">-</td>
                        <td id="testname_td_test_number_${testNumber}">${testName}</td>
                    </tr>
                `)
            );
        })
    }

    function configureAllTests() {
        $('#configureAllTests').modal('show');
    }

    function runAllTests() {
        $('#btn-run-all-tests').attr('disabled', true);
        $('#alltestsModal').modal('show');

        $.each($('#configureAllTests .test-checkbox:not(:checked)'), function(index, uncheckedCkb){
            var testNumber = $(uncheckedCkb).data('test_number');
            $("[data-test_number='" + testNumber + "']").remove();
        })

        // reset test numbers after deletion
        $.each($('.btn-test'), function(index, btn){
            $(btn).attr('data-test_number', index + 1);
        })

        var testsCount = $('#configureAllTests .test-checkbox:checked').length;

        var currentTestProgress = 0;

        fillAllTestsModalTestsBox();

        var currentTestIndex = 0;
        var isSomeTestInProgress = false;
        window.autoTestsLoop = setInterval(function() {
            if (currentTestIndex > testsCount) {
                clearInterval(window.autoTestsLoop)
                window.autoTestsLoop = null; // this is important
                location.reload();
            }

            if (!isSomeTestInProgress) {
                currentTestProgress = 0;
                $('#current_test_progress_table .progress_icon').empty();
                currentTestIndex++
                setProgress(currentTestIndex, testsCount);

                isSomeTestInProgress = true;
                $("[data-test_number='" + currentTestIndex + "']").click();
            }

            // find and click start_test button
            if ($('.btn-start-test:visible').length > 0) {
                $('.btn-start-test:visible').click();
            }

            // find pass-fail-buttons
            if ($('.pass-fail-buttons:visible').length > 0 && $('.no-data').length == 0 ) {
                $('.pass-fail-buttons:visible').find('[value="pass"]').click();
                $('.pass-fail-buttons:visible').find('.btn-set-test-status').click();

                $('.all-tests-modal-body tbody td#status_td_test_number_' + currentTestIndex)
                .empty()
                .append(
                    $(`
                        <i class="fa fa-check text-green"></i>
                    `)
                );

                currentTestProgress = 5;
                setProgress(currentTestIndex + 1, testsCount);
                isSomeTestInProgress = false; // test completed
            }

            if ($('.pass-fail-buttons:visible').length > 0 && $('.no-data').length > 0 ) {
                $('.pass-fail-buttons:visible').find('[value="fail"]').click();
                $('.pass-fail-buttons:visible').find('[name="remarks"]').val('No data exists');
                $('.pass-fail-buttons:visible').find('.btn-set-test-status').click();

                $('.all-tests-modal-body tbody td#status_td_test_number_' + currentTestIndex)
                .empty()
                .append(
                    $(`
                        <i class="fa fa-times text-red"></i>
                    `)
                );

                currentTestProgress = 5;
                setProgress(currentTestIndex + 1, testsCount);
                isSomeTestInProgress = false; // test completed
            }

            // find if test has failed
            if ( $('.test-failed:visible').length > 0 ) {
                $('#testModal').modal('hide');

                $('.all-tests-modal-body tbody td#status_td_test_number_' + currentTestIndex)
                .empty()
                .append(
                    $(`
                        <i class="fa fa-times text-red"></i>
                    `)
                );

                currentTestProgress = 5;
                setProgress(currentTestIndex + 1, testsCount);
                isSomeTestInProgress = false; // test completed
            }

            $('#current_test_progress_table .progress_icon').each(function(index, td){
                if(index == currentTestProgress) {
                    $(td)
                        .empty()
                        .append('<i class="fa fa-spinner fa-pulse fa-fw"></i>')
                } else if (currentTestProgress > index) {
                    $(td)
                        .empty()
                        .append('<i class="fa fa-check text-green"></i>')
                }
            })

            if(currentTestProgress < 4) {
                currentTestProgress++;
            }

            console.log('tests_loop_running');
        }, 2000);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\dev7\htdocs\udil\resources\views/tests/tests.blade.php ENDPATH**/ ?>