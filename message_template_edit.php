<?php
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
if (isset($_GET["id"])) {
    $expiredId=$_GET['id'];
    if ($messae_template=$con->query("SELECT * FROM message_template WHERE id='$expiredId'")) {
        while($rows=$messae_template->fetch_array()){
            $id=$rows["id"];
            $template_name  =$rows["template_name"];
            $text  =$rows["text"];
            $pop_id =$rows["pop_id"];
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
        
        <?php
            $page_title = "Message Template Edit";
            include "Header.php";
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
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-3 mt-5">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Update Message Template</h4>
                        <form id="expired_form">
                            <input type="hidden" id="updateId" value="<?php echo $id; ?>">
                            
                            <div class="form-group mb-3">
                                <label for="" class="form-label">POP/Branch</label>
                                <select name="pop_id" id="pop_id" class="form-select" style="width: 100%;">
                                            <option>---Select---</option>
                                            <?php 
                                            if ($allPOPuSR = $con->query("SELECT * FROM add_pop ")) {
                                                while ($rows = $allPOPuSR->fetch_array()) {
                                                    $select=($rows['id'] == $pop_id) ? 'selected' : '';
                                                    echo '<option value="'.$rows['id'].'" '.$select.'>'.$rows['pop'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="form-label">Template Name</label>
                                <input 
                                    type="text" 
                                    id="template_name" 
                                    class="form-control" 
                                    value="<?php echo $template_name; ?>"
                                    placeholder="Enter Template Name"
                                >
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Template Message</label>
                                <textarea 
                                    id="template_message" 
                                    class="form-control" 
                                    rows="6"
                                    placeholder="Write your template message here..."
                                ><?php echo $text; ?></textarea>
                            </div>
                            
                            <div class="d-flex ">
                                <button type="button" id="updateBtn" class="btn btn-success" style="margin-right: 5px;">Update</button>
                                <a href="message_template.php" class="btn btn-danger mr-2">Cancel</a>
                            </div>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container-fluid -->
</div>

    <!-- End Page-content -->

    <?php include 'Footer.php'; ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

      

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
       <?php include 'script.php';?>
      <script type="text/javascript">
    $(document).ready(function(){
        $("#updateBtn").click(function(){
            var pop_id = $("#pop_id").val();
            var updateId=$("#updateId").val();
            var template_name=$("#template_name").val();
            var template_message=$("#template_message").val();

                if(pop_id.lenght == 0){
                   toastr.error("Please Select POP/Branch");
                   return false;
               }

                if (template_name.length == 0) {
                    toastr.error("Template Name Require ");
                    return false;
                } 
                
                if (template_message.length == 0) {
                    toastr.error("Template Message Require");
                    return false;
                }
 
                $.ajax({
                    type: 'POST',
                    data: {
                        pop_id: pop_id,
                        id:updateId,
                        template_name: template_name, 
                        template_message: template_message, 
                        update_message_template: "1"
                    },
                    url: 'include/message.php',
                    cache: false,
                    dataType:'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                        if(response.success==false){
                            toastr.error(response.error);
                        }

                    }
                });
            
        });
    });
</script>

    </body>
</html>
