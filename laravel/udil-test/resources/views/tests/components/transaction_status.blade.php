<?php

$uniqid = uniqid();

$statuses = [
    1 => "Commencing command processing.",
    2 => "Communication request sent to meter.",
    3 => "Communication established with meter.",
    4 => "Command sent to meter.",
    5 => "Command executed by meter.",
];
?>

<input type="hidden" name="current_transaction_status" value="0">
<input type="hidden" name="seconds_elapsed" value="0">
<input type="hidden" name="writing_tests_transaction_timeout_minutes" value="{{$mdc_test_session->writing_tests_transaction_timeout_minutes}}">

<table id="table_{{$uniqid}}" class="table table-bordered">
    <thead>
        <th></th>
        <th>Status</th>
        <th>Time (Seconds)</th>
    </thead>

    <tbody>
        @foreach($statuses as $key => $status)
        <tr id="status_{{$key}}">
            <td class="status-icon">-</td>
            <td>{{$status}}</td>
            <td class="status-time">-</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function(){

        var table = $('#table_{{$uniqid}}');
        var intervalMiliseconds = 5000;
        
        refreshStatus(table, refreshInterval);

        var refreshInterval = setInterval(() => {
            refreshStatus(table, refreshInterval);
        }, intervalMiliseconds);
        

        var secondsElapsedInterval = setInterval(() => {
            var seconds_elapsed = $('[name="seconds_elapsed"]').val();
            $('[name="seconds_elapsed"]').val( +seconds_elapsed + +5 );
        }, 5000);

        if( $('[name="current_transaction_status"]').val() == 5 ) {
            clearInterval(secondsElapsedInterval);
        }

        table.closest('.modal').on('hidden.bs.modal', function () {
            clearInterval(refreshInterval);
            clearInterval(secondsElapsedInterval);
        })

    });

    function refreshStatus(table, interval){
        $.ajax({
            type: 'get',
            url: '{{url('get-transaction-status')}}?transactionid={{$transactionid}}&mdc_test_session_id={{$mdc_test_session_id}}&test_id={{$test_id}}',
        }).done(function(data){

            if(data.status_level < 5) {
                table
                    .find('tr#status_' + (+data.status_level + +1))
                    .find('.status-icon')
                    .empty()
                    .append('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
            }

            $('[name="current_transaction_status"]').val(data.status_level);

            if(data.status_level == 5) {
                clearInterval(interval);
                $('.pass-fail-buttons').show('fast');
            }

            var seconds_elapsed = $('[name="seconds_elapsed"').val();
            var writing_tests_transaction_timeout_minutes = $('[name="writing_tests_transaction_timeout_minutes"').val();

            if( (+seconds_elapsed / 60) > writing_tests_transaction_timeout_minutes ) {
                clearInterval(interval);

                // fail test
                var failReason = 'transaction status timeout';
                $('.pass-fail-buttons [name="remarks"]').val(failReason);
                $('.pass-fail-buttons').find('[value="fail"]').click();
                saveTestStatus($('.btn-set-test-status'), true);
                $('.failure-remarks').text(failReason)
                $('.test-failed').closest('.error').show();
            }

            for(i = 1; i <= data.status_level; i++) {
                var tr = table.find('tr#status_' + i);

                tr.find('.status-icon').empty().append('<i class="fa fa-check text-green" aria-hidden="true"></i>');

                var fromTime = moment(data['command_receiving_datetime']);

                if(i > 1) {
                    fromTime = moment(data['status_' + (i - 1) + '_datetime']);
                }

                var toTime = moment(data['status_'+i+'_datetime']);
                var duration = moment.duration(toTime.diff(fromTime)).asSeconds();

                tr.find('.status-time').empty()
                    .append( duration );
            }

        }).fail(function(error){
            ajaxErrorSweetAlert(error)
        });
    }
</script>