
<header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.php" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="index.php" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="36">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="d-none d-sm-block ms-2">
                        <h4 class="page-title"> 
                            <?php echo isset($page_title) ? $page_title : 'Welcome To Dashboard'; ?>
                        </h4>
                    </div>
                </div>



                <div class="d-flex">
                    <div class="dropdown d-none d-md-block me-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16">
                                <?php 
                                if (isset($_SESSION['fullname'])) {
                                    echo $_SESSION['fullname'];
									
                                }elseif (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                }
                                ?>
                            </span>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="http://103.146.16.154/profileImages/avatar.png" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                             <?php 
                             if(!empty($page_title=="POP/Branch")){
                                echo '<div class="profile-info">';
                                echo '<p class="profile-item"><i class="mdi mdi-marker-check"></i><strong>Fullname:</strong> '.$fullname.'</p>';
                                echo '<p class="profile-item"><i class="mdi mdi-account-circle"></i> <strong>Username:</strong> '.$username.'</p>';
                                echo '<p class="profile-item"><i class="fas fa-dollar-sign"></i> <strong>Opening Balance:</strong> '.$opening_bal.'</p>';
                                echo '<p class="profile-item"><i class="mdi mdi-phone"></i> <strong>Mobile:</strong> '.$mobile_num1.'</p>';
                                echo '<p class="profile-item"><i class="fas fa-envelope"></i> <strong>Email:</strong>'.$email_address.'</p>';
                                echo ' </div>';
                             }

                            //  if(isset($auth_usr_type)){
                            //     if ($pop_list = $con->query("SELECT * FROM add_pop WHERE id='$auth_usr_type'")) {
                            //         while ($rows = $pop_list->fetch_array()) {
                            //             $lstid = $rows['id'];
                            //             $pop_name = $rows['pop'];
                            //             $pop_status = $rows['status'];
                            //             $fullname = $rows['fullname'];
                            //             $username = $rows['username'];
                            //             $password = $rows['password'];
                            //             $opening_bal = $rows['opening_bal'];
                            //             $mobile_num1 = $rows['mobile_num1'];
                            //             $mobile_num2 = $rows['mobile_num2'];
                            //             $email_address = $rows['email_address'];
                            //             $note = $rows['note'];

                            //             echo '<div class="profile-info">';
                            //             echo '<p class="profile-item"><i class="mdi mdi-marker-check"></i><strong>Fullname:</strong> '.$fullname.'</p>';
                            //             echo '<p class="profile-item"><i class="mdi mdi-account-circle"></i> <strong>Username:</strong> '.$username.'</p>';
                            //             echo '<p class="profile-item"><i class="fas fa-dollar-sign"></i> <strong>Opening Balance:</strong> '.$opening_bal.'</p>';
                            //             echo '<p class="profile-item"><i class="mdi mdi-phone"></i> <strong>Mobile:</strong> '.$mobile_num1.'</p>';
                            //             echo '<p class="profile-item"><i class="fas fa-envelope"></i> <strong>Email:</strong>'.$email_address.'</p>';
                            //             echo ' </div>';
                            //         }
                            //     }
                            //  }
                             
                             
                             ?>
                            <a class="dropdown-item text-danger" href="logout.php"><i class="mdi mdi-power"></i> Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block me-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ion ion-md-notifications"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                <i class="mdi mdi-message-text-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-info rounded-circle font-size-16">
                                                <i class="mdi mdi-glass-cocktail"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It is a long established fact that a reader will</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <style>
.profile-info {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-item {
    margin-bottom: 10px;
    font-size: 14px;
    display: flex;
    align-items: center;
    color: #333;
}

.profile-item i {
    font-size: 18px;
    margin-right: 10px;
    color: #007bff;
}

.profile-item strong {
    color: #495057;
}

</style>