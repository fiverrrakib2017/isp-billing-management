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
        <?php include '../style.php';?>
    
    </head>

    <body data-sidebar="dark">


      

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <?php $page_title="Recharge Filter"; include '../Header.php';?>
        
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
           <div class="row" id="searchRow">
                <div class="col-md-4 col-sm m-auto">
                    <div class="card">
                        <div class="card-header">Recharge Filter</div>
                        <div class="card-body">
                            <div class="form-gruop mb-2">
                                <label>From Date</label>
                                <input type="text" name="" id="popid"  class="form-control d-none" value="<?php echo $auth_usr_POP_id;?>">
                                <input type="date" name="" id="fromDate"  class="form-control">
                            </div>
                            <div class="form-gruop mb-2">
                                <label>To Date</label>
                                <input type="date" name="" id="toDate" placeholder="Enter Student Id" class="form-control">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success"style="width: 100%;" type="button" id="searchBtn"><i class="fas fa-filter"></i>&nbsp;&nbsp;Filter Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none" id="FilterTable">
                <div class="col-md-12 col-sm-12 m-auto">
                    <div class="card" id="mainCard">
                        <div class="card-body">
                           <table id="rechargeDataTable" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                               <thead>
                                   <tr>
                                      <th> Customer Name </th>
                                      <th> Recharged date </th>
                                      <th> Months</th>
                                     
                                      <th> Paid until </th>
                                      <th> Amount </th>
                                   </tr>
                                </thead>
                                <tbody id="rechargeTable"></tbody>
                           </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

   <?php include '../Footer.php';?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
       <!-- JAVASCRIPT -->
        <?php include '../script.php';?>
        <script type="text/javascript">
            $(document).ready(function(){
            
            $("#searchBtn").on('click',function(){
                var fromDate=$("#fromDate").val();
                var toDate=$("#toDate").val();
                var popid=$("#popid").val();
                if (fromDate.length==0) {
                    toastr.error("From Date is require");
                }else if(toDate.length==0){
                    toastr.error("To Date is require");
                }else{
                  var rechargeFilter="0";
                  var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/rechargeFilter.php';
                    $.ajax({
                           url:url, 
                           type:'POST',
                           data:{rechargeFilter:rechargeFilter,fromDate:fromDate,toDate:toDate,popid:popid},
                           success:function(response){
                            
                            $("#FilterTable").removeClass('d-none');
                               $("#rechargeTable").html(response);
                               $("#searchRow").addClass('d-none');
                               $("#rechargeDataTable").dataTable();
                               
                           }
                    });  
                }
                
            });
        });
        </script>
    </body>
</html>
