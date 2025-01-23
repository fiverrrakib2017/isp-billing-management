<div class="row">
                        <div class="col">
                            <div class="card">
                            <a href="customers_new.php?online=1&pop_id=<?php echo $auth_usr_POP_id; ?>">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-primary  me-0 float-end"><i class="fas fa-user-check"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-green">
                                                <?php
                             
                                                echo count(get_filtered_customers('online',$area_id=null,$pop_id=$auth_usr_POP_id,$con));


                                                ?>
                                            </span>
                                            Online
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col">
                            <div class="card">
							<a href="customers_new.php?offline=1&pop_id=<?php echo $auth_usr_POP_id; ?>">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-secondary me-0 float-end"><i
                                                class="fas fa-user-times"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-muted">
                                                <?php
												  echo count(get_filtered_customers('offline',$area_id=null,$pop_id=$auth_usr_POP_id,$con));
												
												
                                                ?>
                                            </span>
                                            <img src="images/icon/disabled.png" height="10" width="10"/>&nbsp;Offline
                                        </div>
                                    </div>
                                </div>
								</a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col">
                            <a href="customers_new.php?active=1&pop_id=<?php echo $auth_usr_POP_id; ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-success me-0 float-end"><i class=" fas fa-users"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-success">
                                                    <?php 
                                                    
                                                    echo count(get_filtered_customers('active',$area_id=null,$pop_id=$auth_usr_POP_id,$con));

                                                    ?>
                                                </span>
                                                Active Customers
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> <!--End col -->
                       
                        <div class="col">
                            <div class="card">
                            <a href="customers_new.php?expired=1&pop_id=<?php echo $auth_usr_POP_id; ?>">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-danger me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php
                                                      echo count(get_filtered_customers('expired',$area_id=null,$pop_id=$auth_usr_POP_id,$con));

                                                    ?>

                                                </span>
                                                Expired
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col">
                            <div class="card">
                            <a href="customers_new.php?disabled=1&pop_id=<?php echo $auth_usr_POP_id; ?>">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-secondary  me-0 float-end"><i class="fas fa-user-slash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php 
                                                 echo count(get_filtered_customers('disabled',$area_id=null,$pop_id=$auth_usr_POP_id,$con));
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
                                                        echo  number_format($currentBal - $totalpaid);
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
                                                    echo number_format($stotalpaid);
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
                                                    echo number_format( $totalAmount - $paidAmount);
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
                                                    echo number_format($stotalDupaid);
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