
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
                                                $totalpaid=0;
                                                // if ($pop_payment = $con->query(" SELECT `sales_price` FROM `customer_rechrg` WHERE pop_id='$auth_usr_POP_id' AND  type <> '4' ")) {
                                                //     while ($rows = $pop_payment->fetch_array()) {
                                                //         $totalpaid += $rows["sales_price"];
                                                //     }
                                                //     echo  number_format( $totalpaid);
                                                // }
                                                $total_due=$con->query("SELECT SUM(purchase_price) AS total_credit FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id' AND type='0'")->fetch_array()['total_credit'];

                                                $total_paid =$con->query("SELECT SUM(sales_price) AS total_paid FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id' AND type!='0'")->fetch_array()['total_paid'];

                                                $total_recharge_amount=$con->query("SELECT SUM(sales_price) AS total_recharge_amount FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id' AND type !='4'")->fetch_array()['total_recharge_amount'];

                                              // $current_balance=$total_recharge_amount-$total_paid;
                                               echo number_format($total_recharge_amount);
                                                ?>
                                                </span>
                                                Total Customer Recharge
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!--End col -->
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
                                                
                                                
                                                $pop_amount=$con->query("SELECT SUM(amount) AS pop_amount FROM pop_transaction WHERE pop_id='$auth_usr_POP_id'")->fetch_array()['pop_amount'] ?? 0;

                                                $total_paid =$con->query("SELECT SUM(purchase_price) AS total_paid FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id' AND type!='4'")->fetch_array()['total_paid'] ?? 0;
                                                echo  number_format($pop_amount - $total_paid);
                                                

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
                                                $stotalpaid = 0;
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
                                                    $totalAmount = 0;
                                                    $paidAmount = 0;
                                                    if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$auth_usr_POP_id  ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $totalAmount += $rows["balance"];
                                                        }
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
                                                $stotalDupaid = 0;
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