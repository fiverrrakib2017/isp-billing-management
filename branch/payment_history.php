<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];

$db_connect_path = $rootPath . '/include/db_connect.php';
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require $db_connect_path;
}

if (file_exists($users_right_path)) {
    require $users_right_path;
}

?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/style.php';
    
    echo file_get_contents($url);
    
    ?>

</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        $page_title = 'Payment History';
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
                   <?php  require 'Component/Transaction_history.php';  ?>
                   </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">
                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers Payment</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">

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
                                        <div class="form-group">


                                        </div>
                                    </div>
                                  <?php include 'Table/transaction_history_table.php';?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            
            $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
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
    
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/script.php';
    
    echo file_get_contents($url);
    
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#transaction_datatable").DataTable();
        });
        //  $(document).ready(function(){
        //      $("#area_table").DataTable();
        //      $("#area-list").load("include/add_area.php?list");
        //      $.ajax({
        //          type: "GET",
        //          url: "include/add_area.php?list",
        //          cache: false,
        //          success: function(areaList) {
        //              $("#area-list").html(areaList);
        //          }
        //      });
        // $("#add_area").click(function(){
        //    var formData=$("#form-area").serialize();
        //       $.ajax({
        //       type:"GET",
        //       data:formData,
        //       url:"include/add_area.php?add",
        //       cache:false,
        //       success: function() {
        //              Swal.fire(
        //                    'Success!',
        //                    'Data Insert Success!',
        //                    'success'
        //                      )
        //                $("#area-list").load("include/add_area.php?list");
        //              }
        //    });
        // });
        //  });   
    </script>
</body>

</html>
