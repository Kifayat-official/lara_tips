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
        <?php
            $curr_meter[] = $meter;
        ?>
        <tr>
            <td>
                <input type="checkbox" onchange="meterCheckboxChanged(this)" checked>
            </td>
            <td>
                <?php echo e($meter->msn); ?>

                <input type="hidden" name="device_identity[<?php echo e($loop->index); ?>][dsn]" value="<?php echo e($meter->msn); ?>">
            </td>
            <td>
                <input class="form-control" type="text" name="device_identity[<?php echo e($loop->index); ?>][global_device_id]" value="<?php echo e($meter->global_device_id); ?>">
            </td>
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
    <div class="form-group col-md-6">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime" readonly>
            <option value="<?php echo e($now->format('d-M-Y H:i:s')); ?>"><?php echo e($now->format('d-M-Y H:i:s')); ?></option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Communication Interval</label>
        <input class="form-control" type="number" name="communication_interval" value="<?php echo e($curr_meter[0]->comm_interval); ?>" min="1" />
    </div>

    <div class="form-group col-md-6">
        <label for="">Device Type</label>
        <select class="form-control" name="device_type">
            <option value="meter" <?php if($curr_meter[0]->device_type == 'meter'): ?> selected <?php endif; ?>>meter</option>
            <option value="DCU" <?php if($curr_meter[0]->device_type == 'DCU'): ?> selected <?php endif; ?>>DCU</option>
            <option value="other" <?php if($curr_meter[0]->device_type == 'other'): ?> selected <?php endif; ?>>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">MDI Reset Date</label>
        <input class="form-control" type="number" name="mdi_reset_date" value="<?php echo e($curr_meter[0]->mdi_reset_date); ?>" min="1" max="28" />
    </div>

    <div class="form-group col-md-6">
        <label for="">MDC Reset Time</label>
        <input class="form-control" type="text" name="mdi_reset_time" value="<?php echo e($curr_meter[0]->mdi_reset_time); ?>" />
    </div>

    <div class="form-group col-md-6">
        <label for="">Sim Number</label>
        <input class="form-control" type="text" name="sim_number" value="<?php echo e($curr_meter[0]->sim_number); ?>"  />
    </div>
    <div class="form-group col-md-6">
        <label for="">SIM ID</label>
        <input class="form-control" type="text" name="sim_id" value="<?php echo e($curr_meter[0]->sim_id); ?>" />
    </div>

    <div class="form-group col-md-6">
        <label for="">phase</label>
        <select class="form-control" name="phase">
            <option value="Single" <?php if($curr_meter[0]->phase == 'Single'): ?> selected <?php endif; ?>>Single</option>
            <option value="Three-phase" <?php if($curr_meter[0]->phase == 'Three-phase'): ?> selected <?php endif; ?>>Three-phase</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Meter Type</label>
        <select class="form-control" name="meter_type">
            <option value="Normal" <?php if($curr_meter[0]->meter_type == 'Normal'): ?> selected <?php endif; ?>>Normal</option>
            <option value="Whole Current" <?php if($curr_meter[0]->meter_type == 'Whole Current'): ?> selected <?php endif; ?>>Whole Current</option>
            <option value="CTO" <?php if($curr_meter[0]->meter_type == 'CTO'): ?> selected <?php endif; ?>>CTO</option>
            <option value="CTPT" <?php if($curr_meter[0]->meter_type == 'CTPT'): ?> selected <?php endif; ?>>CTPT</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Communication Mode</label>
        <select class="form-control" name="communication_mode">
            <option value="GPRS/3G/4G" <?php if($curr_meter[0]->comm_mode == 'GPRS/3G/4G'): ?> selected <?php endif; ?>>GPRS/3G/4G</option>
            <option value="RF" <?php if($curr_meter[0]->comm_mode == 'RF'): ?> selected <?php endif; ?>>RF</option>
            <option value="PLC" <?php if($curr_meter[0]->comm_mode == 'PLC'): ?> selected <?php endif; ?>>PLC</option>
            <option value="Ethernet" <?php if($curr_meter[0]->comm_mode == 'Ethernet'): ?> selected <?php endif; ?>>Ethernet</option>
            <option value="other" <?php if($curr_meter[0]->comm_mode == 'other'): ?> selected <?php endif; ?>>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Communication Type</label>
        <select class="form-control" name="communication_type">
            <option value="always on" <?php if($curr_meter[0]->comm_type == 'always on'): ?> selected <?php endif; ?>>always on</option>
            <option value="periodic-on" <?php if($curr_meter[0]->comm_type == 'periodic-on'): ?> selected <?php endif; ?>>periodic-on</option>
            <option value="on-demand" <?php if($curr_meter[0]->comm_type == 'on-demand'): ?> selected <?php endif; ?>>on-demand</option>
            <option value="other" <?php if($curr_meter[0]->comm_type == 'other'): ?> selected <?php endif; ?>>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Bidirectional Device</label>
        <select class="form-control" name="bidirectional_device">
            <option value="No" <?php if($curr_meter[0]->bidirectional_device == 'No'): ?> selected <?php endif; ?>>No</option>
            <option value="Yes" <?php if($curr_meter[0]->bidirectional_device == 'Yes'): ?> selected <?php endif; ?>>Yes</option>
        </select>
    </div>
<!--
    <?php echo \App\SelectHelper::createSelect( 'phase', 'phase', \App\SelectHelper::$phases, 'col-md-6', 3 ); ?>


    <?php echo \App\SelectHelper::createSelect( 'Meter Type', 'meter_type', \App\SelectHelper::$meter_types, 'col-md-6' ); ?>


    <?php echo \App\SelectHelper::createSelect( 'Communication Mode', 'communication_mode', \App\SelectHelper::$communication_modes, 'col-md-6' ); ?>


    <?php echo \App\SelectHelper::createSelect( 'Communication Type', 'communication_type', \App\SelectHelper::$communication_types, 'col-md-6' ); ?>


    <?php echo \App\SelectHelper::createSelect( 'Bidirectional Device', 'bidirectional_device', \App\SelectHelper::$yes_no, 'col-md-6' ); ?>

-->

</div>

<?php /**PATH D:\dev\htdocs\udil2_testing\resources\views/tests/test_forms/create_device_meter.blade.php ENDPATH**/ ?>