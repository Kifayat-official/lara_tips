<?php $__env->startComponent('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 1,
        'add_privatekey' => 1
    ]); ?>
<?php echo $__env->renderComponent(); ?>
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />


<div class="row">

    <div class="form-group col-md-12">
        <label for="">Meter</label>        
        <select class="form-control" name="global_device_id" required>
            <?php $__currentLoopData = $mdc_test_session->meters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($meter->global_device_id); ?>">MSN: <?php echo e($meter->msn); ?>, Global Device ID: <?php echo e($meter->global_device_id); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <input type="hidden" name="type" value="<?php echo e($type); ?>">

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'Start Datetime',
            'name' => 'start_datetime',
            'class' => 'col-md-6',
            'value' => $test->idt == 'on_demand_data_read_mbil' ? 
                \Carbon\Carbon::now()->addMonths(-2)->format('d-M-Y H:i:s') : 
                \Carbon\Carbon::now()->addMinutes(-2)->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'End Datetime',
            'name' => 'end_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>
    
</div><?php /**PATH D:\Xamp\htdocs\testing_suite\resources\views/tests/test_forms/on_demand_data_read.blade.php ENDPATH**/ ?>