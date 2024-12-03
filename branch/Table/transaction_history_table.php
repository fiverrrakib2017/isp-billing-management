<div class="table-responsive">
                                        <table id="transaction_datatable"
                                            class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Recharge Amount</th>
                                                    <th>Paid Amount</th>
                                                    <th>Action</th>
                                                    <th>Transaction Type</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                        $sql = "SELECT * FROM pop_transaction WHERE pop_id='$auth_usr_POP_id' ORDER BY id DESC";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                        <tr>
                                                            <td><?php echo $rows['id']; ?></td>
                                                            <td> <?php echo $rows['amount']; ?></td>
                                                            <td> <?php echo $rows['paid_amount']; ?></td>


                                                            <td>
                                                                <?php
                                                                $transaction_action = $rows['action'];
                                                                $transaction_type = $rows['transaction_type'];
                                                                
                                                                if ($transaction_action == 'Recharge' && $transaction_type == '1') {
                                                                    echo '<span class="badge bg-danger">Recharged</span> <br> <span class="badge bg-success">Paid</span>';
                                                                } elseif ($transaction_action == 'Recharge' && $transaction_type == '0') {
                                                                    echo '<span class="badge bg-danger">Recharged </span>';
                                                                } elseif ($transaction_action == 'paid') {
                                                                    echo '<span class="badge bg-success">Paid</span>';
                                                                } elseif ($transaction_action == 'Return') {
                                                                    echo '<span class="badge bg-warning">Return</span>';
                                                                }
                                                                 elseif ($transaction_action == 'Recharge' && $transaction_type == '2') {
                                                                    echo '<span class="badge bg-danger">Recharged</span> <br> <span class="badge bg-success">Paid</span>';
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $transaction_type = $rows['transaction_type'];
                                                                if ($transaction_type == 1) {
                                                                    echo '<button class="btn-sm btn btn-outline-success">Cash</button>';
                                                                } elseif ($transaction_type == 0) {
                                                                    echo '<button class="btn-sm btn btn-outline-danger">Credit</button>';
                                                                } elseif ($transaction_type == 2) {
                                                                    echo '<button class="btn-sm btn btn-outline-success">Bkash</button>';
                                                                } elseif ($transaction_type == 3) {
                                                                    echo 'Nagad';
                                                                } elseif ($transaction_type == 4) {
                                                                    echo 'Bank';
                                                                } elseif ($transaction_type == 5) {
                                                                    echo '<button class="btn-sm btn btn-outline-primary">Payment Rcvd</button>';
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            <td> <?php echo $rows['date']; ?></td>
                                                        </tr>
                                                        <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>