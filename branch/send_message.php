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
         $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
         $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        echo file_get_contents($url);
        
        ?>
        <style type="text/css">
            span.select2-selection.select2-selection--single {
                 height: 35px;
            }
        </style>
    </head>

    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php 
           
           $page_title = "Message Template";
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Send Message</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="pop">POP</label>
                                        <select name="pop" id="pop" class="form-control select2" style="width: 100%;">
                                            <option value="" disabled selected>Select POP</option>
                                            <?php
                                            if ($allPOPuSR = $con->query("SELECT * FROM add_pop WHERE id=$auth_usr_POP_id")) {
                                                while ($rows = $allPOPuSR->fetch_array()) {
                                                    echo '<option value='.$rows['id'].'>'.$rows['pop'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="area">Area</label>
                                        <select name="area" id="area" class="form-control select2" style="width: 100%;">
                                            <option value="" disabled selected>---Select Area---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cstmr_ac">Customer Account</label>
                                        <select name="cstmr_ac" id="cstmr_ac" class="form-control select2" style="width: 100%;">
                                            <option value="" disabled selected>Select Customer Account</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone">Customer Phone No.</label>
                                        <input id="phone" type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="currentMessageTemp">Message Template</label>
                                        <select class="form-control select2" id="currentMessageTemp" onchange="currentMsgTemp()" style="width: 100%;">
                                            <option value="" disabled selected>---Select Template---</option>
                                            <?php
                                            if ($allCstmr = $con->query("SELECT * FROM message_template WHERE pop_id=$auth_usr_POP_id")) {
                                                while ($rows = $allCstmr->fetch_array()) {
                                                    echo '<option value='.$rows['id'].'>'.$rows['template_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="message">Message</label>
                                        <textarea id="message" name="message" rows="5" class="form-control" placeholder="Enter Your Message"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">Send Message</button>
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
        
        
        <!-- JAVASCRIPT -->
        <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
            
            echo file_get_contents($url);
            
        ?>

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
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/add_pop.php';
                $.ajax({
                    type: 'POST',
                    url: url, 
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
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    type: 'POST',
                    url: url, 
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
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    type: 'POST',
                    url: url, 
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
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/message.php';
                $.ajax({
                    type:'POST',
                    data:{name:name,currentMsgTemp:currentMsgTemp},
                    url:url,
                    success:function(response){
                        console.log(response);
                        $("#message").val(response);
                    }
                });
           }
           
      </script>

    </body>
</html>
