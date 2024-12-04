<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");


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

        <?php include 'Header.php'; ?>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <?php $page_title="Custmer Disable"; include 'Sidebar_menu.php'; ?>

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
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    

                                   

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
                                                $condition=[];
                                                if(isset($_GET['list']) && !empty($_GET['list'])){
                                                    $ExpMnthYr = mysqli_real_escape_string($con, $_GET["list"]);
                                                    $conditions[] = "expiredate LIKE '%$ExpMnthYr%'";
                                                }else{
                                                    $conditions[] = "status='0'";
                                                }

                                                if(isset($_GET['area_id']) && !empty($_GET['area_id'])){
                                                    $area_id = mysqli_real_escape_string($con, $_GET["area_id"]);
                                                    $conditions[] = "area=$area_id";
                                                }
                                                if(isset($_GET['pop_id']) && !empty($_GET['pop_id'])){
                                                    $pop_id = mysqli_real_escape_string($con, $_GET["pop_id"]);
                                                    $conditions[] = "pop=$pop_id";
                                                }

                                                if(!empty($conditions)){
                                                    $condition = implode(" AND ", $conditions);
                                                    $sql="SELECT * FROM customers WHERE $condition";
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
    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0">
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="Layouts-1">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="Layouts-2">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="Layouts-3">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
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
     <!-- Modal for Send Message -->
     <div class="modal fade bs-example-modal-lg" id="sendMessageModal" tabindex="-1" role="dialog"
               aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog " role="document">
                  <div class="modal-content col-md-12">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span
                           class="mdi mdi-account-check mdi-18px"></span> &nbsp;Send Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <div class="alert alert-info" id="selectedCustomerCount"></div>
                        <form id="paymentForm"  method="POST">
                           
                           <div class="form-group mb-2">
                              <label>Message Template</label>
                              <select class="form-select" name="message_template" >
                                <option>---Select---</option>
                                <?php 
                                    if ($allCstmr=$con->query("SELECT * FROM message_template WHERE user_type=1")) {
                                    while ($rows=$allCstmr->fetch_array()) {
                                        echo '<option value='.$rows['id'].'>'.$rows['template_name'].'</option>';
                                    }
                                }

                                    ?>
                            </select>
                           </div>
                           <div class="form-group mb-2">
                              <label>Message</label>
                              <textarea id="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                           </div>
                           <div class="modal-footer ">
                              <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                              <button type="button" name="send_message_btn" class="btn btn-success">Send Message</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
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