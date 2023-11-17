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

    <div class="form-group col-md-6">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime"  >
            <option value="<?php echo e($now->format('d-M-Y H:i:s')); ?>"><?php echo e($now->format('d-M-Y H:i:s')); ?></option>
        </select>
    </div>

    <?php $__env->startComponent('components.datetimepicker', [
            'title' => 'Activation Date Time',
            'name' => 'activation_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="col-md-12">
        <h4>Day Profile</h4>
        <table class="table table-bordered">
            <tr>
                <td>
                    <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="day_profile[0][name]" value="d1"  >
                    </div>
                </td>
                <td>
                    <label>Tariff Slabs</label>
                    <input type="text" class="form-control" name="day_profile[0][tariff_slabs][0]" value="08:00"  >
                    <input type="text" class="form-control" name="day_profile[0][tariff_slabs][1]" value="17:00"  >
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="day_profile[1][name]" value="d2"  >
                    </div>
                </td>
                <td>
                    <label>Tariff Slabs</label>
                    <input type="text" class="form-control" name="day_profile[1][tariff_slabs][0]" value="09:00"  >
                    <input type="text" class="form-control" name="day_profile[1][tariff_slabs][1]" value="18:00"  >
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-12">
        <h4>Week Profile</h4>
        <table class="table table-bordered">
            <tr>
                <td>
                    <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="week_profile[0][name]" value="w1"  >
                    </div>
                </td>
                <td>
                    <label>Tariff Slabs</label>
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][0]" value="d1"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][1]" value="d2"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][2]" value="d3"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][3]" value="d4"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][4]" value="d5"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][5]" value="d6"  >
                    <input type="text" class="form-control" name="week_profile[0][weekly_day_profile][6]" value="d7"  >
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="week_profile[1][name]" value="w2"  >
                    </div>
                </td>
                <td>
                    <label>Tariff Slabs</label>
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][0]" value="d1"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][1]" value="d2"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][2]" value="d3"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][3]" value="d4"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][4]" value="d5"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][5]" value="d6"  >
                    <input type="text" class="form-control" name="week_profile[1][weekly_day_profile][6]" value="d7"  >
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-12">
        <h4>Season Profile</h4>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Week Profile Name</th>
                <th>Start Date</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control" name="name[]" value="s1"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="week_profile_name[]" value="w1"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="start_date[]" value="01-01"  >
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control" name="name[]" value="s2"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="week_profile_name[]" value="w1"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="start_date[]" value="01-04"  >
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-12">
        <h4>Holiday Profile</h4>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Day Profile Name</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control" name="name[]" value="h1"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="date[]" value="23-03"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="day_profile_name[]" value="d2"  >
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control" name="name[]" value="h2"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="date[]" value="23-03"  >
                </td>
                <td>
                    <input type="text" class="form-control" name="day_profile_name[]" value="d2"  >
                </td>
            </tr>
        </table>
    </div>

</div>
<?php /**PATH D:\dev\htdocs\udil2\resources\views/tests/test_forms/time_of_use_change.blade.php ENDPATH**/ ?>