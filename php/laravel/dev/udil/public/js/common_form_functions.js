
/**
 * 
 * @param {*} formId
 * @param {*} formDataFunction // this function will return FormData, if you do not want to submit form then return null
 * @param {*} submitUrl 
 * @param {*} successfulCallback 
 * @param {*} failureCallback 
 * @param {*} alwaysCallback 
 */
function submitForm(paramObj) {
    console.log(paramObj);

    $(paramObj.formId).submit(function(e) {
        e.preventDefault();

        var formData = paramObj.formDataFunction();
        if(formData == null) {
            return;
        }

        $(paramObj.formId + " [type='submit']").prop('disabled', true);

        $.ajax({
            url: paramObj.submitUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
        }).done(function(data){
            $(paramObj.formId + " [type='submit']").prop('disabled', true);
            if(data.success == true) {
                Swal.fire(
                    'Success',
                    data.message,
                    'success'
                ).then(function(){
                    if(paramObj.successfulCallback != null) {
                        paramObj.successfulCallback(data);
                    }
                });
            } else {
                Swal.fire(
                    'Error',
                    data.message,
                    'error'
                )
                if(paramObj.failureCallback != null) {
                    paramObj.failureCallback();
                }
            }
        }).fail(function(error){
            $(paramObj.formId + " [type='submit']").prop('disabled', true);
            ajaxErrorSweetAlert(error);
            if(paramObj.failureCallback != null) {
                paramObj.failureCallback();
            }
        }).always(function() {
            $(paramObj.formId + " [type='submit']").prop('disabled', false);
            if(paramObj.alwaysCallback != null) {
                paramObj.alwaysCallback();
            }
        });
    })
}

function ajaxErrorSweetAlert(jqXhr) {
    if( jqXhr.status === 422 ) {


        //process validation errors here.
        errors = jqXhr.responseJSON.errors; //this will get the errors response data.
        //show them somewhere in the markup
        //e.g
        errorsHtml = '<div class="alert alert-danger text-left"><ul>';

        $.each( errors, function( key, value ) {
            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        });
        errorsHtml += '</ul></di>';
        
        Swal.fire({
            title: '<strong>Error</strong>',
            type: 'error',
            html: errorsHtml,
        })

        
    } else {
        response = jqXhr.responseJSON
        console.log(response);
        Swal.fire({
            title: '<strong>Error</strong>',
            type: 'error',
            text: response.message,
        })
    }
}