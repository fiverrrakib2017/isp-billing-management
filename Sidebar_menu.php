 <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">


                            <li>
                                <a href="index.php" class="waves-effect">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-check"></i>
                                    <span>Customer </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="customers.php">Total Customer List</a></li>
                                    <li><a href="bulk_payment.php">Bulk Recharge</a></li>
                                    <li><a href="active_cstmr_list.php">Active Customer List</a></li>
                                    <li><a href="customer_expire.php">Expired Customer List</a></li>

                                    <li>
                                        <a href="con_request.php">Connection Request 
                                            <?php 
                                                if ($allCstmr=$con->query("SELECT * FROM customers WHERE user_type='1' AND status=3")) {
                                                    //echo $allCstmr->num_rows;
                                                    if ($allCstmr->num_rows > 0) {
                                                        echo '<span class="badge rounded-pill bg-danger float-end">'.$allCstmr->num_rows.'<span>';
                                                    }else{

                                                    }
                                                }



                                                 ?>
                                        </a>
                                    </li>
                                    <li><a href="customer_dues.php">Customer Dues/Unpaid</a></li>
                                    <li><a href="customer_recharge.php">Customer Recharge</a></li>
                                    <li><a href="package_add.php">Customer Packages</a></li>
                                    <li><a href="pwdmissmatch.php">Password missmatch</a></li>
                                    <li><a href="customer_import.php">Import</a></li>
                                    <!-- <li><a href="area.php">Area</a></li> -->
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-antenna"></i>
                                    <span>Pop Managment</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pop_branch.php">Pop Branch</a></li>
                                    <li><a href="pop_area.php">Pop Area</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-plus-outline"></i>
                                    <span>Customers Packages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pool.php">IP Pool</a></li>
                                    <li><a href="package.php">Packages</a></li>
                                    <li><a href="expired.php">Expired Date</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-ticket-outline"></i>
                                    <span>Tickets</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="allTickets.php"> List All Tickets </a></li>
                                    <li><a href="ticketsTopic.php"> Ticket Topics  </a></li>
									<li><a href="working_group.php"> Working Group  </a></li>
                                    <li><a href="works.php"> Works  </a></li>
                                </ul>
                            </li>

                           <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-book"></i>
                                    <span>Accounts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ledger.php">Leger</a></li>
                                    <li><a href="transactions.php">Transactions</a></li>
                                    <li><a href="reports.php">Reports</a></li>
                                    <li><a href="#">Settings</a></li>
                                    <li><a href="cash_bank.php"> Cash/Bank List </a></li>
                                    <li><a href="voucher.php">Voucher Entry</a></li>
                                    <li><a href="bill_entry.php"> Bill Entry</a></li>
                                    <li><a href="daybook.php">Daybook </a></li>
                                    <li><a href="bank_maping.php">Bank Mapping  </a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class=" far fa-save"></i>
                                    <span>Inventory</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="sale.php">Sale</a></li>
                                    <li><a href="sales_invoice.php">Sale's Invoice</a></li>
                                    <li><a href="purchase.php">Purchase</a></li>
                                    <li><a href="purchase_invoice.php">Purchase Invoice</a></li>
                                    <li><a href="product.php">Products</a></li>
                                    <li><a href="category.php">Category</a></li>
                                    <li><a href="brand.php">Brand</a></li>
                                    <li><a href="client.php">Client </a></li>
                                    <li><a href="supplier.php">Supplier</a></li>
                                </ul>
                            </li>
                            

                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "fa fa-file"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="customers_payment.php">Customer Payment</a></li>
                                    <li><a href="recharge_filter.php">Recharge Filter</a></li>
                                    <li><a href="bill_collection.php">Bill Collection</a></li>
                                    <li><a href="bill_collector.php">Bill Collector</a></li>
                                    <li><a href="mobile_banking.php">Mobile Banking Log</a></li>
                                    <li><a href="bkash_search.php">bKash Search</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "far fa-envelope"></i>
                                    <span>SMS</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="message_template.php">Message Templates</a></li>
                                    <li><a href="send_message.php">Send SMS </a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "fas fa-user-friends"></i>
                                    <span>Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="users.php">User List</a></li>
                                    <li><a href="users_log.php">Users Log</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "mdi mdi-power-settings menu-icon"></i>
                                    <span>Settings</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="nas.php">NAS</a></li>
                                      <li><a href="router_setting.php">Router Settings</a></li>
                                    <li><a href="password_change.php">Password Change</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>