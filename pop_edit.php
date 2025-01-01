<?php
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
include("include/pop_security.php");
if (isset($_GET["id"])) {
    $popId=$_GET['id'];
    if ($POP=$con->query("SELECT * FROM add_pop WHERE id='$popId'")) {
        while($rows=$POP->fetch_array()){
            $id=$rows["id"];
            $popName=$rows["pop"];
            $fullname=$rows["fullname"];
            $username=$rows["username"];
            $password=$rows["password"];
            $opening_bal=$rows["opening_bal"];
            $mobile_num1=$rows["mobile_num1"];
            $mobile_num2=$rows["mobile_num2"];
            $email_address=$rows["email_address"];
            $note=$rows["note"];
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
        <?php include 'style.php'; ?>
    </head>

    <body data-sidebar="dark">


       

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <?php $page_title="Update POP/Branch";  include 'Header.php'; ?>
        
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
    <div class="col-md-8 m-auto">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Update POP/Branch</h5>
            </div>
            <div class="card-body">
                <form action="#" id="updatePop">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="pop">POP/Branch Name</label>
                                <input type="text" class="form-control" id="pop" name="pop" value="<?php echo $popName; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="opening_bal">Opening Balance</label>
                                <input type="text" class="form-control" id="opening_bal" name="opening_bal" value="<?php echo $opening_bal; ?>">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="mobile_num1">Mobile Number 1</label>
                                <input type="text" class="form-control" id="mobile_num1" name="mobile_num1" value="<?php echo $mobile_num1; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="mobile_num2">Mobile Number 2</label>
                                <input type="text" class="form-control" id="mobile_num2" name="mobile_num2" value="<?php echo $mobile_num2; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email_address">Email Address</label>
                                <input type="text" class="form-control" id="email_address" name="email_address" value="<?php echo $email_address; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="note">Note</label>
                                <input type="text" class="form-control" id="note" name="note" value="<?php echo $note; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn btn-success" id="up_pop_button" style="margin-top: 20px;">Update POP/Branch</button>
                                <button onclick="history.back();" type="button" class="btn btn-danger" style="margin-top: 20px;">Back</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        </div> <!-- container -->
    </div>
    <!-- End Page-content -->

    <?php include 'Footer.php'; ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

      

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <?php include 'script.php';?>
      <script type="text/javascript">
       $(document).ready(function () {
                $("#up_pop_button").click(function (e) {
                e.preventDefault();
                var formData = $("#updatePop").serialize();

                $.ajax({
                    type: "POST",
                    url: "include/add_pop.php?update", 
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {
                        $("#up_pop_button").prop("disabled", true).text("Updating...");
                    },
                    success: function (response) {
                        $("#up_pop_button").prop("disabled", false).text("Update POP/Branch");

                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error: ' + error);
                        $("#up_pop_button").prop("disabled", false).text("Update POP/Branch");
                        toastr.error("An error occurred while updating the data.");
                    }
                });
            });
        });

    </script>
    </body>
</html>
