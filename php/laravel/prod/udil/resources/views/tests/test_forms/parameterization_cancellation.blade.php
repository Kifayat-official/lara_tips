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

    {!! \App\SelectHelper::createSelect('Type', 'type', \App\SelectHelper::$types_for_parameterization_cancellation, 'col-md-6') !!}
</div>