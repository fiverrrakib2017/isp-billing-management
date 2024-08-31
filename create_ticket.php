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
</head>

<body data-sidebar="dark">


    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

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
                        <h4 class="page-title">Create Ticket</h4>
                    </div>
                </div>



                <div class="d-flex">





                    <div class="dropdown d-none d-md-block me-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16">
                                <?php if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
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
                    <div class="row" id="searchRow">
                        <div class="col-md-6 col-sm m-auto">
                            <div class="card shadow">
                                <div class="card-header bg-dark text-white">Create Ticket</div>
                                <div class="card-body">
                                    <form action="">
                                        
                                       <div class="from-group mb-2">
										<label>Customer Name</label>
										<select class="form-control select2" id="ticket_customer_id">
										<option value="">Select Customer</option>
											<?php

											if ($allData = $con->query("SELECT * FROM customers ")) {
												while ($rows = $allData->fetch_array()) {
											echo ' <option value="'.$rows['id'].'">['.$rows['id'].'] - '.$rows['username'].' || '.$rows['fullname'].', ('.$rows['mobile'].')</option>';
												}
											}


											?>
										</select>
										</div>
										
										
                                         
										
										<div class="from-group mb-2">
											<label for="">Ticket For</label>
											<select id="ticket_for" name="ticket_for " class="form-select">
												<option value="Home Connection">Home Connection</option>
												<option value="POP">POP Support</option>
												<option value="Corporate">Corporate</option>
												
											</select>
										</div>
										<div class="from-group mb-2">
											<label for=""> Complain Type </label>
											<select id="ticket_complain_type" class="form-select">
											<option value="">Select</option>
												<?php

												if ($allData = $con->query("SELECT * FROM ticket_topic WHERE user_type=1")) {
													while ($rows = $allData->fetch_array()) {
														echo ' <option value="' . $rows['id'] . '">' . $rows['topic_name'] . '</option>';
													}
												}


												?>
											</select>

										</div>
										<div class="from-group mb-2">
											<label for="">Assigned To</label>
											<select id="ticket_assigned" class="form-select">
												<option>---Select---</option>
												 <?php 

                                                if ($group=$con->query("SELECT* FROM working_group")) {

                                                    while ($rows=$group->fetch_array()) {

                                                        $userId=$rows["id"];
                                                        $group_name=$rows["group_name"];
                                                     echo '<option value='.$userId.'>'.$group_name.'</option>';  
                                                    }
                                                }

                                                 ?>  
											</select>
										</div>
										<div class="from-group mb-2">
											<label for="">Note</label>
											<input id="notes" type="text" class="form-control" placeholder="Enter Your Note">

										</div>
										<div class="from-group mb-2">
											<label for="">Ticket Priority</label>
											<select id="ticket_priority" type="text" class="form-select">
                                            <option >---Select---</option>
                                            <option value="1">Low</option>
                                            <option value="2">Normal</option>
                                            <option value="3">Standard</option>
                                            <option value="4">Medium</option>
                                            <option value="5">High</option>
                                            <option value="6">Very High</option>
                                            </select>

										</div>

                                        <div class="form-group">
                                           
                                        </div>
                                    </form>
                                </div>
								<div class="card-footer">
									<button class="btn btn-success"  type="button" id="customer_ticket_btn">&nbsp;&nbsp;Create Now</button>
									 <button  onclick="history.back();" class="btn btn-danger"  type="button">&nbsp;&nbsp;Back</button>
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
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © IT-FAST.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Development <i class="mdi mdi-heart text-danger"></i><a target="__blank" href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

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
        $(document).ready(function() {

			$("#ticket_customer_id").select2();
			$("#customer_ticket_btn").click(function() {
            // Get form values
            var customerId = $("#ticket_customer_id").val();
            
            var assignedTo = $("#ticket_assigned").val();
            var ticketFor = $("#ticket_for").val();
            var complainType = $("#ticket_complain_type").val();
            var notes = $("#notes").val();
            var ticket_priority = $("#ticket_priority").val();
            
            if (assignedTo.length == 0) {
                toastr.error("Customer Assign  is require");
            } else if (ticketFor.length == 0) {
                toastr.error("Please Select Ticket For");
            } else if (complainType.length == 0) {
                toastr.error("Complain Type is require");
            } else if (ticket_priority.length == 0) {
                toastr.error("Ticket Priority is require");
            } else {
                /* Make AJAX request to server*/
                $.ajax({
                    url: "include/tickets_server.php", 
                    type: "POST",
                    data: {
                        customer_id: customerId,
                        
                        assigned_to: assignedTo,
                        ticket_for: ticketFor,
                        complain_type: complainType,
                        notes: notes,
                        priority: ticket_priority,
                        addTicketData: 0,
                    },
                    success: function(response) {
                      /* Handle the response from the server*/
                      if (response == 1) {
                            toastr.success("Ticket Added Success");
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response);
                        }
                    }
                });
            }

        });
            
        });
    </script>
</body>

</html>