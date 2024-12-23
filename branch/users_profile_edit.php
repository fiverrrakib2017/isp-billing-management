<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
}
if (isset($_GET["id"])) {

    $userId=$_GET["id"];

    if ($userData=$con->query("SELECT * FROM users WHERE id='$userId'")) {

        while ($rows=$userData->fetch_array()) {

            $userId=$rows["id"];

            $fullname=$rows["fullname"];

            $username=$rows["username"];

            $password=$rows["password"];

            $mobile=$rows["mobile"];

            $email=$rows["email"];

            $role=$rows["role"];

            $last_login=$rows["lastlogin"];
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
        <?php
         $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
         $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        echo file_get_contents($url);
        
        ?>
    
    </head>

    <body data-sidebar="dark">


       

        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php 
           
           $page_title = "User profile update";
           $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
           $url = $protocol . $_SERVER['HTTP_HOST'] . '/Header.php';
           include '../Header.php';
              
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
                <div class="col-md-6 m-auto">
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <form id="customer_form">
                        <div class="container">
                        <div class="row mb-3 mt-1 ">
                            <div class="col-sm d-none">
                                <div class="form-group">
                                     <label>ID</label>
                                      <input  id="form" type="text" class="form-control" name="id"value="<?php echo $userId; ?>" />
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group ">
                                     <label>Full Name</label>
                                        <input id="form" type="text" class="form-control" name="fullname" value="<?php echo $fullname; ?>" />
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group  ml-2">
                                 <label>User Name</label>
                                    <input id="form" type="text" class="form-control" name="username"value="<?php echo $username; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-1 ">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Password</label>
                                        <input id="form" type="text" class="form-control" name="password" value="<?php echo $password; ?>" />
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group ">
                                    <label>Mobile no.</label>
                                        <input id="form" type="text" class="form-control" name="mobile"value="<?php echo $mobile; ?>" />
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group  ml-2">
                                 <label>Email</label>
                                    <input id="form" type="email" class="form-control" name="email"
                                        value="<?php echo $email; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-1 ">
                            <div class="col-sm">
                                <div class="form-group ">
                                      <label>Role</label>

                                                <select id="form" class="form-control" name="role">
                                                    <option value="Operations">Operations</option>
                                                    <option value="ACCOUNTS">ACCOUNTS</option>
                                                    <option value="SUPPORT">SUPPORT</option>
                                                    <option value="HR & Admin">HR & Admin</option>
                                                    <option value="NOC">NOC</option>
                                                    <option value="SALES">SALES</option>
                                                    <option value="BANK">BANK</option>
                                                    <option value="BILLING">BILLING</option>
                                                    <option value="CUSTOMERS">CUSTOMERS</option>
                                                    <option value="SUPPLIERS">SUPPLIERS</option>
                                                </select>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group ">
                                      <button type="button" id="update_user_button" class="btn btn-primary ml-4" style="margin-top: 21px;">Update Data</button>
                                      <a style="margin-top: 21px;" class="btn btn-danger" href="users.php">Cancle</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
        
        echo file_get_contents($url);
    ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

       

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <?php 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
        
        echo file_get_contents($url);
        
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#update_user_button").click(function(){
                var formData=$("#customer_form").serialize();
                $.ajax({
                    type:"GET",
                    data:formData,
                    url:"../../include/users_server.php?update=true",
                    cache:false,
                    success:function(){
                        toastr.success("Update Success");
                    }
                });
            });
        });
    </script>

    </body>
</html>
