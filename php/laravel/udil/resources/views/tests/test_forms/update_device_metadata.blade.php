@component('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 1,
        'add_privatekey' => 1
    ])
@endcomponent
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />

<h4>Select Meters</h4>
<table class="table table-bordered">
    <thead>
        <th class="col-md-2">Select</th>
        <th class="col-md-5">MSN</th>
        <th class="col-md-5">Global Device ID</th>
    </thead>
    <tbody>
        @foreach($mdc_test_session->meters as $meter)
        <tr>
            <td>
                <input type="checkbox" onchange="meterCheckboxChanged(this)" checked>
            </td>
            <td>
                {{$meter->msn}}
                <input type="hidden" name="global_device_id[]" value="{{$meter->global_device_id}}">
            </td>
            <td>{{$meter->global_device_id}}</td>
        </tr>
        @endforeach
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
    $('#initial_time').focusout(function(){

    var time_val = $('#initial_time').val();
    var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(time_val);
    if(!isValid) {
        alert('Initial Communication Time format is Invalid!');
        return false;
    }
    });
</script>

<div class="row">

    <div class="form-group col-md-12">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime" readonly>
            <option value="{{$now->format('d-M-Y H:i:s')}}">{{ $now->format('d-M-Y H:i:s') }}</option>
        </select>
    </div>

    {!! \App\SelectHelper::createSelect('Communication Mode', 'communication_mode', \App\SelectHelper::$communication_modes, 'col-md-6') !!}
    {!! \App\SelectHelper::createSelect('Bidirectional Device', 'bidirectional_device', \App\SelectHelper::$yes_no, 'col-md-6') !!}
    {!! \App\SelectHelper::createSelect('Communication Type', 'communication_type', \App\SelectHelper::$communication_types, 'col-md-6') !!}

    <div class="form-group col-md-6">
        <label for="">Communication Interval</label>
        <input type="number" class="form-control" name="communication_interval" min="0" value="0">
    </div>

    <div class="form-group col-md-6">
        <label for="">Initial Communication Time (24 Hrs Format)</label>
        <input class="form-control" type="text" id="initial_time" name="initial_communication_time" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}" value="00:00:00"/>
    </div>

    {!! \App\SelectHelper::createSelect('Phase', 'phase', \App\SelectHelper::$phases, 'col-md-6', 3) !!}
    {!! \App\SelectHelper::createSelect('Meter Type', 'meter_type', \App\SelectHelper::$meter_types, 'col-md-6') !!}

</div>