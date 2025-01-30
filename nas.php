<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
require 'routeros/routeros_api.class.php';
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

        <?php $page_title = 'Nas';
        include 'Header.php'; ?>

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
                                            <p class="text-primary mb-0 hover-cursor">NAS</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New NAS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-striped table-bordered  nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>NAS Details</th>
                                                    <th>Online Users</th>
                                                    <th>Location</th>
                                                    <th>IP</th>
                                                    <th>Secret</th>
                                                    <th>Api User</th>
                                                    <th>Description</th>
                                                    <th>Server</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php 
                            $sql="SELECT * FROM nas";
                            $result=mysqli_query($con,$sql);

                            while ($rows=mysqli_fetch_assoc($result)) {
                                $nasname = $rows['nasname'];
                                $api_usr = $rows['api_user'];
                                $api_pswd = $rows['api_password'];
                                $api_server = $rows['api_ip'];
                                $api_port = $rows['ports'];
                                $location = $rows['location'];
                            ?>


                                                <tr>
                                                    <td>
                                                        <?php echo $rows['shortname'] . '<br>';
                                                        
                                                        ////////////////////////////////////
                                                        $API = new RouterosAPI();
                                                        
                                                        //$API->debug = true;
                                                        //$port = 8727;
                                                        if ($API->connect($api_server, $api_usr, $api_pswd, $api_port)) {
                                                            //$API->write('/interface/getall');
                                                            $API->write('/system/resource/print');
                                                        
                                                            $READ = $API->read(true);
                                                        
                                                            //$ARRAY = $API->parseResponse($READ);
                                                        
                                                            echo 'Uptime: ' . $READ['0']['uptime'] . '<br>';
                                                            echo 'Version: ' . $READ['0']['version'] . '<br>';
                                                            echo 'Hardware: ' . $READ['0']['board-name'] . '<br>';
                                                            echo 'CPU: ' . $READ['0']['cpu'] . ', ';
                                                            echo 'Core: ' . $READ['0']['cpu-count'] . ' Core, ';
                                                            echo 'Speed: ' . $READ['0']['cpu-frequency'] / 1000 . ' GHz';
                                                        
                                                            // Online users
                                                            $NAS_Online = $ARRAY = $API->comm('/ppp/active/print', ['count-only' => '']);
                                                        
                                                            //print_r($ARRAY);
                                                        
                                                            $API->disconnect();
                                                        }
                                                        /////////////////////////////////
                                                        ?>
                                                    </td>
                                                    <td><?php echo $NAS_Online; ?>
                                                    <td><?php echo $location; ?>
                                                    <td><?php echo $host = $rows['nasname']; ?>
                                                        <br />
                                                        <div id="pingchk"></div>




                                                    </td>
                                                    <td><?php echo $rows['secret']; ?></td>
                                                    <td><?php echo $rows['api_user']; ?></td>
                                                    <td><?php echo $rows['description']; ?></td>
                                                    <td><?php echo $rows['api_ip']; ?></td>
                                                    <td>
                                                        <!-- <a href="include/nas_delete.php?clid=<?php echo $rows['id']; ?>" class="btn-sm btn btn-danger" onclick=" return confirm('Are You Sure');">Delete
                                    </a> -->
                                                    </td>
                                                </tr>
                                                <?php } ?>
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
    <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add New NAS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/nas_server.php?add_data=true" method="POST" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>NAS Name</label>
                                            <input name="nas_name" type="text" class="form-control "
                                                placeholder="Enter Nas Name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Short Name</label>
                                            <input name="short_name" type="text" class="form-control "
                                                placeholder="Enter Your IP" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Type</label>
                                            <input name="type" type="text"class="form-control "
                                                placeholder="Enter Type" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Port</label>
                                            <input name="port" type="text"class="form-control "
                                                placeholder="Enter Port" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group mb-2">
                                            <label>Secret</label>
                                            <input name="secret" type="text"class="form-control "
                                                placeholder="Enter API Secret" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group mb-2">
                                            <label>API User</label>
                                            <input name="api_user" type="text"class="form-control "
                                                placeholder="Enter API User" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>API Password</label>
                                            <input name="api_pass" type="password" class="form-control"
                                                placeholder="Enter API Password" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Api IP</label>
                                            <input name="api_ip" type="text" class="form-control"
                                                placeholder="Enter Api IP" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Server</label>
                                            <input name="server" type="text" class="form-control"
                                                placeholder="Enter Server" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Location</label>
                                            <input name="location" type="text" class="form-control"
                                                placeholder="Enter Location" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Community</label>
                                            <input name="community" type="text" class="form-control"
                                                placeholder="Enter Community" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Description</label>
                                            <textarea name="description" type="text" class="form-control"
                                                placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>
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
    <div id="deleteModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fa fa-trash"></i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <h4 class="modal-title w-100 " id="DeleteId">1</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="True">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="DeleteConfirm">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>

<script type="text/javascript">
     /**  Add **/
     $('#addModal form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    'url': url,
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
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


                    error: function(xhr, status, error) {
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
</script>


</body>

</html>
