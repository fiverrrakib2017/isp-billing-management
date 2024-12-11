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


        <?php $page_title="Customers"; include '../Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Expired</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Check All <input type="checkbox" id="checkedAll" name="checkedAll" value="Bike"></th> -->
													<th><input type="checkbox" id="checkedAll" name="checkedAll"> All</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>Expired Date</th>
                                                    <th>User Name</th>
                                                    <th>Mobile no.</th>
                                                    <th>POP/Branch</th>
                                                    <th>Area/Location</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php
												if(isset($_GET["list"]))
												{
													$MnthYr=$_GET["list"];
													$area_id=$_GET['area_id'];
                                                    $condition='';
                                                    if($area_id >0){
                                                        $condition .="AND area=$area_id";
                                                    }

                                                    $sql = "SELECT * FROM customers 
                                                    WHERE DATE_FORMAT(createdate, '%Y-%m') = '$MnthYr'
                                                    AND pop=$auth_usr_POP_id $condition AND expiredate >= NOW()";


												}
												else{
													//$sql="SELECT * FROM customers WHERE expiredate<NOW()";
												}
                                               
											   
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
													$username = $rows["username"];

                                                ?>

                                                    <tr>
													<td><input type="checkbox" Value="<?php echo $rows["id"]; ?>" name="checkAll[]" class="checkSingle"></td>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td>
														<?php 
                                                            
                                                            $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                            $chkc = $onlineusr->num_rows;
                                                            if($chkc==1)
                                                            {
                                                                echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                            } else{
                                                                echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';

                                                            }
                                                 
                                                            
                                                            ?>
														
														
														
														<a href="profile.php?clid=<?php echo $rows['id']; ?>"><?php echo $rows["fullname"]; ?></a></td>
                                                        <td>
                                                            <?php

                                                            echo  $rows["package_name"];

                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php

                                                            $expireDate = $rows["expiredate"];
                                                            $todayDate = date("Y-m-d");
                                                            if ($expireDate <= $todayDate) {
                                                                echo "<span class='badge bg-danger'>Expired</span>";
                                                            } else {
                                                                echo $expireDate;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $rows["username"]; ?></td>
                                                        <td><?php echo $rows["mobile"]; ?></td>
                                                        <td>
                                                            <?php
                                                            $popID = $rows["pop"];
                                                            $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                                            while ($popRow = $allPOP->fetch_array()) {
                                                                echo $popRow['pop'];
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php $id = $rows["area"];
                                                            $allArea = $con->query("SELECT * FROM area_list WHERE id='$id' ");
                                                            while ($popRow = $allArea->fetch_array()) {
                                                                echo $popRow['name'];
                                                            }

                                                            ?>

                                                        </td>

                                                        <td>
                                                            <a class="btn-sm btn btn-info" href="profile_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
                                                            <a class="btn-sm btn btn-success" href="profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
                                                            </a>

                                                            <!--<a href="customer_delete.php?clid=<?php echo $rows['id']; ?>" class="btn btn-danger deleteBtn" onclick=" return confirm('Are You Sure');" data-id=<?php echo $rows['id']; ?>><i class="fas fa-trash"></i>
                                                            </a>-->

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

            <?php include '../footer.php';?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
 
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php include '../script.php';?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#customers_table').DataTable();
        });
    </script>
</body>

</html>