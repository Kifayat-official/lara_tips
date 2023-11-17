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

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'Start Datetime',
            'name' => 'start_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'End Datetime',
            'name' => 'end_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->addHours(1)->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="col-md-12">
        <table class="table table-bordered load-shedding-schedule">
            <thead>
                <th>Action Time</th>
                <th>Relay Operate</th>
                <th></th>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="load_shedding_slabs[%%INDEX%%][action_time]" value="06:00:00">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="load_shedding_slabs[%%INDEX%%][relay_operate]" value="0">
                    </td>
                    <td>
                        <button onClick="deleteActionTime(this)" type="button" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="load_shedding_slabs[%%INDEX%%][action_time]" value="09:00:00">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="load_shedding_slabs[%%INDEX%%][relay_operate]" value="1">
                    </td>
                    <td>
                        <button onClick="deleteActionTime(this)" type="button" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button onClick="addActionTime()" type="button" class="btn btn-sm btn-info">
            <i class="fa fa-plus"></i> Add Action Time
        </button>
        <br><br>
    </div>
</div>

<script>
    $(document).ready(function(){
        lastTr = $('table.load-shedding-schedule tr').last()[0];
        reIndexTableArrayInputs($('table.load-shedding-schedule'));
    });

    function addActionTime() {
        $('table.load-shedding-schedule tbody').append($(lastTr).clone());
        reIndexTableArrayInputs($('table.load-shedding-schedule'));
    }

    function deleteActionTime(element) {
        $(element).closest('tr').remove();
        reIndexTableArrayInputs($('table.load-shedding-schedule'));
    }
</script><?php /**PATH D:\dev\htdocs\udil\resources\views/tests/test_forms/load_shedding_scheduling.blade.php ENDPATH**/ ?>