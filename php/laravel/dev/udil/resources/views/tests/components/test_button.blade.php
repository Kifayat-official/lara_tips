@if(isset($col_class))
<div class="{{$col_class}}">
@endif


<button style="text-align: left;" class="btn-test btn btn-block btn-secondary" data-test_id="{{$test->id}}" data-test_number={{$test_number}} data-test_name="{{$test->name}}" 
    {{ $mdc_test_session->is_finished == 1 ? 'disabled' : ''}} >
    <strong>{{isset($test_number) ? $test_number . ' - ' : ''}}</strong>{{ $test->name }}
    <br>
    
    <?php
        $mdc_test_status = $mdc_test_session->getMdcTestStatusByTestId($test->id);

        $status_text = 'Not Initialized';
        $css_class = 'primary';

        if ($mdc_test_status != null) {
            $status_text = $mdc_test_status->is_pass == 1 ? 'Pass' : 'Fail';
            $css_class = $mdc_test_status->is_pass == 1 ? 'success' : 'danger';
        }
    ?>

    <span class="label label-{{$css_class}}">
        Status: {{$status_text}}
    </span>
</button>
@if(isset($col_class))
</div>
@endif