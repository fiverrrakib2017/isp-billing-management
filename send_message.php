 <?php 
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
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
        
          <?php $page_title="Send Message";  include 'Header.php';?>


        
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
              <div class="col-md-6 m-auto">
                  <form action="include/message_server.php?send_message=true" method="POST" id="send_message">
                        <div class="card shadow-lg ">
                        
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group mb-2">
                                            <label>POP</label>
                                            <select  name="pop" id="pop" class="form-control " style="height:55px;">
                                                <option>Select</option>
                                                <?php 

                                                if ($allPOPuSR=$con->query("SELECT * FROM add_pop WHERE user_type=1")) {
                                                    while ($rows=$allPOPuSR->fetch_array()) {
                                                        echo '<option value='.$rows['id'].'>'.$rows['pop'].'</option>';
                                                    }
                                                }

                                                 ?>                                               

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group mb-2">
                                            <label>Area</label>
                                            <select  name="area" id="area" class="form-control" style="height:55px;">
                                                <option>---Select---</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group mb-2">
                                            <label>Customer Account</label>
                                            <select  name="cstmr_ac" id="cstmr_ac" class="form-control " style="height:55px;">
                                            <option>Select</option>                                           

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group mb-2">
                                            <label>Customer Phone No.</label>
                                            <input id="phone" type="text" name="phone" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group mb-2">
                                            <label>Message Template</label>
                                            <select class="form-select" id="currentMessageTemp" onchange="currentMsgTemp()">
                                                <option>Select</option>
                                                <?php 
                                                  if ($allCstmr=$con->query("SELECT * FROM message_template WHERE user_type=1")) {
                                                    while ($rows=$allCstmr->fetch_array()) {
                                                        echo '<option value='.$rows['id'].'>'.$rows['template_name'].'</option>';
                                                    }
                                                }

                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                </div><div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea id="message" name="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

       

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <!-- JAVASCRIPT -->
        <?php include 'script.php'; ?>
      <script type="text/javascript">
          $(document).ready(function(){
                 $('#cstmr_ac').select2();
                 $('#Select3').select2();
                 $('#pop').select2();
                 $('#area').select2();
           });
           $(document).on('change','#pop',function(){
                var popID = $(this).val();
                if(popID){
                $.ajax({
                    type: 'POST',
                    url: 'include/add_pop.php', 
                    data: {pop_id: popID},
                    success: function(response){
                        $('#area').html(response);
                    }
                });
                }else{
                    $('#area').html('<option>---Select---</option>');
                }
            });
           $(document).on('change','#area',function(){
                var areaID = $(this).val();
                if(areaID){
                $.ajax({
                    type: 'POST',
                    url: 'include/customers_server.php', 
                    data: {area_id: areaID},
                    success: function(response){
                        $('#cstmr_ac').html(response);
                    }
                });
                }else{
                    $('#cstmr_ac').html('<option>---Select---</option>');
                }
            });
           $(document).on('change','#cstmr_ac',function(){
                var customerID = $(this).val();
                if(customerID){
                $.ajax({
                    type: 'POST',
                    url: 'include/customers_server.php', 
                    data: {get_customer_phone_number: customerID},
                    success: function(response){
                        $("#phone").val(response);
                    }
                });
                }else{
                    $("#phone").val('Phone Number');
                }
            });
           function currentMsgTemp(){
            var name=$("#currentMessageTemp").val();
            var currentMsgTemp="0";
                $.ajax({
                    type:'POST',
                    data:{name:name,currentMsgTemp:currentMsgTemp},
                    url:'include/message.php',
                    success:function(response){
                        console.log(response);
                        $("#message").val(response);
                    }
                });
           }

           $('#send_message').submit(function(e) {
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
                       toastr.success(response.message);

                    }else if (!response.success && response.errors) {
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
