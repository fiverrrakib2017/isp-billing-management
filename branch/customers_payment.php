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
        
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        
        echo file_get_contents($url);
        
        ?>
    
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            
            <?php 
                $page_title="Customer Payment";
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
                                    <p class="text-primary mb-0 hover-cursor">Customers Payment</p>
                                 </div>
                              </div>
                              <br>
                           </div>
                           <div class="d-flex justify-content-between align-items-end flex-wrap">
                              
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
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr >
                                        <th>Customer Name</th>
                                        <th>Recharged date</th>
                                        <th>Months</th>
                                        <th>Paid until</th>
                                        <th>Amount</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                         <?php 
                          $sql="SELECT * FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id'  ";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>

<td>
    <?php 
    $getCstmrId= $rows["customer_id"]; 
     if ($allCom = $con -> query("SELECT * FROM customers WHERE id='$getCstmrId' ")){
           while ($rowss=$allCom->fetch_array()) {
              $customerName= $rowss['fullname'];
            echo '<a href="profile.php?clid='.$getCstmrId.'">'.$customerName.'</a>';
           }
        } 
    ?>
        
    </td>
    <td>
    <?php 
    $recharge_date_time= $rows['datetm'];
    $dateTm= new DateTime($recharge_date_time);
    echo $dateTm->format("H:i A, d-M-Y");
    ?> 
    </td>

<td><?php echo $rows["months"]; ?></td>
<td><?php echo $rows["rchrg_until"]; ?></td>
<td><?php echo $rows["purchase_price"]; ?></td>

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
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
        
        echo file_get_contents($url);
        
        ?>
      
    </body>
</html>
