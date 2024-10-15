<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    if ($product = $con->query("SELECT * FROM products WHERE id='$userId'")) {
        while ($rows = $product->fetch_array()) {
            $id = $rows["id"];
            $pd_name = $rows["name"];
            $category = $rows["category"];
            $brand = $rows["brand"];
            $p_ac = $rows["purchase_ac"];
            $sales_ac = $rows["sales_ac"];
            $unitId = $rows["unit_id"];
            $p_price = $rows["purchase_price"];
            $s_price = $rows["sale_price"];
            $store = $rows["store"];
            $note = $rows["note"];
            $qty = $rows['qty'];
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
        <?php include 'style.php';?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
          <?php $page_title="Product Update"; include 'Header.php';?>


        
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
                                    <p class="text-primary mb-0 hover-cursor">Product/Update</p>
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
                            <form action="include/product_server.php?update_product" id="productUpdateForm" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo $id; ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Product Name -->
                                            <div class="form-group mb-4">
                                                <label for="product_name">Product Name</label>
                                                <input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $pd_name; ?>" placeholder="Enter Product Name" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                           <!-- Brand -->
                                            <div class="form-group mb-4">
                                                <label for="brand_id">Brand</label>
                                                <select id="brand_id" class="form-select" name="brand" required>
                                                    <option value="">---Select---</option>
                                                    <?php 
                                                        if ($brands = $con->query("SELECT * FROM product_brand")) {
                                                            while($row = $brands->fetch_array()){
                                                                $selected = ($row['id'] == $brand) ? 'selected' : '';

                                                                echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mb-4">
                                                <label for="">Category</label>
                                                <select id="category" class="form-select" name="category" required>
                                                <option value="">---Select---</option>
                                                <?php 
                                                    if ($categories = $con->query("SELECT * FROM product_cat")) {
                                                        while($row = $categories->fetch_array()){
                                                            $selected = ($row['id'] == $category) ? 'selected' : '';
                                                            echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                                                        }
                                                    }
                                                ?>
                                                        

                                                    </select>
                                            </div>
                                        </div>
                                    </div>

                                

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label>Purchase A/C</label>
                                            <select id="purchase_ac" type="text" class="form-control"name="purchase_ac" required>
            <?php
                if ($ledgr = $con->query("SELECT * FROM ledger WHERE `mstr_ledger_id`=2")) {
                    echo '<option value="">Select</option>';
                    while ($rowsitm = $ledgr->fetch_array()) {
                        $ldgritmsID = $rowsitm["id"];
                        $ledger_name = $rowsitm["ledger_name"];
                        echo '<optgroup label="' . $ledger_name . '">';
                        if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {
                            while ($rowssb = $ledgrsubitm->fetch_array()) {
                                $selected = ($rowssb['id'] == $p_ac) ? 'selected' : '';
                                echo '<option value="' . $rowssb['id'] . '" '.$selected.'>' . $rowssb['item_name'] . '</option>';
                            }
                        }
                        echo '</optgroup>';
                    }
                }
            ?>
                                            </select>
                                        </div>
                                    </div>            
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label>Sales Account</label>
                                            <select type="text" id="sales_ac" class="form-control" name="sales_ac" required>
                <?php
                    if ($ledgr = $con->query("SELECT * FROM ledger WHERE `mstr_ledger_id`=1")) {
                        echo '<option value="">Select</option>';
                        while ($rowsitm = $ledgr->fetch_array()) {
                            $ldgritmsID = $rowsitm["id"];
                            $ledger_name = $rowsitm["ledger_name"];
                            echo '<optgroup label="' . $ledger_name . '">';
                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {
                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                    $selected = ($rowssb['id'] == $sales_ac) ? 'selected' : '';
                                    echo '<option value="' . $rowssb['id'] . '" '.$selected.'>' . $rowssb['item_name'] . '</option>';
                                }
                            }
                            echo '</optgroup>';
                        }
                    }
                ?>
                                            </select>
                                        </div>
                                    </div>            
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label>Unit</label>
                                            <select type="text" id="unit_id" class="form-select" name="unit_id" style="width: 100%;" required>
                                            <?php
                                                if ($all_data = $con->query("SELECT id,unit_name FROM units")) {
                                                    echo '<option value="">Select</option>';

                                                    while ($rowsitm = $all_data->fetch_array()) {
                                                        $unit_id = $rowsitm["id"];
                                                        $unit_name = $rowsitm["unit_name"];
                                                        $selected = ($rowsitm['id'] == $unitId) ? 'selected' : '';
                                                        echo '<option ' . $selected . ' value="' . $unit_id . '">' . $unit_name . '</option>';

                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>            
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label for="">Purchase Price</label>
                                            <input type="number" class="form-control" id="p_price" name="p_price" value="<?php echo $p_price; ?>" placeholder="Enter Purchase Price" required/>
                                        </div>
                                    </div>            
                                    
                                </div>


                                


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label for="">Sale's Price</label>
                                            <input type="number" class="form-control" id="s_price" name="s_price" value="<?php echo $s_price; ?>" placeholder="Enter Sale's Price" required/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label for="">Store</label>
                                            <select id="store" class="form-select" name="store">
                                                <option value="">---Select---</option>
                                                <?php 
                                                    if ($stores = $con->query("SELECT * FROM store")) {
                                                        while($row = $stores->fetch_array()){
                                                            $selected = ($row['id'] == $store) ? 'selected' : '';
                                                            echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                                                        }
                                                    }
                                                ?>
                                                        

                                                    </select>       
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label for="">Remarks</label>
                                            <input type="text" class="form-control" id="note"  name="note" placeholder="Enter Your Note" value="<?php echo $note; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label for="">Quantity</label>
                                            <input type="text" class="form-control" id="qty"  name="qty" placeholder="Enter Quantity" value="<?php echo $qty; ?>"/>
                                        </div>
                                    </div>
                                </div>



                                </div>
                                <div class="card-footer">
                                    <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                                    <button type="submit" class=" btn btn-success">Update Now</button>
                                </div>
                                </form>
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

       

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
   <?php include 'script.php';?>
    <script type="text/javascript">
       $("#brand_id").select2();
       $("#category").select2();
       $("#sales_ac").select2();
       $("#purchase_ac").select2();
       $("#unit_id").select2();
       
    /** Store The data from the database table **/
        $(document).ready(function(){
            $('#productUpdateForm').on('submit', function(e){
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            toastr.success(result.message);
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function() {
                        toastr.error("Error occurred during the request.");
                    }
                });
            });
        });
 
    </script>

    </body>
</html>
