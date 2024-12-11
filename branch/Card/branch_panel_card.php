<div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-primary  me-0 float-end"><i class="fas fa-user-check"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-green">
                                                <?php
                                                $sql = "SELECT radacct.username FROM radacct
                                                INNER JOIN customers
                                                ON customers.username=radacct.username
                                                
                                                WHERE customers.pop='$auth_usr_POP_id' AND radacct.acctstoptime IS NULL";
                                                $countpoponlnusr = mysqli_query($con, $sql);

                                                echo $countpoponlnusr->num_rows;
                                                


                                                ?>
                                            </span>
                                            Online
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <a href="customers_new.php">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-success me-0 float-end"><i class=" fas fa-users"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-success">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM customers WHERE  pop=$auth_usr_POP_id AND status='1'")) {
                                                        echo  $totalCustomer->num_rows;
                                                    }

                                                    ?>
                                                </span>
                                                Active Customers
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> <!--End col -->
                       
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="customer_expire.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-danger me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php
                                                    
                                                    $todayDate=date('Y-m-d');
                                                     if ($AllExcstmr = $con->query("SELECT * FROM customers WHERE expiredate < NOW() AND user_type=$auth_usr_type AND pop=$auth_usr_POP_id")) {
                                                        echo  $AllExcstmr->num_rows;
                                                    }

                                                    ?>

                                                </span>
                                                Expired
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                            <a href="customer_disabled.php">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-secondary  me-0 float-end"><i class="fas fa-user-slash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0' AND pop=$auth_usr_POP_id")) {
                                                    echo  $dsblcstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Disabled
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div><!--end col -->
                    </div> <!-- end row-->
                    <div class="row">
                       
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="payment_history.php">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                                    class="mdi mdi-currency-bdt fa-2x text-gray-300"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                <?php
                                                if ($pop_payment = $con->query(" SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$auth_usr_POP_id' ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $currentBal += $rows["balance"];
                                                    }
                                                    if ($pop_payment = $con->query(" SELECT `purchase_price` FROM `customer_rechrg` WHERE pop_id='$auth_usr_POP_id' ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $totalpaid += $rows["purchase_price"];
                                                        }
                                                        echo  $currentBal - $totalpaid;
                                                    }
                                                }

                                                ?>
                                                </span>
                                                Current Balance
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!--End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card ">
                                <a href="payment_history.php">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-success me-0 float-end"> <i class="mdi mdi-currency-bdt fa-2x text-white-300"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                            <?php

                                                if ($pop_payment = $con->query(" SELECT `paid_amount` FROM `pop_transaction` WHERE pop_id='$auth_usr_POP_id' ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $stotalpaid += $rows["paid_amount"];
                                                    }
                                                    echo $stotalpaid;
                                                }
                                                ?>
                                            </span>
                                            Total Paid
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div><!--end col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="payment_history.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-danger me-0 float-end">  <i class="mdi mdi-currency-bdt fa-2x text-gray-300"></i>
                                            </span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php
                                                    
                                                    if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$auth_usr_POP_id  ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $totalAmount += $rows["balance"];
                                                        }
                                                        $totalAmount;
                                                    }
    
                                                    if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$auth_usr_POP_id  ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $paidAmount += $rows["amount"];
                                                        }
                                                    }
                                                    echo $totalAmount - $paidAmount;
                                                    ?>

                                                </span>
                                                Total Due
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- End col -->
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card ">
                                <a href="payment_history.php">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-success me-0 float-end"> <i class="mdi mdi-currency-bdt fa-2x text-white-300"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                            <?php

                                                if ($pop_dupayment = $con->query(" SELECT paid_amount FROM pop_transaction WHERE pop_id='$auth_usr_POP_id' AND transaction_type='5' ")) {
                                                    while ($rowsdp = $pop_dupayment->fetch_array()) {
                                                        $stotalDupaid += $rowsdp['paid_amount'];
                                                    }
                                                    echo $stotalDupaid;
                                                }
                                                ?>
                                            </span>
                                            Due Paid
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card ">
                                <a href="allTickets.php">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-warning me-0 float-end"><i class="fas fa-notes-medical"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id")) {
                                                    echo  $dsblcstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Tickets
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div><!--end col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="pop_area.php">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                                    class="fas fa-search-location"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM area_list WHERE pop_id='$auth_usr_POP_id' ")) {
                                                        echo $totalCustomer->num_rows;
                                                    }
                                                    
                                                    ?>
                                                </span>
                                                Area
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!--End col -->
                    </div>