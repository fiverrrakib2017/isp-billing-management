<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
}

?>

<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
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
        $page_title="Works";
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
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">


                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Works</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target="#addModal" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                              Works</button>
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
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Works</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
						   <div class="modal-body">
							  <form action="../include/works_backend.php" method="POST" enctype="multipart/form-data">
									<div class="form-group mb-2 d-none">
										<input name="add_works_data" class="form-control" type="text" >
									</div>
									<div class="form-group mb-2">
										<label>Name</label>
										<input name="name" placeholder="Enter Name" class="form-control" type="text" >
									</div>
                                    <div class="form-group mb-2">
                                        <label>Email</label>
                                        <input name="email" placeholder="Enter Email" class="form-control" type="email" >
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Phone</label>
                                        <input name="phone" placeholder="Enter Phone" class="form-control" type="text" >
                                    </div>
									<div class="form-group mb-2 ">
										<label>Group</label>
										<select name="group_id" class="form-select" type="text" >
                                            <option>---Select---</option>  
                                            <?php 

                                                if ($group=$con->query("SELECT* FROM working_group WHERE pop_id=$auth_usr_POP_id")) {

                                                    while ($rows=$group->fetch_array()) {

                                                        $userId=$rows["id"];
                                                        $group_name=$rows["group_name"];
                                                     echo '<option value='.$userId.'>'.$group_name.'</option>';  
                                                    }
                                                }

                                                 ?>                             
                                        </select>
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
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Works</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
						   <div class="modal-body">
							  <form action="../include/works_backend.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group mb-2 d-none">
                                        <input name="update_works_data" class="form-control" type="text" >
                                    </div>
                                    <div class="form-group mb-2 d-none">
                                        <label>ID</label>
                                        <input name="id"  class="form-control" type="text" >
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Name</label>
                                        <input name="name" placeholder="Enter Name" class="form-control" type="text" >
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Email</label>
                                        <input name="email" placeholder="Enter Email" class="form-control" type="email" >
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Phone</label>
                                        <input name="phone" placeholder="Enter Phone" class="form-control" type="text" >
                                    </div>
                                    <div class="form-group mb-2 ">
                                        <label>Group</label>
                                        <select name="group_id" class="form-select" type="text" >
                                            <option>---Select---</option>  
                                            <?php 

                                                if ($group=$con->query("SELECT* FROM working_group where pop_id=$auth_usr_POP_id")) {

                                                    while ($rows=$group->fetch_array()) {

                                                        $userId=$rows["id"];
                                                        $group_name=$rows["group_name"];
                                                     echo '<option value='.$userId.'>'.$group_name.'</option>';  
                                                    }
                                                }

                                                 ?>                             
                                        </select>
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
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Group</th>
                                                    <th></th>
                                               </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                                if ($userlist=$con->query("SELECT* FROM works WHERE pop_id=$auth_usr_POP_id")) {

        while ($rows=$userlist->fetch_array()) {

            $userId=$rows["id"];
            $name=$rows["name"];
            $email=$rows["email"];
            $phone=$rows["phone"];
            $group_id=$rows["group_id"];
            if ($list=$con->query("SELECT `group_name` FROM working_group WHERE id=$group_id")) {
                while ($ro=$list->fetch_array()) {
                     $group_name=$ro["group_name"];
                }
            }
             echo '
     <tr>
     <td>'.$userId.'</td>
     <td>'.$name.'</td>
	 <td>'.$email.'</td>
     <td>'.$phone.'</td>
     <td>
       '.$group_name.' 
    </td>
    <td style=" text-align:right;">
        <button type="button" class="btn btn-info edit-btn" data-id="'.$userId.'"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger delete-btn" data-id="'.$userId.'" ><i class=" fas fa-trash"></i>
        </button>
        </td>
     </tr>'; 
        }
    }

                                                 ?>
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
        $("#users_table").DataTable();
		/** Handle Delete button click**/
        $('#datatable tbody').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        // Confirm deletion
        if (confirm("Are you sure you want to delete this item?")) {
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/works_backend.php';
            $.ajax({
                type: 'POST', 
                url: url, 
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
        var url = "../include/works_backend.php?edit_data=true&id=" + id;
          $.ajax({
            type: 'GET',
            url: url,
              success: function (response) {
                const jsonResponse = JSON.parse(response);
                  if (jsonResponse.success) {
                    $('#editModal').modal('show');
                    $('#editModal input[name="id"]').val(jsonResponse.data.id);
                    $('#editModal input[name="name"]').val(jsonResponse.data.name);
                    $('#editModal input[name="email"]').val(jsonResponse.data.email);
                    $('#editModal input[name="phone"]').val(jsonResponse.data.phone);
                    $('#editModal select[name="group_id"]').val(jsonResponse.data.group_id);
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
    			if (jsonResponse.success) {
    				toastr.success(jsonResponse.message);
                    $('#editModal').modal('hide');
                    $('#editModal form')[0].reset();
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
