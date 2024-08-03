<?php 

include "include/db_connect.php";

if (isset($_POST["send"])) {
    $email=$_POST["email"];

    $query=$con->query("SELECT * FROM users WHERE email='$email'");
    $row=$query->fetch_array();
    $email_to=$row["email"];
    $password=$row["password"];


    $body="Email Recovery";

    $msg="Your Password is $password";

    $header="From, starCommunication@gmail.com";
    // if (mail($email_to, $body,  $msg, )) {
    //     echo "<script>alert('Please Check Your Email');</script>";
    // }else{
    //     echo "<script>alert('Something else please try agian');</script>";
    // }
    $result=mail($email_to, $body,  $msg);
    if ($result==true) {
        echo "<script>alert('please check your email');</script>";
    }else{
         echo "<script>alert('no');</script>";
    }
}

 ?>



<!DOCTYPE html>
<html>
<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>FAST-ISP-Billing</title>
      <!-- plugins:css -->
      <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
      <!-- endinject -->
      <!-- plugin css for this page -->
      <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
      <!-- End plugin css for this page -->
      <!-- inject:css -->
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/custom.css">
      <!-- endinject -->
      <link rel="shortcut icon" href="images/favicon.png" />
   </head>
<body>
<div class="container">
    <div class="row mt-5 py-3 mr-3 ml-3">

        <div class="col-md-6 m-auto mb-4" id="formArea">

            <h4 class="text-center">Forgot Your Password?</h4><br>

            <form id="forgot_form" method="POST">
                <label>
                    <b style="color: green;">Enter Your Email*</b>
                </label>

                <input id="form" name="email" class="form-control form-control-sm" type="email" placeholder="Enter Your Email"><br>

                <button name="send" class="btn btn-success mr-1">Send</button>
            </form>
        </div>

    </div>
</div>
</body>
</html>