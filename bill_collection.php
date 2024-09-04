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
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">


    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- C3 Chart css -->
    <link href="assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <style>
        /* .form-inline {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        } */
    </style>
    </head>

    <body data-sidebar="dark">


        <!-- Loader -->
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/it-fast.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/it-fast.png" alt="" height="36">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>

                        <div class="d-none d-sm-block ms-2">
                            <h4 class="page-title">Bill Collection</h4>
                        </div>
                    </div>

                    

                    <div class="d-flex">

                       

                        

                        <div class="dropdown d-none d-md-block me-2">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="font-size-16">
                                    <?php if (isset($_SESSION['fullname'])) {
                                        echo $_SESSION['fullname'];
                                    } ?>
                                </span> 
                            </button>
                        </div>


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block me-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ion ion-md-notifications"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="mdi mdi-cart-outline"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                    <i class="mdi mdi-message-text-outline"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">You have 87 unread messages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-info rounded-circle font-size-16">
                                                    <i class="mdi mdi-glass-cocktail"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It is a long established fact that a reader will</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
        
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
                                        $userSql = "SELECT id, fullname FROM users";
                                        $userResult = mysqli_query($con, $userSql);
                                        
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
$sql = "SELECT u.id, DATE(cr.datetm) AS recharge_date, SUM(cr.sales_price) AS total_collection, u.fullname AS recharge_by_name  FROM customer_rechrg cr JOIN users u ON cr.rchg_by = u.id WHERE cr.status = '0' GROUP BY u.id, DATE(cr.datetm), u.fullname ORDER BY recharge_date DESC";
$result = mysqli_query($con, $sql);

while ($rows = mysqli_fetch_assoc($result)) {
    // Extract year and month from the recharge_date
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

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © IT-FAST.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <!-- Settings -->
                <hr class="mt-0">
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="Layouts-1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="Layouts-2">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="Layouts-3">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox"  id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
            
            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
      
        
        <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    <script src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
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
