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
                    </div>