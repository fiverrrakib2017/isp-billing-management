<?php
include("include/security_token.php");
include "include/db_connect.php";
include("include/pop_security.php");
include("include/users_right.php");
if (isset($_GET["id"])) {
    $areaId=$_GET['id'];
    if ($POP=$con->query("SELECT * FROM area_list WHERE id='$areaId'")) {
        while($rows=$POP->fetch_array()){
            $id=$rows["id"];
            $area_name=$rows["name"];
            $billing_date=$rows["billing_date"];
        }
    }
}


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
        
           <?php  $page_title="Update Area"; include 'Header.php';?>
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
                <div id="alertMsg" class="alert alert-success p-2 mt-3" style="width: 400px; display:none;">
                 <i class="mdi mdi-check-circle"></i>
                 <strong class="mx-2">Success!</strong> Update Data 
                </div>
           </div> 
            <div class="row mt-5 py-3 mr-3 ml-3">

                    <div class="col-md-4 m-auto" id="formArea">

                        <h4 class="text-center">Update Area</h4><br>
                        <form id="updateArea">
                            <label><b style="color: green;">Area Location*</b></label>
                            <input class="d-none" type="text" value="<?php echo $id; ?>" name="id">
                            <input id="form" name="area" class="form-control form-control-sm" type="text" value="<?php echo $area_name; ?>"><br>
                            <label><b style="color: green;">Billing Date*</b></label>
                            <input type="text" name="billing_date" class="form-control form-control-sm" value="<?php echo $billing_date ?? 0; ?>"><br>
                            <button id="up_area_button" class="btn btn-primary mr-1">Update</button>
                            <a href="pop_area.php" id="up_delete_button" class="btn btn-danger mr-1">Cancle</a>
                        </form>
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
        
        
        <?php include 'script.php';?>
   <script type="text/javascript">
    $(document).ready(function(){
        $("#up_area_button").click(function(e){
            e.preventDefault();
            var formData=$("#updateArea").serialize();
            $.ajax({
            type:"GET",
            url:"include/add_area.php?update",
            data:formData,
            cache:false,
            success:function(){
                toastr.success('Data Update Success!');
                }
           });
        });
    });
</script>
    </body>
</html>
