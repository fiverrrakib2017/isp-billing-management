<?php
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/db_connect.php';
include 'include/pop_security.php';

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
        <?php $page_title="Area"; include 'Header.php'; ?>

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
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"
                                        style="margin-bottom: 12px;">&nbsp;&nbsp;New
                                        Area</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
                        aria-hidden="true" id="addModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="form-area">
                                                    <div class="form-group mb-1">
                                                        <label>POP</label>
                                                        <select class="form-select" name="pop_id">
                                                            <option>Select</option>
                                                            <?php
                                                            if ($pop = $con->query("SELECT * FROM add_pop WHERE user_type='1'  ")) {
                                                                while ($rows = $pop->fetch_array()) {
                                                                    $id = $rows['id'];
                                                                    $name = $rows['pop'];
                                                            
                                                                    echo '<option value=' . $id . '>' . $name . '</option>';
                                                                }
                                                            }
                                                            
                                                            ?>


                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Area</label>
                                                        <input class="form-control" type="text" name="area"
                                                            placeholder="Type Your Area" id="area" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Billing Cycle Date</label>
                                                        <select class="form-select" type="text" id="billing_date" name="billing_date">
                                                            <?php 
                                                            
                                                            for($i=1; $i<30; $i++){
                                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                                            }
                                                            
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group d-none">
                                                        <label>User Type</label>
                                                        <input class="form-control" type="text" name="user_type"
                                                            value="<?php echo $auth_usr_type; ?>" id="user_type" />
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
                                        <table id="areaDataTable" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Area</th>
                                                    <th>Total Customers</th>
                                                    <th>Online</th>
                                                    <th>Expired</th>
                                                    <th>POP/Branch Name</th>
                                                    <th>Billing Cycle</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="areaList">
                                            <?php 

if (!empty($_GET['pop_id'])) {
    $pop_id = (int)$_GET['pop_id'];
} else if (!empty($auth_usr_POP_id)) {
    $pop_id = (int)$auth_usr_POP_id;
} else {
    $pop_id = null; 
}

if ($pop_id !== null) {
    $sql_con = "SELECT * FROM area_list WHERE pop_id = $pop_id";
} else {
    $sql_con = "SELECT * FROM area_list"; 
}

$result = mysqli_query($con, $sql_con);

while ($rows2 = mysqli_fetch_assoc($result)) {
    $areaID = $rows2['id'];
    ?>

    <tr>
        <td><?php echo $areaID; ?></td>
        <td><?php echo htmlspecialchars($rows2['name']); ?></td>
        <td>
            <?php
            $totalcust = $con->query("SELECT COUNT(*) as total FROM customers WHERE area = '$areaID'");
            $area_cust = $totalcust->fetch_assoc()['total'];
            echo $area_cust;
            ?>
        </td>
        <td>
            <?php
             $sql = "SELECT radacct.username FROM radacct
             INNER JOIN customers
             ON customers.username=radacct.username
             
             WHERE customers.area='$areaID' AND radacct.acctstoptime IS NULL";
             $countpoponlnusr = mysqli_query($con, $sql);

             echo $countpoponlnusr->num_rows;
            ?>
        </td>

        <td>
            <?php
            $totalexcust = $con->query("SELECT COUNT(*) as expired FROM customers WHERE area = '$areaID' AND expiredate < NOW()");
            $area_excust = $totalexcust->fetch_assoc()['expired'];
            echo '<a href="customer_expire.php?area_id=' . $areaID . '"><span class="badge bg-danger">' . $area_excust . '</span></a>';
            ?>
        </td>

        <td>
            <?php
            $popID = $rows2['pop_id'];
            $get = $con->query("SELECT pop FROM add_pop WHERE id = $popID");
            if ($rows3 = $get->fetch_assoc()) {
                echo htmlspecialchars($rows3['pop']);
            }
            ?>
        </td>
        <td>
            <?php 
            $final_data= $rows2['billing_date'] ?? 0;
            if($final_data > 0){
                echo '<span class="badge bg-success">'.$final_data.'</span></span>';
            }else{
                echo '<span class="badge bg-danger">'.$final_data.'</span></span>';
            }
            ?>
        </td>

        <td style="text-align:right;">
            <a class="btn btn-info" href="area_edit.php?id=<?php echo $areaID; ?>">
                <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-success" href="view_area.php?id=<?php echo $areaID; ?>">
                <i class="fas fa-eye"></i>
            </a>
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

            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->




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
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?php include 'script.php'; ?>
    <script type="text/javascript">
        $("#areaDataTable").DataTable();
        $("#add_area").click(function() {
            var area = $("#area").val();
            var billing_date = $("#billing_date").val();
            if (area.length == 0) {
                toastr.error("Area name is require");
            }else if(billing_date.length==0){
                toastr.error("Billing Cycle Date is require");
            } 
            else {
                var formData = $("#form-area").serialize();
                $.ajax({
                    type: "GET",
                    data: formData,
                    url: "include/add_area.php?add",
                    cache: false,
                    success: function(data) {
                        toastr.success(data);
                        $("#addModal").modal('hide');
                        $("#areaDataTable").DataTable();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                });
            }


        });
    </script>

</body>

</html>
