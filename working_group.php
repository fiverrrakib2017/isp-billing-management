<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";

?>
<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <!-- C3 Chart css -->
        <link href="assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    	<link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
        <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    </head>

    <body data-sidebar="dark">


        <!-- Loader -->
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/it-fast.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/it-fast.png" alt="" height="36">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>

                        <div class="d-none d-sm-block ms-2">
                            <h4 class="page-title">Working Group</h4>
                        </div>
                    </div>

                    

                    <div class="d-flex">

                       

                        

                        <div class="dropdown d-none d-md-block me-2">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="font-size-16">
                                    <?php if (isset($_SESSION['fullname'])) {
                                        echo $_SESSION['fullname'];
                                    } ?>
                                </span> 
                            </button>
                        </div>


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="profileImages/avatar.png" alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block me-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ion ion-md-notifications"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="mdi mdi-cart-outline"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                    <i class="mdi mdi-message-text-outline"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">You have 87 unread messages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-info rounded-circle font-size-16">
                                                    <i class="mdi mdi-glass-cocktail"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It is a long established fact that a reader will</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                            View all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </header>


        
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
                                            <p class="text-primary mb-0 hover-cursor">Working Group</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target="#addModal" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                              Working Group</button>
                          </div>
                            </div>
                        </div>
                    </div>






                          <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Working Group</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
						   <div class="modal-body">
							  <form action="include/working_group_backend.php" method="POST" enctype="multipart/form-data">
									<div class="form-group mb-2 d-none">
										<input name="add_group_data" class="form-control" type="text" >
									</div>
									<div class="form-group mb-2">
										<label>Group Name</label>
										<input name="group_name" placeholder="Group Name" class="form-control" type="text" >
									</div>
									<div class="form-group mb-2">
										<label>Area</label>
										<select  name="area_id[]"  class="form-control" style="width: 100%;" multiple >
                                        <option>---Select---</option>
                                        <?php
                                        if ($allArea=$con->query("SELECT * FROM area_list")) {
                                            while($rows=$allArea->fetch_array()){
                                                echo '<option value="'.$rows['id'].'">'.$rows['name'].'</option>'; 
                                            }
                                        }
                                        ?>
                                        </select>
									</div>
									<div class="form-group mb-2 ">
										<label>Note</label>
										<input name="note" placeholder="Enter Your Note" class="form-control" type="text" >
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


				 <div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Working Group</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
						   <div class="modal-body">
							  <form action="include/working_group_backend.php" method="POST" enctype="multipart/form-data">
									<div class="form-group mb-2 d-none">
										<input name="update_working_data" class="form-control" type="text" >
									</div>
									<div class="form-group mb-2 d-none">
										<input name="id" class="form-control" type="text" >
									</div>
									<div class="form-group mb-2">
										<label>Group Name</label>
										<input name="group_name" placeholder="Group Name" class="form-control" type="text" >
									</div>
                                    <div class="form-group mb-2">
										<label>Area</label>
										<select type="text" name="area_id[]"  class="form-select" style="width: 100%;" multiple>
                                        <option>---Select---</option>
                                        <?php
                                        if ($allArea=$con->query("SELECT * FROM area_list")) {
                                            while($rows=$allArea->fetch_array()){
                                                echo '<option value="'.$rows['id'].'">'.$rows['name'].'</option>'; 
                                            }
                                        }
                                        ?>
                                        </select>
									</div>
									<div class="form-group mb-2 ">
										<label>Note</label>
										<input name="note" placeholder="Enter Your Note" class="form-control" type="text" >
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






                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title"></span>


                                    <div class="col-md-6 float-md-right grid-margin-sm-0">



                                    </div>


                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                               <tr>
                                                  <th>ID</th>
                                                    <th>Group Name</th>
                                                    <th>Area Name</th>
                                                    <th>Note</th>
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

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © IT-FAST.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <!-- Settings -->
                <hr class="mt-0">
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="Layouts-1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="Layouts-2">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="Layouts-3">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox"  id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
            
            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script> 
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
     <script type="text/javascript">
    $(document).ready(function() {
        loadTableData();

        function loadTableData() {
            $.ajax({
                url: "include/working_group_backend.php?get_all_working_data", 
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var tbody = $('#datatable tbody');
                    tbody.empty();

                    $.each(data, function(index, row) {
                        var areaNames = row.area_names.join(', ');

                        var html = '<tr>'+
                            '<td>'+ row.id +'</td>'+
                            '<td>'+ row.group_name +'</td>'+
                            '<td>'+ areaNames +'</td>'+
                            '<td>'+ row.note +'</td>'+
                            '<td style="text-align:right;">'+
                                '<button type="button" class="btn btn-info edit-btn" data-id="'+ row.id +'"><i class="fas fa-edit"></i></button>'+
                                '<button type="button" class="btn btn-danger delete-btn" data-id="'+ row.id +'"><i class="fas fa-trash"></i></button>'+
                            '</td>'+
                        '</tr>';
                        tbody.append(html);
                    });
                }
            });
        }

        $('#addModal').on('shown.bs.modal', function () {
            if (!$("select[name='area_id[]']").hasClass("select2-hidden-accessible")) {
                $("select[name='area_id[]']").select2({
                    dropdownParent: $('#addModal'),
                     allowClear: true,
                    placeholder: "Select Area"
                });
            }
        });
        $('#editModal').on('shown.bs.modal', function () {
            if (!$("select[name='area_id']").hasClass("select2-hidden-accessible")) {
                $("select[name='area_id']").select2({
                    dropdownParent: $('#editModal'),
                     allowClear: true,
                    placeholder: "Select Area"
                });
            }
        });
        $("#users_table").DataTable();
		/** Handle Delete button click**/
        $('#datatable tbody').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        // Confirm deletion
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                type: 'POST', 
                url: 'include/working_group_backend.php', 
                data: { delete_data: true, id: id }, 
                success: function(response) {
                    const jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        toastr.success("Item deleted successfully!");
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        toastr.error(jsonResponse.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Error deleting item! " + error);
                }
            });
        }
    });

       /** Store The data from the database table **/
	  $('#addModal form').submit(function(e){
		e.preventDefault();

		var form = $(this);
		var url = form.attr('action');
		var formData = form.serialize();
		/** Use Ajax to send the delete request **/
		$.ajax({
		  type:'POST',
		  'url':url,
		  data: formData,
		 success: function (response) {
			/*Parse the JSON response*/ 
			const jsonResponse = JSON.parse(response);

			/* Check if the request was successful*/
			if (jsonResponse.success) {
				/*Hide the modal*/ 
				$('#addModal').modal('hide'); 
				 /*Reset the form*/ 
				$('#addModal form')[0].reset();
				/* Show success message*/
				toastr.success(jsonResponse.message); 

				/*Reload the page after a short delay*/ 
				setTimeout(() => {
					location.reload();
				}, 500);
			} else {
				/*Show error message if success is false*/ 
				toastr.error(jsonResponse.message); // Show error message
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
    
    	/** Handle edit button click**/
        $('#datatable tbody').on('click', '.edit-btn', function () {
    		
        var id = $(this).data('id');
        var url = "include/working_group_backend.php?edit_data=true&id=" + id;
          $.ajax({
            type: 'GET',
            url: url,
              success: function (response) {
                const jsonResponse = JSON.parse(response);
                  if (jsonResponse.success) {
                    $('#editModal').modal('show');
                    $('#editModal input[name="id"]').val(jsonResponse.data.id);
                    $('#editModal input[name="group_name"]').val(jsonResponse.data.group_name);
                    $('#editModal input[name="note"]').val(jsonResponse.data.note);
                    $('#editModal select[name="area_id"]').val(jsonResponse.data.area_id);
                  } else {
                      toastr.error("Error fetching data for edit: " + jsonResponse.message);
                  }
              },
              error: function (xhr, status, error) {
                console.error(xhr.responseText);
                toastr.error("Error fetching data for edit!");
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
    			$('#editModal').modal('hide');
    			$('#editModal form')[0].reset();
    			if (jsonResponse.success) {
    				toastr.success(jsonResponse.message);

    				/*Reload the page after a short delay*/ 
    				setTimeout(() => {
    					location.reload();
    				}, 500);
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
    	  });
    	});


        /** Handle form submission for delete **/
      $('#DeleteModal form').submit(function(e){
        e.preventDefault();
        /*Get the submit button*/
        var submitBtn =  $('#DeleteModal form').find('button[type="submit"]');

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
          success: function (response) {
            if (response.success) {
              $('#DeleteModal').modal('hide');
              toastr.success(response.message);
             
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
    });
    </script>

    </body>
</html>
