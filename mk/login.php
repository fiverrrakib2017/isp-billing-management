<?php

include "../include/db_connect.php";
$dbUsername="rakibas375";
$dbPassword="iloverakib";
if (isset($_POST['login'])) {
     $userInputName=$_POST['username'];
     $userInputPwd=$_POST['password'];

    if ($userInputName===$dbUsername & $userInputPwd===$dbPassword) {
        header("location:marketing_client.php");
        
    }else{
        
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
        <!-- App favicon -->
        <link rel="../shortcut icon" href="assets/images/favicon.ico">
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <!-- C3 Chart css -->
        <link href="../assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    
    </head>

    <body data-sidebar="dark">
<!-- Loader -->
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

         <!-- Begin page -->
         <div class="accountbg" style="background: url('../assets/images/logo-it.png');background-size: cover;background-position: center;"></div>

        <div class="account-pages mt-2 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <div class="mb-3">
                                        <a href="#"><img src="../assets/images/it-fast.png" height="30" alt="logo"></a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-size-18 mt-2 text-center">Welcome Back !</h4>
                                    <p class="text-muted text-center mb-4">Sign in to continue to Marketing Client</p>
    
                                    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="rakibas375">
                                        </div>
    
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="iloverakib">
                                        </div>
                                        <div>
                                            <!-- <?php if (isset($wrong_info)) {
                                                echo '<p style="color:red;">'.$wrong_info.'</p>';
                                            } ?> -->
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
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        
        
        <!-- Peity chart-->
        <script src="../assets/libs/peity/jquery.peity.min.js"></script>
        
        <!--C3 Chart-->
        <script src="../assets/libs/d3/d3.min.js"></script>
        <script src="../assets/libs/c3/c3.min.js"></script> 
        <script src="../assets/libs/jquery-knob/jquery.knob.min.js"></script>
        
        <script src="../assets/js/pages/dashboard.init.js"></script>
        
        <script src="../assets/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="../assets/js/pages/datatables.init.js"></script> 

        <script src="../assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/js-fluid-meter.js"></script>
        <!-- <script type="text/javascript">
         $(document).ready(function(){
         
             $("#marketing_client_add").click(function(e) {
                e.preventDefault();
             var formData = $("#marketing_client_form").serialize();
             alert(formData);
             $.ajax({
                 type: "GET",
                 url: "include/marketing_client_server.php?add",
                 data: formData,
                 cache: false,
                 success: function(response) {
                    alert(response.data);
                 // $("#alertMsg").show();
                 // setTimeout(function() { $("#alertMsg").hide(); }, 10000);
                 //     $("#product-list").load("include/product.php?list");
                 }
             });
         });
         });
      </script> -->
    </body>
</html>
