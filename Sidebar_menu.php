 <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">


                            <li>
                                <a href="index.php" class="waves-effect">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <li >
                                
                                <?php if (!(isset($page_title) && $page_title === 'Tickets') && isset($_SESSION['details']['role']) && ($_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role'] == 'Staff' || $_SESSION['details']['role'] == 'Supports')): ?>
                                    <select name="menu_select_box" id="menu_select_box" class="form-select"></select>
                                <?php endif; ?>

                            </li> 
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Staff' || $_SESSION['details']['role']=='Supports'): ?>  
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-check"></i>
                                    <span>Customer </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="customers_new.php">Customer List</a></li>
                                    <li>
                                        <a href="con_request.php">Connection Request 
                                            <?php 
                                                if ($allCstmr=$con->query("SELECT * FROM customer_request WHERE status=0")) {
                                                    if ($allCstmr->num_rows > 0) {
                                                        echo '<span class="badge rounded-pill bg-danger float-end">'.$allCstmr->num_rows.'<span>';
                                                    }else{

                                                    }
                                                }



                                                 ?>
                                        </a>
                                    </li>
                                    <!-- <li><a href="customer_dues.php">Customer Unpaid</a></li> -->
                                    <li><a href="customer_recharge.php">Customer Recharge</a></li>
                                    <li><a href="credit_recharge_list.php">Credit Recharge List</a></li>
                                    <li><a href="package_add.php">Customer Packages</a></li>
                                    <li><a href="pwdmissmatch.php">Password missmatch</a></li>
                                    <li><a href="customer_import.php">Import</a></li>
                                    <!-- <li><a href="area.php">Area</a></li> -->
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Supports'): ?>  
                           
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-antenna"></i>
                                        <span>Pop/Area Mgt</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="pop_branch.php">Pop Branch</a></li>
                                        <li><a href="pop_area.php">Pop Area</a></li>
                                        <li><a href="area_house_no.php">House/Holding/Building</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Supports'): ?>     
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
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Staff' || $_SESSION['details']['role']=='Supports'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fas fa-ticket-alt"></i>
                                    <span>Tickets</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="allTickets.php"> List All Tickets </a></li>
                                    <li><a href="ticketsTopic.php"> Ticket Topics  </a></li>
									<li><a href="working_group.php"> Working Group  </a></li>
                                    <li><a href="works.php"> Works  </a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Accounts'): ?> 
                           <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-book"></i>
                                    <span>Accounts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ledger.php">Leger</a></li>
                                    <li><a href="transactions.php">Transactions</a></li>
                                    <li><a href="reports.php">Reports</a></li>
                                    <li><a href="balance_sheet.php">Balance Sheet</a></li>
                                    <li><a href="#">Settings</a></li>
                                    <li><a href="cash_bank.php"> Cash/Bank List </a></li>
                                    <li><a href="voucher.php">Voucher Entry</a></li>
                                    <li><a href="bill_entry.php"> Bill Entry</a></li>
                                    <li><a href="daybook.php">Daybook </a></li>
                                    <li><a href="bank_maping.php">Bank Mapping  </a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='HR & Admin'): ?> 
                           <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-book"></i>
                                    <span>HR Management</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="department.php">Department</a></li>
                                    <li><a href="shift.php">Shift</a></li>
                                    <li><a href="leave.php">Leave</a></li>
                                    <li><a href="attendance.php">Attendance</a></li>
                                    <li><a href="employee.php">Employee</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Accounts'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class=" far fa-save"></i>
                                    <span>Inventory</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="product.php">Products</a></li>
                                    <li><a href="category.php">Category</a></li>
                                    <li><a href="brand.php">Brand</a></li>
                                    <li><a href="units.php">Units</a></li>
                                    <li><a href="store.php">Store</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Accounts'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-shopping-cart"></i>
                                    <span>Sale's</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="sale.php">Sale</a></li>
                                    <li><a href="sales_invoice.php">Sale's Invoice</a></li>
                                    <li><a href="client.php">Client </a></li>
                                    <li><a href="client_tickets.php">Client Tickets</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin' || $_SESSION['details']['role']=='Accounts'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-shopping-bag"></i>
                                    <span>Purchase</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="purchase.php">Purchase</a></li>
                                    <li><a href="purchase_invoice.php">Purchase Invoice</a></li>
                                    <li><a href="supplier.php">Supplier</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                           


                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "fa fa-file"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="customers_payment.php">Customer Payment</a></li>
                                    <!-- <li><a href="recharge_filter.php">Recharge Filter</a></li> -->
                                    <li><a href="bill_collection.php">Bill Collection</a></li>
                                    <li><a href="cash_collection.php">Cash Collection</a></li>
                                    <!-- <li><a href="mobile_banking.php">Mobile Banking Log</a></li>
                                    <li><a href="bkash_search.php">bKash Search</a></li> -->
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin'): ?> 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class= "far fa-envelope"></i>
                                    <span>SMS</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="message_template.php">Message Templates</a></li>
                                    <li><a href="send_message.php">Send SMS </a></li>
                                    <li><a href="sms_schedule.php">Schedule</a></li>
                                    <li><a href="sms_settings.php">Settings</a></li>
                                    <li><a href="sms_report.php">Report</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin'): ?> 
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
                            <?php endif; ?>
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin'): ?> 
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
                            <?php endif; ?> 
                            <?php if (isset($_SESSION['details']['role']) && $_SESSION['details']['role'] == 'Super Admin'): ?> 
                               <li>
                                    <a href="company.php" class="waves-effect">
                                        <i class="mdi mdi-domain"></i>
                                        <span> Company </span>
                                    </a>
                                </li>


                            <?php endif; ?>
                        </ul>
                    </div>