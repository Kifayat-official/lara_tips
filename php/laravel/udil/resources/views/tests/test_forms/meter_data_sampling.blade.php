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
</script>

<div class="row">

    <div class="form-group col-md-6">
        <label for="">Request Date Time</label>
        <?php $now = \Carbon\Carbon::now(); ?>
        <select class="form-control" name="request_datetime" readonly>
            <option value="{{$now->format('d-M-Y H:i:s')}}">{{ $now->format('d-M-Y H:i:s') }}</option>
        </select>
    </div>

    @component('components.datetimepicker', [
            'title' => 'Activation Date Time',
            'name' => 'activation_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ])
    @endcomponent

    {!! \App\SelectHelper::createSelect( 'Data Type', 'data_type', \App\SelectHelper::$data_types, 'col-md-6' ) !!}

    <div class="form-group col-md-6">
        <label for="">Sampling Interval</label>
        <input type="number" class="form-control" name="sampling_interval" value="30" min="1">
    </div>

    <div class="form-group col-md-6">
        <label for="">Sampling Initial Time</label>
        <input type="number" class="form-control" name="sampling_initial_time" value="0" min="0" max="59">
    </div>

</div>
