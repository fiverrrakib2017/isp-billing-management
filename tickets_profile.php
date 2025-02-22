<?php
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/db_connect.php';

if (isset($_GET['id'])) {
    $tId = $_GET['id'];
    if ($cstmr = $con->query("SELECT * FROM ticket WHERE id='$tId'")) {
        while ($rows = $cstmr->fetch_array()) {
            $ticket_id = $rows['id'];
            $customer_id = $rows['customer_id'];
            $ticket_type = $rows['ticket_type'];
            $asignto = $rows['asignto'];
            $ticketfor = $rows['ticketfor'];
            $complain_type = $rows['complain_type'];
            $pop = $rows['pop'];
            $startdate = $rows['startdate'];
            $enddate = $rows['enddate'];
        }

        $onlineusr = $con->query("SELECT * FROM radacct WHERE acctterminatecause='' AND username='$username'");
        $onlineusr->num_rows;
    }

    // $ticketId = $rows['id'];

    // if ($ticketDetails = $con->query("SELECT * FROM ticket_details WHERE tcktid='$ticketId' ORDER BY id DESC LIMIT 1")) {
    //     while ($rowss = $ticketDetails->fetch_array()) {
    //         $comment = $rowss['comments'];
    //         echo $comment;
    //     }
    // }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>

</head>

<body data-sidebar="dark">




    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Ticket Profile';
        include 'Header.php'; ?>

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
                            <a class="btn-sm btn btn-info mb-3" href="tickets_edit.php?id=<?php echo $_GET['id']; ?>"><i
                                    class="fas fa-edit"></i></a>

                            <a href="ticket_delete.php?id=<?php echo $_GET['id']; ?>" class="btn-sm btn btn-danger mb-3"
                                onclick=" return confirm('Are You Sure');"><i class="fas fa-trash"></i></a>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card rounded-3 border-0">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="mdi mdi-ticket-confirmation"></i> Ticket Profile
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="mdi mdi-account-circle text-primary"></i>
                                                    Customer Name:</p>
                                                <a href="#" class="text-dark fw-bold">
                                                    <?php
                                                    echo $con->query("SELECT * FROM customers WHERE id='$customer_id'")->fetch_array()['fullname'];
                                                    ?>
                                                </a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="mdi mdi-marker-check text-success"></i>
                                                    Ticket Type:</p>
                                                <a href="#" class="text-dark fw-bold"><?php echo $ticket_type; ?></a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="mdi mdi-tag text-warning"></i> Ticket ID:
                                                </p>
                                                <a href="#" class="text-dark fw-bold"><?php echo $ticket_id; ?></a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="fas fa-user-cog text-danger"></i> Assigned
                                                    To:</p>
                                                <a href="#" class="text-dark fw-bold">
                                                    <?php
                                                    if ($group = $con->query("SELECT * FROM `working_group` WHERE id=$asignto")) {
                                                        while ($rows = $group->fetch_array()) {
                                                            echo $rows['group_name'];
                                                        }
                                                    }
                                                    ?>
                                                </a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="ion ion-md-paper text-info"></i> Ticket For:
                                                </p>
                                                <a href="#" class="text-dark fw-bold"><?php echo $ticketfor; ?></a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="fas fa-envelope text-secondary"></i>
                                                    Complain Type:</p>
                                                <a href="#" class="text-dark fw-bold">
                                                    <?php
                                                    $complainId = $complain_type;
                                                    if ($allComplain = $con->query("SELECT * FROM ticket_topic WHERE id='$complainId' ")) {
                                                        while ($singleComplain = $allComplain->fetch_array()) {
                                                            echo $singleComplain['topic_name'];
                                                        }
                                                    }
                                                    ?>
                                                </a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="fas fa-calendar-alt text-primary"></i> From
                                                    Date:</p>
                                                <a href="#" class="text-dark fw-bold"><?php echo date('d M Y', strtotime($startdate)); ?></a>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between">
                                                <p class="mb-0"><i class="fas fa-calendar-check text-success"></i> To
                                                    Date:</p>
                                                <a href="#" class="text-dark fw-bold"><?php echo date('d M Y', strtotime($enddate)); ?></a>
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
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Comment</th>
                                                        <th>Progress</th>
                                                        <th>date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($tickets = $con->query("SELECT * FROM ticket_details WHERE tcktid='$ticket_id' ")) {
                                                        while ($rows = $tickets->fetch_array()) {
                                                            $lstid = $rows['id'];
                                                            $date = $rows['datetm'];
                                                            $comment = $rows['comments'];
                                                            $progress = $rows['parcent'];
                                                    
                                                            echo '
                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                <td>' .
                                                                $lstid .
                                                                '</td>
                                                                                                                    
                                                                                                                    <td>' .
                                                                $comment .
                                                                '</td>
                                                                                                                                                                                                                                    <td>' .
                                                                $progress .
                                                                '</td>
                                                                                                                                                                                                                                <td>' .
                                                                date('d F Y', strtotime($date)) .
                                                                '</td>';
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
                                                    <input type="text" class="d-none" id="ticket_id"
                                                        value="<?php echo $ticket_id; ?>">
                                                    <select id="ticket_type" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="Active" <?php echo $ticket_type == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="New" <?php echo $ticket_type == 'New' ? 'selected' : ''; ?>>New</option>
                                                        <option value="Open" <?php echo $ticket_type == 'Open' ? 'selected' : ''; ?>>Open</option>
                                                        <option value="Complete" <?php echo $ticket_type == 'Complete' ? 'selected' : ''; ?>>Complete</option>
                                                        <option value="Close" <?php echo $ticket_type == 'Close' ? 'selected' : ''; ?>>Close</option>
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
                                                        
                                                        if ($group = $con->query('SELECT * FROM `working_group`')) {
                                                            while ($rows = $group->fetch_array()) {
                                                                $userId = $rows['id'];
                                                                $group_name = $rows['group_name'];
                                                                $selected = $userId == $asignto ? 'selected' : '';
                                                                echo '<option value="' . $userId . '" ' . $selected . '>' . $group_name . '</option>';
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
                                                    <textarea class="form-control" id="commentBox" rows="5" name="comment" placeholder="Enter Your Comment"
                                                        style="height: 89px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <button class="btn btn-success" type="button" id="addCommentBtn">Add Comment</button> -->
                                        <button type="button" id="addCommentBtn" class="btn btn-success">Add
                                            Comment</button>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Latest Tickets</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tickets_table" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Complain Type</th>
                                            <th>Ticket Type</th>
                                            <th>Comments</th>
                                            <th> Assigned To</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ticket-list">
                                        <?php
                                            $result = $con->query("SELECT * FROM ticket WHERE customer_id=$customer_id ORDER BY id DESC");

                                            while ($rows = mysqli_fetch_assoc($result)) {

                                            ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $complain_typeId = $rows['complain_type'];
                                                $ticketsId = $rows['id'];
                                                if ($allCom = $con->query("SELECT * FROM ticket_topic WHERE id='$complain_typeId' ")) {
                                                    while ($rowss = $allCom->fetch_array()) {
                                                        $topicName = $rowss['topic_name'];
                                                        echo '<a href="#">' . $topicName . '</a>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $ticketType = $rows['ticket_type'];
                                                if ($ticketType == 'Active') {
                                                    echo "<span class='badge bg-danger'>Active</span>";
                                                } elseif ($ticketType == 'Open') {
                                                    echo "<span class='badge bg-info'>Open</span>";
                                                } elseif ($ticketType == 'New') {
                                                    echo "<span class='badge bg-danger'>New</span>";
                                                } elseif ($ticketType == 'Complete') {
                                                    echo "<span class='badge bg-success'>Complete</span>";
                                                }
                                                
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $ticketId = $rows['id'];
                                                
                                                if ($ticketDetails = $con->query("SELECT * FROM ticket_details WHERE tcktid='$ticketId' ORDER BY id DESC ")) {
                                                    while ($rowss = $ticketDetails->fetch_array()) {
                                                        $comment = $rowss['comments'];
                                                        echo $comment . '--' . $rowss['parcent'];
                                                        if (count($rowss) > 1) {
                                                            echo '<br>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $assign_id = $rows['asignto'];
                                                echo $con->query("SELECT * FROM `working_group` WHERE id=$assign_id")->fetch_array()['group_name'];
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                
                                                echo date('d M Y', strtotime($rows['startdate']));
                                                
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>



    <?php include 'script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tickets_table").DataTable();
            $("#addCommentBtn").click(function() {
                var ticket_id = $("#ticket_id").val();
                var ticket_type = $("#ticket_type").val();
                var progress = $("#progress").val();
                var commentBox = $("#commentBox").val();
                var assigned = $("#assigned").val();
                addTicketData(ticket_id, ticket_type, progress, commentBox, assigned);
            });

            function addTicketData(ticket_id, ticket_type, progress, commentBox, assigned) {
                if (ticket_type.length == 0) {
                    toastr.error("Ticket Type is required");
                } else if (progress.length == 0) {
                    toastr.error("Progress is required");
                } else if (commentBox.length == 0) {
                    toastr.error("Comment is required");
                } else if (assigned.length == 0) {
                    toastr.error("Assigned To is required");
                } else {
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
                        success: function(response) {
                            if (response == 1) {
                                toastr.success("Comment Successfully Added");
                                setTimeout(function() {
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
