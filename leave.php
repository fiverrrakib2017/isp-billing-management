<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");
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

        <?php $page_title="Leave";  include 'Header.php';  ?>

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
                                            <p class="text-primary mb-0 hover-cursor">Leave</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;Add New Leave</button>

                                   

                                </div>

                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="table1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                            <thead class="bg-success text-white" style="background-color: #2c845f !important;">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Employee Name</th>
                                                    <th>Leave Type</th>
                                                    <th>Leave Reason</th>
                                                    <th>Status</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
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
     <!-- Add Modal -->
     <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add New Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/hrm_server.php?add_leave=true" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label>Employee Name</label>
                            <select name="employee_id" class="form-select" type="text" style="width: 100%;" required></select>
                        </div>           
                        <div class="form-group mb-2">
                            <label>Leave Type</label>
                            <select name="leave_type" class="form-select" type="text" required>
                                <option >---Select---</option>
                                <option value="Sick">Sick</option>
                                <option value="Casual">Casual</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>           
                        <div class="form-group mb-2">
                            <label>Leave Reason</label>
                            <textarea name="leave_reason" class="form-control" type="text" placeholder="Enter Leave Reason" required></textarea>
                        </div>    
                        <div class="form-group mb-2">
                            <label>Leave Status</label>
                            <select name="leave_status" class="form-select" type="text" required>
                                <option >---Select---</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>        
                        <div class="form-group mb-2">
                            <label>Start Date</label>
                            <input name="start_date" class="form-control" type="date"  required>
                        </div>           
                        <div class="form-group mb-2">
                            <label>End Date</label>
                            <input name="end_date" class="form-control" type="date"  required>
                        </div>           
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- Edit Modal -->
     <div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="include/hrm_server.php?edit_leave=true" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label>Employee Name</label>
                            <input type="text" class="d-none" name="id">
                            <select name="employee_id" class="form-select" type="text" style="width: 100%;" required></select>
                        </div>           
                        <div class="form-group mb-2">
                            <label>Leave Type</label>
                            <select name="leave_type" class="form-select" type="text" required>
                                <option >---Select---</option>
                                <option value="Sick">Sick</option>
                                <option value="Casual">Casual</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>           
                        <div class="form-group mb-2">
                            <label>Leave Reason</label>
                            <textarea name="leave_reason" class="form-control" type="text" placeholder="Enter Leave Reason" required></textarea>
                        </div>    
                        <div class="form-group mb-2">
                            <label>Leave Status</label>
                            <select name="leave_status" class="form-select" type="text" required>
                                <option >---Select---</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>        
                        <div class="form-group mb-2">
                            <label>Start Date</label>
                            <input name="start_date" class="form-control" type="date"  required>
                        </div>           
                        <div class="form-group mb-2">
                            <label>End Date</label>
                            <input name="end_date" class="form-control" type="date"  required>
                        </div>           
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
    <?php include 'script.php';?>
    <script type="text/javascript">
    var table;
    $(document).ready(function(){
            table=$('#table1').DataTable( {
                "searching": true,
                "paging": true,
                "info": false,
                "lengthChange":true ,
                "processing"		: true,
                "serverSide"		: true,
                "zeroRecords":    "No matching records found",
                "ajax"				: {
                    url			: "include/hrm_server.php?show_leave_data=true",
                    type		: 'GET',
                },
                "buttons": [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'pdf',
                exportOptions: { columns: ':visible' },
                orientation: 'landscape',
                pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            }, 
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
            ],
        });
        table.buttons().container().appendTo($('#export_buttonscc'));	
    });
    /** Leave Add **/
    $('#addModal form').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        $.ajax({
            type:'POST',
            'url':url,
            data: formData,
            success: function (response) {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    $('#addModal').modal('hide'); 
                    $('#addModal form')[0].reset();
                    table.draw();
                    toastr.success(jsonResponse.message); 
                } else {
                    toastr.error(jsonResponse.message); 
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
    /** Leave Edit **/
    $(document).on("click", "button[name='edit_button']", function() {
        var shift_id = $(this).data("id");
        $.ajax({
            url: "include/hrm_server.php?get_leave=true", 
            type: "GET",
            data: { id: shift_id }, 
            dataType:'json',
            success: function(response) {
                if (response.success) {
                $('#editModal').modal('show');
                $('#editModal input[name="id"]').val(response.data.id);
                $('#editModal select[name="employee_id"]').val(response.data.employee_id);
                $('#editModal select[name="leave_type"]').val(response.data.leave_type);
                $('#editModal textarea[name="leave_reason"]').val(response.data.leave_reason);
                $('#editModal select[name="leave_status"]').val(response.data.leave_status);
                $('#editModal input[name="start_date"]').val(response.data.start_date);
                $('#editModal input[name="end_date"]').val(response.data.end_date);
                } else {
                    toastr.error("Error fetching data for edit: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Failed to fetch department details');
            }
        });
    });

    /** Update The data from the database table **/
    $('#editModal form').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        /*Get the submit button*/
        var submitBtn = form.find('button[type="submit"]');

        /*Save the original button text*/
        var originalBtnText = submitBtn.html();

        /*Change button text to loading state*/
            

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        /** Use Ajax to send the delete request **/
        $.ajax({
            type:'POST',
            'url':url,
            data: formData,
            beforeSend: function () {
            form.find(':input').prop('disabled', true);
            },
            success: function (response) {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    toastr.success(jsonResponse.message);
                    $('#editModal').modal('hide');
                    $('#editModal form')[0].reset();
                    table.draw();
                }
            },

            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("An error occurred. Please try again.");
                }
            },
            complete:function(){
                form.find(':input').prop('disabled', false);
            }
        });
    });

    /*Delete Script*/
    $(document).on('click',"button[name='delete_button']",function(){
        var id=$(this).data('id');
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                type: 'POST', 
                url: 'include/hrm_server.php', 
                data: { leave_delete_data: true, id: id }, 
                dataType:'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success("Deleted successfully!");
                       table.draw();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Error deleting item! " + error);
                }
            });
        }
    });
    loadEmployee();
    function loadEmployee(){
        $.ajax({
            type: 'GET', 
            url: 'include/hrm_server.php', 
            data: { get_all_employee: true }, 
            dataType:'json',
            success: function(response) {
                var form = $("select[name='employee_id']");
                form.append("<option value=''>---Select---</option>");
                for (var i = 0; i < response.data.length; i++) {
                    form.append("<option value='" + response.data[i].id + "'>" + response.data[i].name + "</option>");
                }

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                toastr.error("Error deleting item! " + error);
            }
        });
    }
    $("#addModal").on('show.bs.modal', function (event) {
        /*Check if select2 is already initialized*/
        if (!$("select[name='employee_id']").hasClass("select2-hidden-accessible")) {
            $("select[name='employee_id']").select2({
                dropdownParent: $("#addModal"),
                placeholder: "Select Employee"
            });
        }
     }); 
    </script>
</body>

</html>