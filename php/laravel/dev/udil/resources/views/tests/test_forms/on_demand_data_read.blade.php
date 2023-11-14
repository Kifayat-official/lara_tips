@component('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 1,
        'add_privatekey' => 1
    ])
@endcomponent
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />


<div class="row">

    <div class="form-group col-md-12">
        <label for="">Meter</label>        
        <select class="form-control" name="global_device_id" required>
            @foreach($mdc_test_session->meters as $meter)
            <option value="{{$meter->global_device_id}}">MSN: {{$meter->msn}}, Global Device ID: {{$meter->global_device_id}}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="type" value="{{$type}}">

    @component('components.datetimepicker', [
            'title' => 'Start Datetime',
            'name' => 'start_datetime',
            'class' => 'col-md-6',
            'value' => $test->idt == 'on_demand_data_read_mbil' ? 
                \Carbon\Carbon::now()->addMonths(-2)->format('d-M-Y H:i:s') : 
                \Carbon\Carbon::now()->addMinutes(-2)->format('d-M-Y H:i:s')
        ])
    @endcomponent

    @component('components.datetimepicker', [
            'title' => 'End Datetime',
            'name' => 'end_datetime',
            'class' => 'col-md-6',
            'value' => \Carbon\Carbon::now()->format('d-M-Y H:i:s')
        ])
    @endcomponent
    
</div>