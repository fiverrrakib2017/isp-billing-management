<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'OLT Device List';
        include 'Header.php'; ?>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <?php include 'Sidebar_menu.php'; ?>

                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">
                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">OLT Device List</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <!-- <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;Create New Onu</button> -->



                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="row">

                                <?php
                                $devices = [
                                    [
                                        'id' => 1,
                                        'name' => 'Huawei OLT 1234',
                                        'ip' => '192.168.1.100',
                                        'status' => 'active',
                                        'brand' => 'Huawei',
                                        'model' => 'HG8245H',
                                        'location' => 'Dhaka',
                                        'cpu' => 55,
                                        'ram' => 70,
                                    ],
                                
                                    [
                                        'id' => 2,
                                        'name' => 'ZTE OLT 5678',
                                        'ip' => '192.168.1.101',
                                        'status' => 'inactive',
                                        'brand' => 'ZTE',
                                        'model' => 'ZXA10',
                                        'location' => 'Chittagong',
                                        'cpu' => 30,
                                        'ram' => 45,
                                    ],
                                
                                    [
                                        'id' => 3,
                                        'name' => 'Fiberhome OLT 9012',
                                        'ip' => '192.168.1.102',
                                        'status' => 'maintenance',
                                        'brand' => 'Fiberhome',
                                        'model' => 'AN5506-04',
                                        'location' => 'Khulna',
                                        'cpu' => 80,
                                        'ram' => 60,
                                    ],
                                
                                    [
                                        'id' => 4,
                                        'name' => 'Viewsonic OLT 9012',
                                        'ip' => '192.168.1.102',
                                        'status' => 'active',
                                        'brand' => 'Fiberhome',
                                        'model' => 'AN5506-04',
                                        'location' => 'Cumilla',
                                        'cpu' => 80,
                                        'ram' => 60,
                                    ],
                                ];
                                ?>
                                <?php 
                                    foreach ($devices as $device):
                                        $cardClass = 'bg-secondary';
                                        if ($device['status'] == 'active') {
                                            $cardClass = 'bg-success';
                                        } elseif ($device['status'] == 'inactive') {
                                            $cardClass = 'bg-danger';
                                        } elseif ($device['status'] == 'maintenance') {
                                            $cardClass = 'bg-warning';
                                        }

                                        $badgeClass = 'badge-secondary';
                                        if ($device['status'] == 'active') {
                                            $badgeClass = 'bg-success';
                                        } elseif ($device['status'] == 'inactive') {
                                            $badgeClass = 'bg-danger';
                                        } elseif ($device['status'] == 'maintenance') {
                                            $badgeClass = 'bg-warning';
                                        }
                                    ?>

                                <div class="col-md-6">
                                    <div class="card ">
                                        <div class="card-header text-white <?php echo $cardClass; ?> d-flex justify-content-between align-items-center">
                                            <h5 class="card-title"><?php echo htmlspecialchars($device['name']); ?></h5>
                                        </div>
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="col-md-6">
                                                <p><strong>IP Address:</strong> <?php echo htmlspecialchars($device['ip']); ?></p>
                                                <p><strong>Status:</strong>
                                                    <span class="badge <?php echo $badgeClass; ?>">
                                                        <?php echo ucfirst(htmlspecialchars($device['status'])); ?>
                                                    </span>
                                                </p>
                                                <p><strong>Brand:</strong> <?php echo htmlspecialchars($device['brand']); ?></p>
                                                <p><strong>Model:</strong> <?php echo htmlspecialchars($device['model']); ?></p>
                                                <p><strong>Location:</strong> <?php echo htmlspecialchars($device['location']); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <canvas id="usageChart-<?php echo $device['id']; ?>"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>


                            </div>
                        </div>

                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            <?php foreach ($devices as $device): ?>
            var ctx = document.getElementById('usageChart-<?php echo $device['id']; ?>').getContext('2d');
            var usageChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['CPU Usage', 'RAM Usage'],
                    datasets: [{
                        label: 'Usage',
                        data: [<?php echo $device['cpu']; ?>, <?php echo $device['ram']; ?>],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
            <?php endforeach; ?>
        });
    </script>

</body>

</html>
