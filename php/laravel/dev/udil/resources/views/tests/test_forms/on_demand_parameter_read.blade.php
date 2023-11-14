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
    
</div>