
 
 
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
            <?php
         if (isset($page_title)) {
                if ($page_title=="Branch Dashboard") {
                    echo ' <select name="menu_select_box" id="menu_select_box" class="form-select"></select>';
                } 
                

            }    
            ?>   
        </li> 

         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="mdi mdi-account-check"></i>
                 <span>Customer </span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                <li><a href="customers_new.php">Customer List</a></li>
                <li><a href="customer_recharge.php">Customer Recharge</a></li>
                <li><a href="credit_recharge_list.php">Credit Recharge List</a></li>
                <li><a href="package_add.php">Customer Packages</a></li>
                <li><a href="pwdmissmatch.php">Password missmatch</a></li>
                <li><a href="customer_import.php">Import</a></li>
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
                <li><a href="allTickets.php"> List All Tickets </a></li>
                <li><a href="ticketsTopic.php"> Ticket Topics  </a></li>
                <li><a href="working_group.php"> Working Group  </a></li>
                <li><a href="works.php"> Works  </a></li>
            </ul>
        </li>





         <li>
             <a href="javascript: void(0);" class="has-arrow waves-effect">
                 <i class="fa fa-file"></i>
                 <span>Reports</span>
             </a>
             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="customers_payment.php">Customer Payment</a></li>
                 <li><a href="payment_history.php">Payment History</a></li>
                 <li><a href="bill_collection.php">Bill Collection</a></li>
                 <li><a href="cash_collection.php">Cash Collection</a></li>
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
                 <li><a href="sms_report.php">Report</a></li>
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