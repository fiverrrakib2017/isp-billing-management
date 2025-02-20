<?php
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/db_connect.php';
//   ini_set('display_errors', '1');
//   ini_set('display_startup_errors', '1');
//   error_reporting(E_ALL);

if (isset($_GET['clid'])) {
    $clid = $_GET['clid'];
    if ($cstmr = $con->query("SELECT * FROM clients WHERE id='$clid'")) {
        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows['id'];
            $fullname = $rows['fullname'];
            $company = $rows['company'];
            $mobile = $rows['mobile'];
            $email = $rows['email'];
            $address = $rows['address'];
            $createdate = $rows['createdate'];
        }
    }
}

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
        <?php $page_title = 'Client Profile';
        include 'Header.php'; ?>
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
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end align-items-center gap-2 py-2">
                                <abbr title="Create Invoice">
                                    <a href="sale.php" class="btn btn-sm btn-primary ">
                                        <i class="fas fa-money-bill-wave me-1"></i> Create Invoice
                                    </a>
                                </abbr>

                                <abbr title="Supplier Payment">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#paymentModal"
                                        class="btn btn-sm btn-success">
                                        <i class="fas fa-hand-holding-usd me-1"></i> Payment Received
                                    </button>
                                </abbr>

                                <abbr title="Edit Client">
                                    <button type="button" data-id="<?php echo $clid; ?>"
                                        class="btn btn-sm btn-info edit-btn">
                                        <i class="mdi mdi-account-edit me-1"></i> Edit
                                    </button>
                                </abbr>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="container">
                            <div class="main-body">
                                <div class="row gutters-sm">
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center profile">
                                                    <img src="profileImages/avatar.png" alt='Profile Picture'
                                                        class="rounded-circle" width="150" />
                                                    <div class="imgUpIcon">
                                                        <button id="uploadBtn" type="button">
                                                            <i class="mdi mdi-camera"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mt-3">
                                                        <h5>
                                                            <?php echo $fullname; ?>
                                                        </h5>
                                                        <p class="text-secondary mb-1"># <?php echo $clid; ?>
                                                            <br>
                                                            <?php echo $mobile; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                                                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                                        <p><i class="mdi mdi-marker-check"></i> Fullname:</p>
                                                        <a href="#"><?php echo $fullname; ?></a>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                                        <p><i class="mdi mdi-phone"></i> Mobile:</p>
                                                        <a href="#"><?php echo $mobile; ?></a>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                                        <p><i class="fas fa-id-card"> </i> Address: </p>
                                                        <a href="#"><?php echo $address; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- Earnings (Monthly) Card Example -->
                                            <div class="col-xl-4 col-md-6 mb-4">
                                                <div class="card shadow py-2" style="border-left:3px solid #2A0FF1;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Total Sales's</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php
                                                                    
                                                                    $total_amount = $con->query("SELECT SUM(grand_total) AS amount FROM sales WHERE client_id='$clid' ")->fetch_array()['amount'] ?? 0;
                                                                    echo floatval($total_amount);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Earnings (Monthly) Card Example -->
                                            <div class="col-xl-4 col-md-6 mb-4">
                                                <div class="card shadow  py-2" style="border-left:3px solid #27F10F;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                    Total Paid</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php
                                                                    
                                                                    $total_paid_amount = $con->query("SELECT SUM(amount) AS total_paid FROM inventory_transaction WHERE client_id='$clid' AND transaction_type  !='0' AND inventory_type='Customer'")->fetch_array()['total_paid'] ?? 0;
                                                                    echo floatval($total_paid_amount);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Pending Requests Card Example -->
                                            <div class="col-xl-4 col-md-6 mb-4">
                                                <div class="card shadow  py-2" style="border-left:3px solid red;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                    Total Due</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php
                                                                    echo floatval($total_amount - $total_paid_amount);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab"
                                                                    href="#transaction" role="tab">
                                                                    <span class="d-none d-md-block">Transaction
                                                                    </span><span class="d-block d-md-none"><i
                                                                            class="mdi mdi-home-variant h5"></i></span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#invoice" role="tab">
                                                                    <span class="d-none d-md-block">Invoice</span><span
                                                                        class="d-block d-md-none"><i
                                                                            class="mdi mdi-account h5"></i></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div class="tab-pane active p-3" id="transaction"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="table-responsive">
                                                                                <table id="transaction_datatable"
                                                                                    class="table table-bordered dt-responsive nowrap"
                                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Note</th>
                                                                                            <th>Transaction Type</th>
                                                                                            <th>Transaction Date</th>
                                                                                            <th>Posting Date</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                          $totalCount=1;
                                                                                          $result =$con->query("SELECT * FROM inventory_transaction WHERE inventory_type='Customer' AND  client_id=$lstid");
                                                                                          
                                                                                          while ($rows = mysqli_fetch_assoc($result)) {
                                                                                          
                                                                                          ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <?php
                                                                                                echo $totalCount++;
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?php echo $rows['amount']; ?>
                                                                                            </td>
                                                                                            <td><?php echo $rows['note']; ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php
                                                                                                if ($rows['transaction_type'] == '1') {
                                                                                                    echo "<span class='badge bg-success'>Cash</span>";
                                                                                                } elseif ($rows['transaction_type'] == '2') {
                                                                                                    echo "<span class='badge bg-info'>Bkash</span>";
                                                                                                } elseif ($rows['transaction_type'] == '3') {
                                                                                                    echo "<span class='badge bg-success'>Nagad</span>";
                                                                                                } elseif ($rows['transaction_type'] == '4') {
                                                                                                    echo "<span class='badge bg-primary'>Due Paid</span>";
                                                                                                } elseif ($rows['transaction_type'] == '0') {
                                                                                                    echo "<span class='badge bg-danger'>Crdit</span>";
                                                                                                } elseif ($rows['transaction_type'] == '5') {
                                                                                                    echo "<span class='badge bg-info'>Bank</span>";
                                                                                                }
                                                                                                ?>
                                                                                            <td>
                                                                                                <?php
                                                                                                echo date('d F Y', strtotime($rows['transaction_date']));
                                                                                                ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php
                                                                                                echo date('d F Y', strtotime($rows['create_date']));
                                                                                                
                                                                                                ?>
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
                                                            <div class="tab-pane  p-3" id="invoice"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="table table-responsive">
                                                                                <table id="invoice_datatable"
                                                                                    class="table table-bordered dt-responsive nowrap"
                                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Invoice id</th>
                                                                                            <th>Customer Name</th>
                                                                                            <th>Sub Total</th>
                                                                                            <th>Paid Amount</th>
                                                                                            <th>Due Balance</th>
                                                                                            <th>Grand Total</th>
                                                                                            <th>Create Date</th>
                                                                                            <th></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                       $sql = "SELECT * FROM sales WHERE client_id=?";
                                                                                       $stmt = $con->prepare($sql);
                                                                                       $stmt->bind_param("i", $lstid);  
                                                                                       $stmt->execute();
                                                                                       $result = $stmt->get_result();

                                                                                       while ($rows = $result->fetch_assoc()) {
                                                                                       ?>
                                                                                        <tr>
                                                                                            <td><?php echo htmlspecialchars($rows['id']); ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php
                                                                                                $supplier_id = $rows['client_id'];
                                                                                                $allCustomerData = $con->prepare('SELECT fullname FROM suppliers WHERE id=?');
                                                                                                $allCustomerData->bind_param('i', $supplier_id);
                                                                                                $allCustomerData->execute();
                                                                                                $client_result = $allCustomerData->get_result();
                                                                                                
                                                                                                if ($client_row = $client_result->fetch_assoc()) {
                                                                                                    echo '<a href="client_profile.php?clid=' . htmlspecialchars($supplier_id) . '">' . htmlspecialchars($client_row['fullname']) . '</a>';
                                                                                                }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?php echo htmlspecialchars($rows['sub_total']); ?>
                                                                                            </td>
                                                                                            <td><?php echo htmlspecialchars($rows['total_paid']); ?>
                                                                                            </td>
                                                                                            <td><?php echo htmlspecialchars($rows['total_due']); ?>
                                                                                            </td>
                                                                                            <td><?php echo htmlspecialchars($rows['grand_total']); ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php
                                                                                                $date = $rows['date'];
                                                                                                $formatted_date = date('d F Y', strtotime($date));
                                                                                                echo htmlspecialchars($formatted_date);
                                                                                                ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <a class="btn-sm btn btn-primary"
                                                                                                    href="sales_inv_edit.php?clid=<?php echo htmlspecialchars($rows['id']); ?>"><i
                                                                                                        class="fas fa-edit"></i></a>
                                                                                                <a class="btn-sm btn btn-success"
                                                                                                    href="invoice/sales_inv_view.php?clid=<?php echo htmlspecialchars($rows['id']); ?>"><i
                                                                                                        class="fas fa-eye"></i></a>
                                                                                                <button type="button"
                                                                                                    name="delete_button"
                                                                                                    data-id="<?php echo htmlspecialchars($rows['id']); ?>"
                                                                                                    class="btn-sm btn btn-danger"
                                                                                                    style="margin-right: 5px;"><i
                                                                                                        class="fas fa-trash"></i></button>


                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php  }  ?>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <!-- Modal for addPayment -->
            <div class="modal fade bs-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content col-md-12">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><span
                                    class="mdi mdi-account-check mdi-18px"></span> &nbsp;Payment Received</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="include/sale_server.php?add_due_payment=true" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="client_id" id="client_id" value="<?php echo $clid; ?>">

                                <div class="form-group mb-2">
                                    <label>Due Amount</label>
                                    <input readonly name="due_amount" placeholder="Enter Due Amount"
                                        class="form-control" type="text" value="<?php
                                        echo round($total_amount - $total_paid_amount, 2);
                                        ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Paid Amount</label>
                                    <input name="paid_amount" placeholder="Enter Paid Amount" class="form-control"
                                        type="text" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Select Accounts</label>
                                    <select type="text" class="form-control" id="sub_ledger_id"
                                        name="sub_ledger_id" style="width: 100%;">
                                        <?php
                                        if ($ledgr = $con->query("SELECT * FROM ledger WHERE mstr_ledger_id='1'")) {
                                            echo '<option value="">Select</option>';
                                        
                                            while ($rowsitm = $ledgr->fetch_array()) {
                                                $ldgritmsID = $rowsitm['id'];
                                                $ledger_name = $rowsitm['ledger_name'];
                                        
                                                echo '<optgroup label="' . $ledger_name . '">';
                                        
                                                // Sub Ledger items list
                                                if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {
                                                    while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                        $sub_ldgrid = $rowssb['id'];
                                                        $ldgr_items = $rowssb['item_name'];
                                        
                                                        echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
                                                    }
                                                }
                                        
                                                echo '</optgroup>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Transaction Type</label>
                                    <select name="transaction_type" id="transaction_type" class="form-select"
                                        type="text" required>
                                        <option value="">---Select---</option>
                                        <option value="2">Bkash</option>
                                        <option value="3">Nagad</option>
                                        <option value="4">Due Payment</option>
                                        <option value="5">Bank</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Transaction Date</label>
                                    <input name="transaction_date" class="form-control" type="date" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Transaction Notes</label>
                                    <input name="transaction_note" class="form-control" type="text"
                                        placeholder="Enter Transaction Notes" required>
                                </div>
                                <div class="modal-footer ">
                                    <button data-bs-dismiss="modal" type="button"
                                        class="btn btn-danger">Cancel</button>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content col-md-12">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><span
                                    class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="include/client_backend.php?update_client_data=true" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-group mb-2 d-none">
                                    <input name="id" class="form-control" type="text"
                                        value="<?php echo $clid; ?>">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Fullname</label>
                                    <input name="fullname" placeholder="Enter Fullname" class="form-control"
                                        type="text">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Company</label>
                                    <input name="company" placeholder="Enter Company" class="form-control"
                                        type="text">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Phone Number</label>
                                    <input class="form-control" type="text" name="phone_number" id="phone_number"
                                        placeholder="Type Phone Number" />
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Email</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="Type Your Email" />
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Address</label>
                                    <input class="form-control" type="text" name="address" id="address"
                                        placeholder="Type Your Address" />
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Status</label>
                                    <select class="form-control" type="text" name="status">
                                        <option value="">---Select---</option>
                                        <option value="1">Active</option>
                                        <option value="0">Expire</option>
                                    </select>
                                </div>

                                <div class="modal-footer ">
                                    <button data-bs-dismiss="modal" type="button"
                                        class="btn btn-danger">Cancel</button>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'Footer.php'; ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right Sidebar -->
    <!-- /Right-bar -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#transaction_datatable").DataTable();
            $("#invoice_datatable").DataTable();
            $('select[name="invoice_id"]').on('change', function() {
                var invoiceId = $(this).val();

                if (invoiceId) {
                    $.ajax({
                        url: 'include/purchase_server.php',
                        type: 'GET',
                        data: {
                            get_invoice_data: true,
                            invoice_id: invoiceId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('input[name="total_due"]').val(response.total_due);
                            } else {
                                toastr.error(response.message);
                                $('input[name="total_due"]').val('');
                            }
                        }
                    });
                } else {
                    $('input[name="total_due"]').val('');
                }
            });

            /** Handle edit button click**/
            $(document).on('click', '.edit-btn', function() {

                var id = $(this).data('id');
                var url = "include/client_backend.php?edit_data=true&id=" + id;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        const jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            $('#editModal').modal('show');
                            $('#editModal input[name="id"]').val(jsonResponse.data.id);
                            $('#editModal input[name="fullname"]').val(jsonResponse.data
                                .fullname);
                            $('#editModal input[name="company"]').val(jsonResponse.data
                                .company);
                            $('#editModal input[name="phone_number"]').val(jsonResponse.data
                                .mobile);
                            $('#editModal input[name="email"]').val(jsonResponse.data.email);
                            $('#editModal input[name="address"]').val(jsonResponse.data
                                .address);
                            $('#editModal select[name="status"]').val(jsonResponse.data.status);
                        } else {
                            toastr.error("Error fetching data for edit: " + jsonResponse
                                .message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Error fetching data for edit!");
                    }
                });
            });


            /** Update The data from the database table **/
            $('#editModal form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                /*Get the submit button*/
                var submitBtn = form.find('button[type="submit"]');

                /*Save the original button text*/
                var originalBtnText = submitBtn.html();

                /*Change button text to loading state*/


                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                /** Use Ajax to send the delete request **/
                $.ajax({
                    type: 'POST',
                    'url': url,
                    data: formData,
                    beforeSend: function() {
                        form.find(':input').prop('disabled', true);
                    },
                    success: function(response) {
                        const jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            toastr.success(jsonResponse.message);
                            $('#editModal').modal('hide');
                            $('#editModal form')[0].reset();
                            /*Reload the page after a short delay*/
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },

                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("An error occurred. Please try again.");
                        }
                    },
                });
            });

            /**********************Paid Due Amount Script****************************/

            $('#paymentModal').on('shown.bs.modal', function() {
                if (!$('#sub_ledger_id').hasClass("select2-hidden-accessible")) {
                    $('#sub_ledger_id').select2({
                        dropdownParent: $('#paymentModal')
                    });
                }
                if (!$('#transaction_type').hasClass("select2-hidden-accessible")) {
                    $('#transaction_type').select2({
                        dropdownParent: $('#paymentModal')
                    });
                }
            });
            $('#paymentModal form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    'url': url,
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $("#paymentModal").modal('hide');
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response.message);
                        }
                    },


                    error: function(xhr, status, error) {
                        /** Handle  errors **/
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        }
                    }
                });
            });
            /*Delete Script*/
            $(document).on('click', "button[name='delete_button']", function() {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this item?")) {

                    $.ajax({
                        type: 'POST',
                        url: 'include/sale_server.php',
                        data: {
                            delete_invoice: true,
                            invoice_id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.success("Deleted successfully!");
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            toastr.error("Error deleting item! " + error);
                        }
                    });
                }
            });

        });
    </script>
</body>

</html>
