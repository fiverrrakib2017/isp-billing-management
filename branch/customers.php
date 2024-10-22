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
        $page_title = "Customers";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        echo file_get_contents($url);
    ?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

    <?php 
        $page_title = "Customers";
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
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>

                                   

                                </div>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addCustomerModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input id="customer_fullname" type="text" class="form-control " placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Username <span id="usernameCheck"></span></label>
                                                                        <input id="customer_username" type="text" class="form-control " name="username" placeholder="Enter Your Username" oninput="checkUsername();" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Password</label>
                                                                        <input id="customer_password" type="password" class="form-control " name="password" placeholder="Enter Your Password" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile no.</label>
                                                                        <input id="customer_mobile" type="text" class="form-control " name="mobile" placeholder="Enter Your Mobile Number" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Expired Date</label>
                                                                        <select id="customer_expire_date" class="form-select">
                                                                            <option value="<?php echo date("d"); ?>"><?php echo date("d"); ?></option>
                                                                            <?php
                                                                            if ($exp_cstmr = $con->query("SELECT * FROM customer_expires")) {
                                                                                while ($rowsssss = $exp_cstmr->fetch_array()) {


                                                                                    $exp_date = $rowsssss["days"];

                                                                                    echo '<option value="' . $exp_date . '">' . $exp_date . '</option>';
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Address</label>
                                                                        <input id="customer_address" type="text" class="form-control" name="address" placeholder="Enter Your Addres" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>POP/Branch</label>
                                                                        <select id="customer_pop" class="form-select">
                                                                            <option value="">Select Pop/Branch</option>
                                                                            <?php
                                                                            if ($pop = $con->query("SELECT * FROM add_pop where id=$auth_usr_POP_id")) {
                                                                                while ($rows = $pop->fetch_array()) {


                                                                                    $id = $rows["id"];
                                                                                    $name = $rows["pop"];

                                                                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>Area/Location</label>
                                                                        <select id="customer_area" class="form-select" name="area">
                                                                            <option>Select Area</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Nid Card Number</label>
                                                                        <input id="customer_nid" type="text" class="form-control" name="nid" placeholder="Enter Your Nid Number" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package</label>
                                                                        <select id="customer_package" class="form-select">


                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Connection Charge</label>
                                                                        <input id="customer_con_charge" type="text" class="form-control" name="con_charge" placeholder="Enter Connection Charge" value="500" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package Price</label>
                                                                        <input disabled id="customer_price" type="text" class="form-control" value="00" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Remarks</label>
                                                                        <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select id="customer_status" class="form-select">
                                                                            <option value="">Select Status</option>
                                                                            <option value="0">Disable</option>
                                                                            <option value="1">Active</option>
                                                                            <option value="2">Expire</option>
                                                                            <option value="3">Request</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="customer_add">Add Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                            <thead class="bg-success text-white" style="background-color: #2c845f !important;">
                                                <tr>
													<th><input type="checkbox" id="checkedAll" name="checkedAll"> All</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>Amount</th>
                                                    <th>Expired Date</th>
                                                    <th>Expired Date</th>
                                                    <th>User Name</th>
                                                    <th>Mobile no.</th>
                                                    <th>POP/Branch</th>
                                                    <th>Area/Location</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">
                                               
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
            <?php 
        $page_title = "Customers";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
        echo file_get_contents($url);
    ?>

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
                                    if ($allCstmr=$con->query("SELECT * FROM message_template WHERE pop_id=$auth_usr_POP_id")) {
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
    <?php 
        $page_title = "Customers";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
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
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php?send_message=true';
                 /*AJAX request to send selected customers to backend*/ 
                 $.ajax({
                    url:url,
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
            });
           
            
			});
			
			
		
		

        $(document).on('keyup', '#customer_username', function() {
            var customer_username = $("#customer_username").val();
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
            $.ajax({
                type: 'POST',
                url: url,
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
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
            $.ajax({
                type: 'POST',
                url: url,
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
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
            $.ajax({
                type: 'POST',
                url: url,
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
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
            $.ajax({
                type: 'POST',
                url:url,
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
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    type: 'POST',
                    url:url,
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


    <script type="text/javascript">
        var table;
        $(document).ready(function(){

         function loadPopOptions() {
           
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/pop_server.php?get_pop_data=1';

            $.ajax({
               url: url,
               type: 'GET',
               dataType: 'json',
               success: function(response) {
                     if (response.success == true) {
                        var pop_id = '<?php echo $auth_usr_POP_id;?>'; 
                        var popOptions = '<label style="margin-left: 20px;"> ';
                        popOptions += '<select class="pop_filter form-select">';
                        popOptions += '<option value="">--Select POP--</option>';
                        $.each(response.data, function(key, data) {
                           if (data.id == pop_id) {
                              popOptions += '<option value="' + data.id + '">' + data.pop + '</option>';
                           }
                        });

                        popOptions += '</select></label>';

                        setTimeout(() => {
                           $('.dataTables_length').append(popOptions);
                           $('.select2').select2(); 
                        }, 500);
                     }
               }
            });
         }

            loadPopOptions();

                table=$('#customers_table').DataTable( {
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthChange":true ,
                    "processing"		: true,
                    "serverSide"		: true,
                    "zeroRecords":    "No matching records found",
                    "ajax"				: {
                        url			: "../include/customer_free_con_server.php",
                        type		: 'GET',
                    },
                    "buttons": [			
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    titleAttr: 'Copy',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    titleAttr: 'CSV',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'pdf',
                    exportOptions: { columns: ':visible' },
                    orientation: 'landscape',
                    pageSize: "LEGAL",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'PDF'
                }, 
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    titleAttr: 'Print',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-list"></i> Column Visibility',
                    titleAttr: 'Column Visibility'
                }
                ],
            });
            table.buttons().container().appendTo($('#export_buttonscc'));	
        });
         /* POP filter change event*/
        $(document).on('change','.pop_filter',function(){
        
        var pop_filter_result = $('.pop_filter').val() == null ? '' : $('.pop_filter').val();

            table.columns(9).search(pop_filter_result).draw();
        
        });

    </script>
</body>

</html>