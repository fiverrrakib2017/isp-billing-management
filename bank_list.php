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

        <?php $page_title="Bank List";  include 'Header.php';  ?>

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
                                            <p class="text-primary mb-0 hover-cursor">Units</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;Create Bank</button>

                                   

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
                                            <thead >
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Bank Name</th>
                                                    <th>Branch Name</th>
                                                    <th>Account Number</th>
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
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/bank_server.php?add_bank=true" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label>Bank Name</label>
                            <input name="bank_name" placeholder="Enter Bank Name" class="form-control" type="text" >
                        </div>           
                        <div class="form-group mb-2">
                            <label>Branch Name</label>
                            <input name="branch_name" placeholder="Enter Branch Name" class="form-control" type="text" >
                        </div>           
                        <div class="form-group mb-2">
                            <label>Account Number</label>
                            <input name="account_number" placeholder="Enter Account Number" class="form-control" type="text" >
                        </div>           
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Bank</button>
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
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/bank_server.php?update_bank=true" method="POST" enctype="multipart/form-data" >          
                        <div class="form-group mb-2">
                            <label>Bank Name</label>
                             <input name="id" class="d-none" type="text" >
                             <input name="bank_name" placeholder="Enter Bank Name" class="form-control" type="text" >
                        </div>   
                        <div class="form-group mb-2">
                            <label>Branch Name</label>
                            <input name="branch_name" placeholder="Enter Branch Name" class="form-control" type="text" >
                        </div>           
                        <div class="form-group mb-2">
                            <label>Account Number</label>
                            <input name="account_number" placeholder="Enter Account Number" class="form-control" type="text" >
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
                    url			: "include/bank_server.php?show_bank_data=true",
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
    /** Department Add **/
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
    /** Department Edit **/
    $(document).on("click", "button[name='edit_button']", function() {
        var _id = $(this).data("id");
        $.ajax({
            url: "include/bank_server.php?get_bank=true", 
            type: "GET",
            data: { id: _id }, 
            dataType:'json',
            success: function(response) {
                if (response.success) {
                $('#editModal').modal('show');
                $('#editModal input[name="id"]').val(response.data.id);
                $('#editModal input[name="bank_name"]').val(response.data.bank_name);
                $('#editModal input[name="branch_name"]').val(response.data.branch_name);
                $('#editModal input[name="account_number"]').val(response.data.account_number);
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
                url: 'include/bank_server.php', 
                data: { delete_data: true, id: id }, 
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

    </script>
</body>

</html>