<?php $__env->startComponent('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 1,
        'add_privatekey' => 1
    ]); ?>
<?php echo $__env->renderComponent(); ?>
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />

<h4>Select Meters</h4>
<table class="table table-bordered">
    <thead>
        <th class="col-md-2">Select</th>
        <th class="col-md-5">MSN</th>
        <th class="col-md-5">Global Device ID</th>
    </thead>
    <tbody>
        <?php $__currentLoopData = $mdc_test_session->meters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <input type="checkbox" onchange="meterCheckboxChanged(this)" checked>
            </td>
            <td>
                <?php echo e($meter->msn); ?>

                <input type="hidden" name="global_device_id[]" value="<?php echo e($meter->global_device_id); ?>">
            </td>
            <td><?php echo e($meter->global_device_id); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<script>
    function meterCheckboxChanged(ckb){
        var checked = $(ckb).prop('checked');
        var tr = $(ckb).closest('tr');
        if(checked == false) {
            tr.css('text-decoration', 'line-through');
        } else {
            tr.css('text-decoration', 'initial');
        }
        tr.find("input[type='hidden']").prop('disabled', !checked);
    }
</script>

<div class="row">

    <div class="form-group col-md-12">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime" readonly>
            <option value="<?php echo e($now->format('d-M-Y H:i:s')); ?>"><?php echo e($now->format('d-M-Y H:i:s')); ?></option>
        </select>
    </div>

    <?php echo \App\SelectHelper::createSelect('Type', 'type', \App\SelectHelper::$types_for_apms, 'col-md-6'); ?>

    <?php echo \App\SelectHelper::createSelect('Enable Tripping', 'enable_tripping', \App\SelectHelper::$enable_tripping_for_apms, 'col-md-6'); ?>

    
    <div class="form-group col-md-6">
        <label for="">Critical Event Threshold Limit</label>
        <input type="number" step="any" class="form-control" name="critical_event_threshold_limit" min="0" value="0">
    </div>

    <div class="form-group col-md-6">
        <label for="">Critical Event Log Time (seconds)</label>
        <input type="number" class="form-control" name="critical_event_log_time" min="0" value="0">
    </div>

    <div class="form-group col-md-6">
        <label for="">Tripping Event Threshold Limit</label>
        <input type="number" step="any" class="form-control" name="tripping_event_threshold_limit" min="0" value="0">
    </div>

    <div class="form-group col-md-6">
        <label for="">Tripping Event Log Time (seconds)</label>
        <input type="number" class="form-control" name="tripping_event_log_time" min="0" value="0">
    </div>

</div><?php /**PATH D:\dev\htdocs\udil\resources\views/tests/test_forms/apms_tripping_events.blade.php ENDPATH**/ ?>