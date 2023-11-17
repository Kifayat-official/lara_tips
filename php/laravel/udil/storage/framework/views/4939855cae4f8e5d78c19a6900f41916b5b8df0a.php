<?php $__env->startComponent('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 1,
        'add_privatekey' => 1
    ]); ?>
<?php echo $__env->renderComponent(); ?>
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />
<?php

$uniqid = uniqid();

?>
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
        <table id="day_profile_<?php echo e($uniqid); ?>" class="table table-bordered day_profile_table">
            <thead>
                <th>Name</th>
                <th>Tariff Slabs</th>
                <th>Action</th>
            </thead>
            <tbody>
                <input type="hidden" class="form-control" name="day_profile[]">
            </tbody>
        </table>
        <div class="text-right">
            <button onclick="addDayProfile('#day_profile_<?php echo e($uniqid); ?>')" type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i>
                Add Day Profile
            </button>
        </div>
    </div>

    <div class="col-md-12">
        <h4>Week Profile</h4>
        <table id="week_profile_<?php echo e($uniqid); ?>" class="table table-bordered week_profile_table">
            <thead>
                <th>Name</th>
                <th>Tariff Slabs</th>
                <th>Action</th>
            </thead>
            <tbody>
                <input type="hidden" class="form-control" name="week_profile[]">
            </tbody>
        </table>
        <div class="text-right">
            <button onclick="addWeekProfile('#week_profile_<?php echo e($uniqid); ?>')" type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i>
                Add Week Profile
            </button>
        </div>
    </div>

    <div class="col-md-12">
        <h4>Season Profile</h4>
        <table id="season_profile_<?php echo e($uniqid); ?>" class="table table-bordered season_profile_table">
            <thead>
                <th>Name</th>
                <th>Week Profile Name</th>
                <th>Start Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <input type="hidden" class="form-control" name="season_profile[]">
            </tbody>
        </table>
        <div class="text-right">
            <button onclick="addSeasonProfile('#season_profile_<?php echo e($uniqid); ?>')" type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i>
                Add Season Profile
            </button>
        </div>
    </div>

    <div class="col-md-12">
        <h4>Holiday Profile</h4>
        <table id="holiday_profile_<?php echo e($uniqid); ?>" class="table table-bordered holiday_profile_table">
            <thead>
                <th>Name</th>
                <th>Date</th>
                <th>Day Profile Name</th>
                <th>Action</th>
            </thead>
            <tbody>
                    <input type="hidden" class="form-control" name="holiday_profile[]">
            </tbody>
        </table>
        <div class="text-right">
            <button onclick="addHolidayProfile('#holiday_profile_<?php echo e($uniqid); ?>')" type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i>
                Add Holiday Profile
            </button>
        </div>
        <br><br>
    </div>

</div>

<script>
    var holiday_profile_count = 0;
    var season_profile_count = 0;
    var week_slab_count1 = 0;
    var week_slab_count2 = 0;
    var week_slab_count3 = 0;
    var week_slab_count4 = 0;
    var tariff_slab_count1 = 0;
    var tariff_slab_count2 = 0;
    var tariff_slab_count3 = 0;
    var tariff_slab_count4 = 0;
    var tariff_slab_count5 = 0;
    var tariff_slab_count6 = 0;
    var tariff_slab_count7 = 0;
    var day_profile_count = 0;
    var week_profile_count = 0;
    var sum_of_day_profile = 0;
    var sum_of_week_profile = 0;
    var sum_of_season_profile = 0;
    var sum_of_holiday_profile = 0;

    function removeTariffSlabs(button) {
        $(button).closest('div').remove();

        if($(button).attr("value") == 't1')
        {
            $('[id=t1]').each(function(i){
                $(this).attr('name', 'day_profile[0][tariff_slabs]['+i+']');
            });
            tariff_slab_count1 --;
        }
        if($(button).attr("value") == 't2')
        {
            $('[id=t2]').each(function(i){
                $(this).attr('name', 'day_profile[1][tariff_slabs]['+i+']');
            });
            tariff_slab_count2 --;
        }
        if($(button).attr("value") == 't3')
        {
            $('[id=t3]').each(function(i){
                $(this).attr('name', 'day_profile[2][tariff_slabs]['+i+']');
            });
            tariff_slab_count3 --;
        }
        if($(button).attr("value") == 't4')
        {
            $('[id=t4]').each(function(i){
                $(this).attr('name', 'day_profile[3][tariff_slabs]['+i+']');
            });
            tariff_slab_count4 --;
        }
        if($(button).attr("value") == 't5')
        {
            $('[id=t5]').each(function(i){
                $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
            });
            tariff_slab_count5 --;
        }
        if($(button).attr("value") == 't6')
        {
            $('[id=t6]').each(function(i){
                $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
            });
            tariff_slab_count6 --;
        }
        if($(button).attr("value") == 't7')
        {
            $('[id=t7]').each(function(i){
                $(this).attr('name', 'day_profile[6][tariff_slabs]['+i+']');
            });
            tariff_slab_count7 --;
        }
    }

    function removeDaySlabs(button) {
        $(button).closest('tr').remove();
        $('[id=day_profile]').each(function(i){
                var n = i+1;
                $(this).attr('name', 'day_profile['+i+'][name]');
                $(this).attr('value', 'd'+n+'');
            });
        day_profile_count --;
        sum_of_day_profile --;

        if(day_profile_count == 0)
        {
            $('.day_profile_table'+ " tbody").append(
                `
                <input type="hidden" class="form-control" name="day_profile[]">
                `
            );
        }
            if($(button).val() == 0)
            {
                tariff_slab_count1 = 0;
                if($('#t2').length)
                {

                    $('[id=t2]').each(function(i){
                        $(this).attr('name', 'day_profile[0][tariff_slabs]['+i+']');
                        $(this).attr('id','t1');
                    });
                    $('[id=remove_tariff_slab_t2]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t1');
                        $(this).attr('value','t1');
                    });
                    tariff_slab_count1 = tariff_slab_count2;
                    tariff_slab_count2 = 0;
                }

                if($('#t3').length)
                {

                    $('[id=t3]').each(function(i){
                        $(this).attr('name', 'day_profile[1][tariff_slabs]['+i+']');
                        $(this).attr('id','t2');
                    });
                    $('[id=remove_tariff_slab_t3]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t2');
                        $(this).attr('value','t2');
                    });
                    tariff_slab_count2 = tariff_slab_count3;
                    tariff_slab_count3 = 0;
                }

                if($('#t4').length)
                {

                    $('[id=t4]').each(function(i){
                        $(this).attr('name', 'day_profile[2][tariff_slabs]['+i+']');
                        $(this).attr('id','t3');
                    });
                    $('[id=remove_tariff_slab_t4]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t3');
                        $(this).attr('value','t3');
                    });
                    tariff_slab_count3 = tariff_slab_count4;
                    tariff_slab_count4 = 0;
                }

                if($('#t5').length)
                {

                    $('[id=t5]').each(function(i){
                        $(this).attr('name', 'day_profile[3][tariff_slabs]['+i+']');
                        $(this).attr('id','t4');
                    });
                    $('[id=remove_tariff_slab_t5]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t4');
                        $(this).attr('value','t4');
                    });
                    tariff_slab_count4 = tariff_slab_count5;
                    tariff_slab_count5 = 0;
                }

                if($('#t6').length)
                {

                    $('[id=t6]').each(function(i){
                        $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
                        $(this).attr('id','t5');
                    });
                    $('[id=remove_tariff_slab_t6]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t5');
                        $(this).attr('value','t5');
                    });
                    tariff_slab_count5 = tariff_slab_count6;
                    tariff_slab_count6 = 0;
                }

                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 1)
            {
                tariff_slab_count2 = 0;
                if($('#t3').length)
                {

                    $('[id=t3]').each(function(i){
                        $(this).attr('name', 'day_profile[1][tariff_slabs]['+i+']');
                        $(this).attr('id','t2');
                    });
                    $('[id=remove_tariff_slab_t3]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t2');
                        $(this).attr('value','t2');
                    });
                    tariff_slab_count2 = tariff_slab_count3;
                    tariff_slab_count3 = 0;
                }

                if($('#t4').length)
                {

                    $('[id=t4]').each(function(i){
                        $(this).attr('name', 'day_profile[2][tariff_slabs]['+i+']');
                        $(this).attr('id','t3');
                    });
                    $('[id=remove_tariff_slab_t4]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t3');
                        $(this).attr('value','t3');
                    });
                    tariff_slab_count3 = tariff_slab_count4;
                    tariff_slab_count4 = 0;
                }

                if($('#t5').length)
                {

                    $('[id=t5]').each(function(i){
                        $(this).attr('name', 'day_profile[3][tariff_slabs]['+i+']');
                        $(this).attr('id','t4');
                    });
                    $('[id=remove_tariff_slab_t5]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t4');
                        $(this).attr('value','t4');
                    });
                    tariff_slab_count4 = tariff_slab_count5;
                    tariff_slab_count5 = 0;
                }

                if($('#t6').length)
                {

                    $('[id=t6]').each(function(i){
                        $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
                        $(this).attr('id','t5');
                    });
                    $('[id=remove_tariff_slab_t6]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t5');
                        $(this).attr('value','t5');
                    });
                    tariff_slab_count5 = tariff_slab_count6;
                    tariff_slab_count6 = 0;
                }

                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 2)
            {
                tariff_slab_count3 = 0;
                if($('#t4').length)
                {

                    $('[id=t4]').each(function(i){
                        $(this).attr('name', 'day_profile[2][tariff_slabs]['+i+']');
                        $(this).attr('id','t3');
                    });
                    $('[id=remove_tariff_slab_t4]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t3');
                        $(this).attr('value','t3');
                    });
                    tariff_slab_count3 = tariff_slab_count4;
                    tariff_slab_count4 = 0;
                }

                if($('#t5').length)
                {

                    $('[id=t5]').each(function(i){
                        $(this).attr('name', 'day_profile[3][tariff_slabs]['+i+']');
                        $(this).attr('id','t4');
                    });
                    $('[id=remove_tariff_slab_t5]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t4');
                        $(this).attr('value','t4');
                    });
                    tariff_slab_count4 = tariff_slab_count5;
                    tariff_slab_count5 = 0;
                }

                if($('#t6').length)
                {

                    $('[id=t6]').each(function(i){
                        $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
                        $(this).attr('id','t5');
                    });
                    $('[id=remove_tariff_slab_t6]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t5');
                        $(this).attr('value','t5');
                    });
                    tariff_slab_count5 = tariff_slab_count6;
                    tariff_slab_count6 = 0;
                }

                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 3)
            {
                tariff_slab_count4 = 0;
                if($('#t5').length)
                {

                    $('[id=t5]').each(function(i){
                        $(this).attr('name', 'day_profile[3][tariff_slabs]['+i+']');
                        $(this).attr('id','t4');
                    });
                    $('[id=remove_tariff_slab_t5]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t4');
                        $(this).attr('value','t4');
                    });
                    tariff_slab_count4 = tariff_slab_count5;
                    tariff_slab_count5 = 0;
                }

                if($('#t6').length)
                {

                    $('[id=t6]').each(function(i){
                        $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
                        $(this).attr('id','t5');
                    });
                    $('[id=remove_tariff_slab_t6]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t5');
                        $(this).attr('value','t5');
                    });
                    tariff_slab_count5 = tariff_slab_count6;
                    tariff_slab_count6 = 0;
                }

                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 4)
            {
                tariff_slab_count5 = 0;
                if($('#t6').length)
                {

                    $('[id=t6]').each(function(i){
                        $(this).attr('name', 'day_profile[4][tariff_slabs]['+i+']');
                        $(this).attr('id','t5');
                    });
                    $('[id=remove_tariff_slab_t6]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t5');
                        $(this).attr('value','t5');
                    });
                    tariff_slab_count5 = tariff_slab_count6;
                    tariff_slab_count6 = 0;
                }

                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 5)
            {
                tariff_slab_count6 = 0;
                if($('#t7').length)
                {

                    $('[id=t7]').each(function(i){
                        $(this).attr('name', 'day_profile[5][tariff_slabs]['+i+']');
                        $(this).attr('id','t6');
                    });
                    $('[id=remove_tariff_slab_t7]').each(function(i){
                        $(this).attr('id', 'remove_tariff_slab_t6');
                        $(this).attr('value','t6');
                    });
                    tariff_slab_count6 = tariff_slab_count7;
                    tariff_slab_count7 = 0;
                }
            }

            if($(button).val() == 6)
            {
                tariff_slab_count7 = 0;
            }

            $('[id=remove_day_slabs]').each(function(i){
                $(this).attr('value', i);
            });

            $('[id=add_tariff_slab]').each(function(i){
                $(this).attr('value', i);
            });

            if($('.w1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w1').empty();
                $('.w1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w1'+i).append(html);

                });

            }

            if($('.w2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w2').empty();
                $('.w2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w2'+i).append(html);

                });

            }

            if($('.w3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w3').empty();
                $('.w3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w3'+i).append(html);

                });

            }

            if($('.w4').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w4').empty();
                $('.w4').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w4'+i).append(html);

                });

            }

            if($('#holiday_0').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_0').empty();
                $('#holiday_0').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_0').append(html);

                });

            }

            if($('#holiday_1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_1').empty();
                $('#holiday_1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_1').append(html);

                });

            }

            if($('#holiday_2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_2').empty();
                $('#holiday_2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_2').append(html);

                });

            }

            if($('#holiday_3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_3').empty();
                $('#holiday_3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_3').append(html);

                });

            }

            if($('#holiday_4').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_4').empty();
                $('#holiday_4').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_4').append(html);

                });

            }

            if($('#holiday_5').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_5').empty();
                $('#holiday_5').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_5').append(html);

                });

            }

            if($('#holiday_6').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_6').empty();
                $('#holiday_6').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_6').append(html);

                });

            }

            if($('#holiday_7').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_7').empty();
                $('#holiday_7').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_7').append(html);

                });

            }

            if($('#holiday_8').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_8').empty();
                $('#holiday_8').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_8').append(html);

                });

            }
            if($('#holiday_9').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_9').empty();
                $('#holiday_9').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_9').append(html);

                });

            }

            if($('#holiday_10').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_10').empty();
                $('#holiday_10').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_10').append(html);

                });

            }
    }

    function addTariffSlab(button1) {

        if($(button1).val() == 0)
        {
            if(tariff_slab_count1 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t1" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count1+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t1" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t1">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count1 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 1)
        {
            if(tariff_slab_count2 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t2" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count2+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t2" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t2">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count2 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 2)
        {
            if(tariff_slab_count3 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t3" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count3+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t3" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t3">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count3 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 3)
        {
            if(tariff_slab_count4 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t4" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count4+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t4" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t4">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count4 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 4)
        {
            if(tariff_slab_count5 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t5" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count5+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t5" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t5">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count5 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 5)
        {
            if(tariff_slab_count6 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t6" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count6+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t6" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t6">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count6 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

        if($(button1).val() == 6)
        {
            if(tariff_slab_count7 < 4)
            {
                $(button1).before(
                    `
                    <div class="form-inline">
                                <input id="t7" class="col-md-11" type="text" class="form-control" name="day_profile[`+$(button1).val()+`][tariff_slabs][`+tariff_slab_count7+`]" value="08:00">
                                &nbsp;&nbsp;
                                <button id="remove_tariff_slab_t7" onclick="removeTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="t7">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );

                tariff_slab_count7 ++;
            }else{

                alert('Tariff slabs cannot be greater than 4');
            }
        }

    }

    function addDayProfile(tableId) {

        if(day_profile_count < 7)
        {
            if(day_profile_count == 0)
            {
                $(tableId + " tbody").empty();
            }
            sum_of_day_profile = day_profile_count +1;
            $(tableId + " tbody").append(
                `
                <tr>
                    <td>
                        <div class="form-group">
                        <input id="day_profile" type="text" class="form-control" name="day_profile[`+day_profile_count+`][name]" value="d`+sum_of_day_profile+`"  readonly>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <button id=add_tariff_slab onclick="addTariffSlab(this)" type="button" class="btn btn-sm btn-primary" value="`+day_profile_count+`">
                                <i class="fa fa-plus-circle"></i>
                                Add Tariff Slab
                            </button>
                        </div>
                    </td>
                    <td>
                        <button id="remove_day_slabs" onclick="removeDaySlabs(this)" type="button" class="btn btn-sm btn-danger" value="`+day_profile_count+`">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                `
            );
            day_profile_count ++;
            if($('.w1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w1').empty();
                $('.w1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w1'+i).append(html);

                });

            }

            if($('.w2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w2').empty();
                $('.w2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w2'+i).append(html);

                });

            }

            if($('.w3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w3').empty();
                $('.w3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w3'+i).append(html);

                });

            }

            if($('.w4').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('.w4').empty();
                $('.w4').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#w4'+i).append(html);

                });

            }

            if($('#holiday_0').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_0').empty();
                $('#holiday_0').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_0').append(html);

                });

            }

            if($('#holiday_1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_1').empty();
                $('#holiday_1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_1').append(html);

                });

            }

            if($('#holiday_2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_2').empty();
                $('#holiday_2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_2').append(html);

                });

            }

            if($('#holiday_3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_3').empty();
                $('#holiday_3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_3').append(html);

                });

            }

            if($('#holiday_4').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_4').empty();
                $('#holiday_4').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_4').append(html);

                });

            }

            if($('#holiday_5').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_5').empty();
                $('#holiday_5').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_5').append(html);

                });

            }

            if($('#holiday_6').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_6').empty();
                $('#holiday_6').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_6').append(html);

                });

            }

            if($('#holiday_7').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_7').empty();
                $('#holiday_7').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_7').append(html);

                });

            }

            if($('#holiday_8').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_8').empty();
                $('#holiday_8').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_8').append(html);

                });

            }
            if($('#holiday_9').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_9').empty();
                $('#holiday_9').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_9').append(html);

                });

            }

            if($('#holiday_10').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                $('#holiday_10').empty();
                $('#holiday_10').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='d"+value+"'>d"+value+"</option>";

                        });
                    $('#holiday_10').append(html);

                });

            }

        }else{

            alert('Day Profiles cannot be greater than 7');
        }

    }

    function removeWeekSlabs(button){
        $(button).closest('tr').remove();
        $('[id=week_profile]').each(function(i){
                var n = i+1;
                $(this).attr('name', 'week_profile['+i+'][name]');
                $(this).attr('value', 'w'+n+'');
            });
        week_profile_count --;
        sum_of_week_profile --;

        if(week_profile_count == 0)
        {
            $('.week_profile_table'+ " tbody").append(
                `
                <input type="hidden" class="form-control" name="week_profile[]">
                `
            );
        }

        if($(button).val() == 0)
        {
            week_slab_count1 = 0;
                if($('.w2').length)
                {
                    $('.w2').each(function(i){
                        $(this).attr('name', 'week_profile[0][weekly_day_profile]['+i+']');
                        $(this).attr('id','w1'+i+'');
                        $(this).attr('class','col-md-10 w1');
                    });
                    $('[id=remove_weekly_tariff_slab_w2]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w1');
                        $(this).attr('value','w1');
                    });
                    week_slab_count1 = week_slab_count2;
                    week_slab_count2 = 0;
                }

                if($('.w3').length)
                {
                    $('.w3').each(function(i){
                        $(this).attr('name', 'week_profile[1][weekly_day_profile]['+i+']');
                        $(this).attr('id','w2'+i+'');
                        $(this).attr('class','col-md-10 w2');
                    });
                    $('[id=remove_weekly_tariff_slab_w3]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w2');
                        $(this).attr('value','w2');
                    });
                    week_slab_count2 = week_slab_count3;
                    week_slab_count3 = 0;
                }

                if($('.w4').length)
                {
                    $('.w4').each(function(i){
                        $(this).attr('name', 'week_profile[2][weekly_day_profile]['+i+']');
                        $(this).attr('id','w3'+i+'');
                        $(this).attr('class','col-md-10 w3');
                    });
                    $('[id=remove_weekly_tariff_slab_w4]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w3');
                        $(this).attr('value','w3');
                    });
                    week_slab_count3 = week_slab_count4;
                    week_slab_count4 = 0;
                }
        }

        if($(button).val() == 1)
        {
            week_slab_count2 = 0;
                if($('.w3').length)
                {
                    $('.w3').each(function(i){
                        $(this).attr('name', 'week_profile[1][weekly_day_profile]['+i+']');
                        $(this).attr('id','w2'+i+'');
                        $(this).attr('class','col-md-10 w2');
                    });
                    $('[id=remove_weekly_tariff_slab_w3]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w2');
                        $(this).attr('value','w2');
                    });
                    week_slab_count2 = week_slab_count3;
                    week_slab_count3 = 0;
                }

                if($('.w4').length)
                {
                    $('.w4').each(function(i){
                        $(this).attr('name', 'week_profile[2][weekly_day_profile]['+i+']');
                        $(this).attr('id','w3'+i+'');
                        $(this).attr('class','col-md-10 w3');
                    });
                    $('[id=remove_weekly_tariff_slab_w4]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w3');
                        $(this).attr('value','w3');
                    });
                    week_slab_count3 = week_slab_count4;
                    week_slab_count4 = 0;
                }
        }

        if($(button).val() == 2)
        {
            week_slab_count3 = 0;
            if($('.w4').length)
                {
                    $('.w4').each(function(i){
                        $(this).attr('name', 'week_profile[2][weekly_day_profile]['+i+']');
                        $(this).attr('id','w3'+i+'');
                        $(this).attr('class','col-md-10 w3');
                    });
                    $('[id=remove_weekly_tariff_slab_w4]').each(function(i){
                        $(this).attr('id', 'remove_weekly_tariff_slab_w3');
                        $(this).attr('value','w3');
                    });
                    week_slab_count3 = week_slab_count4;
                    week_slab_count4 = 0;
                }
        }

        if($(button).val() == 3)
        {
            week_slab_count4 = 0;
        }

        $('[id=remove_week_slabs]').each(function(i){
                $(this).attr('value', i);
            });

        $('[id=add_tariff_slab_for_week_profile]').each(function(i){
                $(this).attr('value', i);
            });

            if($('#season_0').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_0').empty();
                $('#season_0').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_0').append(html);

                });

            }

            if($('#season_1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_1').empty();
                $('#season_1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_1').append(html);

                });

            }

            if($('#season_2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_2').empty();
                $('#season_2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_2').append(html);

                });

            }

            if($('#season_3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_3').empty();
                $('#season_3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_3').append(html);

                });

            }
    }

    function addTariffSlabForWeekProfile(button1){
        if($(button1).val() == 0)
        {
            if(week_slab_count1 < 7)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }

                $(button1).before(
                    `
                    <div class="form-inline">
                            <select class="col-md-10 w1" name="week_profile[`+$(button1).val()+`][weekly_day_profile][`+week_slab_count1+`]" id="w1`+week_slab_count1+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html +="<option value='d"+value+"'>d"+value+"</option>";


                            })
                            +
                            `
                            </select>
                                &nbsp;&nbsp;
                                <button id="remove_weekly_tariff_slab_w1" onclick="removeWeeklyTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="w1">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );
                $('#w1'+week_slab_count1).append(html);
                week_slab_count1 ++;
            }else{

                alert('Tariff slabs cannot be greater than 7');
            }
        }

        if($(button1).val() == 1)
        {
            if(week_slab_count2 < 7)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }

                $(button1).before(
                    `
                    <div class="form-inline">
                            <select class="col-md-10 w2" name="week_profile[`+$(button1).val()+`][weekly_day_profile][`+week_slab_count2+`]" id="w2`+week_slab_count2+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html +="<option value='d"+value+"'>d"+value+"</option>";


                            })
                            +
                            `
                            </select>
                                &nbsp;&nbsp;
                                <button id="remove_weekly_tariff_slab_w2" onclick="removeWeeklyTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="w2">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );
                $('#w2'+week_slab_count2).append(html);
                week_slab_count2 ++;
            }else{

                alert('Tariff slabs cannot be greater than 7');
            }
        }

        if($(button1).val() == 2)
        {
            if(week_slab_count3 < 7)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }

                $(button1).before(
                    `
                    <div class="form-inline">
                            <select class="col-md-10 w3" name="week_profile[`+$(button1).val()+`][weekly_day_profile][`+week_slab_count3+`]" id="w3`+week_slab_count3+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html +="<option value='d"+value+"'>d"+value+"</option>";


                            })
                            +
                            `
                            </select>
                                &nbsp;&nbsp;
                                <button id="remove_weekly_tariff_slab_w3" onclick="removeWeeklyTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="w3">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );
                $('#w3'+week_slab_count3).append(html);
                week_slab_count3 ++;
            }else{

                alert('Tariff slabs cannot be greater than 7');
            }
        }

        if($(button1).val() == 3)
        {
            if(week_slab_count4 < 7)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }

                $(button1).before(
                    `
                    <div class="form-inline">
                            <select class="col-md-10 w4" name="week_profile[`+$(button1).val()+`][weekly_day_profile][`+week_slab_count4+`]" id="w4`+week_slab_count4+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html +="<option value='d"+value+"'>d"+value+"</option>";


                            })
                            +
                            `
                            </select>
                                &nbsp;&nbsp;
                                <button id="remove_weekly_tariff_slab_w4" onclick="removeWeeklyTariffSlabs(this)" type="button" class="btn btn-sm btn-danger" style="font-size: 0.5em;" value="w4">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                    `
                );
                $('#w4'+week_slab_count4).append(html);
                week_slab_count4 ++;
            }else{

                alert('Tariff slabs cannot be greater than 7');
            }
        }
    }

    function addWeekProfile(tableId){
        if(week_profile_count < 4)
        {
            if(week_profile_count == 0)
            {
                $(tableId + " tbody").empty();
            }
            sum_of_week_profile = week_profile_count +1;
            $(tableId + " tbody").append(
                `
                <tr>
                    <td>
                        <div class="form-group">
                        <input id="week_profile" type="text" class="form-control" name="week_profile[`+week_profile_count+`][name]" value="w`+sum_of_week_profile+`"  readonly>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <button id="add_tariff_slab_for_week_profile" onclick="addTariffSlabForWeekProfile(this)" type="button" class="btn btn-sm btn-primary" value="`+week_profile_count+`">
                                <i class="fa fa-plus-circle"></i>
                                Add Tariff Slab
                            </button>
                        </div>
                    </td>
                    <td>
                        <button id="remove_week_slabs" onclick="removeWeekSlabs(this)" type="button" class="btn btn-sm btn-danger" value="`+week_profile_count+`">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                `
            );
            week_profile_count ++;
            if($('#season_0').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_0').empty();
                $('#season_0').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_0').append(html);

                });

            }

            if($('#season_1').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_1').empty();
                $('#season_1').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_1').append(html);

                });

            }

            if($('#season_2').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_2').empty();
                $('#season_2').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_2').append(html);

                });

            }

            if($('#season_3').length)
            {
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
                $('#season_3').empty();
                $('#season_3').each(function(i){
                    html= '';
                    $.each(array1, function(index, value){

                        html +="<option value='w"+value+"'>w"+value+"</option>";

                        });
                    $('#season_3').append(html);

                });

            }

        }else{

            alert('Week Profiles cannot be greater than 4');
        }
    }

    function removeWeeklyTariffSlabs(button){
        $(button).closest('div').remove();

        if($(button).attr("value") == 'w1')
        {
            $('.w1').each(function(i){
                $(this).attr('name', 'week_profile[0][weekly_day_profile]['+i+']');
            });
            week_slab_count1 --;
        }


        if($(button).attr("value") == 'w2')
        {
            $('.w2').each(function(i){
                $(this).attr('name', 'week_profile[0][weekly_day_profile]['+i+']');
            });
            week_slab_count2 --;
        }


        if($(button).attr("value") == 'w3')
        {
            $('.w3').each(function(i){
                $(this).attr('name', 'week_profile[0][weekly_day_profile]['+i+']');
            });
            week_slab_count3 --;
        }


        if($(button).attr("value") == 'w4')
        {
            $('.w4').each(function(i){
                $(this).attr('name', 'week_profile[0][weekly_day_profile]['+i+']');
            });
            week_slab_count4 --;
        }
    }

    function addSeasonProfile(tableId){
        if(season_profile_count < 4)
        {
            if(season_profile_count == 0)
            {
                $(tableId + " tbody").empty();
            }
            var html1= '';
                var array1 =[];
                for (i=1; i <= sum_of_week_profile; i++){
                    array1.push(i);
                }
            sum_of_season_profile = season_profile_count +1;
            $(tableId + " tbody").append(
                `
                <tr>
                    <td>
                        <div class="form-group">
                        <input class="season_profile" type="text" class="form-control" name="season_profile[`+season_profile_count+`][name]" value="s`+sum_of_season_profile+`"  readonly>
                        </div>
                    </td>
                    <td>
                        <div class="form-inline">
                            <select class="col-md-12 season_profile_week_profile" name="season_profile[`+season_profile_count+`][week_profile_name]" id="season_`+season_profile_count+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html1 +="<option value='w"+value+"'>w"+value+"</option>";

                            })
                            +
                            `
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                        <input type="text" class="form-control start_date" name="season_profile[`+season_profile_count+`][start_date]" value="">
                        </div>
                    </td>
                    <td>
                        <button onclick="removeSeasonSlabs(this)" type="button" class="btn btn-sm btn-danger">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                `
            );

            $('#season_'+season_profile_count).append(html1);
            season_profile_count ++;
        }else{

            alert('Season Profiles cannot be greater than 4');
        }
    }

    function removeSeasonSlabs(button){
        $(button).closest('tr').remove();
        $('.season_profile').each(function(i){
                var n = i+1;
                $(this).attr('name', 'season_profile['+i+'][name]');
                $(this).attr('value', 's'+n+'');
            });

        $('.season_profile_week_profile').each(function(i){
                var n = i+1;
                $(this).attr('name', 'season_profile['+i+'][week_profile_name]');
                $(this).attr('id', 'season_'+i+'');
            });

        $('.start_date').each(function(i){
                var n = i+1;
                $(this).attr('name', 'season_profile['+i+'][start_date]');

            });
        season_profile_count --;
        sum_of_season_profile --;

        if(season_profile_count == 0)
        {
            $('.season_profile_table'+ " tbody").append(
                `
                <input type="hidden" class="form-control" name="season_profile[]">
                `
            );
        }
    }

    function addHolidayProfile(tableId){

        if(holiday_profile_count < 10)
        {
            if(holiday_profile_count == 0)
            {
                $(tableId + " tbody").empty();
            }
                var html= '';
                var array1 =[];
                for (i=1; i <= sum_of_day_profile; i++){
                    array1.push(i);
                }
                sum_of_holiday_profile = holiday_profile_count +1;
            $(tableId + " tbody").append(
                `
                <tr>
                    <td>
                        <div class="form-group">
                        <input class="holiday_profile" type="text" class="form-control" name="holiday_profile[`+holiday_profile_count+`][name]" value="h`+sum_of_holiday_profile+`">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                        <input type="text" class="form-control start_date_holiday_profile" name="holiday_profile[`+holiday_profile_count+`][date]" value="">
                        </div>
                    </td>
                    <td>
                        <div class="form-inline">
                            <select class="col-md-12 holiday_profile_day_profile" name="holiday_profile[`+holiday_profile_count+`][day_profile_name]" id="holiday_`+holiday_profile_count+`">
                            `
                            +
                            $.each(array1, function(index, value){

                                html +="<option value='d"+value+"'>d"+value+"</option>";

                            })
                            +
                            `
                            </select>
                        </div>
                    </td>
                    <td>
                        <button onclick="removeHolidaySlabs(this)" type="button" class="btn btn-sm btn-danger">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                `
            );

            $('#holiday_'+holiday_profile_count).append(html);
            holiday_profile_count ++;
        }else{

            alert('Holiday Profiles cannot be greater than 10');
            }
    }

    function removeHolidaySlabs(button){
        $(button).closest('tr').remove();
        $('.holiday_profile').each(function(i){
                var n = i+1;
                $(this).attr('name', 'holiday_profile['+i+'][name]');
                $(this).attr('value', 'h'+n+'');
            });

        $('.holiday_profile_day_profile').each(function(i){
                var n = i+1;
                $(this).attr('name', 'holiday_profile['+i+'][day_profile_name]');
                $(this).attr('id', 'holiday_'+i+'');
            });

        $('.start_date_holiday_profile').each(function(i){
                var n = i+1;
                $(this).attr('name', 'holiday_profile['+i+'][date]');

            });
        holiday_profile_count --;
        sum_of_holiday_profile --;

        if(holiday_profile_count == 0)
        {
            $('.holiday_profile_table'+ " tbody").append(
                `
                    <input type="hidden" class="form-control" name="holiday_profile[]">

                `
            );
        }
    }
</script>
<?php /**PATH D:\udil\htdocs\udil\resources\views/tests/test_forms/time_of_use_change.blade.php ENDPATH**/ ?>