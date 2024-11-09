<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";
error_reporting(E_ALL);


if(isset($_GET["inactive"]))
{
    if($_GET["inactive"]=="true")
    {
        $popID = $_GET["pop"];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) 
            {
                $custmr_usrname = $rowsct["username"];

                // Deleting users from Radius user list
                $con->query("DELETE FROM radcheck WHERE username = '$custmr_usrname'");
                $con->query("DELETE FROM radreply WHERE username = '$custmr_usrname'");
                $con->query("UPDATE customers SET status='0' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='0' WHERE id='$popID'");

            }

            header('Location: '.$_SERVER['PHP_SELF']);
            die;


    }
    else if($_GET["inactive"]=="false")
    {
        $popID = $_GET["pop"];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) 
            {
                $custmr_usrname = $rowsct["username"];
                $custmr_password = $rowsct["password"];
                $custmr_package = $rowsct["package_name"];
                
                // Deleting users from Radius user list
                $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$custmr_usrname','Cleartext-Password',':=','$custmr_password')");
                $con->query("INSERT INTO radreply (username,attribute,op,value) VALUES('$custmr_usrname','MikroTik-Group',':=','$custmr_package')");
                $con->query("UPDATE customers SET status='1' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='1' WHERE id='$popID'");

            }

            header('Location: '.$_SERVER['PHP_SELF']);
            die;


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

       <?php 
       $page_title="POP/Branch"; 

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

                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                                        POP/Branch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addModal">
                        <div class="modal-dialog" role="document">
                            <form id="pop_branch">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add POP/Branch</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>POP/Branch</label>
                                                            <input class="form-control" type="text" name="pop" id="pop" placeholder="Type Your POP/Branch" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Fullname</label>
                                                            <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Type Your fullname" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Username</label>
                                                            <input class="form-control" type="text" name="username" id="username" placeholder="Enter username" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Password</label>
                                                            <input class="form-control" type="password" name="password" id="password" placeholder="Enter Your Password" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Opening Balance</label>
                                                            <input class="form-control" type="text" name="opening_bal" id="opening_bal" placeholder="Enter Balance" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="margin-right:5px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number</label>
                                                            <input class="form-control" type="text" name="mobile_num1" placeholder="Enter Your Mobile Number" id="mobile_num1" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number 2</label>
                                                            <input class="form-control" type="text" name="mobile_num2" id="mobile_num2" placeholder="Enter Mobile No" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Email Address</label>
                                                            <input class="form-control" type="email" name="email_address" placeholder="Enter Email Address" id="email_address" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="form-group mb-3">
                                                        <label>Note</label>
                                                        <textarea id="note" placeholder="Enter Your Text" class="form-control" rows="4" cols="50"></textarea>

                                                    </div>
                                                    <input class="d-none" type="text" id="user_type" name="user_type" value="<?php echo $auth_usr_type; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="button" id="addButton" class="btn btn-primary">Add POP/Branch</button>
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
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>POP/Branch</th>

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

                                                $sql = "SELECT * FROM add_pop  WHERE  user_type='$auth_usr_type'  ";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                    <tr>
                                                        <td><?php echo $popId = $rows['id']; ?></td>
                                                        <td><a href="view_pop.php?id=<?php echo $rows['id']; ?>"><?php echo $popName = $rows['pop']; ?></a> </td>
                                                        <td>
                                                            <?php
                                                            if ($pop_usr = $con->query("SELECT * FROM customers WHERE pop='$popId'  ")) {
                                                                echo $popttlusr = $pop_usr->num_rows;
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php

                                                                $sql = "SELECT radacct.username FROM radacct
                                                                INNER JOIN customers
                                                                ON customers.username=radacct.username
                                                                
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
                                                               if($totalexprs == 0)
                                                               {
                                                                   echo $totalexprs;   

                                                               }
                                                               else{

                                                                   echo "<span class='badge bg-danger'>$totalexprs</span>";
                                                               }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popId  ")) {
                                                                while ($rowssss = $pop_payment->fetch_array()) {
                                                                    $totalAmount = $rowssss["balance"];
                                                                }
                                                                $totalAmount;
                                                            }

                                                            if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$popId  ")) {
                                                                while ($rowss = $pop_payment->fetch_array()) {
                                                                    $paidAmount = $rowss["amount"];
                                                                }
                                                            }
                                                            echo $totalAmount - $paidAmount;

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            //echo $popId;
                                                            if ($allTransactionAmount = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popId ")) {
                                                                while ($totalAmount = $allTransactionAmount->fetch_array()) {
                                                                    $totalCostAmount =  $totalAmount['balance'];
                                                                }
                                                            }
                                                            if ($allCustomerAmount = $con->query("SELECT SUM(purchase_price) AS recharge_amount FROM `customer_rechrg` WHERE pop_id=$popId ")) {
                                                                while ($CstmrAmount = $allCustomerAmount->fetch_array()) {
                                                                    $totalCustomerAmount  = $CstmrAmount['recharge_amount'];
                                                                }
                                                            }
                                                            echo $totalCostAmount - $totalCustomerAmount;

                                                            ?>

                                                        </td>
                                                            <td>

                                                            <span>
                                                            <?php
                                                            $pop_status = $rows['status'];
                                                            if($rows['status']=='0')
                                                            {
                                                                $checkd = "";
                                                               echo '<a href="?inactive=false&pop='.$popId.'">Active</a>';

                                                            }
                                                            elseif($rows['status']=='1')
                                                            {
                                                                echo '<a href="?inactive=true&pop='.$popId.'">Inctive</a>';
                                                                $checkd = "checked";
                                                            }
                                                            
                                                            
                                                            ?></span>

                                                            </td>
                                                        </td>

                                                        <td style="text-align:right">
                                                            
                                                        <input disabled="disabled" class="form-check form-switch" type="checkbox" onchange="popAction()" id="<?php echo $popId; ?>" value="id="<?php echo $popId; ?>"" switch="bool" <?php echo $checkd; ?>>
                                            <label class="form-label" for="<?php echo $popId; ?>" data-on-label="Yes"
                                                   data-off-label="No"></label>

                                                        </td>

                                                        <td style="text-align:right">
                                                            <a class="btn-sm btn btn-success" href="view_pop.php?id=<?php echo $rows['id']; ?>"><i class="mdi mdi-eye"></i></a>

                                                            <a class="btn-sm btn btn-info" href="pop_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>

                                                            



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


    <?php include 'script.php';?>
    
    <script type="text/javascript">
        add_pop_branch();

        function add_pop_branch() {
            $("#addButton").click(function() {
                var pop = $('#pop').val();
                var fullname = $('#fullname').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var opening_bal = $('#opening_bal').val();
                var mobile_num1 = $('#mobile_num1').val();
                var mobile_num2 = $('#mobile_num2').val();
                var email_address = $('#email_address').val();
                var note = $('#note').val();
                var user_type = $('#user_type').val();
                addPopData(pop, fullname, username, password, opening_bal, mobile_num1, mobile_num2, email_address, note, user_type);
            });
        }
        const addPopData = (pop, fullname, username, password, opening_bal, mobile_num1, mobile_num2, email_address, note, user_type) => {
            if (pop.length == 0) {
                toastr.error("POP/Branch name is required");
            } else if (fullname.length == 0) {
                toastr.error("Fullname is required");
            } else if (username.length == 0) {
                toastr.error("Username is required");
            } else if (password.length == 0) {
                toastr.error("Password is required");
            } else if (opening_bal.length == 0) {
                toastr.error("Type your opening balance");
            } else if (mobile_num1.length == 0) {
                toastr.error("Mobile Number  is required");
            } else if (email_address.length == 0) {
                toastr.error("Email is required");
            } else {

                var addPopData = "0";
                $.ajax({
                    type: "POST",
                    data: {
                        pop: pop,
                        fullname: fullname,
                        username: username,
                        password: password,
                        opening_bal: opening_bal,
                        mobile_num1: mobile_num1,
                        mobile_num2: mobile_num2,
                        email_address: email_address,
                        note: note,
                        addPopData: addPopData,
                        user_type: user_type
                    },
                    url: "include/popBranch.php",
                    cache: false,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("POP/Branch Create Success");
                            $("#addModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error('Please Try Again');
                        }
                    }
                });


            }
        }

        $(document).ready(function(){

            $(".form-check form-switch").change(function() {
                //$(this).val()
                alert("ok");
            });

        });

            
                       
        

    </script>
</body>

</html>