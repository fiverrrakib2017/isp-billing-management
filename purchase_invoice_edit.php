<?php
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
include("include/pop_security.php");
if (isset($_GET["id"])) {
    if ($sales = $con->query("SELECT * FROM purchase WHERE id=".$_GET['id'] ."")) {
        while ($rows = $sales->fetch_array()) {
            $id = $rows['id'];
            $usr_id = $rows['usr_id'];
            $client_id = $rows['client_id'];
            $invoice_date = $rows['date'];
            $sub_total = $rows['sub_total'];
            $discount = $rows['discount'];
            $grand_total = $rows['grand_total'];
            $total_due = $rows['total_due'];
            $total_paid = $rows['total_paid'];
            $note = $rows['note'];
            $status = $rows['status'];
        }
    }
}
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
        <?= $page_title="Edit Purchase Invoice"; include 'Header.php';?>

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
                    <form id="form-data" action="include/purchase_server.php?update_invoice=1&invoice_id=<?php echo $id; ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header">
                                    <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="refer_no" class="form-label">Refer No:</label>
                                                    <input class="form-control" type="text" placeholder="Type Your Refer No" id="refer_no" name="refer_no" >
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-2">
                                                    <label>Suppliers Name</label>
                                                    <div class="input-group">
                                                        <select type="text" id="supplier_name" name="client_id" class="form-select select2">
                                                            <option>---Select---</option>
                                                        </select>
                                                        <button type="button" class="btn btn-primary add-supplier-btn" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                                        <span>+</span>
                                                    </button>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="note" class="form-label">Note:</label>
                                                    <input class="form-control" type="text" placeholder="Notes" id="note" name="note"  value="<?php echo $note; ?>">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="currentDate" class="form-label">Invoice Date</label>
                                                    <input class="form-control" type="date" id="currentDate" value="<?php echo date('Y-m-d', strtotime($invoice_date)); ?>" name="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                       
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_item" class="form-label">Product</label>
                                                    <div class="input-group">
                                                        <select type="text" id="product_name"  class="form-control">
                                                            <option>---Select---</option>
                                                        </select>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproductModal">+</button>
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
                                                    <input type="text" class="form-control price" id="price" value="00">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="total_price" class="form-label">Total Price</label>
                                                    <input id="total_price" type="text" class="form-control total_price" value="00">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="details" class="form-label">Notes</label>
                                                    <input id="details" type="text" class="form-control" placeholder="Notes">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-1 ">
                                                <button type="button" id="submitButton" class="btn btn-primary mt-4">Add Now</button>
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
                                <tbody id="tableRow">
                                <?php
                                    $sql = "SELECT * FROM `purchase_details` WHERE invoice_id=$id";
                                    $result = mysqli_query($con, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {

                                    ?>

                                <tr>
                                    <td>
                                        <?php
                                            $product_id = $rows["product_id"];
                                            if ($allPD = $con->query("SELECT * FROM products WHERE id='$product_id' ")) {
                                                while ($rowss = $allPD->fetch_array()) {
                                                    echo ' <input type="hidden" name="table_product_id[]" value="'.$rowss['id'].'">'; 
                                                    echo $rowss['name']; 
                                                }
                                            }
                                        ?>
                                    

                                    </td>
                                    <td>
                                        <input  type="hidden" min="1" name="table_qty[]" value="<?php echo $rows['qty']; ?>" class="form-control table_qty"><?php echo $rows['qty']; ?>
                                    </td>
                                    <td>
                                        <input  type="hidden" name="table_price[]" class="form-control table_price" value="<?php echo $rows['value']; ?>"><?php echo $rows['value']; ?>
                                    </td>
                                    <td>
                                        <input  type="hidden" id="table_total_price" name="table_total_price[]" class="form-control" value="<?php echo $rows['total']; ?>"><?php echo $rows['total']; ?></td>
                                
                                        <td>
                                            <button class="btn btn-danger btn-sm removeRow">

                                                <i class="fas fa-times"></i>
                                            
                                            </button>
                                        </td>
                                
                                    </tr>
                                <?php } ?>

                                </tbody>
                                </table>
                                <div class="form-group text-end">
                                <button type="button"  data-bs-target="#invoiceModal" data-bs-toggle="modal" class="btn btn-success"><i class="fe fe-dollar"></i> Process Invoice</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- container-fluid -->
               
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php';?>
        </div>
        <!-- end main content-->
    </div>
    <?php include 'modal/product_modal.php'; ?>
    <?php include 'modal/supplier_modal.php'; ?>
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
                              <label>Total Amount </label>
                              <input readonly class="form-control table_total_amount" name="table_total_amount" type="text" value="<?php echo $sub_total; ?>">
                           </div>
                           <div class="form-group mb-2">
                              <label>Paid Amount </label>
                              <input  type="text" class="form-control table_paid_amount" name="table_paid_amount" value="<?php echo $total_paid; ?>">
                           </div>
                           <div class="form-group mb-2">
                              <label> Discount Amount </label>
                              <input  type="text" class="form-control table_discount_amount" name="table_discount_amount" value="<?php echo $discount; ?>">
                           </div>
                           <div class="form-group mb-2">
                              <label> Due Amount </label>
                              <input type="text" readonly class="form-control table_due_amount" name="table_due_amount" value="<?php echo $total_due; ?>">
                           </div>
                           <div class="form-group mb-2">
                              <label>Type</label>
                              <select type="text" class="form-select table_status" name="table_status">
                                <option value="">---Select---</option>
                                <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>Draft</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Completed</option>
                                <option value="2" <?php echo ($status == 2) ? 'selected' : ''; ?>>Print Invoice</option>
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

    <?php include 'script.php'; ?>
    <script src="modal/product_modal.js"></script>
    <script src="modal/supplier_modal.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#supplier_name").select2(); 
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
            getSupplierData()

            function getSupplierData() {
                var client_id=<?php echo $client_id; ?>;
                $.ajax({
                    url: "include/purchase_server.php?getSupplierData",
                    method: 'GET',
                    success: function(response) {
                        $('#supplier_name').html(response);
                        $('#supplier_name').val(client_id);
                    
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
                $('#submitButton').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`).prop('disabled', true);
                $.ajax({
                    url: 'include/product_server.php?check_product_qty=true', 
                    method: 'POST',
                    data: { product_id: selectedProductId, qty: quantity },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success==true) {
                            var row = `<tr>
                                <td><input type="hidden" name="table_product_id[]" value="`+ selectedProductId +`">${productName}</td>
                                <td><input type="hidden" min="1" name="table_qty[]" value="${quantity}" class="form-control table_qty">${quantity}</td>
                                <td><input type="hidden" name="table_price[]" class="form-control table_price" value="${price}">${price}</td>
                                <td><input type="hidden" id="table_total_price" name="table_total_price[]" class="form-control" value="${totalPrice}">${totalPrice}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm removeRow">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>`;
                            $("#tableRow").append(row);
                            

                            calculateTotalAmount(); 

                            /*Clear The Fild*/
                            $('#product_name').val('');
                            $('#qty').val('1');
                            $('#price').val('');
                            $('#total_price').val('');
                            selectedProductId = null;
                        } else if(response.success==false) {
                            /*IF The Stock Is Not Available*/
                            toastr.error(response.message);
                        }
                       
                    },
                    error: function() {
                      //  toastr.error('Error checking product stock.');

                    },
                    complete:function(){
                        $('#submitButton').html('Submit').prop('disabled', false);
                    }
                });
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

       

    </script>


</body>

</html>