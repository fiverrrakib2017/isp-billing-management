<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="addproductModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="card">
                    <form action="#" id="productForm" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Product Name</label>
                                        <input type="text"  class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Brand</label>
                                        <select id="brand_id" class="form-select"
                                            name="brand" required style="width: 100%;">
                                            <option value="">---Select---</option>
                                            <?php 
                                                if ($category = $con-> query("SELECT * FROM product_brand")) {
                                                    while($rows= $category->fetch_array()){

                                                    $id=$rows["id"];
                                                    
                                                        $name = $rows["name"];
                                                        
                                                        echo '<option value='.$id.'>'.$name.'</option>';
                                                    }
                                                }
                                                
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Category</label>
                                        <select id="category" class="form-select" name="category" style="width: 100%;" required>
                                        <option value="">---Select---</option>
                                        <?php 
                                            if ($category = $con-> query("SELECT * FROM product_cat")) {
                                                while($rows= $category->fetch_array()){

                                                $id=$rows["id"];
                                                
                                                    $name = $rows["name"];
                                                    
                                                    echo '<option value='.$id.'>'.$name.'</option>';
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
                                        <select id="purchase_ac" type="text" class="form-control"name="purchase_ac" required style="width: 100%;">
                                        <?php
                                    if ($ledgr = $con->query("SELECT * FROM ledger Where `mstr_ledger_id`=2")) {
                                        echo '<option value="">Select</option>';

                                        while ($rowsitm = $ledgr->fetch_array()) {
                                            $ldgritmsID = $rowsitm["id"];
                                            $ledger_name = $rowsitm["ledger_name"];

                                            echo '<optgroup label="' . $ledger_name . '">';


                                            // Sub Ledger items list
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {


                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    $sub_ldgrid = $rowssb["id"];
                                                    $ldgr_items = $rowssb["item_name"];

                                                    echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
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
                                        <select type="text" id="sales_ac" class="form-control" name="sales_ac" required style="width: 100%;">
                                    <?php
                                    if ($ledgr = $con->query("SELECT * FROM ledger Where `mstr_ledger_id`=1")) {
                                        echo '<option value="">Select</option>';

                                        while ($rowsitm = $ledgr->fetch_array()) {
                                            $ldgritmsID = $rowsitm["id"];
                                            $ledger_name = $rowsitm["ledger_name"];

                                            echo '<optgroup label="' . $ledger_name . '">';


                                            // Sub Ledger items list
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {


                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    $sub_ldgrid = $rowssb["id"];
                                                    $ldgr_items = $rowssb["item_name"];

                                                    echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
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
                                        <label>Units</label>
                                        <select type="text" id="unit_id" class="form-select" name="unit_id" required style="width: 100%;">
                                    <?php
                                    if ($all_data = $con->query("SELECT id,unit_name FROM units")) {
                                        echo '<option value="">Select</option>';

                                        while ($rowsitm = $all_data->fetch_array()) {
                                            $unit_id = $rowsitm["id"];
                                            $unit_name = $rowsitm["unit_name"];

                                            echo '<option value="' . $unit_id . '">' . $unit_name . '</option>';

                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>
                                </div>            
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Purchase Price</label>
                                        <input type="number" class="form-control" id="p_price"  name="p_price" placeholder="Enter Your Price" required/>
                                    </div>
                                </div>            
                                
                            </div>


                            


                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Sale's Price</label>
                                        <input type="number" class="form-control" id="s_price"  name="s_price" placeholder="Enter Your Sale's Price" required/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Store</label>
                                        <select id="store" class="form-select" name="store" style="width: 100%;">
                                            <option value="">---Select---</option>
                                            <?php 
                                                if ($store = $con-> query("SELECT * FROM store")) {
                                                    while($rows= $store->fetch_array()){

                                                        $id=$rows["id"];
                                                    
                                                        $name = $rows["name"];
                                                        
                                                        echo '<option value='.$id.'>'.$name.'</option>';
                                                    }
                                                }
                                                
                                                ?>
                                                    

                                                </select>       
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Remarks</label>
                                        <input type="text" class="form-control" id="note"  name="note" placeholder="Enter Your Note" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Quantity</label>
                                        <input type="text" class="form-control" id="qty"  name="qty" placeholder="Enter Quantity" />
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-footer">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
                            <button type="submit" id="addProductBtn" class=" btn btn-success">Add Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
