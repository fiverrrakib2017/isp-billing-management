<?php
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
error_reporting(E_ALL);

if (isset($_GET['inactive'])) {
    if ($_GET['inactive'] == 'true') {
        $popID = $_GET['pop'];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) {
            $custmr_usrname = $rowsct['username'];

            // Deleting users from Radius user list
            $con->query("DELETE FROM radcheck WHERE username = '$custmr_usrname'");
            $con->query("DELETE FROM radreply WHERE username = '$custmr_usrname'");
            $con->query("UPDATE customers SET status='0' WHERE username='$custmr_usrname'");
            $con->query("UPDATE add_pop SET status='0' WHERE id='$popID'");
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        die();
    } elseif ($_GET['inactive'] == 'false') {
        $popID = $_GET['pop'];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) {
            $custmr_usrname = $rowsct['username'];
            $custmr_password = $rowsct['password'];
            $custmr_package = $rowsct['package_name'];

            // Deleting users from Radius user list
            $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$custmr_usrname','Cleartext-Password',':=','$custmr_password')");
            $con->query("INSERT INTO radreply (username,attribute,op,value) VALUES('$custmr_usrname','MikroTik-Group',':=','$custmr_package')");
            $con->query("UPDATE customers SET status='1' WHERE username='$custmr_usrname'");
            $con->query("UPDATE add_pop SET status='1' WHERE id='$popID'");
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        die();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_pop_branch') {
    $delete_pop_id = isset($_POST['data']['id']) ? $_POST['data']['id'] : [];
    if (empty($delete_pop_id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
        exit;
    }
    $delete_pop_id = intval($delete_pop_id);
    $delete_pop_query = "DELETE FROM add_pop WHERE id = $delete_pop_id";
    if (!$con->query($delete_pop_query)) {
        echo json_encode(['success' => false, 'message' => 'Failed to delete POP/Branch.']);
        exit;
    }
    $delete_pop_transaction_query = "DELETE FROM pop_transaction WHERE pop_id = $delete_pop_id";
    if (!$con->query($delete_pop_transaction_query)) {
        echo json_encode(['success' => false, 'message' => 'Failed to delete POP/Branch transactions.']);
        exit;
    }   
    echo json_encode(['success' => true, 'message' => 'Delete successfully.']);
    exit;
}

?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

    <style>
        
      
    
    </style>
</head>

<body data-sidebar="dark">




    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        $page_title = 'POP/Branch';
        
        include 'Header.php';
        
        ?>

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
                                            <p class="text-primary mb-0 hover-cursor">POP/Branch</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">

                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        data-bs-toggle="modal" data-bs-target="#addModal"
                                        style="margin-bottom: 12px;">&nbsp;&nbsp;New
                                        POP/Branch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade " tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true"
                        id="addModal">
                        <div class="modal-dialog" role="document">
                            <form action="include/popBranch.php?add_pop=true" method="POST"
                                enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add POP/Branch</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>POP/Branch</label>
                                                            <input class="form-control" type="text" name="pop"
                                                                id="pop" placeholder="Type Your POP/Branch" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Fullname</label>
                                                            <input class="form-control" type="text" name="fullname"
                                                                id="fullname" placeholder="Type Your fullname" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Username</label>
                                                            <input class="form-control" type="text" name="username"
                                                                id="username" placeholder="Enter username" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Password</label>
                                                            <input class="form-control" type="password" name="password"
                                                                id="password" placeholder="Enter Your Password" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Opening Balance</label>
                                                            <input class="form-control" type="text"
                                                                name="opening_bal" id="opening_bal"
                                                                placeholder="Enter Balance" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="margin-right:5px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number</label>
                                                            <input class="form-control" type="text"
                                                                name="mobile_num1"
                                                                placeholder="Enter Your Mobile Number"
                                                                id="mobile_num1" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number 2</label>
                                                            <input class="form-control" type="text"
                                                                name="mobile_num2" id="mobile_num2"
                                                                placeholder="Enter Mobile No" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Email Address</label>
                                                            <input class="form-control" type="email"
                                                                name="email_address" placeholder="Enter Email Address"
                                                                id="email_address" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="form-group mb-3">
                                                        <label>Note</label>
                                                        <textarea id="note" placeholder="Enter Your Text" class="form-control" rows="4" cols="50"></textarea>

                                                    </div>
                                                    <input class="d-none" type="text" id="user_type"
                                                        name="user_type" value="<?php echo $auth_usr_type; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="submit" class="btn btn-primary">Add POP/Branch</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>POP/Branch</th>
                                                    <!-- <th></th> -->
                                                    <th>Total Users</th>
                                                    <th>Online Users</th>
                                                    <th>Expired Users</th>
                                                    <th>Total Due</th>
                                                    <th>Available Balance</th>
                                                    <th>Action</th>
                                                    <th>Active</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
        $result =$con->query("SELECT * FROM add_pop WHERE user_type='$auth_usr_type'");
        while ($rows = mysqli_fetch_assoc($result)) {
            $popId = $rows['id']; 
            $customer_changes = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month_year = date('Y-m', strtotime("-$i month"));
                 $result_customers = $con->query("SELECT * FROM customers WHERE pop='$popId' AND createdate LIKE '$month_year%'");
                $countconn = mysqli_num_rows($result_customers);

                $customer_changes[] = $countconn;
            }
            if (count($customer_changes) < 6) {
                $customer_changes = array_pad($customer_changes, 6, 0);
            }
            $chart_data = implode(',', $customer_changes);
        ?>

                                                <tr>
                                                    <td><?php echo $popId; ?></td>
                                                    <td>
                                                        <a href="view_pop.php?id=<?php echo $popId; ?>"
                                                            class="text-dark text-truncate" style="max-width: 150px;">
                                                            <?php echo substr($rows['pop'], 0, 15); ?>
                                                        </a>
                                                    </td>
                                                    <!-- <td>
    <canvas id="chart-<?php echo $popId; ?>" width="300 !important" height="100 !important"></canvas>
    <script>
        let ctx<?php echo $popId; ?> = document.getElementById("chart-<?php echo $popId; ?>").getContext("2d");

        new Chart(ctx<?php echo $popId; ?>, {
            type: "bar", 
            data: {
                labels: ["6 Month", "5 Month", "4 Month", "3 Month", "2 Month", "1 Month"],
                datasets: [{
                    label: "New Customers",
                    data: [<?php echo implode(',', $customer_changes); ?>], 
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4CAF50", "#FF9800", "#9C27B0"],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { display: false } 
                },
                responsive: true,
              
                scales: {
                    x: { display: false }, 
                    y: { display: false }
                }
            }
        });
    </script>
</td> -->




                                                    <td>
                                                        <?php
                                                        $pop_usr = $con->query("SELECT * FROM customers WHERE pop='$popId'");
                                                        echo $pop_usr->num_rows;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sql = "SELECT radacct.username FROM radacct
                                                                                INNER JOIN customers ON customers.username=radacct.username
                                                                                WHERE customers.pop='$popId' AND radacct.acctstoptime IS NULL";
                                                        $countpoponlnusr = mysqli_query($con, $sql);
                                                        echo $countpoponlnusr->num_rows;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE pop='$popId' AND NOW() > expiredate";
                                                        $countxprd = mysqli_query($con, $sql);
                                                        $totalexprs = $countxprd->num_rows;
                                                        echo $totalexprs == 0 ? $totalexprs : "<span class='badge bg-danger'>$totalexprs</span>";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $pop_payment = $con->query("SELECT SUM(amount) AS balance FROM pop_transaction WHERE pop_id=$popId");
                                                        $totalAmount = $pop_payment->fetch_array()['balance'];
                                                        
                                                        $paidAmount = $con->query("SELECT SUM(paid_amount) AS amount FROM pop_transaction WHERE pop_id=$popId")->fetch_array()['amount'];
                                                        echo round($totalAmount - $paidAmount);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $allTransactionAmount = $con->query("SELECT SUM(amount) AS balance FROM pop_transaction WHERE pop_id=$popId")->fetch_array()['balance'];
                                                        $allCustomerAmount = $con->query("SELECT SUM(purchase_price) AS recharge_amount FROM customer_rechrg WHERE pop_id=$popId")->fetch_array()['recharge_amount'];
                                                        echo round($allTransactionAmount - $allCustomerAmount);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <?php
                                                            $pop_status = $rows['status'];
                                                            if ($pop_status == '0') {
                                                                echo '<a href="?inactive=false&pop=' . $popId . '">Active</a>';
                                                            } elseif ($pop_status == '1') {
                                                                echo '<a href="?inactive=true&pop=' . $popId . '">Inactive</a>';
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td style="text-align:right">
                                                        <input disabled="disabled" class="form-check form-switch"
                                                            type="checkbox" onchange="popAction()"
                                                            id="<?php echo $popId; ?>" value="id=<?php echo $popId; ?>"
                                                            switch="bool" <?php echo $checkd; ?>>
                                                        <label class="form-label" for="<?php echo $popId; ?>"
                                                            data-on-label="Yes" data-off-label="No"></label>
                                                    </td>
                                                    <td style="text-align:right">
                                                        <a class="btn-sm btn btn-success"
                                                            href="view_pop.php?id=<?php echo $rows['id']; ?>"><i
                                                                class="mdi mdi-eye"></i></a>
                                                        <a class="btn-sm btn btn-info"
                                                            href="pop_edit.php?id=<?php echo $rows['id']; ?>"><i
                                                                class="fas fa-edit"></i></a>
                                                        <?php 
                                                        if($pop_usr->num_rows > 0) {
                                                            echo '<button class="btn-sm btn btn-secondary" disabled><i class="fas fa-ban"></i></button>';
                                                        } else {
                                                            echo '<button class="btn-sm btn btn-danger" data-id="' . $rows['id'] . '" name="delete_btn"><i class="fas fa-trash"></i></button>';
                                                        }
                                                        
                                                        ?>
                                                    </td>
                                                </tr>

                                                <?php } ?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            include 'Footer.php';
            
            ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?php include 'script.php'; ?>
    <!-- JavaScript -->

    <!-- Peity chart-->

    <!-- <script src="assets/libs/peity/jquery.peity.min.js"></script>
    <script src="assets/js/pages/chartjs.init.js"></script>
    <script src="assets/js/pages/peity.init.js"></script> -->
    
    <script type="text/javascript">
        $(document).ready(function() {
           /** Bar chart**/
            $(".peity-bar").peity("bar");
            
            $('.tooltip-data').each(function() {
        var tooltipContent = $(this).data('title').split(',').join('<br>');
        $(this).attr('title', tooltipContent);
    });
            /**  Add POP/Branch**/
            $('#addModal form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    'url': url,
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#addModal').modal('hide');
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else if (response.success == false) {
                            toastr.error(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },


                    error: function(xhr, status, error) {
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
            // var ctx = document.getElementById('bar').getContext('2d');
            // var chart = new Chart(ctx, {
            //     type: 'bar',
            //     data: {
            //         labels: ['6 Months', '5 Months', '4 Months', '3 Months', '2 Months', '1 Month'],
            //         datasets: [{
            //             label: '',
            //             data: [11, 19, 13, 15, 12, 14],
            //             backgroundColor: 'rgba(75, 192, 192, 0.2)', 
            //             borderWidth: 2,
            //             fill: false
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });
        });



        /************************** Customer Disable Section **************************/
        $(document).on('click', 'button[name="delete_btn"]', function(e) {
            e.preventDefault();
            if (!confirm("Are you sure you want to delete this POP/Branch? This action cannot be undone.")) {
                return;
            }

            var $button = $(this);
            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

            $.ajax({
                url: "",
                method: 'POST',
                data: {
                    action: 'delete_pop_branch',
                    data:{
                        id: $button.data('id')
                    }
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    toastr.error("Request failed.");
                },
                complete: function() {
                    $button.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                }
            });
        });
    </script>
</body>

</html>
