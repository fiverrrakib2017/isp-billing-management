<?php
include "include/db_connect.php";

if (isset($_POST["login"])) {
    $password = $_POST["password"];
    $username = $_POST["username"];

    /*Fetch user data from the database*/ 
    $usr = $con->query("SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");
    $usrext = $usr->num_rows;

    if ($usrext == 1) {
        /* Fetch user details*/
        while ($rows = $usr->fetch_array()) {
            $uid = $rows["id"];
            $username = $rows["username"];
            $ufullname = $rows["fullname"];
            $role = $rows["role"];
        }

        /*Start session and set session variables*/ 
        session_start();
        $_SESSION["uid"] = $uid;
        $_SESSION["username"] = $username;
        $_SESSION["fullname"] = $ufullname;

        /*Log the user's IP address*/ 
        $loggeIP = $_SERVER['REMOTE_ADDR'];
        $con->query("INSERT INTO user_login_log(username, time, ip, status) VALUES('$username', NOW(), '$loggeIP', 'Success')");
        $con->query("UPDATE users SET lastlogin=NOW() WHERE username='$username' AND password='$password'");

        /* Redirect based on the user's role*/
        if ($role == 'BILLING') {
            header("Location: billing/index.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        /* Log failed login attempt*/
        $loggeIP = $_SERVER['REMOTE_ADDR'];
        $con->query("INSERT INTO user_login_log(username, time, ip, status) VALUES('$username', NOW(), '$loggeIP', 'Failed')");
        $wrong_info = "Username or Password Wrong!";
    }
}
?>


<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>Login | ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
    
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
    </head>

    <body>

        <!-- Loader -->
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

         <!-- Begin page -->
         <div class="accountbg" style="background: url('assets/images/logo-it.png');background-size: cover;background-position: center;"></div>

        <div class="account-pages mt-2 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <div class="mb-3">
                                        <a href="#"><img src="assets/images/it-fast.png" height="30" alt="logo"></a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-size-18 mt-2 text-center">Welcome Back !</h4>
                                    <p class="text-muted text-center mb-4">Sign in to continue to ISP-BILLING-SOFTWARE</p>
    
                                    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                        </div>
    
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                        </div>
                                        <div>
                                            <?php if (isset($wrong_info)) {
                                                echo '<p style="color:red;">'.$wrong_info.'</p>';
                                            } ?>
                                        </div>
    
                                        <div class="row mt-4">
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="customControlInline">
                                                    <label class="form-check-label" for="customControlInline">
                                                        Remember me
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <button name="login" class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>
    
                                        <div class="mb-0 row">
                                            <div class="col-12 mt-4">
                                                <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                            </div>
                                        </div>
                                    </form>
    
                                </div>
    
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

                             
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <script src="assets/js/app.js"></script>

        <script src="js/toastr/toastr.min.js"></script>
    <script src="js/toastr/toastr.init.js"></script>

    </body>
</html>
