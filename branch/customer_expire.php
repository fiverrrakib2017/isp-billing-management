<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];

$db_connect_path = $rootPath . '/include/db_connect.php';
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require $db_connect_path;
}

if (file_exists($users_right_path)) {
    require $users_right_path;
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $page_title = 'Customers';
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
    
    echo file_get_contents($url);
    
    ?>
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        $page_title = 'Expire Customers';
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
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
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>
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
                                        <?php
                                        $popIdCondition = '';
                                        $areaIdCondition = '';
                                        
                                        /* Check for pop_id in the query string*/
                                        if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
                                            $popIdCondition = " AND pop='" . mysqli_real_escape_string($con, $_GET['pop_id']) . "'";
                                        }
                                        
                                        /* Check for area_id in the query string*/
                                        if (isset($_GET['area_id']) && !empty($_GET['area_id'])) {
                                            $areaIdCondition = " AND area='" . mysqli_real_escape_string($con, $_GET['area_id']) . "'";
                                        }
                                        
                                        /* Check for pop_id in the session*/
                                        if($popIdCondition==''){
                                            $pop_id = $_SESSION['user_pop'] ? $_SESSION['user_pop'] : '0';
                                            $popIdCondition = " AND pop='" . mysqli_real_escape_string($con, $pop_id) . "'";
                                        }
                                        
                                        /* Expire Date Filter check*/
                                        if (isset($_GET['list'])) {
                                            $ExpMnthYr = mysqli_real_escape_string($con, $_GET['list']);
                                            $sql = "SELECT * FROM customers WHERE expiredate LIKE '%$ExpMnthYr%' $popIdCondition $areaIdCondition";
                                        } else {
                                            $sql = "SELECT * FROM customers WHERE expiredate < NOW() $popIdCondition $areaIdCondition";
                                        }

                                        
                                        
                                        $result = mysqli_query($con, $sql);
                                        
                                        ?>

                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap"
                                            style="width: 100%;">
                                            <thead class="bg-success text-white">
                                                <tr>
                                                    <th><input type="checkbox" id="checkedAll" name="checkedAll"> All
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>Amount</th>
                                                    <th>Expired Status</th>
                                                    <th>Expired Date</th>
                                                    <th>Username</th>
                                                    <th>Mobile no.</th>
                                                    <th>POP/Branch</th>
                                                    <th>Area/Location</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                                <?php while ($rows = mysqli_fetch_assoc($result)) : ?>
                                                <tr>
                                                    <td><input type="checkbox" value="<?php echo $rows['id']; ?>"
                                                            name="checkAll[]" class="checkSingle"></td>
                                                    <td><?php echo $rows['id']; ?></td>
                                                    <td>
                                                        <?php
                                                        $username = $rows['username'];
                                                        $onlineusr = $con->query("SELECT * FROM radacct WHERE acctstoptime IS NULL AND username='$username'");
                                                        $statusIcon = $onlineusr->num_rows == 1 ? 'online.png' : 'offline.png';
                                                        ?>
                                                        <abbr title="<?php echo $statusIcon == 'online.png' ? 'Online' : 'Offline'; ?>">
                                                            <img src="../images/icon/<?php echo $statusIcon; ?>" height="10"
                                                                width="10" />
                                                        </abbr>
                                                        <a
                                                            href="profile.php?clid=<?php echo $rows['id']; ?>"><?php echo $rows['fullname']; ?></a>
                                                    </td>
                                                    <td><?php echo $rows['package_name']; ?></td>
                                                    <td><?php echo $rows['price']; ?></td>
                                                    <td>
                                                        <?php
                                                        $expireDate = $rows['expiredate'];
                                                        $badgeClass = $expireDate <= date('Y-m-d') ? 'bg-danger' : 'bg-success';
                                                        echo "<span class='badge $badgeClass'>" . ($badgeClass == 'bg-danger' ? 'Expired' : 'Active') . '</span>';
                                                        ?>
                                                    </td>
                                                    <td><?php echo $rows['expiredate']; ?></td>
                                                    <td><?php echo $rows['username']; ?></td>
                                                    <td><?php echo $rows['mobile']; ?></td>
                                                    <td>
                                                        <?php
                                                        $popID = $rows['pop'];
                                                        $popQuery = $con->query("SELECT pop FROM add_pop WHERE id=$popID");
                                                        echo $popQuery->fetch_assoc()['pop'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $areaID = $rows['area'];
                                                        $areaQuery = $con->query("SELECT name FROM area_list WHERE id='$areaID'");
                                                        echo $areaQuery->fetch_assoc()['name'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info"
                                                            href="profile_edit.php?clid=<?php echo $rows['id']; ?>"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a class="btn btn-success"
                                                            href="profile.php?clid=<?php echo $rows['id']; ?>"><i
                                                                class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="card-footer" style="text-align: right;">
                                    <button class="btn btn-primary" id="send_message_btn">Send Message</button>
                                    <button class="btn btn-success" id="export_to_excel">Export To Excel</button>
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
    <?php include 'modal/customer_modal.php'; ?>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
    
    echo file_get_contents($url);
    ?>
    <script src="js/customer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#printCustomerButton").click(function() {
                printCustomerData();
            });
           

            
          

          

           

          
            // Print function
            function printCustomerData() {
                var printContents = document.getElementById('customerDataContainer').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }



            $("#checkedAll").change(function() {
                if (this.checked) {
                    $(".checkSingle").each(function() {
                        this.checked = true;
                    })
                } else {
                    $(".checkSingle").each(function() {
                        this.checked = false;
                    })
                }
            });

            $(".checkSingle").click(function() {
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;
                    $(".checkSingle").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    })
                    if (isAllChecked == 0) {
                        $("#checkedAll").prop("checked", true);
                    }
                } else {
                    $("#checkedAll").prop("checked", false);
                }
            });
        });




        $("#customers_table").DataTable();

    </script>
</body>

</html>
