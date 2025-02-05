<?php

if(!isset($_SESSION)){
    session_start();
}
include "include/db_connect.php";

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        /* Fetch user securely using prepared statement*/
        $stmt = $con->prepare("SELECT id, username, fullname, role, password FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            /*Set session variables*/ 
            $_SESSION["uid"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["fullname"] = $row["fullname"];
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

            /*Log user's IP*/ 
            $loggeIP = $_SERVER['REMOTE_ADDR'];
            $stmt = $con->prepare("INSERT INTO user_login_log(username, time, ip, status) VALUES (?, NOW(), ?, 'Success')");
            $stmt->bind_param("ss", $username, $loggeIP);
            $stmt->execute();

            /*Update last login time & store CSRF token*/ 
            $stmt = $con->prepare("UPDATE users SET lastlogin = NOW(), csrf_token = ? WHERE username = ?");
            $stmt->bind_param("ss", $_SESSION['csrf_token'], $username);
            $stmt->execute();

            header("Location: index.php");
            exit();
        } else {
            $wrong_info = "Username or Password is incorrect!";
        }

        /* Log failed login attempt*/
        $stmt = $con->prepare("INSERT INTO user_login_log(username, time, ip, status) VALUES (?, NOW(), ?, 'Failed')");
        $stmt->bind_param("ss", $username, $_SERVER['REMOTE_ADDR']);
        $stmt->execute();
    } else {
        $wrong_info = "Please enter both username and password!";
    }
}

if (isset($_SESSION["uid"])) {
    $stmt = $con->prepare("SELECT csrf_token FROM users WHERE id=?");
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $_SESSION["csrf_token"] === $user["csrf_token"]) {
        header("Location: index.php");
        exit();
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
