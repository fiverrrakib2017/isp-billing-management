<?php
include("include/security_token.php");
include("include/users_right.php");
$areaData = [];
$areaResult = $con->query("SELECT * FROM area_list");

if ($areaResult) {
    while ($row = $areaResult->fetch_assoc()) {
        $areaData[$row['pop_id']][] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
}
echo  '<script>var areas = ' . json_encode($areaData) . ';</script>';
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

        <?php
        $page_title="Schedule";
        include 'Header.php'; 
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
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">
                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Sms Schedule</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
									<button type="button" class="btn btn-primary mt-2 mb-2 mt-xl-0 mdi mdi-account-plus mdi-18px"  data-bs-toggle="modal" data-bs-target="#addModal">&nbsp;&nbsp;Add New</button>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="bg-success text-white" style="background-color: #2c845f !important;">
                                                <tr>
                                                    <th>No.</th> 
                                                    <th>POP/Branch Name</th> 
                                                    <th> Area Name</th> 
                                                    <th>Message</th> 
                                                    <th>Schedule Date</th> 
                                                    <th>Created</th>
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

            <?php include 'Footer.php';?>

        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title text-white " id="exampleModalLabel">Schedule Add&nbsp;&nbsp;<i class="mdi mdi-account-plus"></i></h5>
                </div>
                <form action="include/message_server.php?add_message_shchedule_data=true" method="POST" id="add_message_schedule_modal_form">
                    <div class="modal-body">
                       
                        <div class="from-group mb-2">
                            <label for=""> POP/Branch </label>
                            <select id="pop_id" name="pop_id" class="form-select" style="width: 100%;">
                                <option value="all">All POP/Branch</option>
                                <?php
                                $result = $con->query("SELECT * FROM add_pop");
                              
                                if ($result) {
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value='".$row['id']."'>".$row['pop']."</option>";
                                    }
                                } else {
                                    echo "<option value=''>No data available</option>";
                                }
                                ?>
                            </select>


                        </div>
                        <div class="from-group mb-2">
                            <label for=""> POP/Area </label>
                            <select id="area_id" name="area_id" class="form-select" style="width: 100%;" >
                                <option value="all">All POP/Area</option>
                            </select>

                        </div>

                        <div class="from-group mb-2">
                            <label for="">Message Template</label>
                            <select id="template_id" name="template_id" class="form-select" style="width: 100%;" >
                                <option >---Select---</option>
                                <?php
                                if ($result=$con->query("SELECT * FROM message_template")) {
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['template_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="from-group mb-2">
                            <label for="">Message Template</label>
                            <textarea id="message" name="message" class="form-control" placeholder="Enter Your Message"></textarea>

                        </div>
                        <div class="from-group mb-2">
                            <label for=""> Send Date </label>
                            <input  name="send_date" type="date" class="form-control"></input>

                        </div>
                        <div class="from-group mb-2">
                            <label for="">Note</label>
                            <input id="notes" type="text" name="notes" class="form-control" placeholder="Enter Your Note">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title text-white " id="exampleModalLabel">Schedule Update&nbsp;&nbsp;<i class="mdi mdi-account-plus"></i></h5>
                </div>
                <form action="include/message_server.php?update_message_shchedule_data=true" method="POST" id="update_message_schedule_modal_form">
                    <div class="modal-body">
                       
                        <div class="from-group mb-2">
                            <label for=""> POP/Branch </label>
                            <input type="text" name="id" class="d-none">
                            <select id="pop_id" name="pop_id" class="form-select" style="width: 100%;">
                                <option value="all">All POP/Branch</option>
                                <?php
                                $result = $con->query("SELECT * FROM add_pop");
                              
                                if ($result) {
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value='".$row['id']."'>".$row['pop']."</option>";
                                    }
                                } else {
                                    echo "<option value=''>No data available</option>";
                                }
                                ?>
                            </select>


                        </div>
                        <div class="from-group mb-2">
                            <label for=""> POP/Area </label>
                            <select id="area_id" name="area_id" class="form-select" style="width: 100%;" >
                                <option value="all">All POP/Area</option>
                                <?php
                                if ($result=$con->query("SELECT * FROM area_list")) {
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>

                        <div class="from-group mb-2">
                            <label for="">Message Template</label>
                            <select id="template_id" name="template_id" class="form-select" style="width: 100%;" >
                                <option >---Select---</option>
                                <?php
                                if ($result=$con->query("SELECT * FROM message_template")) {
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['template_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="from-group mb-2">
                            <label for="">Message Template</label>
                            <textarea id="message" name="message" class="form-control" placeholder="Enter Your Message"></textarea>

                        </div>
                        <div class="from-group mb-2">
                            <label for=""> Send Date </label>
                            <input  name="send_date" type="date" class="form-control"></input>

                        </div>
                        <div class="from-group mb-2">
                            <label for="">Note</label>
                            <input id="notes" type="text" name="notes" class="form-control" placeholder="Enter Your Note">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <form action="include/message_server.php?delete_message_schedule_data=true" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <input type="hidden" name="id" value="">
                    <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <?php include 'script.php'; ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){
            table=$('#datatable1').DataTable( {
               "searching": true,
                "paging": true,
                "info": false,
                "lengthChange":true ,
                "processing"		: true,
                "serverSide"		: true,
                "zeroRecords":    "No matching records found",
                "ajax"				: {
                    url			: "include/message_server.php?get_message_schedule_data=1",
                    type		: 'GET',
                },
                "order": [[0, 'desc']], 
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
        /* Area filter change event*/
        $(document).on('change', '.area_filter', function(){
            var area_filter_result = $('.area_filter').val() || '';
            table.columns(7).search(area_filter_result).draw();
        });   
    $(document).on('shown.bs.modal', '#addModal', function () { 
        // Check if select2 is already initialized for pop_id
        if (!$('#pop_id').hasClass("select2-hidden-accessible")) {
            $("#pop_id").select2({
                dropdownParent: $('#addModal')
            });
        }

        // Check if select2 is already initialized for area_id
        if (!$('#area_id').hasClass("select2-hidden-accessible")) {
            $("#area_id").select2({
                dropdownParent: $('#addModal')
            });
        }

        // Check if select2 is already initialized for template_id
        if (!$('#template_id').hasClass("select2-hidden-accessible")) {
            $("#template_id").select2({
                dropdownParent: $('#addModal')
            });
        }
    });
    

    $(document).on('change', 'select[name="pop_id"]', function() {
        var selectedPopId = $(this).val();

        /*Filter area by pop_id*/ 
        var filteredAreas = areas[selectedPopId] || [];
        var areaOptions = '<option value="all">All POP/Area</option>';
        filteredAreas.forEach(function(area) {
            areaOptions += '<option value="' + area.id + '">' + area.name + '</option>';
        });

        // Update the Area dropdown
        $('select[name="area_id"]').html(areaOptions);
    });
    $(document).on('change', 'select[name="template_id"]', function(){
        template_id = $(this).val();
        var currentMsgTemp="0";
        if(template_id){
            $.ajax({
                type: 'POST',
                url:'include/message.php',
                data: {name: template_id, currentMsgTemp: currentMsgTemp},
                success: function(response){
                    $('textarea[name="message"]').val(response);
                }
            });
        }
    });
    $('#add_message_schedule_modal_form').submit(function(e) {
        e.preventDefault();

        /* Get the submit button */
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();

        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
        submitBtn.prop('disabled', true);

        var form = $(this);
        var url = form.attr('action');
        /*Change to FormData to handle file uploads*/
        var formData = new FormData(this);

        /* Use Ajax to send the request */
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType:'json',
            success: function(response) {
                if (response.success) {
                $("#addModal").fadeOut(500, function() {
                    $(this).modal('hide');
                    toastr.success(response.message);
                    $('#datatable1').DataTable().ajax.reload();
                });

                } else if (!response.success && response.errors) {
                    $.each(response.errors, function(field, message) {
                        toastr.error(message);
                    });
                }
            },
            error: function(xhr, status, error) {
                /* Handle errors */
            },
            complete: function() {
                /* Reset button text and enable the button */
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });

    /** Handle edit button click**/
    $('#datatable1 tbody').on('click', '.edit-btn', function () {
      var id = $(this).data('id');
      var url = "include/message_server.php?edit_data=true&id=" + id;
      $.ajax({
          type: 'GET',
          url: url,
          dataType:'json',
          success: function (response) {
              if (response.success) {
                $('#editModal').modal('show');
                $('#editModal input[name="id"]').val(response.data.id);


                $('#editModal select[name="pop_id"]').select2();
                $('#editModal select[name="pop_id"]').val(response.data.pop_id);
               

                $('#editModal select[name="area_id"]').select2();
                $('#editModal select[name="area_id"]').val(response.data.area_id);
                
                $('#editModal textarea[name="message"]').val(response.data.message_text); 
                $('#editModal input[name="send_date"]').val(response.data.send_date);
                $('#editModal input[name="notes"]').val(response.data.note);
              } else {
                toastr.error("Error fetching data for edit!");
              }
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
            toastr.error("Error fetching data for edit!");
          }
      });
    });
    
     /** Handle Delete button click**/
    $('#datatable1 tbody').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        $('#deleteModal').modal('show');
        var value_input = $("input[name*='id']").val(id);
    });
    /** Handle form submission for delete **/
    $('#deleteModal form').submit(function(e){
        e.preventDefault();
        /*Get the submit button*/
        var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

        /* Save the original button text*/
        var originalBtnText = submitBtn.html();

        /*Change button text to loading state*/
        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        /** Use Ajax to send the delete request **/
        $.ajax({
        type:'POST',
        'url':url,
        data: formData,
        dataType:'json',
        success: function (response) {
            $('#deleteModal').modal('hide');
            if (response.success) {
            toastr.success(response.message);
            $('#datatable1').DataTable().ajax.reload( null , false);
            }
        },

        error: function (xhr, status, error) {
            /** Handle  errors **/
            toastr.error(xhr.responseText);
        },
        complete: function () {
            submitBtn.html(originalBtnText);
            }
        });
    });
    $('#update_message_schedule_modal_form').submit(function(e) {
        e.preventDefault();

        /* Get the submit button */
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();

        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
        submitBtn.prop('disabled', true);

        var form = $(this);
        var url = form.attr('action');
        /*Change to FormData to handle file uploads*/
        var formData = new FormData(this);

        /* Use Ajax to send the request */
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType:'json',
            success: function(response) {
                if (response.success) {
                $("#editModal").fadeOut(500, function() {
                    $(this).modal('hide');
                    toastr.success(response.message);
                    $('#datatable1').DataTable().ajax.reload();
                });

                } else if (!response.success && response.errors) {
                    $.each(response.errors, function(field, message) {
                        toastr.error(message);
                    });
                }
            },
            error: function(xhr, status, error) {
                /* Handle errors */
            },
            complete: function() {
                /* Reset button text and enable the button */
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });
    </script>
</body>

</html>