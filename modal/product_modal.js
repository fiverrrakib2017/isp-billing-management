$('#addproductModal').on('shown.bs.modal', function () {
    // Check if select2 is already initialized
    if (!$('#brand_id').hasClass("select2-hidden-accessible")) {
        $("#brand_id").select2({
            dropdownParent: $('#addproductModal')
        });
    }
    if (!$('#category').hasClass("select2-hidden-accessible")) {
        $("#category").select2({
            dropdownParent: $('#addproductModal')
        });
    }
    if (!$('#unit_id').hasClass("select2-hidden-accessible")) {
        $("#unit_id").select2({
            dropdownParent: $('#addproductModal')
        });
    }
    if (!$('#sales_ac').hasClass("select2-hidden-accessible")) {
        $("#sales_ac").select2({
            dropdownParent: $('#addproductModal')
        });
    }
    if (!$('#purchase_ac').hasClass("select2-hidden-accessible")) {
        $("#purchase_ac").select2({
            dropdownParent: $('#addproductModal')
        });
    }
});

$('#productForm').submit(function(e) {
    e.preventDefault();

    /* Get the submit button */
    var submitBtn = $(this).find('button[type="submit"]');
    var originalBtnText = submitBtn.html();

    submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>');
    submitBtn.prop('disabled', true);

    var form = $(this);
    var formData = new FormData(this);
    var baseUrl = window.location.origin;
  
    $.ajax({
        type: form.attr('method'),
        url:baseUrl+'/include/product_server.php?add_product',
        data: formData,
        processData: false,
        contentType: false,
        dataType:'json',
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                form[0].reset();
                $("#addproductModal").modal('hide');
                if (typeof getProductData === 'function') {
                    getProductData();
                }
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { 
                 /* Validation error*/
                var errors = xhr.responseJSON.errors;

                /* Loop through the errors and show them using toastr*/
                $.each(errors, function(field, messages) {
                    $.each(messages, function(index, message) {
                        /* Display each error message*/
                        toastr.error(message); 
                    });
                });
            } else {
                /*General error message*/ 
                toastr.error('An error occurred. Please try again.');
            }
        },
        complete: function() {
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
        }
    });
});
// $(document).on('click','#addProductBtn',function(e){
//     e.preventDefault();
//     /* Perform validation*/
//     let isValid = true;
//     $("#productForm").find("input[required], select[required]").each(function () {
//         if (!$(this).val()) {
//             $(this).addClass("is-invalid"); 
//             isValid = false;
//         } else {
//             $(this).removeClass("is-invalid"); 
//         }
//     });

//     /* If the form is not valid*/
//     if (!isValid) {
//         toastr.error("Please fill in all required fields.");
//         return;
//     }
//     var baseUrl = window.location.origin;
//     var formData = $("#productForm").serialize(); 
//     $.ajax({
//         url:baseUrl+'/include/product_server.php?add_product',
//         type: 'POST',
//         data: formData,
//         contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//         processData: true,
//         success: function(response) {
        
//             var result = JSON.parse(response);
//             if (result.success) {
//                 toastr.success(result.message);
//                 $('#productForm')[0].reset(); 
//                 $("#addproductModal").modal('hide');
//                 getProductData(); 
//             } else {
//                 toastr.error(result.message);
//             }
//         },
//         error: function() {
//             toastr.error("Error occurred during the request.");
//         }
//     });
// });