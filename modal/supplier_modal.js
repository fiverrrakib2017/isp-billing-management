$('#addSupplierModal form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
     success: function (response) {
        /*Parse the JSON response*/ 
        const jsonResponse = JSON.parse(response);

        /* Check if the request was successful*/
        if (jsonResponse.success) {
            /*Hide the modal*/ 
            $('#addSupplierModal').modal('hide'); 
             /*Reset the form*/ 
            $('#addSupplierModal form')[0].reset();
            /* Show success message*/
            toastr.success(jsonResponse.message); 

            /*Reload the page after a short delay*/ 
            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            /*Show error message if success is false*/ 
            toastr.error(jsonResponse.message); // Show error message
        }
    },


      error: function (xhr, status, error) {
         /** Handle  errors **/
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, value) {
                toastr.error(value[0]); 
            });
        }
      }
    });
  });