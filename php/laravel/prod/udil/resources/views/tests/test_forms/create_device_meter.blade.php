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
        <?php
            $curr_meter[] = $meter;
        ?>
        <tr>
            <td>
                <input type="checkbox" onchange="meterCheckboxChanged(this)" checked>
            </td>
            <td>
                {{$meter->msn}}
                <input type="hidden" name="device_identity[{{$loop->index}}][dsn]" value="{{$meter->msn}}">
            </td>
            <td>
                <input class="form-control" type="text" name="device_identity[{{$loop->index}}][global_device_id]" value="{{$meter->global_device_id}}">
            </td>
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
    <div class="form-group col-md-6">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime" readonly>
            <option value="{{$now->format('d-M-Y H:i:s')}}">{{ $now->format('d-M-Y H:i:s') }}</option>
        </select>
    </div>
    
    <div class="form-group col-md-6">
        <label for="">Communication Interval</label>
        <input class="form-control" type="number" name="communication_interval" value="{{ $curr_meter[0]->comm_interval }}" min="1" />
    </div>

    <div class="form-group col-md-6">
        <label for="">Device Type</label>
        <select class="form-control" name="device_type">
            <option value="1" @if($curr_meter[0]->device_type == '1') selected @endif>Meter</option>
            <option value="3" @if($curr_meter[0]->device_type == '3') selected @endif>APMS</option>
			<option value="2" @if($curr_meter[0]->device_type == '2') selected @endif>DCU</option>
            <option value="4" @if($curr_meter[0]->device_type == '4') selected @endif>Grid Meter</option>
            <option value="5" @if($curr_meter[0]->device_type == '3') selected @endif>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">MDI Reset Date</label>
        <input class="form-control" type="number" name="mdi_reset_date" value="{{ $curr_meter[0]->mdi_reset_date }}" min="1" max="28" />
    </div>

    <div class="form-group col-md-6">
        <label for="">MDC Reset Time</label>
        <input class="form-control" type="text" name="mdi_reset_time" value="{{ $curr_meter[0]->mdi_reset_time }}" />
    </div>

    <div class="form-group col-md-6">
        <label for="">Sim Number</label>
        <input class="form-control" type="text" name="sim_number" value="{{ $curr_meter[0]->sim_number }}"  />
    </div>
    <div class="form-group col-md-6">
        <label for="">SIM ID</label>
        <input class="form-control" type="text" name="sim_id" value="{{ $curr_meter[0]->sim_id }}" />
    </div>

    <div class="form-group col-md-6">
        <label for="">phase</label>
        <select class="form-control" name="phase">
            <option value="1" @if($curr_meter[0]->phase == '1') selected @endif>Single</option>
            <option value="3" @if($curr_meter[0]->phase == '3') selected @endif>Three-phase</option>
            <option value="2" @if($curr_meter[0]->phase == '2') selected @endif>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Meter Type</label>
        <select class="form-control" name="meter_type">
            <option value="1" @if($curr_meter[0]->meter_type == '1') selected @endif>Normal</option>
            <option value="2" @if($curr_meter[0]->meter_type == '2') selected @endif>Whole Current</option>
            <option value="3" @if($curr_meter[0]->meter_type == '3') selected @endif>CTO</option>
            <option value="4" @if($curr_meter[0]->meter_type == '4') selected @endif>CTPT</option>
            <option value="5" @if($curr_meter[0]->meter_type == '5') selected @endif>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Communication Mode</label>
        <select class="form-control" name="communication_mode">
            <option value="1" @if($curr_meter[0]->comm_mode == '1') selected @endif>GPRS/3G/4G</option>
            <option value="2" @if($curr_meter[0]->comm_mode == '2') selected @endif>RF</option>
            <option value="3" @if($curr_meter[0]->comm_mode == '3') selected @endif>PLC</option>
            <option value="4" @if($curr_meter[0]->comm_mode == '4') selected @endif>Ethernet</option>
            <option value="5" @if($curr_meter[0]->comm_mode == '5') selected @endif>other</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Communication Type</label>
        <select class="form-control" name="communication_type">
            <!-- <option value="0" @if($curr_meter[0]->comm_type == '0') selected @endif>always on</option> -->
            <option value="1" @if($curr_meter[0]->comm_type == '1') selected @endif>Mode-I/Non-Keepalive</option>
            <option value="2" @if($curr_meter[0]->comm_type == '2') selected @endif>Mode-II/Keep-alive</option>
            <!-- <option value="3" @if($curr_meter[0]->comm_type == '3') selected @endif>other</option> -->
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="">Initial Communication Time (24 Hrs Format)</label>
        <input class="form-control" type="text" id="initial_time" name="initial_communication_time" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}" value="{{ ($curr_meter[0]->initial_communication_time ) ? $curr_meter[0]->initial_communication_time : '00:00:00' }}" />
    </div>

    <div class="form-group col-md-6">
        <label for="">Bidirectional Device</label>
        <select class="form-control" name="bidirectional_device">
            <option value="0" @if($curr_meter[0]->bidirectional_device == '0') selected @endif>No</option>
            <option value="1" @if($curr_meter[0]->bidirectional_device == '1') selected @endif>Yes</option>
        </select>
    </div>
<!--
    {!! \App\SelectHelper::createSelect( 'phase', 'phase', \App\SelectHelper::$phases, 'col-md-6', 3 ) !!}

    {!! \App\SelectHelper::createSelect( 'Meter Type', 'meter_type', \App\SelectHelper::$meter_types, 'col-md-6' ) !!}

    {!! \App\SelectHelper::createSelect( 'Communication Mode', 'communication_mode', \App\SelectHelper::$communication_modes, 'col-md-6' ) !!}

    {!! \App\SelectHelper::createSelect( 'Communication Type', 'communication_type', \App\SelectHelper::$communication_types, 'col-md-6' ) !!}

    {!! \App\SelectHelper::createSelect( 'Bidirectional Device', 'bidirectional_device', \App\SelectHelper::$yes_no, 'col-md-6' ) !!}
-->

</div>

