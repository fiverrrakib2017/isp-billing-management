<?php
include 'include/db_connect.php';
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/pop_security.php';
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    if ($product = $con->query("SELECT * FROM products WHERE id='$productId'")) {
        while ($rows = $product->fetch_array()) {
            $id = $rows['id'];
            $pd_name = $rows['name'];
            $desc = $rows['description'];
            $category = $rows['category'];
            $brand = $rows['brand'];
            $p_ac = $rows['purchase_ac'];
            $sales_ac = $rows['sales_ac'];
            $p_price = $rows['purchase_price'];
            $s_price = $rows['sale_price'];
            $store = $rows['store'];
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
    <?= include 'style.php' ?>

</head>

<body data-sidebar="dark">




    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Product Profile';
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
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img class="img-fluid"
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSkdGbj-QrUuNqhXP7DtY3-t8yD6H1Tk4uFg&s">
                            </div>
                            <div class="card mt-3">
                                <div class="card-title text-center mt-1">
                                    <h5>About This Product</h5>
                                </div>
                                <div class="card-body">
                                    <p>this is the nast timethis is the nast timethis is the nast timethis is the nast
                                        timethis is the nast timethis is the nast timethis is the nast time</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Name:</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $pd_name; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Category</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php
                                            
                                            if ($categories = $con->query("SELECT * FROM product_cat WHERE id= '$category' ")) {
                                                while ($row = $categories->fetch_array()) {
                                                    echo $row['name'];
                                                }
                                            }
                                            
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Brand</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php
                                            if ($brands = $con->query("SELECT * FROM product_brand WHERE id= '$brand' ")) {
                                                while ($row = $brands->fetch_array()) {
                                                    echo $row['name'];
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Purchase Account No:</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE id='$p_ac'")) {
                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    echo $rowssb['item_name'];
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sales Account:</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE id='$sales_ac'")) {
                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    echo $rowssb['item_name'];
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Purchase Price:</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $p_price; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sale's Price:</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $s_price; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Store</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php
                                            if ($allstore = $con->query("SELECT `name` FROM store WHERE id='$store'")) {
                                                while ($rowssb = $allstore->fetch_array()) {
                                                    echo $rowssb['name'];
                                                }
                                            }
                                            
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                            <!-- Nav tabs -->
                                             <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                                <li class="nav-item">
                                                   <button class="nav-link active" data-bs-toggle="tab" href="#purchase_history" role="tab">
                                                   <span class="d-none d-md-block">Purchase History</span><span class="d-block d-md-none">Purchase History</span>
                                                   </button>
                                                </li>
                                                <li class="nav-item">
                                                   <button class="nav-link" data-bs-toggle="tab" href="#sales_history" role="tab">
                                                   <span class="d-none d-md-block">Sales History
                                                   </span><span class="d-block d-md-none">Sales History</span>
                                                   </button>
                                                </li>
                                             </ul>
                                             <!-- Tab panes -->
                                             <div class="tab-content">
                                                <div class="tab-pane p-3 tab-pane p-3 active" id="purchase_history" role="tabpanel">
                                                    <div class="table table-responsive">
                                                    <table id="purchase_history_table" class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice id</th>
                                                                <th>Supplier Name</th>
                                                                <th>Sub Total</th>
                                                                <th>Discount</th>
                                                                <th>Total Due</th>
                                                                <th>Grand Total</th>
                                                                <th>Status</th>
                                                                <th>Invoice Date</th>
                                                                <th>Create Date</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                        $sales_invoices = $con->query("SELECT * FROM purchase_details WHERE product_id='$productId'");
                        while ($row = $sales_invoices->fetch_assoc()) {
                           $purchase_invoice_id=$row['invoice_id'];
                           $query = "SELECT * FROM purchase WHERE id=$purchase_invoice_id";
                           $result = mysqli_query($con, $query);
                           if (mysqli_num_rows($result) > 0) {
                               while ($rows = mysqli_fetch_assoc($result)) {
                                   echo "<tr>";
                                   echo "<td>" . $rows['id'] . "</td>";
                                   echo "<td>";
                       
                                   $client_id = $rows['client_id'];
                                   $allCustomerData = $con->query("SELECT * FROM suppliers WHERE id=$client_id");
                                   while ($client_loop = $allCustomerData->fetch_array()) {
                                       echo '<a href="supplier_profile.php?clid=' . $client_id . '" >' . $client_loop['fullname'] . '</a>';
                                   }
                       
                                   echo "</td>";
                                   echo "<td>" . $rows['sub_total'] . "</td>";
                                   echo "<td>" . $rows['discount'] . "</td>";
                                   echo "<td>" . $rows['total_due'] . "</td>";
                                   echo "<td>" . $rows['grand_total'] . "</td>";
                                   $status_badge = ($rows['status'] == '1') ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-danger">Draft Invoice</span>';
                                   echo "<td>" . $status_badge . "</td>";
                                   echo "<td>";
                       
                                   $date = $rows['date'];
                                   $formatted_date = date("d F Y", strtotime($date));
                                   echo $formatted_date;
                       
                                   echo "</td>";
                       
                                   echo "<td>" . (!empty($rows['created_at']) ? date("d F Y", strtotime($rows['created_at'])) : $rows['created_at']) . "</td>";
                       
                       
                                   echo "<td>";
                       
                                   echo '<a class="btn-sm btn btn-success" style="margin-right: 5px;" href="invoice/purchase_inv_view.php?clid=' . $rows['id'] . '"><i class="fas fa-eye"></i></a>';
                                 
                       
                                   echo "</td>";
                                   echo "</tr>";
                               }
                           } 
                        }
                        ?>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-3" id="sales_history" role="tabpanel">
                                                    <div class="table table-responsive">
                                                    <table id="sales_history_table" class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                            <th>Invoice id</th>
                                                            <th>Customer Name</th>
                                                            <th>Sub Total</th>
                                                            <th>Paid Amount</th>
                                                            <th>Discount</th>
                                                            <th>Due Balance</th>
                                                            <th>Grand Total</th>
                                                            <th>Status</th>
                                                            <th>Invoice Date</th>
                                                            <th>Create Date</th>
                                                            <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                        $sales_invoices = $con->query("SELECT * FROM sales_details WHERE product_id='$productId'");
                        while ($row = $sales_invoices->fetch_assoc()) {
                           $sales_invoice_id=$row['invoice_id'];
                           $query = "SELECT * FROM sales WHERE id=$sales_invoice_id";

                           
                           $result = mysqli_query($con, $query);
                       
                           if (mysqli_num_rows($result) > 0) {
                               while ($rows = mysqli_fetch_assoc($result)) {
                                   echo "<tr>";
                                   echo "<td>" . $rows['id'] . "</td>";
                                   echo "<td>";
                       
                                   $client_id = $rows['client_id'];
                                   $allCustomerData = $con->query("SELECT * FROM clients WHERE id=$client_id");
                                   while ($client_loop = $allCustomerData->fetch_array()) {
                                       echo '<a href="client_profile.php?clid=' . $client_id . '" >' . $client_loop['fullname'] . '</a>';
                                   }
                       
                                   echo "</td>";
                                   echo "<td>" . $rows['sub_total'] . "</td>";
                                   echo "<td>" . $rows['total_paid'] . "</td>";
                                   echo "<td>" . $rows['discount'] . "</td>";
                                   echo "<td>" . $rows['total_due'] . "</td>";
                                   echo "<td>" . $rows['grand_total'] . "</td>";
                                 
                                   $status_badge = ($rows['status'] == '1') ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-danger">Draft Invoice</span>';
                                   echo "<td>" . $status_badge . "</td>";
                                   echo "<td>";
                       
                                   $date = $rows['date'];
                                   $formatted_date = date("d F Y", strtotime($date));
                                   echo $formatted_date;
                       
                                   echo "</td>";
                       
                                   echo "<td>" . (!empty($rows['created_at']) ? date("d F Y", strtotime($rows['created_at'])) : $rows['created_at']) . "</td>";
                       
                                   echo "<td>";
                                  
                                   echo '<a class="btn-sm btn btn-success" style="margin-right: 5px;" href="invoice/sales_inv_view.php?clid=' . $rows['id'] . '"><i class="fas fa-eye"></i></a>';
                       
                                   echo "</td>";
                                   echo "</tr>";
                               }
                           } 
                           
                        }
                        ?>
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
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php include 'Footer.php'; ?>

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <?php include 'script.php'; ?>
    <script type="text/javascript">
        $("#purchase_history_table").DataTable();
        $("#sales_history_table").DataTable();

        $(document).ready(function() {
            $("#update_button").click(function(e) {
                e.preventDefault();
                var formData = $("#update_product").serialize();
                $.ajax({
                    type: "GET",
                    url: "include/product.php?update",
                    data: formData,
                    cache: false,
                    success: function() {
                        $("#alertMsg").show();
                        setTimeout(function() {
                            $("#alertMsg").hide();
                        }, 5000);
                    }
                });
            });
        });
    </script>

</body>

</html>
