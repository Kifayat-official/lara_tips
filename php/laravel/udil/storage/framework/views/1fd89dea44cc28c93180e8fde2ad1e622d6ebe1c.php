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

    <?php echo \App\SelectHelper::createSelect('Communication Mode', 'communication_mode', \App\SelectHelper::$communication_modes, 'col-md-6'); ?>

    <?php echo \App\SelectHelper::createSelect('Bidirectional Device', 'bidirectional_device', \App\SelectHelper::$yes_no, 'col-md-6'); ?>

    <?php echo \App\SelectHelper::createSelect('Communication Type', 'communication_type', \App\SelectHelper::$communication_types, 'col-md-6'); ?>


    <div class="form-group col-md-6">
        <label for="">Communication Interval</label>
        <input type="number" class="form-control" name="communication_interval" min="0" value="0">
    </div>

    <?php echo \App\SelectHelper::createSelect('Phase', 'phase', \App\SelectHelper::$phases, 'col-md-6', 3); ?>

    <?php echo \App\SelectHelper::createSelect('Meter Type', 'meter_type', \App\SelectHelper::$meter_types, 'col-md-6'); ?>


</div><?php /**PATH D:\dev\htdocs\udil\resources\views/tests/test_forms/update_device_metadata.blade.php ENDPATH**/ ?>