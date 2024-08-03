<?php 



include "include/db_connect.php";

if(isset($_POST["loginConfirmBtn"]))
{
$password = $_POST["password"];

 $username = $_POST["username"];
 $usr = $con -> query("SELECT * FROM customers WHERE username='$username' AND password='$password' LIMIT 1");
 $usrext = $usr->num_rows;
 
 if($usrext==1)
 {
      while($rows= $usr->fetch_array())
  {
      $uid = $rows["id"];
      $fullname = $rows["fullname"];
  }
session_start();
$_SESSION["subscribe_id"] = $uid;    
$_SESSION["subscribe_fullname"] = $fullname;    
header("location: subscribe_profile.php");
     
 }else{
    $wrong_info="Username or Password Wrong!";
 }
    
}












 ?>






<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customer Login Page</title>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');

:root{
    --font-ubuntu: 'Ubuntu', monospace;
    --color-border: #e5e5e5;
}

.font-ubuntu{
    font: normal 500 16px var(--font-ubuntu);
}

#register, #login-form {
    padding: 5% 0;
    background: url("assets/images/background.png") no-repeat;
    background-size: cover;
}

#login-form{
    padding: 10% 0;
}

#register .upload-profile-image{
    position: relative;
    width: 10%;
    margin-left: auto;
    margin-right: auto;
    transition: filter .8s ease;
}

#register .upload-profile-image:hover{
    filter: drop-shadow(1px 1px 22px #7584bb);
}

#upload-profile{
    position: absolute;
    top: 0;
    z-index: 10;
    width: 200px;
    margin-top: 0px;
    opacity: 0;
}

#upload-profile::-webkit-file-upload-button{
    visibility: hidden;
}

#upload-profile::before{
    content: ' ';
    display: inline-block;
    width: 200px;
    height: 200px;
    cursor: pointer;
    border-radius: 50%;
}

#register .upload-profile-image .camera-icon{
    position: absolute;
    top: 70px;
    width: 60px !important;
    filter: invert(30%) !important;
}

#register .upload-profile-image:hover .camera-icon{
    filter: invert(100%) !important;
}

#reg-form input[type='text'],
#reg-form input[type='email'],
#reg-form input[type='password'],
#log-form input[type='text'],
#log-form input[type='email'],
#log-form input[type='password']{
    border: none;
    border-radius: unset;
    border-bottom: 1px solid var(--color-border);
    font-family: var(--font-ubuntu);
}

#reg-form input[type='text'],
#reg-form input[type='email'],
#reg-form input[type='password'],
#log-form input[type='text'],
#log-form input[type='email'],
#log-form input[type='password']{
    outline: none;
    box-shadow: none;
}

</style>
<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
</head>
<body>
<section id="login-form">
    <div class="row m-0">
        <div class="col-lg-4 offset-lg-2">
            <div class="text-center pb-5">
                <h1 class="login-title text-dark">Login</h1>
                <p class="p-1 m-0 font-ubuntu text-black-50">Login and enjoy additional features</p>
                <span class="font-ubuntu text-black-50">Create a new <a href="register.php">account</a></span>
            </div>
            <!-- <div class="upload-profile-image d-flex justify-content-center pb-5">
                <div class="text-center">
                    <img src="" style="width: 200px; height: 200px" class="img rounded-circle" alt="profile">
                </div>
            </div> -->
            <div class="d-flex justify-content-center">
                <form method="post" id="log-form">

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" required name="username" id="username" class="form-control" placeholder="Username*">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="password" required name="password" id="password" class="form-control" placeholder="password*">
                        </div>
                    </div>
                    <div>
                        <?php if (isset($wrong_info)) {
                            echo '<p style="color:red;">'.$wrong_info.'</p>';
                        } ?>
                    </div>
                    <div class="submit-btn text-center my-5">
                        <button type="submit" class="btn btn-warning rounded-pill text-dark px-5" name="loginConfirmBtn">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>