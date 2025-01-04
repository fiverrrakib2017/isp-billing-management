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
    if (!$('#assets_ac').hasClass("select2-hidden-accessible")) {
        $("#assets_ac").select2({
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