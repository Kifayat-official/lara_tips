$(document).ready(function(){
    $('.datetimepicker-field').datetimepicker();

    // chuss animation
    $('.login-box-body').fadeOut('fast').fadeIn('fast').fadeOut('fast').fadeIn('fast');
});

function reIndexTableArrayInputs(table) {
    
    $.each($(table).find('tbody tr'), function(index, tr) {
        $.each($(tr).find('input'), function(i, input) {
            $(input).attr('name', $(input).attr('name').replace(/\[.*?\]/, '['+index+']') );
        })
    })
}