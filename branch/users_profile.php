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
           
           $page_title = "User profile ";
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
               <div class="container">
                    <div class="main-body">

                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center profile">
                                            <img src="http://103.146.16.154/images/avatar.png" alt='profile' class="rounded-circle"
                                                width="150" />
                                            <div class="imgUpIcon">
                                                <button id="uploadBtn" data-bs-toggle="modal"
                                                    data-bs-target="#Profile_pic_upload_Modal" type="button">
                                                    <i class="mdi mdi-camera"></i>
                                                </button>

                                            </div>
                                            <div class="mt-3">
                                                <h4>
                                                    <?php echo $fullname; ?><br>
                                                    (<?php echo $userId; ?>)
                                                </h4>
                                                <p class="text-secondary mb-1"><?php echo $mobile; ?></p>
                                                <p class="text-muted font-size-sm"><?php echo $address; ?></p>
                                                <button class="btn btn-primary">Print</button>
                                                <button class="btn btn-outline-primary">Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
               <div class="card-body">
                   <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-marker-check"></i> Fullname:</p> <a href="#"><?php echo $fullname; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-account-circle"></i>   Username:</p> <a href="#"><?php echo $username; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-phone"></i> Mobile:</p> <a href="#"><?php echo $mobile; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-envelope"></i> Email:</p> <a href="#"><?php echo $email; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="fas fa-location-arrow"></i> Area:</p> <a href="#"><?php echo $area; ?></a>
                    </div>
                </div>
               </div>
           </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $fullname; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Username</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $username;?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Password</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $password; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mobile</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $mobile; ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $email; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Role</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $role; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Last Login</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $last_login; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="btn btn-info "
                                                    href="users_profile_edit.php?id=<?php echo $userId; ?>">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                               

                            </div>
                        </div>

                    </div>
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

    </body>
</html>
