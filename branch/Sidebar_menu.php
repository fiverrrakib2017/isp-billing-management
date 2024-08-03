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
                 <li><a href="active_cstmr_list.php">Active Customer List</a></li>
                 <li><a href="customer_expire.php">Expired Customer List</a></li>
                 <li><a href="customer_recharge.php">Customer Recharge</a></li>
                 <li><a href="customer_dues.php">Customer Dues/Unpaid</a></li>
                 <li><a href="bulk_payment.php">Bulk Recharge</a></li>
                 <li>
                     <a href="con_request.php">Customer Request
                         <?php
                            if ($allCstmr = $con->query("SELECT * FROM customers WHERE user_type=$auth_usr_type AND pop=$auth_usr_POP_id AND status=3")) {
                                //echo $allCstmr->num_rows;
                                if ($allCstmr->num_rows > 0) {
                                    echo '<span class="badge rounded-pill bg-danger float-end">' . $allCstmr->num_rows . '<span>';
                                } else {
                                }
                            }



                            ?>

                     </a>
                 </li>
                 <li><a href="package_add.php">Package's</a></li>
             </ul>
         </li>

         <li>
             <a href="pop_area.php" class="waves-effect">
                 <i class="mdi mdi-antenna"></i>
                 <span> Services Area </span>
             </a>
         </li>
         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="mdi mdi-ticket-outline"></i>
                 <span>Tickets</span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="allTickets.php">Tickets List</a></li>
                 <li><a href="ticketsTopic.php"> Ticket Topics </a></li>
             </ul>
         </li>





         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="fa fa-file"></i>
                 <span>Reports</span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="customers_payment.php">Customer Recharge</a></li>
                 <li><a href="recharge_filter.php">Recharge Filter</a></li>
                 <li><a href="payment_history.php">Payment History</a></li>
                 <li><a href="mobile_banking.php">Mobile Banking Log</a></li>
             </ul>
         </li>
         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="far fa-envelope"></i>
                 <span>SMS</span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="message_template.php">Message Templates</a></li>
                 <li><a href="send_message.php">Send SMS </a></li>
                 <li><a href="summery_reports.php">Summary Report</a></li>
             </ul>
         </li>
         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="fas fa-user-friends"></i>
                 <span>Users</span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="users.php">User List</a></li>
             </ul>
         </li>
     </ul>
 </div>