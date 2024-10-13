<?php
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
include("include/pop_security.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php';?>
   
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php $page_title="Sale";  include 'Header.php';  ?>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <?php include 'Sidebar_menu.php'; ?>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <form id="form-data" action="include/sale_server.php?add_invoice" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="refer_no" class="form-label">Refer No:</label>
                                                    <input class="form-control" type="text" placeholder="Type Your Refer No" id="refer_no" name="refer_no">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-2">
                                                    <label>Client Name</label>
                                                    <select type="text" id="client_name" name="client_id" class="form-select select2">
                                                        <option value="">---Select---</option>
                                    <?php 

                                    if($allClient=$con->query("select * from clients")){
                                        while($rows=$allClient->fetch_array()){
                                            $id=$rows['id']; 
                                            $fullname=$rows['fullname']; 
                                           echo '<option value='.$id.'>'.$fullname.'</option>'; 
                                        }
                                    }
                                    
                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="note" class="form-label">Note:</label>
                                                    <input class="form-control" type="text" placeholder="Notes" id="note" name="note">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="currentDate" class="form-label">Date</label>
                                                    <input class="form-control" type="date" id="currentDate" value="<?php echo $date = date('m/d/Y ', time()); ?>" name="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_item" class="form-label">Product</label>
                                                    <!-- <div class="input-group">
                                                        <select type="text" id="product_name"  class="form-control" >
                                                            <option>---Select---</option>
                                                        </select>
                                                        <button  type="button" data-bs-toggle="modal" data-bs-target="#addproductModal">+</button>
                                                    </div> -->
                                                    <div class="input-group">
                                                        <select id="product_name" class="form-select select2" aria-label="Product Name">
                                                            <option value="">---Select---</option>
                                                        </select>
                                                        <button type="button" class="btn btn-primary add-product-btn" data-bs-toggle="modal" data-bs-target="#addproductModal">
                                                            <span>+</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="qty" class="form-label">Quantity</label>
                                                    <input type="number" id="qty" class="form-control" min="1" value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" class="form-control price" id="price" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="total_price" class="form-label">Total Price</label>
                                                    <input id="total_price" type="text" class="form-control total_price" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="details" class="form-label">Details</label>
                                                    <input id="details" type="text" class="form-control" placeholder="Details">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-1">
                                                <button type="button" id="submitButton" class="btn btn-primary mt-4">Submit Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                <thead class="bg bg-info text-white">
                                    <th>Product List</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </thead>
                                <tbody id="tableRow"></tbody>
                                
                                </table>
                                <div class="form-group text-center">
                                    <button type="button" name="finished_btn" class="btn btn-success"><i class="fe fe-dollar"></i> Finished</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- container-fluid -->
               
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php'; ?>
        </div>
        <!-- end main content-->
    </div>
    <?php include 'modal/product_modal.php'; ?>
    <div class="modal fade bs-example-modal-lg" id="invoiceModal" tabindex="-1" role="dialog"
               aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog " role="document">
                  <div class="modal-content col-md-12">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span
                           class="mdi mdi-account-check mdi-18px"></span> &nbsp;Invoice Summery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <form id="paymentForm">
                            <div class="form-group mb-2">
                              <label>Ledger/Sub ledger </label>
                              <select class="form-select select2" name="sub_ledger" type="text" style="width: 100%;" required></select>
                           </div>
                           <div class="form-group mb-2">
                              <label>Total Amount </label>
                              <input readonly class="form-control table_total_amount" name="table_total_amount" type="text">
                           </div>
                           <div class="form-group mb-2">
                              <label>Paid Amount </label>
                              <input  type="text" class="form-control table_paid_amount" name="table_paid_amount" >
                           </div>
                           <div class="form-group mb-2">
                              <label> Discount Amount </label>
                              <input  type="text" class="form-control table_discount_amount" name="table_discount_amount" value="00">
                           </div>
                           <div class="form-group mb-2">
                              <label> Due Amount </label>
                              <input type="text" readonly class="form-control table_due_amount" name="table_due_amount" >
                           </div>
                           <div class="form-group mb-2">
                              <label>Type</label>
                              <select type="text" class="form-select table_status" name="table_status">
                                <option value="">---Select---</option>
                                <option value="0">Draf</option>
                                <option value="1">Completed</option>
                                <option value="2">Print Invoice</option>
                            </select>
                           </div>
                           <div class="modal-footer ">
                              <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                              <button type="button" id="save_invoice_btn" class="btn btn-success">Save Invoice</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
    <!-- END layout-wrapper -->
   
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    
    <script src="modal/product_modal.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
        $("#client_name").select2(); 
        $("#product_name").select2(); 
          var selectedProductId = null;
            getProductData();
            function getProductData() {

                $.ajax({
                    url: "include/purchase_server.php?getProductData",
                    method: 'GET',
                    success: function(response) {
                        $('#product_name').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            }
           
            $("#product_name").change(function() {
                var itemId = $(this).val();
                $.ajax({
                    url: "include/purchase_server.php?getSingleProductData",
                    method: 'GET',
                    data: {
                        id: itemId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        selectedProductId = data.id;
                        var price = data.sale_price;

                        $('#price').val(price);
                        updateTotalPrice();

                    },
                    error: function(xhr, status, error) {
                        /*handle the error response*/ 
                        console.log(error);
                    }
                });
            });
            $('#qty').on('input', function() {
                updateTotalPrice();
            });
            $('#price').on('input', function() {
                updateTotalPrice();
            });

            function updateTotalPrice() {
                var qty = $('#qty').val();
                var price = $('#price').val();
                var total = qty * price;
                $('#total_price').val(total);
               
            }

            $(document).on('click','#submitButton',function(e){
                e.preventDefault(); 

                var productName = $('#product_name option:selected').text();
                var quantity = $('#qty').val();
                var price = $('#price').val();
                var totalPrice = $('#total_price').val();

                if(!selectedProductId || !quantity || !price || !totalPrice) {
                    toastr.error('Please fill in all fields');
                    return;
                }

                var row = `<tr>
                    <td><input type="hidden" name="table_product_id[]"value="`+ selectedProductId +`">${productName}</td>

                    <td><input type="hidden" min="1" name="table_qty[]" value="${quantity}" class="form-control table_qty">${quantity}</td>

                    <td><input  type="hidden" name="table_price[]" class="form-control table_price" value="${price}">${price}</td>

                    <td><input  type="hidden" id="table_total_price" name="table_total_price[]" class="form-control" value="${totalPrice}">${totalPrice}</td>

                   <td>
                   <button class="btn btn-danger btn-sm removeRow">

                    <i class="fas fa-times"></i>
                   
                   </button>
                   </td>

                   
                    
                  </tr>`;

                $("#tableRow").append(row);
                calculateTotalAmount(); 
                 $('#product_name').val('');
                 $('#qty').val('1');
                 $('#price').val('');
                 $('#total_price').val('');
                 selectedProductId = null;
            });
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                calculateTotalAmount(); 
            });
            /* Calculate total amount function*/
            function calculateTotalAmount() {
                var totalAmount = 0;
                $('#tableRow tr').each(function() {
                    var total_price = $(this).find('input[name="table_total_price[]"]').val();
                    totalAmount += parseFloat(total_price);
                });
                $('input[name="table_total_amount"]').val(totalAmount);

                // Calculate Due Amount
                var paidAmount = parseFloat($('input[name="table_paid_amount"]').val()) || 0;
                var discountAmount = parseFloat($('input[name="table_discount_amount"]').val()) || 0;
                var dueAmount = totalAmount - paidAmount - discountAmount;
                $('input[name="table_due_amount"]').val(dueAmount);
            }
            /*Update Due Amount when Paid Amount or Discount changes*/ 
            $(document).on('input', 'input[name="table_paid_amount"], input[name="table_discount_amount"]', function() {
                calculateTotalAmount();
            });

            $('#save_invoice_btn').on('click', function() {
                var mainFormData = $('#form-data').serializeArray();
                var modalFormData = $('#paymentForm').serializeArray(); 
                var allFormData = $.merge(mainFormData, modalFormData);
                var isValid = true;
                /*Validate each form data field*/ 
                $.each(allFormData, function(index, field) {
                    if (field.name==='client_id' && field.value === '') {
                        toastr.error("Client must be selected!");
                        isValid = false; 
                        return false; 
                    }
                    else if (field.name === 'table_paid_amount' && field.value === '') {
                        toastr.error("Paid Amount is required");
                        isValid = false; 
                        return false; 
                    }
                    else if (field.name === 'sub_ledger' && field.value === '') {
                        toastr.error("Please select a sub ledger!");
                        isValid = false;
                        return false; 
                    }
                    else if (field.name === 'date' && field.value === '') {
                        toastr.error("Date is required!");
                        isValid = false; 
                        return false;
                    }
                });

                if (!isValid) {
                    return false;
                }
                $(this).prop('disable',true).html('Saving...'); 
                $.ajax({
                    type:'POST',
                    url:$("#form-data").attr('action'),
                    data:$.param(allFormData),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            /*Close the invoice modal*/ 
                            $('#invoiceModal').modal('hide'); 
                            setTimeout(() => {
                                location.reload(); 
                            }, 500);
                        } else {
                            toastr.error(response.message);
                        }
                        $('#save_invoice_btn').prop('disabled', false).html('Save Invoice');
                    },
                    error:function(xhr,status,error){
                        toastr.error("Error:"+error); 
                        $('#save_invoice_btn').prop('disabled', false).html('Save Invoice');
                    }
                }); 
            });

        });

        $(document).on('click','button[name="finished_btn"]',function(){
            $('#invoiceModal').modal('show');
            $.ajax({
                url: "include/transactions_server.php?getLedger",
                method: 'GET',
                success: function(response) {
                    $('select[name="sub_ledger"]').html(response);
                    $('select[name="sub_ledger"]').select2({
                        dropdownParent: $('#invoiceModal')
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

       

    </script>


</body>

</html>