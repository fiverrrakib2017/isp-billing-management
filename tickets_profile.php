<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";

if(isset($_GET['id'])){
   $tId =$_GET['id'];
    if ($cstmr = $con -> query("SELECT * FROM ticket WHERE id='$tId'")) {
    
    while($rows= $cstmr->fetch_array())
        {
        $ticket_id=$rows["id"];
                $ticket_type=$rows["ticket_type"];
                $asignto=$rows["asignto"];
                $ticketfor=$rows["ticketfor"];
                $complain_type=$rows["complain_type"];
                $pop=$rows["pop"];
                $startdate=$rows["startdate"];
                $enddate=$rows["enddate"];
        }

        $onlineusr = $con->query("SELECT * FROM radacct WHERE acctterminatecause='' AND username='$username'");
        $onlineusr->num_rows;

    }

}
?>

<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
    
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
                            <h4 class="page-title">Ticket Profile</h4>
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
            <div class="row">
                <div class="col-md-6 ml-auto">
                    <a class="btn-sm btn btn-info mb-3" href="tickets_edit.php?id=<?php echo $_GET['id']; ?>"><i class="fas fa-edit"></i></a>

                    <a href="ticket_delete.php?id=<?php echo $_GET['id']; ?>" class="btn-sm btn btn-danger mb-3" onclick=" return confirm('Are You Sure');"><i class="fas fa-trash"></i></a>
                    <br>
                </div>
            </div> 
            <div class="row">
                <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
               <div class="card-body">
                   <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-marker-check"></i> Ticket Type:</p> <a href="#"><?php echo $ticket_type; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-account-circle"></i>  Ticket Id:</p> <a href="#"><?php echo $ticket_id; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-dollar-sign"></i>   Assigned To:</p> <a href="#">
                            <?php 
                               // echo $asignto;
                                if ($group = $con->query("SELECT * FROM `working_group` WHERE id=$asignto")) {
                                    while ($rows = $group->fetch_array()) {
                                        echo  $rows["group_name"];
                                    }
                                }
                             ?>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="ion ion-md-paper"></i> Ticket For:</p> <a href="#"><?php echo $ticketfor; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-envelope"></i> Complain Type:</p> <a href="#">
                            <?php 
                            $complainId= $complain_type; 
                            if ($allComplain=$con->query("SELECT * FROM ticket_topic WHERE id='$complainId' ")) {
                                while ($singleComplain=$allComplain->fetch_array()) {
                                    echo $singleComplain['topic_name'];
                                }
                            }

                            ?>
                            
                        </a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="fas fa-calendar"></i> From Date</p> 
                        <a href="#">
                            <td><?php echo date("d F Y", strtotime($startdate)); ?></td>

                        </a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="fas fa-calendar-alt"></i> To Date</p> 
                        <a href="#">
                            <td><?php echo date("d F Y", strtotime($enddate)); ?></td>

                        </a>
                    </div>
                </div>
               </div>
           </div>
                            </div>
                            <div class="col-md-8 ">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4 class="card-title">POST Table</h4>
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Comment</th>
                                                        <th>Progress</th>
                                                        <th>date</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <?php 
                                        if ($tickets = $con-> query("SELECT * FROM ticket_details WHERE tcktid='$ticket_id' ")) {
                                          while($rows= $tickets->fetch_array())
                                          {
                                              $lstid=$rows["id"];
                                              $date=$rows["datetm"];
                                              $comment = $rows["comments"];
                                              $progress = $rows["parcent"];

                                           
                                             echo '
                                             <tr>
                                             <td>'.$lstid.'</td>
                                             <td>'.$comment.'</td>
                                             <td>'.$progress.'</td>
                                             <td>'.date("d F Y", strtotime($date)).'</td>
                                             '; 
                                          }
                                        }

                                       




                                           ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

            <div class="card mb-3">
                <div class="card-body">
                   <div class="row">
                       <div class="col-sm">
                           <div class="form-group mb-2">
                               <label>Ticket Status</label>
                               <input type="text" class="d-none" id="ticket_id" value="<?php echo $ticket_id; ?>">
                               <select id="ticket_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Active" <?php echo ($ticket_type == "Active") ? 'selected' : ''; ?>>Active</option>
                                    <option value="New" <?php echo ($ticket_type == "New") ? 'selected' : ''; ?>>New</option>
                                    <option value="Open" <?php echo ($ticket_type == "Open") ? 'selected' : ''; ?>>Open</option>
                                    <option value="Complete" <?php echo ($ticket_type == "Complete") ? 'selected' : ''; ?>>Complete</option>
                                    <option value="Close" <?php echo ($ticket_type == "Close") ? 'selected' : ''; ?>>Close</option>
                                </select>
                           </div>
                        </div> 
                   <div class="col-sm">
                       <div class="form-group mb-2">
                           <label>Progress</label>
                            <select id="progress" class="form-select">
                                <option value="">Select</option>
                                <option value="0%">0%</option>
                                <option value="15%">15%</option>
                                <option value="25%">25%</option>
                                <option value="35%">35%</option>
                                <option value="45%">45%</option>
                                <option value="55%">55%</option>
                                <option value="65%">65%</option>
                                <option value="75%">75%</option>
                                <option value="85%">85%</option>
                                <option value="95%">95%</option>
                                <option value="100%">100%</option>
                            </select>
                       </div>
                   </div> 
                   <div class="col-sm">
                    <div class="form-group mb-2">
                            <label for="">Assigned To</label>
                            <select name="assigned" id="assigned" class="form-select">
                        <?php 

                            
                        if ($group = $con->query("SELECT * FROM `working_group`")) {
                            while ($rows = $group->fetch_array()) {
                                $userId = $rows["id"];
                                 $group_name = $rows["group_name"];
                                // Check if this userId is the assigned one
                                $selected = ($userId == $asignto) ? 'selected' : '';
                                echo '<option value="'.$userId.'" '.$selected.'>'.$group_name.'</option>';  
                            }
                        }
                        ?>
                            </select>
                        </div>
                    </div>

                   </div>
                   <div class="row">
                       
                        <div class="col-sm">
                           <div class="form-group mb-2">
                              <label>Write Comment</label> 
                              <textarea class="form-control" id="commentBox" rows="5" name="comment" placeholder="Enter Your Comment" style="height: 89px;"></textarea>
                           </div>
                        </div>
                   </div>
                   <button class="btn btn-success" type="button" id="addCommentBtn">Add Comment</button>
                </div>
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
        <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script> 

    <script src="assets/js/app.js"></script>
   <script type="text/javascript">
       $(document).ready(function(){
            $("#addCommentBtn").click(function(){
                var ticket_id = $("#ticket_id").val();
                var ticket_type = $("#ticket_type").val();
                var progress = $("#progress").val();
                var commentBox = $("#commentBox").val();
                var assigned = $("#assigned").val();

                // Call the function to send data via AJAX
                addTicketData(ticket_id, ticket_type, progress,  commentBox, assigned);
            });

            function addTicketData(ticket_id, ticket_type, progress,  commentBox, assigned){
                // Validate input fields
                if (ticket_type.length == 0) {
                    toastr.error("Ticket Type is required");
                } else if (progress.length == 0) {
                    toastr.error("Progress is required");
                } else if (commentBox.length == 0) {
                    toastr.error("Comment is required");
                } else if (assigned.length == 0) {
                    toastr.error("Assigned To is required");
                } else {
                    // AJAX call to the server-side script
                    $.ajax({
                        type: "POST",
                        url: "include/tickets_server.php",
                        data: {
                            id: ticket_id,
                            type: ticket_type,
                            progress: progress,
                            comment: commentBox,
                            assigned: assigned,
                            addTicketComment: "1"
                        },
                        cache: false,
                        success: function(response){
                            if(response == 1){
                                toastr.success("Comment Successfully Added");
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error("An error occurred: " + error);
                        }
                    });
                }
            }
        });

    </script>
    </body>
</html>
