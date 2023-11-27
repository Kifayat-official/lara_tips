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
    
</div><?php /**PATH D:\dev\htdocs\udil\resources\views/tests/test_forms/on_demand_parameter_read.blade.php ENDPATH**/ ?>