<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';

function timeAgo($startdate)
{
    /*Convert startdate to a timestamp*/
    $startTimestamp = strtotime($startdate);
    $currentTimestamp = time();

    /* Calculate the difference in seconds*/
    $difference = $currentTimestamp - $startTimestamp;

    /*Define time intervals*/
    $units = [
        'year' => 31536000,
        'month' => 2592000,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'min' => 60,
        'second' => 1,
    ];

    /*Check for each time unit*/
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>' . ' ' . $time . ' ' . $unit . ($time > 1 ? 's' : '') . '';
        }
    }
    /*If the difference is less than a second*/
    return '<img src="images/icon/online.png" height="10" width="10"/> just now';
}
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

        <?php $page_title = 'Customer Request';
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
                                            <p class="text-primary mb-0 hover-cursor">Customer Request</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#customer_create_modal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;Create Request
                                        customer</button>
                                </div>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                    aria-labelledby="myLargeModalLabel" id="customer_create_modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span
                                                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create
                                                    Request customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input id="customer_req_fullname" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile</label>
                                                                        <input id="customer_req_mobile" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Customer Mobile" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Address</label>
                                                                        <input id="customer_req_address" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Customer Address" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Area</label>
                                                                        <select id="customer_req_area_id" type="text"
                                                                            class="form-select" style="width: 100%;">
                                                                            <option value="0">---Select---</option>
                                                                            <?php
                                                                            
                                                                            $get_area = $con->query('SELECT * FROM area_list');
                                                                            while ($orws = $get_area->fetch_array()) {
                                                                                echo '<option value="' . $orws['id'] . '">' . $orws['name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Request By</label>
																		
																		<select id="customer_req_request_by" type="text"
                                                                            class="form-select" style="width: 100%;">
                                                                            <option value="0">---Select---</option>
                                                                            <?php
                                                                            
                                                                            $ename = $con->query('SELECT * FROM employees');
                                                                            while ($orwen = $ename->fetch_array()) {
                                                                                echo '<option value="' . $orwen['name'] . '">' . $orwen['name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
																		
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Remarks</label>
																		<input id="customer_req_remarks" type="text"
                                                                            class="form-control" placeholder="Enter Remarks" />                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success"
                                                    id="customer_request_add_btn">Add Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade " tabindex="-1"
                                    aria-labelledby="myLargeModalLabel" id="customer_edit_modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span
                                                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;   Update
                                                    Request customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_edit_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input type="text" name="customer_request_id"
                                                                            id="customer_request_id" hidden />
                                                                        <input id="customer_req_fullname" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile</label>
                                                                        <input id="customer_req_mobile" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Customer Mobile" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Address</label>
                                                                        <input id="customer_req_address" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Customer Address" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Area</label>
                                                                        <select id="customer_req_area_id" type="text"
                                                                            class="form-select" style="width: 100%;">
                                                                            <option value="0">---Select---</option>
                                                                            <?php
                                                                            
                                                                            $get_area = $con->query('SELECT * FROM area_list');
                                                                            while ($orws = $get_area->fetch_array()) {
                                                                                echo '<option value="' . $orws['id'] . '">' . $orws['name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Request By</label>
																		
																		<select id="customer_req_request_by" type="text"
                                                                            class="form-select" style="width: 100%;">
                                                                            <option value="0">---Select---</option>
                                                                            <?php
                                                                            
                                                                            $ename = $con->query('SELECT * FROM employees');
                                                                            while ($orwen = $ename->fetch_array()) {
                                                                                echo '<option value="' . $orwen['name'] . '">' . $orwen['name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
																		
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Remarks</label>
																		<input id="customer_req_remarks" type="text"
                                                                            class="form-control" placeholder="Enter Remarks" />                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success"
                                                    id="customer_request_update_btn">Update Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
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
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Req. Time</th>
                                                    <th>FullName</th>
                                                    <th>Mobile no.</th>
                                                    <th>Area</th>
                                                    <th>Address</th>
                                                    <th>Reference By</th>
                                                    <th>Remarks</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php
                                                $result = $con->query("SELECT * FROM customer_request WHERE status=0 ORDER BY id DESC");

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                <tr>
                                                    <td><?php echo $rows['id']; ?></td>
                                                    <!-- <td><?php echo timeAgo($rows['req_date'])." ~ ".$rows['req_date']; ?></td> -->
                                                    <td><?php echo timeAgo($rows['req_date']) . " ~ " . date('d M Y', strtotime($rows['req_date'])); ?></td>

                                                    <td><?php echo $rows['fullname']; ?></td>


                                                    <td><?php echo $rows['mobile']; ?></td>

                                                    <td>
                                                        <?php $id = $rows['area_id'];
                                                        $allArea = $con->query("SELECT * FROM area_list WHERE id='$id' ");
                                                        while ($popRow = $allArea->fetch_array()) {
                                                            echo $popRow['name'] ?? 'Unknown';
                                                        }
                                                        
                                                        ?>

                                                    </td>
                                                    <td><?php echo $rows['address']; ?></td>
                                                    <td><?php echo $rows['request_by']; ?></td>
                                                    <td><?php echo $rows['remarks']; ?></td>

                                                    <td>

                                                    <button type="button" class="btn btn-success approve-btn" data-id=<?php echo $rows['id']; ?>>Approve</button>

                                                        <button type="button" class="btn btn-primary edit-btn"
                                                            data-id=<?php echo $rows['id']; ?>><i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id=<?php echo $rows['id']; ?>><i class="fas fa-trash"></i>
                                                        </button>

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
    <!-- Right Sidebar -->

    <!-- /Right-bar -->
    <?php include 'modal/customer_modal.php'; ?>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script src="js/customer.js"></script>
    <script type="text/javascript">
        $("#customers_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
        $("#customer_create_modal").on('show.bs.modal', function(event) {
            if (!$('#customer_req_area_id').hasClass("select2-hidden-accessible")) {
                $("#customer_req_area_id").select2({
                    dropdownParent: $("#customer_create_modal"),
                    placeholder: "---Select---"
                });
            }
        });
        $('#customer_request_add_btn').on('click', function() {
            /*Collect form data*/
            let fullname = $('#customer_req_fullname').val().trim();
            let mobile = $('#customer_req_mobile').val().trim();
            let address = $('#customer_req_address').val().trim();
            let area_id = $('#customer_req_area_id').val();
            let request_by = $('#customer_req_request_by').val().trim();
            let remarks = $('#customer_req_remarks').val().trim();

            /* Form validation*/
            if (fullname === '' || mobile === '' || address === '') {
                toastr.error('Please fill out all fields.');
                return;
            }

            /* Ajax request*/
            $.ajax({
                url: 'include/customers_server.php?create_customer_request=true',
                type: 'POST',
                dataType: 'json',
                data: {
                    fullname: fullname,
                    mobile: mobile,
                    address: address,
                    area_id: area_id,
                    request_by: request_by,
                    remarks:remarks
                },
                success: function(response) {
                    if (response.success = true) {
                        toastr.success(response.message);
                        $('#customer_create_modal').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                    if (response.success == false) {
                        toastr.success(response.message);
                    }

                },
                error: function() {
                    toastr.error('An error occurred while processing the request.');
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: 'include/customers_server.php?get_customer_request_data=true',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success === true) {
                        $("#customer_edit_modal").modal('show');
                        $("#customer_edit_modal #customer_req_fullname").val(response.data.fullname);
                        $("#customer_edit_modal #customer_req_mobile").val(response.data.mobile);
                        $("#customer_edit_modal #customer_req_address").val(response.data.address);
                        $("#customer_edit_modal #customer_req_area_id").val(response.data.area_id);
                        $("#customer_edit_modal #customer_req_request_by").val(response.data.request_by);
                        $("#customer_edit_modal #customer_req_remarks").val(response.data.remarks);
                        $("#customer_edit_modal #customer_request_id").val(response.data.id);
                    }
                    if (response.success == false) {
                        toastr.success(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Error deleting item! " + error);
                }
            });
        });
        $(document).on('click', '#customer_request_update_btn', function(e) {
            e.preventDefault();
               var fullname= $("#customer_edit_modal #customer_req_fullname").val();
               var mobile= $("#customer_edit_modal #customer_req_mobile").val();
               var address= $("#customer_edit_modal #customer_req_address").val();
                var area_id=$("#customer_edit_modal #customer_req_area_id").val();
                var request_by= $("#customer_edit_modal #customer_req_request_by").val();
                var remarks=$("#customer_edit_modal #customer_req_remarks").val();
               var id= $("#customer_edit_modal #customer_request_id").val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'include/customers_server.php?update_customer_request=true',
                data: {
                    id:id,
                    fullname:fullname,
                    mobile:mobile,
                    address:address,
                    area_id:area_id,
                    request_by:request_by,
                    remarks:remarks
                },
                success: function(response) {
                    if (response.success === true) {
                        toastr.success(response.message);
                        $("#customer_edit_modal").modal('hide'); 
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Error updating data! " + error);
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            /* Confirm deletion*/
            if (confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'include/customers_server.php?delete_customer_request_data=true',
                    data: {
                        delete_data: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.success = true) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                        if (response.success == false) {
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Error deleting item! " + error);
                    }
                });
            }
        });
        $(document).on("click", ".approve-btn", function (e) {
            var id = $(this).data('id');
            e.preventDefault();

            if (confirm("Are you sure you want to Approve?")) {

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: 'include/customers_server.php?get_customer_request_data=true',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success === true) {
                            $("#customer_request_id").val(response.data.id || "");
                            $("#customer_fullname").val(response.data.fullname || "");
                            $("#customer_mobile").val(response.data.mobile || "");
                            $("select[name='customer_area']").val(response.data.area_id || "");
                            $("#customer_address").val(response.data.address || "");
                            
                            $("#addCustomerModal").modal("show");
                        }
                        if (response.success == false) {
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Error deleting item! " + error);
                    }
                });
               

               
            }
        });

    </script>
</body>

</html>
