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
?>
<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
         $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
         $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/style.php';
        echo file_get_contents($url);
        
        ?>
    </head>

    <body data-sidebar="dark">


      

        <!-- Begin page -->
        <div id="layout-wrapper">
        
          
        <?php 
           
           $page_title = "Message Template";
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
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">


                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Users</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                              User</button>
                          </div>
                            </div>
                        </div>
                    </div>






                    <div class="modal fade bs-example-modal-lg" id="client-add-popup" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content col-md-10">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New User</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div>
  <form id="user_form">
            <div>
                <div class="card">
                    <div class="card-body">
                        <form class="form-sample">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label>Full Name</label>
                                        <input id="fullname" type="text"
                                            class="form-control"
                                            name="fullname" id="fullname"
                                            placeholder="Enter Your Fullname" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label>User Name</label>
                                        <input id="username" type="text"
                                            class="form-control"
                                            name="username" id="username"
                                            placeholder="Enter Your Username" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label>Password</label>
                                        <input id="password" type="password"
                                            class="form-control"
                                            name="password" id="password"
                                            placeholder="Enter Your Password" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label>Mobile no.</label>
                                        <input id="mobile" type="text"
                                            class="form-control"
                                            name="mobile" id="mobile"
                                            placeholder="Enter Your Mobile Number" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label>Email</label>
                                        <input id="email" type="email"
                                            class="form-control"
                                            name="email" id="email"
                                            placeholder="Enter Your Email" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group mb-1">
                                        <label>Role</label>
                                        <select class="form-select"
                                            name="role" id="role">
                                            <option value="">Select</option>
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
                                <div class="col-md-6 d-none">
                                    <div class="form-goup">
                                        <label>POP id</label>
                                        <input type="text" name="pop_id" value="<?php echo $auth_usr_POP_id;?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Customer form end-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                                 data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="user_add">Save changes</button>
            </div>
        </form>
                           </div>
                        </div>
                     </div>
                  </div>







                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title"></span>


                                    <div class="col-md-6 float-md-right grid-margin-sm-0">



                                    </div>


                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                               <tr>
                                                  <th>ID</th>
                                                    <th>Name</th>
                                                    <th>User Name</th>
                                                    <th>Mobile no.</th>
                                                    <th>Role</th>
                                                    <th>Last Login</th>
                                                    <th></th>
                                               </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                                if ($userlist=$con->query("SELECT * FROM users WHERE pop_id=$auth_usr_POP_id ")) {

        while ($rows=$userlist->fetch_array()) {

            $userId=$rows["id"];
            $fullname=$rows["fullname"];
            $username=$rows["username"];
            $password=$rows["password"];
            $mobile=$rows["mobile"];
            $email=$rows["email"];
            $role=$rows["role"];
            $last_login=$rows["lastlogin"];

             echo '
     <tr>
     <td>'.$userId.'</td>
     <td><a href="users_profile.php?id='.$userId.'">'.$fullname.'</a></td>
     <td>'.$username.'</td>
    <td>'.$mobile.'</td>
    <td>'. $role.'</td>
    <td>'.$last_login.'</td>
    <td style=" text-align:right;">
        <a class="btn btn-info" href="users_profile_edit.php?id='.$userId.'"><i class="fas fa-edit"></i></a>
        <a class="btn btn-success" href="users_profile.php?id='.$userId.'"><i class="fas fa-eye"></i>
        </a>
       
        </td>
     </tr>'; 
        }
    }

                                                 ?>
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
        
        
        <!-- JAVASCRIPT -->
        <?php 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/script.php';
        
        echo file_get_contents($url);
        
    ?>
     <script type="text/javascript">
    $(document).ready(function() {
        $("#users_table").DataTable();
        $("#user-list").load("include/users.php?list");
        var userdta = "0";
        $.ajax({
            type: "GET",
            url: "../../include/users.php?list",
            data: userdta,
            cache: false,
            success: function(userlist) {
                $("#user-list").html(userlist);
            }
        });

        $("#user_add").click(function() {
        	var fullname=$("#fullname").val();
        	var username=$("#username").val();
        	var password=$("#password").val();
        	var mobile=$("#mobile").val();
        	var email=$("#email").val();
        	var role=$("#role").val();
        	if (fullname.length==0) {
                    toastr.error('name is required');
                 }else if(username.length==0){
                    toastr.error('Username is required');
                 }else if(password.length==0){
                    toastr.error('Password is required');
                 }else if(mobile.length==0){
                    toastr.error('Mobile is required');
                 }else if(email.length==0){
                    toastr.error('Email is required');
                 }else if(role.length==0){
                 	toastr.error("Role is required");
                 }else{
                 	var userdta = $("#user_form").serialize();
            $.ajax({
                type: "GET",
                url: "../../include/users_server.php?add",
                data: userdta,
                cache: false,
                success: function(repp) {
                    toastr.success("User added Success");
                    setTimeout(()=>{
                            location.reload();
                        },1000);
                }
            });
                 }
        });
    });
    </script>

    </body>
</html>
