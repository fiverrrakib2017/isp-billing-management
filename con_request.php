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
                                                                        <input id="customer_req_request_by"
                                                                            type="text" class="form-control "
                                                                            placeholder="Enter Name" />
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
                                                    <th>FullName</th>
                                                    <th>Mobile no.</th>
                                                    <th>Area</th>
                                                    <th>Address</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php
                                                 $sql="SELECT * FROM customer_request WHERE status=0 ORDER BY id DESC";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                <tr>
                                                    <td><?php echo $rows['id']; ?></td>
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

                                                    <td>

                                                        <button type="submit" id="approve_button" type="button"
                                                            class="btn btn-success">Approve</button>

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
                    request_by: request_by
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
        $(document).on('click', '#approve_button', function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to Approve?")) {
                var row = $(this).closest('tr');
                var customer_requeest_id = row.find('td:nth-child(1)').text().trim();
                var customer_requeest_fullname = row.find('td:nth-child(2)').text().trim();
                var customer_requeest_mobile = row.find('td:nth-child(3)').text().trim();
                var customer_requeest_area = row.find('td:nth-child(4)').text().trim();
                var customer_requeest_address = row.find('td:nth-child(5)').text().trim();
                $("#addCustomerModal").modal('show');

                if (customer_requeest_fullname.length > 0) {
                    $("#customer_fullname").val(customer_requeest_fullname);
                }
                if (customer_requeest_mobile.length > 0) {
                    $("#customer_mobile").val(customer_requeest_mobile);
                }
                if (customer_requeest_area.length > 0) {
                    $("select[name='customer_area']").val(customer_requeest_area);
                }
                if (customer_requeest_address.length > 0) {
                    $("#customer_address").val(customer_requeest_address);
                }
                if (customer_requeest_id.length > 0) {
                    $("#customer_request_id").val(customer_requeest_id);
                }
            }
        });
    </script>
</body>

</html>
