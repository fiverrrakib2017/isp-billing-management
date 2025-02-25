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
            $page_title = 'Location/Area';
            $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
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
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal"
                                        data-bs-target="#fileImportModal">
                                        <img src="https://img.icons8.com/?size=100&id=117561&format=png&color=000000"
                                            class="img-fluid icon-img" style="height: 20px !important;">
                                        Import Excel File
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>User Name</th>
                                                    <th>Password</th>
                                                    <th>Package</th>
                                                    <th>Mobile</th>
                                                    <th>POP</th>
                                                    <th>Area</th>
                                                    <th>Price</th>
                                                    <th>Expired</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php
                                                $directory = "../csv/"; 
                                                $files = scandir($directory); 
                                                $upldNo = 1;

                                                foreach ($files as $file) {
                                                    if (pathinfo($file, PATHINFO_EXTENSION) === "csv") {
                                                        $CSVvar = fopen($directory . $file, "r");
                                                        if ($CSVvar !== FALSE) {
                                                            $i = 0;
                                                            while ($data = fgetcsv($CSVvar)) {
                                                                if ($i > 0) { 
                                                                    ?>
                                                <tr>
                                                    <td><?php echo $upldNo++; ?></td>
                                                    <td><?php echo htmlspecialchars($data[0]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[1]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[2]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[3]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[4]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[5]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[6]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[7]); ?></td>
                                                    <td><?php echo htmlspecialchars($data[8]); ?></td>
                                                </tr>
                                                <?php
                        }
                        $i++;
                    }
                }
                fclose($CSVvar);
            }
        }
        ?>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div style="float:letf; width:200px;"><button type="button" id="btn_import"
                                            class="btn btn-success">Process</button></div>
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


    <!--------------------CSV File Import Modal---------------------------->
    <div class="modal fade " id="fileImportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="mdi mdi-upload"></i> File Import
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="file_import_form" method="POST">
                        <div class="form-group mb-2">
                            <label>Upload Your File:</label>
                            <input type="file" name="import_file_name" id="import_file_name" class="form-control" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="file_upload_submit_btn" class="btn btn-success"><i
                            class="mdi mdi-upload"></i> Upload Now</button>
                </div>
            </div>
        </div>
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
            $("#customers_table").DataTable();
            $(document).on('click', '#btn_import', function() {
                if (confirm("Are you sure you want to import?")) {
                    $.ajax({
                        type: 'POST',
                        url: "../include/cstmr_import.php",
                        data: {
                            customImprt: 0
                        },
                        success: function(response) {
                            toastr.success("Successfully Imported");
                        }
                    });
                }
            });
            $("button[name='file_upload_submit_btn']").click(function(e) {
                e.preventDefault();
                
                var imageData = $("#import_file_name").prop('files')[0];
                var form_data = new FormData();
                form_data.append('import_file_name', imageData);

                $.ajax({
                    url: "../include/cstmr_import.php?file_import",
                    type: "POST",
                    data: form_data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        
                        if (response.success) {
                            toastr.success(response.message);
                            location.reload();
                        }
                        if(response.success==false){
                            toastr.error(response.message);
                        }
                        $('#fileImportModal').modal('hide');
                    },
                    error: function() {
                        alert("File upload failed, please try again.");
                    }
                });
            });
        });
    </script>
</body>

</html>
