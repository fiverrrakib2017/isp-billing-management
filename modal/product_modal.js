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
$(document).on('click','#addProductBtn',function(e){
    e.preventDefault();
    var baseUrl = window.location.origin;
    var formData = $("#productForm").serialize(); 
    $.ajax({
        url:baseUrl+'/include/product_server.php?add_product',
        type: 'POST',
        data: formData,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        processData: true,
        success: function(response) {
        
            var result = JSON.parse(response);
            if (result.success) {
                toastr.success(result.message);
                $('#productForm')[0].reset(); 
                $("#addproductModal").modal('hide');
                getProductData(); 
            } else {
                toastr.error(result.message);
            }
        },
        error: function() {
            toastr.error("Error occurred during the request.");
        }
    });
});