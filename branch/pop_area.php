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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php 
        $page_title = "Customers";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        
        echo file_get_contents($url);
        
        ?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                $page_title = "Location/Area";
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
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
                     <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                           <div class="d-flex align-items-end flex-wrap">
                              <div class="mr-md-3 mr-xl-5">
                                 <div class="d-flex">
                                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                    </p>
                                    <p class="text-primary mb-0 hover-cursor">Area</p>
                                 </div>
                              </div>
                              <br>
                           </div>
                           <div class="d-flex justify-content-between align-items-end flex-wrap">
                              
                              <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                              Area</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addModal">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="card">
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <form id="form-area">
                                        <div class="form-group mb-1 d-none">
                                              <label>POP</label>
                                              <select class="form-select" name="pop_id">
                                      <?php 
                                    if ($pop = $con-> query("SELECT * FROM add_pop WHERE id=$auth_usr_POP_id  ")) {
                                        while($rows= $pop->fetch_array()){

                                           
                                            $id = $rows["id"];
                                            $name = $rows["pop"];
                                            
                                            echo '<option value='.$id.'>'.$name.'</option>';
                                        }
                                    }
                                      

                                       ?>
                                                 

                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label>Area</label>
                                              <input class="form-control" type="text" name="area" placeholder="Type Your Area" id="area" />
                                          </div>
                                          <div class="form-group d-none">
                                              <label>User Type</label>
                                              <input class="form-control" type="text" name="user_type" value="<?php echo $auth_usr_type; ?>" id="user_type" />
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-danger"data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" id="add_area" class="btn btn-primary">Add Area</button>
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
                                 <div class="form-group">
                                    
                                       
                                 </div>
                              </div>
                              <div class="table-responsive">
                                 <table id="areaDataTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr >
                                          <th>ID</th>
                                          <th>Area</th>
                                          <th>Customers</th>
										  <th>Expired</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <tbody id="areaList">
                                        <?php 

                                if ($auth_usr_type==1) {
                                $sql_con="SELECT * FROM area_list WHERE user_type=1";
                                }else{
                                    $sql_con="SELECT * FROM area_list WHERE pop_id=$auth_usr_POP_id";
                                }
                          $sql=$sql_con ;
                          $result=mysqli_query($con,$sql);

                          while ($rows2=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
        <td><?php echo $areaID = $rows2["id"]; ?></td>
        <td><?php echo $rows2["name"]; ?></td>
        <td>
			<?php 
			$totalcust= $con->query("SELECT * FROM customers WHERE area='$areaID'");
										   
										$area_cust = $totalcust->num_rows; 
										echo $area_cust;
			?>
        </td>
		
		<td>
			<?php 
			$totalexcust= $con->query("SELECT * FROM customers WHERE area='$areaID' AND expiredate<NOW()");
										   
										echo $area_excust = $totalexcust->num_rows; 
										
			?>
        </td>
		
		
        
        <td style="text-align:right;">
        <a class="btn btn-info" href="area_edit.php?id=<?php echo $rows2["id"]; ?>"><i class="fas fa-edit"></i></a>
        <a class="btn btn-success" href="view_area.php?id=<?php echo $rows2["id"]; ?>"><i class="fas fa-eye"></i>
        </a>
        <!-- <a id="deleteId" onclick=" return confirm('Are You Sure');" href="area_delete.php?id=<?php echo $rows2["id"]; ?>"  value="" class="btn btn-danger"><i class="fas fa-trash"></i></a>-->
        </td></tr>
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

    <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
            
            echo file_get_contents($url);
            
        ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->



        

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>


        <div id="deleteModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <div class="icon-box">
                            <i class="fa fa-trash"></i>
                        </div>
                        <h4 class="modal-title w-100">Are you sure?</h4>
                        <h4 class="modal-title w-100 d-none" id="DeleteId"></h4>
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
        
        <!-- JAVASCRIPT -->
        <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
            
            echo file_get_contents($url);
            
        ?>
         <script type="text/javascript">
            $(document).ready(function() {
                /* Initialize DataTable*/
                const areaTable = $("#areaDataTable").DataTable();

                /* Add area button click event*/
                $("#add_area").click(function() {
                    const areaName = $("#area").val();

                    /* Validate input*/
                    if (areaName.length === 0) {
                        toastr.error("Area name is required");
                        return;
                    }

                    /*Serialize form data*/ 
                    const formData = $("#form-area").serialize();
                    
                    const protocol = location.protocol;
                    const host = '<?php echo $_SERVER['HTTP_HOST']; ?>';
                    const url = `${protocol}//${host}/include/add_area.php?add`;
                    // console.log(url); 
                    // console.log(formData);
                    // return false; 
                    $.ajax({
                        type: "GET",
                        url: url,
                        data: formData,
                        cache: false,
                        success: function(response) {
                            toastr.success(response);

                            $("#addModal").modal('hide');

                            //areaTable.ajax.reload();

                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    });
                });
            });

        </script> 

    </body>
</html>
