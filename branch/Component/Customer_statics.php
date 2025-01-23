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
                                
                                echo count(get_filtered_customers('online', $area_id = null, $pop_id = $auth_usr_POP_id, $con));
                                
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
                                echo count(get_filtered_customers('offline', $area_id = null, $pop_id = $auth_usr_POP_id, $con));
                                
                                ?>
                            </span>
                            <img src="images/icon/disabled.png" height="10" width="10" />&nbsp;Offline
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
                                
                                echo count(get_filtered_customers('active', $area_id = null, $pop_id = $auth_usr_POP_id, $con));
                                
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
                        <span class="mini-stat-icon bg-danger me-0 float-end"><i
                                class="fas fa-exclamation-triangle"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter text-danger">
                                <?php
                                echo count(get_filtered_customers('expired', $area_id = null, $pop_id = $auth_usr_POP_id, $con));
                                
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
                        <span class="mini-stat-icon bg-secondary  me-0 float-end"><i
                                class="fas fa-user-slash"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter text-teal">
                                <?php
                                echo count(get_filtered_customers('disabled', $area_id = null, $pop_id = $auth_usr_POP_id, $con));
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
