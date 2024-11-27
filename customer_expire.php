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

       <?php $page_title="Customer Expired"; include 'Header.php';?>
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
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>
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
if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
    $popIdCondition = " AND pop='{$_GET['pop_id']}'";
}

/*Expire Date Filter check*/ 
if (isset($_GET["list"])) {
    $ExpMnthYr = $_GET["list"];
    $sql = "SELECT * FROM customers WHERE expiredate LIKE '%$ExpMnthYr%' $popIdCondition";
} else {
    $sql = "SELECT * FROM customers WHERE expiredate < NOW() $popIdCondition";
}

$result = mysqli_query($con, $sql);
?>

<table id="customers_table" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
    <thead class="bg-success text-white">
        <tr>
            <th><input type="checkbox" id="checkedAll" name="checkedAll"> All</th>
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
                <td><input type="checkbox" value="<?php echo $rows['id']; ?>" name="checkAll[]" class="checkSingle"></td>
                <td><?php echo $rows['id']; ?></td>
                <td>
                    <?php 
                        $username = $rows['username'];
                        $onlineusr = $con->query("SELECT * FROM radacct WHERE acctstoptime IS NULL AND username='$username'");
                        $statusIcon = ($onlineusr->num_rows == 1) ? 'online.png' : 'offline.png';
                    ?>
                    <abbr title="<?php echo $statusIcon == 'online.png' ? 'Online' : 'Offline'; ?>">
                        <img src="images/icon/<?php echo $statusIcon; ?>" height="10" width="10" />
                    </abbr>
                    <a href="profile.php?clid=<?php echo $rows['id']; ?>"><?php echo $rows['fullname']; ?></a>
                </td>
                <td><?php echo $rows['package_name']; ?></td>
                <td><?php echo $rows['price']; ?></td>
                <td>
                    <?php 
                        $expireDate = $rows['expiredate'];
                        $badgeClass = ($expireDate <= date("Y-m-d")) ? 'bg-danger' : 'bg-success';
                        echo "<span class='badge $badgeClass'>" . ($badgeClass == 'bg-danger' ? 'Expired' : 'Active') . "</span>";
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
                    <a class="btn btn-info" href="profile_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-success" href="profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
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

            <?php include 'Footer.php';?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <?php include 'modal/customer_modal.php';?>
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
     
    <?php include 'script.php';?>
    <script src="js/customer.js"></script>
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
		
		

    </script>
</body>

</html>