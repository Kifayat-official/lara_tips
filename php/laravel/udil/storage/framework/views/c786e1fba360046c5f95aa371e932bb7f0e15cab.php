<div class="box hidden-print">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo e(isset($title) ? $title : 'Reports Filter'); ?></h3>
  </div>
  <!-- /.box-header -->

  <?php

    if(isset($show_complete_incomplete_selector))
    {
      // don't do
    }
    else if(request()->has('completed_tests_only'))
    {
      $show_complete_incomplete_selector = request()->completed_tests_only == 1 ? true : false;
      session(['completed_tests_only' => $show_complete_incomplete_selector]);
    }
    else if(Session::has('completed_tests_only')) {
      // dd( session('completed_tests_only') );
      $show_complete_incomplete_selector = session('completed_tests_only') == 1 || session('completed_tests_only') == true ? true : false;
    }

    $test_sessions = new \App\MdcTestSession;

    if($show_complete_incomplete_selector)
    {
      $test_sessions = $test_sessions->where('is_finished', 1);
    }

    $test_sessions = $test_sessions->get();

  ?>

  <div class="box-body">

    <?php if(isset($show_complete_incomplete_selector) && $show_complete_incomplete_selector == true): ?>
    <form method="get">
      <div class="form-group">
        <label for="">Show Completed Tests Only</label>
        <select class="form-control" id="completed_tests_only" name="completed_tests_only">
          <option value="0">No</option>
          <option value="1" <?php echo e($show_complete_incomplete_selector ? 'selected' : ''); ?>>Yes</option>
        </select>
      </div>
    </form>
    <?php endif; ?>

    <form action="<?php echo e($url); ?>" method="get">
      <label for="company">Select MDC Test Sessions</label>
      <select class="form-control form-control-sm" name="mdc_test_session_id">
        <?php $__currentLoopData = $test_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test_session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($test_session->id); ?>" <?php echo e(isset($mdc_test_session) && $mdc_test_session->id == $test_session->id ? 'selected' : ''); ?>>
          <?php echo e($test_session->id_numeric); ?> - <?php echo e($test_session->company->name); ?> - [<?php echo e($test_session->testProfile->name); ?>]
        </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <br>

      <div class="text-right">
        <button type="button" class="btn btn-default" onClick="printReport()">
          <?php echo e(isset($print_report_button_title) ? $print_report_button_title : 'Export Report to PDF'); ?>

        </button>
        <button type="submit" class="btn btn-success">
          <?php echo e(isset($show_report_btn_title) ? $show_report_btn_title : 'Show Report'); ?>

        </button>
      </div>
    </form>

  </div>
  <!-- ./box-body -->
</div>

<?php $__env->startSection('js'); ?>
<script>

  $(document).ready(function(){

    $('#hide-background').change(function(){
      $('.background-image').toggle();
    });

    $('#completed_tests_only').change(function(){
      $(this).closest('form').submit()
    });

    $('[name="mdc_test_session_id"]').change(function(){
      $(this).closest('form').submit()
    });

    if( $('[name="mdc_test_session_id"]').val() != null && $('[name="mdc_test_session_id"]').val() != '' && $('[name="mdc_test_session_id"]').val() != "<?php echo e(isset($mdc_test_session) ? $mdc_test_session->id : 's'); ?>") {
      $('[name="mdc_test_session_id"]').closest('form').submit()
    }
  });

  function printReport() {
    if( $('#tests_report, #certificate').length == 0 ) {
      alert('No report found. Please click [Show Report] button first');
      return;
    }

    window.print();
  }
</script>
<?php $__env->stopSection(); ?>
<?php /**PATH D:\dev\htdocs\udil2_testing\resources\views/components/reports_filter.blade.php ENDPATH**/ ?>