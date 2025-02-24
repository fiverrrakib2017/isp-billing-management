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
        <?php include 'style.php';?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php $page_title="Company Management"; include 'Header.php';?>


        
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
                                    <p class="text-primary mb-0 hover-cursor">Company Management</p>
                                </div>


                            </div>
                            <br>



                        </div>
                        <div class="d-flex justify-content-between align-items-end flex-wrap">
                            <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                            data-bs-toggle="modal" data-bs-target="#addCompanyModal" style="margin-bottom: 12px;">&nbsp;&nbsp;Add New Company</button>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Company Name</th>
                                                    <th>Address</th>
                                                    <th>Username</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Create Date</th>
                                                    <th>Expire Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

$sql = "SELECT * FROM companies";
$result = mysqli_query($con, $sql);

while ($rows = mysqli_fetch_assoc($result)) {

?>

    <tr>
        <td><?php echo $rows['id']; ?></td>
        <td><a href="company_profile.php?clid=<?php echo $rows['id']; ?>"><?php echo $rows["fullname"]; ?></a></td>
        <td><?php echo $rows["company_name"]; ?></td>
        <td><?php echo $rows["address"]; ?></td>
        <td><?php echo $rows["username"]; ?></td>
        <td><?php echo $rows["mobile"]; ?></td>
        <td><?php echo $rows['email']; ?></td>
        <td>
            <?php

             $create_date= $rows['create_date'];
             echo date('d M Y', strtotime($create_date));

            ?>
        </td>
        <td>
            <?php

             $expiredate= $rows['expiredate'];
             echo date('d M Y', strtotime($expiredate));

            ?>
        </td>
        <td style="text-align:right">
            <button type="button" class="btn btn-info edit-btn" data-id="<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></button>

            <a class="btn btn-success" href="company_profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
            </a>
            <button class="btn btn-danger delete-btn" data-id="<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i>
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

    <?php include 'Footer.php';?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <?php include 'modal/client_modal.php'; ?>
        
    <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    <script type="text/javascript" src="modal/company_modal.js"></script>
     <script type="text/javascript">
    $(document).ready(function() {
        $("#datatable").DataTable();
		/** Handle Delete button click**/
        $('#datatable tbody').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        // Confirm deletion
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                type: 'POST', 
                url: 'include/company_server.php', 
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

    
    
    	/** Handle edit button click**/
        $('#datatable tbody').on('click', '.edit-btn', function () {
    		
        var id = $(this).data('id');
        var url = "include/company_server.php?edit_data=true&id=" + id;
          $.ajax({
            type: 'GET',
            url: url,
              success: function (response) {
                const jsonResponse = JSON.parse(response);
                  if (jsonResponse.success) {
                    $('#editModal').modal('show');
                    $('#editModal input[name="id"]').val(jsonResponse.data.id);
                    $('#editModal input[name="fullname"]').val(jsonResponse.data.fullname);
                    $('#editModal input[name="company"]').val(jsonResponse.data.company);
                    $('#editModal input[name="phone_number"]').val(jsonResponse.data.mobile);
                    $('#editModal input[name="email"]').val(jsonResponse.data.email);
                    $('#editModal input[name="address"]').val(jsonResponse.data.address);
                    $('#editModal select[name="status"]').val(jsonResponse.data.status);
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
