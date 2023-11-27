<?php if(isset($col_class)): ?>
<div class="<?php echo e($col_class); ?>">
<?php endif; ?>


<button style="text-align: left;" class="btn-test btn btn-block btn-secondary" data-test_id="<?php echo e($test->id); ?>" data-test_number=<?php echo e($test_number); ?> data-test_name="<?php echo e($test->name); ?>" 
    <?php echo e($mdc_test_session->is_finished == 1 ? 'disabled' : ''); ?> >
    <strong><?php echo e(isset($test_number) ? $test_number . ' - ' : ''); ?></strong><?php echo e($test->name); ?>

    <br>
    
    <?php
        $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);

        $status_text = 'Not Initialized';
        $css_class = 'primary';

        if ($mdc_test_status != null) {
            $status_text = $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail';
            $css_class = $mdc_test_status->is_pass == 1 ? 'success' : 'danger';
        }
    ?>

    <span class="label label-<?php echo e($css_class); ?>">
        Status: <?php echo e($status_text); ?>

    </span>
</button>
<?php if(isset($col_class)): ?>
</div>
<?php endif; ?><?php /**PATH D:\udil\htdocs\udil\resources\views/tests/components/test_button.blade.php ENDPATH**/ ?>