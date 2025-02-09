<?php
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
include("include/pop_security.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php';?>
</head>

<body data-sidebar="dark">
   
    <!-- Begin page -->
    <div id="layout-wrapper">
      <?php $page_title="Customer Package"; include 'Header.php';?>
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
                                            <p class="text-primary mb-0 hover-cursor">Customer/Package</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New Package</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content col-md-6">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-lan mdi-18px"></span> &nbsp;Package</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div>
                                    <!--Customer form start-->
                                    <form id="pool-frm">
                                        <div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <form class="form-sample" id="package_form">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label>Package Name</label>
                                                                    <input id="package_name" type="text" class="form-control " placeholder="1-MBPS / 2-MBPS" name="package_name" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pool</label>
                                                                    <select id="form" class="form-control" name="pool_name">
                                                                        <option>Select pool</option>
                                                                        <?php
                                                                        $pool = $con->query("SELECT * FROM pool");


                                                                        while ($rows = $pool->fetch_array()) {
                                                                            $lstid = $rows["id"];
                                                                            $poolname = $rows["name"] . " (IP " . $rows["ip_block"] . ")";



                                                                            echo '<option value=' . $lstid . '>' . $poolname . '</option>';
                                                                        }


                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--Customer form end-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="packg_add">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Pool</th>
                                                    <th>Start IP</th>
                                                    <th>End IP</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($package = $con->query("SELECT * FROM radgroupcheck")) {


                                                    while ($rows = $package->fetch_array()) {
                                                        $lstid = $rows["id"];
                                                        $groupname = $rows["groupname"];

                                                        $pool = $con->query("SELECT * FROM pool WHERE name='$groupname'");
                                                        while ($rowp = $pool->fetch_array()) {
                                                            $pname = $rowp["name"];
                                                            $pstrtip = $rowp["start_ip"];
                                                            $pendip = $rowp["end_ip"];
                                                        }
                                                        echo '
                                          <tr>
                                          <td>' . $rows["groupname"] . '</td>
                                          <td>' . $pname . '</td>
                                          <td>' . $pstrtip . '</td>
                                          <td>' . $pendip . '</td>
                                          <td style="text-align:right;">
                                          <a class="btn btn-info" href=""><i class="fas fa-edit"></i></a>
                                          
                                          <a class="btn btn-success" href=""><i class="mdi mdi-eye"></i>
                                          </a>
                                          
                                          </td>
                                          </tr>
                                          ';
                                                    }
                                                    // Free result set
                                                    //$result -> free_result();
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php'; ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php';?>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#package_table").DataTable();

            // var nas = "0";
            // $.ajax({
            //     type: "GET",
            //     url: "include/package.php?list",
            //     data: nas,
            //     cache: false,
            //     success: function(packagelist) {
            //         $("#packg-list").html(packagelist);
            //     }
            // });


            //add package

            $("#packg_add").click(function() {

                var pacgdt = $("#package_form").serialize();
                $.ajax({
                    type: "GET",
                    url: "include/package.php?add",
                    data: pacgdt,
                    cache: false,
                    success: function(packagelist) {
                        $("#packg-list").load("include/package.php?list");
                    }
                });


            });





        });
    </script>



</body>

</html>