<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
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

        <?php $page_title = 'ONU Device List';
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
                                            <p class="text-primary mb-0 hover-cursor">ONU Device List</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <!-- <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;Create New Onu</button> -->



                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ONT Device List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="tableStyle">
                        <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial Number</th>
                                    <th>MAC Address</th>
                                    <th>PON Port</th>
                                    <th>Status</th>
                                    <th>RX Power (dBm)</th>
                                    <th>Distance (m)</th>
                                    <th>Last Online</th>
                                    <th>Offline Time</th>
                                    <th>Offline Reason</th>
                                    <th>Location</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
    <tr>
        <td>1</td>
        <td>SN123456789</td>
        <td>00:1A:C2:7B:00:47</td>
        <td>0/1/1</td>
        <td><span class="badge bg-success">Online</span></td>
        <td>-18.20</td>
        <td>250</td>
        <td>2025-05-28 14:32</td>
        <td>N/A</td>
        <td>-</td>
        <td>Dhaka Office</td>
        <td>2025-05-28 15:00</td>
    </tr>
    <tr>
        <td>2</td>
        <td>SN987654321</td>
        <td>00:1A:C2:7B:00:48</td>
        <td>0/1/2</td>
        <td><span class="badge bg-danger">Offline</span></td>
        <td>-20.10</td>
        <td>300</td>
        <td>2025-05-27 10:00</td>
        <td>2025-05-28 09:00</td>
        <td>Power Failure</td>
        <td>Chittagong Office</td>
        <td>2025-05-28 09:05</td>
    </tr>
    <tr>
        <td>3</td>
        <td>SN112233445</td>
        <td>00:1A:C2:7B:00:49</td>
        <td>0/1/3</td>
        <td><span class="badge bg-success">Online</span></td>
        <td>-17.50</td>
        <td>150</td>
        <td>2025-05-28 13:20</td>
        <td>N/A</td>
        <td>-</td>
        <td>Barishal Branch</td>
        <td>2025-05-28 14:00</td>
    </tr>
    <tr>
        <td>4</td>
        <td>SN556677889</td>
        <td>00:1A:C2:7B:00:50</td>
        <td>0/1/4</td>
        <td><span class="badge bg-danger">Offline</span></td>
        <td>-22.30</td>
        <td>280</td>
        <td>2025-05-26 16:45</td>
        <td>2025-05-27 08:30</td>
        <td>Fiber Cut</td>
        <td>Rajshahi Branch</td>
        <td>2025-05-27 09:00</td>
    </tr>
    <tr>
        <td>5</td>
        <td>SN998877665</td>
        <td>00:1A:C2:7B:00:51</td>
        <td>0/2/1</td>
        <td><span class="badge bg-success">Online</span></td>
        <td>-19.00</td>
        <td>200</td>
        <td>2025-05-28 15:15</td>
        <td>N/A</td>
        <td>-</td>
        <td>Sylhet Office</td>
        <td>2025-05-28 15:20</td>
    </tr>

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



    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
   <script>
    $(document).ready(function () {
        $('#datatable1').DataTable();
    });
   </script>

</body>

</html>
