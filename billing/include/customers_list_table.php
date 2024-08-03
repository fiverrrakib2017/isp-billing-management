<?php
include("security_token.php");
include("db_connect.php");
include("pop_security.php");
include("users_right.php");

?>

    <script type="text/javascript">
	$(document).ready(function() {
		
			
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
																	
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Check All <input type="checkbox" id="checkedAll" name="checkedAll" value="Bike"></th> -->
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
												if(isset($_POST["srch_poplst"]) && isset($_POST["srch_area_id"]) && isset($_POST["customer_sttssrch"]))
												{
													$srch_pop_id =$_POST["srch_poplst"];
													$srch_area_id =$_POST["srch_area_id"];
													$customer_sttssrch =$_POST["customer_sttssrch"];
													
													$status = "";
													if($customer_sttssrch=="expired")
													{
														$status = "2";														
													}
													if($customer_sttssrch=="disabled")
													{
														$status = "0";														
													}
													if($customer_sttssrch=="active")
													{
														$status = "1";														
													}
																										
												
												 if($srch_pop_id !="" && $srch_area_id=='all' && $customer_sttssrch=='all')
												 {
													 $sql = "SELECT * FROM customers WHERE pop='$srch_pop_id'";									 
												 }
												 
												 if($srch_pop_id !="" && $srch_area_id !='all' && $customer_sttssrch=='all')
												 {
													 $sql = "SELECT * FROM customers WHERE pop='$srch_pop_id' AND area='$srch_area_id'";	 
												 }
													
												// Search by status
												if($srch_pop_id !="" && $srch_area_id =='all' && $customer_sttssrch !='all')
												 {
													 $sql = "SELECT * FROM customers WHERE pop='$srch_pop_id' AND status='$status'";	 
												 }
												 // Search by status
												if($srch_pop_id !="" && $srch_area_id !='all' && $customer_sttssrch !='all')
												 {
													 $sql = "SELECT * FROM customers WHERE pop='$srch_pop_id' AND area='$srch_area_id' AND status='$status'";	 
												 }
																						


                                                //$sql = "SELECT * FROM customers WHERE pop='$current_pop_id'";
                                                
												
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
                                                        
                                                        
                                                        <a href="profile.php?clid=<?php echo $rows['id']; ?>" target="_blank"> <?php echo $rows["fullname"]; ?></a></td>
                                                        <td>
                                                            <?php

                                                            
                                                            echo  $rows["package_name"];
                                                            // if ($allData = $con->query("SELECT * FROM radgroupcheck WHERE id='$packageId'")) {
                                                            //     while ($packageName = $allData->fetch_array()) {
                                                            //         echo  $packageName['groupname'];
                                                            //     }
                                                            // }

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
                                                            <a class="btn btn-info" target="_blank" href="profile_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
                                                            <a class="btn btn-success" target="_blank" href="profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
                                                            </a>

                                                            <!-- <a href="customer_delete.php?clid=<?php echo $rows['id']; ?>" class="btn btn-danger deleteBtn" onclick=" return confirm('Are You Sure');" data-id=<?php echo $rows['id']; ?>><i class="fas fa-trash"></i>
                                                            </a> -->

                                                        </td>
                                                    </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>