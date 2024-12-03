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

    <?php $page_title="Customers Disabled"; include '../Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Disabled</p>
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
												 $popIdCondition = '';
                                                 $areaIdCondition = '';
                                                 $DEFAULT_CONDITION='';
                                                 
                                                 /* Check for pop_id in the query string*/
                                                 if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
                                                     $popIdCondition = " AND pop='" . mysqli_real_escape_string($con, $_GET['pop_id']) . "'";
                                                 }else{
                                                     $DEFAULT_CONDITION = " AND pop='" . $_SESSION['user_pop'] . "'";
                                                 }
                                                 
                                                 /* Check for area_id in the query string*/
                                                 if (isset($_GET['area_id']) && !empty($_GET['area_id'])) {
                                                     $areaIdCondition = " AND area='" . mysqli_real_escape_string($con, $_GET['area_id']) . "'";
                                                 }else{
                                                    $DEFAULT_CONDITION = " AND pop='" . $_SESSION['user_pop'] . "'";
                                                 }

                                                 /* Expire Date Filter check*/
                                                if (isset($_GET['list'])) {
                                                    $ExpMnthYr = mysqli_real_escape_string($con, $_GET['list']);
                                                    $sql = "SELECT * FROM customers WHERE expiredate LIKE '%$ExpMnthYr%' $popIdCondition $areaIdCondition";
                                                } else {
                                                    $sql = "SELECT * FROM customers WHERE status='0' AND expiredate < NOW() $popIdCondition $areaIdCondition $DEFAULT_CONDITION";
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
                                                            <a class="btn btn-info" href="profile_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
                                                            <a class="btn btn-success" href="profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
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
                                <div class="card-footer" style="text-align: right;">
                                    <button class="btn btn-primary" id="send_message_btn" >Send Message</button>
                                    <button class="btn btn-success" id="export_to_excel" >Export To Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © IT-FAST.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Development <i class="mdi mdi-heart text-danger"></i><a target="__blank" href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

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
                    <h4 class="modal-title w-100 " id="DeleteId">1</h4>
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
     
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php
        
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
        
        echo file_get_contents($url);
        
    ?>
    <script type="text/javascript">
	
	$(document).ready(function() {
            $(document).on('click','#export_to_excel',function(){
                    let csvContent = "data:text/csv;charset=utf-8,";
                
                /* Add header row*/
                csvContent += [
                    'ID', 'Name', 'Package', 'Expired Date', 'User Name', 'Mobile no.', 'POP/Branch', 'Area/Location'
                ].join(",") + "\n";
                
                /*Add data rows*/ 
                $('#customers_table tbody tr').each(function() {
                    let row = [];
                    $(this).find('td').each(function() {
                        row.push($(this).text().trim());
                    });
                    csvContent += row.join(",") + "\n";
                });

                /* Create a link element and simulate click to download the CSV file*/
                let encodedUri = encodeURI(csvContent);
                let link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "customers.csv");
                document.body.appendChild(link); // Required for Firefox
                link.click();
                document.body.removeChild(link);
            });
			
            $("#checkedAll").change(function() {
                $(".checkSingle").prop('checked', $(this).prop("checked"));
            });
            $(".checkSingle").change(function() {
                if ($(".checkSingle:checked").length == $(".checkSingle").length) {
                    $("#checkedAll").prop("checked", true);
                } else {
                    $("#checkedAll").prop("checked", false);
                }
            });
            $("#send_message_btn").click(function() {
                var selectedCustomers = [];
                $(".checkSingle:checked").each(function() {
                    selectedCustomers.push($(this).val());
                });
                var countText = "You have selected " + selectedCustomers.length + " customers.";
                $("#selectedCustomerCount").text(countText);
                console.log(selectedCustomers); 
                $('#sendMessageModal').modal('show'); 

            });
            $('button[name="send_message_btn"]').on('click',function(e){
                e.preventDefault(); 
                 /*AJAX request to send selected customers to backend*/ 
                 $.ajax({
                    url: 'include/customers_server.php?send_message=true',
                    method: 'POST',
                    data: {
                        /*sending the array of customer IDs*/ 
                        customer_ids: selectedCustomers, 
                        message: $("#message").val(),
                    },
                    success: function(response) {
                        alert("Message sent successfully to selected customers.");
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                        alert("There was an error sending the message.");
                    }
                });
            });
            $('select[name="message_template"]').on('change', function() {
                var name=$(this).val();
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
            });
           
            
			});
			
			
        $("#customers_table").DataTable();
		
		

        $(document).on('keyup', '#customer_username', function() {
            var customer_username = $("#customer_username").val();
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    current_username: customer_username
                },
                success: function(response) {
                    $("#usernameCheck").html(response);
                }
            });
        });
        
        $(document).on('change', '#customer_pop', function() {
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    current_pop_name: pop_id
                },
                success: function(response) {
                     $("#customer_area").html(response);
                }
            });
        });
        $(document).on('change', '#customer_pop', function() {
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    pop_name: pop_id,
                    getCustomerPackage:0
                },
                success: function(response) {
                     $("#customer_package").html(response);
                }
            });
        });
        $(document).on('change', '#customer_package', function() {
            var packageId = $("#customer_package").val();
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    package_id: packageId,
                    pop_id: pop_id,
                    getPackagePrice:0
                },
                success: function(response) {
                     $("#customer_price").val(response);
                }
            });
        });




        $("#customer_add").click(function() {
            var fullname = $("#customer_fullname").val();
            var package = $("#customer_package").val();
            var username = $("#customer_username").val();
            var password = $("#customer_password").val();
            var mobile = $("#customer_mobile").val();
            var address = $("#customer_address").val();
            var expire_date = $("#customer_expire_date").val();
            var area = $("#customer_area").val();
            var pop = $("#customer_pop").val();
            var nid = $("#customer_nid").val();
            var con_charge = $("#customer_con_charge").val();
            var price = $("#customer_price").val();
            var remarks = $("#customer_remarks").val();
            var status = $("#customer_status").val();
            var user_type = <?php echo $auth_usr_type; ?>;

            customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop, con_charge, price, remarks, nid, status)

        });

        function customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop, con_charge, price, remarks, nid, status) {
            if (fullname.length == 0) {
                toastr.error("Customer name is require");
            } else if (package.length == 0) {
                toastr.error("Customer Package is require");
            } else if (username.length == 0) {
                toastr.error("Username is require");
            } else if (password.length == 0) {
                toastr.error("Password is require");
            } else if (mobile.length == 0) {
                toastr.error("Mobile number is require");
            } else if (expire_date.length == 0) {
                toastr.error("Expire Date is require");
            } else if (pop.length == 0) {
                toastr.error("POP/Branch is require");
            } else if (area.length == 0) {
                toastr.error("Area is require");
            } else if (con_charge.length == 0) {
                toastr.error("Connection Charge is require");
            } else if (price.length == 0) {
                toastr.error("price is require");
            } else if (status.length == 0) {
                toastr.error("Status is require");
            } else {
                $("#customer_add").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                var addCustomerData = 0;
                $.ajax({
                    type: 'POST',
                    url: 'include/customers_server.php',
                    data: {
                        addCustomerData: addCustomerData,
                        fullname: fullname,
                        package: package,
                        username: username,
                        password: password,
                        mobile: mobile,
                        address: address,
                        expire_date: expire_date,
                        area: area,
                        pop: pop,
                        con_charge: con_charge,
                        price: price,
                        remarks: remarks,
                        nid: nid,
                        status: status,
                        user_type: user_type,
                    },
                    success: function(responseData) {
                        if (responseData == 1) {
                            toastr.success("Added Successfully");
                            $("#addCustomerModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(responseData);
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>