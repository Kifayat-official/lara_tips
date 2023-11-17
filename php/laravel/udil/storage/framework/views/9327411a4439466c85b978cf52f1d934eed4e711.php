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

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'Start Datetime',
            'name' => 'start_datetime',
            'class' => 'col-md-6',
            'value' => $test->idt == 'reading_stored_monthly_billing_data' ? 
                \Carbon\Carbon::now()->addMonths(-2)->format('d-M-Y H:i:s') :
                \Carbon\Carbon::now()->addDays(-2)->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'End Datetime',
            'name' => 'end_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="form-group col-md-6">
      <label for="">Starting Index</label>
      <input type="number" class="form-control" name="starting_index" value="0">
    </div>

    <div class="form-group col-md-6">
      <label for="">Limit</label>
      <input type="number" class="form-control" name="limit" value="10">
    </div>

</div><?php /**PATH D:\dev\htdocs\udil2_testing\resources\views/tests/test_forms/reading_test_through_database.blade.php ENDPATH**/ ?>