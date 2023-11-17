<?php $__env->startSection('content'); ?>
  <?php $__env->startComponent('components.reports_filter', [
    'url' => url('detailed_test_report_data'),
    'mdc_test_session' => isset($mdc_test_session) ? $mdc_test_session : null,
    'show_complete_incomplete_selector' => true,
  ]); ?>
  <?php echo $__env->renderComponent(); ?>

<?php if( isset($mdc_test_session) ): ?>

  <div id="tests_report" class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Tests Report</h3>

    </div>
      <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
      <table>
        <tbody>
          <tr>
            <td>Company: &nbsp;</td>
            <td><?php echo e($mdc_test_session->company->name); ?></td>
          </tr>
          <tr>
          <td>Representative: &nbsp;</td>
            <td><?php echo e($mdc_test_session->company_rep); ?></td>
          </tr>
          <tr>
            <td>Rep. Designation: &nbsp;</td>
            <td><?php echo e($mdc_test_session->company_rep_designation); ?></td>
          </tr>
          <tr>
            <td>MDC Version: &nbsp;</td>
            <td><?php echo e($mdc_test_session->mdc_version); ?></td>
          </tr>
        </tbody>
      </table>

        </div>
      </div>
        <br>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="col-md-1">Sr. No</th>
            <th>Test Type</th>
            <th class="col-md-1">Status</th>
            <th class="col-md-4">Details</th>
            <th class="col-md-3">Picture</th>
          </tr>
        </thead>
          <tbody>
            <?php $__currentLoopData = $mdc_test_session->testProfile->tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($loop->index + 1); ?></td>
              <td><?php echo e($test->name); ?></td>

              <?php
                $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);
              ?>

              <?php if($mdc_test_status == null): ?>
                <td><i class="fa fa-exclamation" aria-hidden="true"></i></td>
                <td>Test Not Initialized</td>
                <td></td>
              <?php elseif($mdc_test_status != null && $mdc_test_status->is_pass == 1): ?>
                <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
                <td>Test Pass</td>
                <td></td>
              <?php elseif($mdc_test_status != null && $mdc_test_status->is_pass == 0): ?>
              <?php
                    $content = basename($mdc_test_status->attachment);
              ?>
                <td><i class="fa fa-times text-danger" aria-hidden="true"></i></td>
                <td><?php echo e($mdc_test_status->remarks); ?></td>
                <td> <img src="<?php echo e(route('image.displayImage', [$content] )); ?>" width="320px" height="220px" title="" alt=""></td>

              <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
      </table>

    </div>
      <!-- ./box-body -->
  </div>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script> console.log('Hi!'); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dev\htdocs\udil\resources\views/reports/detailed_test_report.blade.php ENDPATH**/ ?>