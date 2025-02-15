<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";


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
        
           <?php $page_title="Bill Collection"; include 'Header.php';?>
        
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
            <div class="row">
                     <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                           <div class="d-flex align-items-end flex-wrap">
                              <div class="mr-md-3 mr-xl-5">
                                 <div class="d-flex">
                                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                    </p>
                                    <p class="text-primary mb-0 hover-cursor">Bill Collection</p>
                                 </div>
                              </div>
                              <br>
                           </div>
                           <div class="d-flex justify-content-between align-items-end flex-wrap">
                              
                           </div>
                        </div>
                     </div>
                  </div>
            <div class="row">
                     <div class="col-md-12 stretch-card">
                        <div class="card">
                           
                           <div class="card-body">
                              <span class="card-title"></span>
                              <div class="col-md-6 float-md-right grid-margin-sm-0">
                                 <div class="form-group">
                                    
                                       
                                 </div>
                              </div>
                              <div class="table-responsive">
                                <div class="form-inline float-right mb-3" style="width: 300px;">
                                    <select id="select_user_id" class="form-select">
                                        <option value="">Select User</option>
                                        <?php 
                                        /* Fetching users from the database*/
                                        $userResult = $con->query("SELECT id, fullname FROM users WHERE user_type='1'");
                                        
                                        while ($userRow = mysqli_fetch_assoc($userResult)) {
                                            echo "<option value='" . $userRow['id'] . "'>" . $userRow['fullname'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                              <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Recharged Date</th>
                                        <th>Collect By</th>
                                        <th>Amount</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
    <tbody id="tableBody">
    <?php 
$result = $con->query("SELECT u.id, DATE(cr.datetm) AS recharge_date, SUM(cr.purchase_price) AS total_collection, u.fullname AS recharge_by_name  FROM customer_rechrg cr JOIN users u ON cr.rchg_by = u.id WHERE cr.status = '0' AND cr.type !='4' GROUP BY u.id, DATE(cr.datetm), u.fullname ORDER BY recharge_date DESC");

while ($rows = mysqli_fetch_assoc($result)) {
    $recharge_date = $rows['recharge_date'];
    $yearMonth = date("Y-m-d", strtotime($recharge_date)); 
?>
<tr>
    <td>
        <input type="checkbox"  data-id="<?php echo $rows['id']; ?>" data-collection_date="<?php echo $rows['recharge_date']; ?>">
    </td>
    <td>
        <a href="daily_recharge.php?date=<?php echo $yearMonth; ?>&user_id=<?php echo $rows['id'];?>">
            <?php 
            $dateTm = new DateTime($recharge_date);
            echo $dateTm->format("d-M-Y");
            ?>
        </a>
    </td>
    <td><?php echo $rows["recharge_by_name"]; ?></td>
    <td><?php echo $rows["total_collection"]; ?></td>
    <td>
        <a   href="daily_recharge.php?date=<?php echo $yearMonth; ?>&user_id=<?php echo $rows['id'];?>" class="btn-sm btn btn-success"><i class="fas fa-eye"></i> </a>
    </td>
</tr>
<?php } ?>

    </tbody>
</table>


                              </div>
                           </div>
                           <div class="card-footer" style="text-align: right;">
                                <button type="submit" name="bill_button" class=" btn btn-danger">Total Cash Collection</button>
                            </div>
                        </div>
                     </div>
                  </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php include 'Footer.php';?>

</div>



<div class="modal fade bs-example-modal-lg" id="bill_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Bill Collect
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/bill_collection_server.php?add_collection" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-2 d-none">
                        <input name="user_id" id="user_id" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Collection Date</label>
                        <input type="text"  name="collection_date" id="collection_date" class="form-control" readonly>
                    </div> 
                    <div class="form-group mb-2">
                        <label>Total Amount</label>
                        <input name="total_amount" id="total_amount" placeholder="Enter Amount" class="form-control" type="text" readonly>
                    </div>              
                    <div class="form-group mb-2">
                        <label>Received Amount</label>
                        <input name="received_amount" id="received_amount" placeholder="Enter Amount" class="form-control" type="text" required>
                    </div>              
                    <div class="form-group mb-2">
                        <label>Remarks</label>
                        <input name="note" id="note" placeholder="Enter Remarks" class="form-control" type="text" >
                    </div>              
                                 
                    <div class="modal-footer ">
                        <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

    

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
      
        
        <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select_user_id").select2();
            $('#select_user_id').change(function() {
                var userId = $(this).val();

                $.ajax({
                    url: 'include/bill_collection_server.php?show_data_filter',
                    type: 'GET',
                    data: { user_id: userId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#tableBody').html(data.tableData);
                        $('#pagination').html(data.pagination);
                    }
                });
            });
             /* Filter With Pagination*/
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                var userId = $('#select_user_id').val();

                $.ajax({
                    url: 'include/bill_collection_server.php?show_data_filter',
                    type: 'GET',
                    data: { user_id: userId, page: page },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#tableBody').html(data.tableData);
                        $('#pagination').html(data.pagination);
                    }
                });
            });
             /* Only allow one checkbox to be selected*/
            $('#datatable input[type="checkbox"]').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#datatable input[type="checkbox"]').not(this).prop('checked', false);
                }
            });

            /*When the bill button is clicked*/ 
            $("button[name='bill_button']").click(function(){
                 var select_id = [];
                var totalAmount = '';
                var collectionDate=[]
                $('#datatable input[type="checkbox"]:checked').each(function() {
                    select_id.push($(this).data('id'));
                    collectionDate.push($(this).data('collection_date'));

                    /* Get the row's data from the table*/
                    var row = $(this).closest('tr');
                    console.log(row); 
                    totalAmount = row.find('td:eq(3)').text().trim(); 
                });
                /* Set the values in the modal's form fields*/
                $('#total_amount').val(totalAmount);
                $("input[name='collection_date']").val(collectionDate);
                $("input[name='user_id']").val(select_id);

                if (select_id.length > 0) {
                    $("#bill_modal").modal('show');
                } else {
                    toastr.error("Please Select Checkbox");
                }
            });
             /** Store The data from the database table **/
            $('#bill_modal form').submit(function(e){
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                /** Use Ajax to send the delete request **/
                $.ajax({
                type:'POST',
                'url':url,
                data: formData,
                dataType:'json',
                success: function (response) {
                    /* Check if the request was successful*/
                    if (response.success) {
                        /*Hide the modal*/ 
                        $('#bill_modal').modal('hide'); 
                        /*Reset the form*/ 
                        $('#bill_modal form')[0].reset();
                        /* Show success message*/
                        toastr.success(response.message); 

                        /*Reload the page after a short delay*/ 
                        setTimeout(() => {
                            location.reload();
                        }, 500);
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
        });

    </script>
    </body>
</html>
