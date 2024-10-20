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
    
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php 
            $page_title = "Bulk Payment";
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
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkedAll" name="checkedAll" value="Bike"> Check All </th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>User Name</th>
                                                    <th>Mobile no.</th>
                                                    <th>Month/Year</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="b_payment-list">
                                               <?php 
                          $sql="SELECT * FROM customers WHERE pop='$auth_usr_POP_id' ";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
<td><input  type="checkbox" name="checkAll" class="checkSingle" ></td>
<td><?php echo $rows["id"]; ?></td>
<td><?php echo $rows["fullname"]; ?></td>
<td>
    <?php
      $packName= $rows["package"]; 
      $allPOP=$con->query("SELECT * FROM `radgroupcheck` WHERE id=$packName ");
    while ($popRow=$allPOP->fetch_array()) {
       echo  $popRow['groupname'];
    }


    ?>
    
</td>
<td><?php echo $rows["username"]; ?></td>
<td><?php echo $rows["mobile"]; ?></td>
<td>
    <input  type="text"  class="form-control form-control-sm" value='<?php echo date('d-M-Y'); ?>'>
</td>
<td><input type="text" class="form-control form-control-sm" value=<?php echo $rows["price"]; ?>></td>

</tr>
                       <?php } ?>
                                            </tbody>
                                            <tfoot>
                                           <tr>
                                               <th colspan="8"><button style="float:right" class="btn btn-success">Process Payment</button></th>
                                           </tr>
                                            </tfoot>
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
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';

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
          $(document).ready(function() {
  $("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
    }else {
      $("#checkedAll").prop("checked", false);
    }
  });
});
      </script>
    </body>
</html>
