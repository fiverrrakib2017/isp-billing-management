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
    <style type="text/css">
        span.select2-selection.select2-selection--single {
            height: 35px;
        }
    </style>
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        
        $page_title = 'Message Template';
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
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body  shadow">
                                    <form class="row g-3 align-items-end" id="search_box">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="from_date" class="form-label">Start Date <span
                                                        class="text-danger">*</span></label>
                                                <input name="start_date" id="start_date" class="form-control"
                                                    type="date" placeholder="Start Date" required>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="end_date" class="form-label">End Date <span
                                                        class="text-danger">*</span></label>
                                                <input name="end_date" id="end_date" class="form-control"
                                                    type="date" placeholder="End Date" required>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pop_id" class="form-label">POP/Branch Name <span
                                                        class="text-danger">*</span></label>
                                                <select name="pop_id" id="pop_id" class="form-select"
                                                    style="width: 100%;">
                                                    <option>---Select---</option>
                                                    <?php
                                                    if ($allPOPuSR = $con->query("SELECT * FROM add_pop WHERE id = $auth_usr_POP_id")) {
                                                        while ($rows = $allPOPuSR->fetch_array()) {
                                                            //$selected = ($rows['id'] == $auth_usr_POP_id) ? 'selected' : '';
                                                            echo '<option value="' . $rows['id'] . '" >' . $rows['pop'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="area" class="form-label">Area <span
                                                        class="text-danger">*</span></label>
                                                <select name="area" id="area" class="form-select"
                                                    style="width: 100%;">
                                                    <option>---Select---</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-md-2 d-grid">
                                            <div class="form-group">
                                                <button type="button" name="search_btn" class="btn btn-success">
                                                    <i class="fas fa-search me-1"></i> Search Now
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body d-none" id="print_area">



                                    <div class="table-responsive responsive-table">

                                        <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>


                                                    <th class="">ID.</th>
                                                    <th class="">Username</th>
                                                    <th class="">POP/Branch</th>
                                                    <th class="">Area</th>
                                                    <th class="">Phone Number</th>
                                                    <th class="">Status</th>
                                                    <th class="">Message</th>
                                                    <th class="">Send</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_data">
                                                <tr id="no-data">
                                                    <td colspan="10" class="text-center">No data available</td>
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

            <?php
            $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
            
            echo file_get_contents($url);
            
            ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Modal for Send Message -->
    <div class="modal fade bs-example-modal-lg" id="sendMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                        &nbsp;Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="paymentForm" method="POST">

                        <div class="form-group mb-2">
                            <label>Message Template</label>
                            <select class="form-select" name="message_template">
                                <option>---Select---</option>
                                <?php
                                if ($allCstmr = $con->query('SELECT * FROM message_template WHERE pop_id=' . $auth_usr_POP_id . ' ')) {
                                    while ($rows = $allCstmr->fetch_array()) {
                                        echo '<option value=' . $rows['id'] . '>' . $rows['template_name'] . '</option>';
                                    }
                                }
                                
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Message</label>
                            <textarea id="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="button" name="send_message_btn" class="btn btn-success">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

            $('#pop_id').select2({
                placeholder: 'Select POP/Branch',
                allowClear: false
            });
            $('#area').select2({
                placeholder: 'Select Area',
                allowClear: false
            });
            $('#customer_status').select2({
                placeholder: 'Select Status',
                allowClear: false
            });

            $("select[name='pop_id']").on('change', function() {
                var pop_id = $(this).val();
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/add_pop.php';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        pop_id: pop_id
                    },
                    success: function(data) {
                        $('#area').html(data).select2({
                            placeholder: 'Select Area',
                            allowClear: false
                        });
                    }
                });
            });

            /***Load Customer **/
            $("button[name='search_btn']").click(function() {
                var button = $(this);

                button.html(
                    `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`
                );
                button.attr('disabled', true);
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var pop_id = $("#pop_id").val();
                var area_id = $("#area").val();
                if ($.fn.DataTable.isDataTable("#datatable1")) {
                    $("#datatable1").DataTable().destroy();
                }
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/message_server.php?get_sms_logs_data=true';
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        pop_id: pop_id,
                        area_id: area_id
                    },
                    success: function(response) {
                        if (response.success == true) {

                            $("#print_area").removeClass('d-none');
                            $("#_data").html(response.data);
                            $("#datatable1").DataTable({
                                "paging": true,
                                "searching": true,
                                "ordering": true,
                                "info": true
                            });

                        }

                        if (response.success == false) {
                            toastr.error(response.message);
                            $("#_data").html(
                                '<tr id="no-data"><td colspan="10" class="text-center">No data available</td></tr>'
                            );
                        }
                    },
                    complete: function() {
                        button.html('<i class="fas fa-search me-1"></i> Search Now');
                        button.attr('disabled', false);
                    }
                });
            });

        });
    </script>

</body>

</html>
