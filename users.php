<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";

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
        
           <?php $page_title="Users"; include 'Header.php'; ?>


        
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
                                 data-bs-toggle="modal" data-bs-target="#addModal" style="margin-bottom: 12px;">&nbsp;&nbsp;New User</button>
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

                                                if ($userlist=$con->query("SELECT* FROM users")) {

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

    <?php include 'Footer.php'; ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

           <!-- Add Modal -->
<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/users_server.php?add_user=true" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Your Fullname" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">User Name</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username" />

                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" />
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="mobile">Mobile no.</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Your Mobile Number" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" />

                            </div>
                            <div class="form-group mb-3">
                                        <label for="role">Role</label>
                                        <select class="form-select" id="role" name="role">
                                        <option value="">Select</option>
                                        <option value="Operations">Operations</option>
                                        <option value="Staff">Staff</option>
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
                    </div>

                   

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <!-- JAVASCRIPT -->
        <?php include 'script.php'; ?>
     <script type="text/javascript">
    $(document).ready(function() {
        $("#users_table").DataTable();
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "user_delete.php?id=" + userId;
            }
        }
        /**  Add **/
    $('#addModal form').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        $.ajax({
            type:'POST',
            'url':url,
            data: formData,
            dataType:'json',
            success: function (response) {
                if (response.success) {
                    $('#addModal').modal('hide'); 
                    toastr.success(response.message); 
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    toastr.error(response.message); 
                }
            },


            error: function (xhr, status, error) {
                /** Handle  errors **/
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]); 
                    });
                }
            }
        });
    });
       
    });
    </script>

    </body>
</html>
