<?php
date_default_timezone_set('Asia/Dhaka');
include "include/security_token.php";
include "include/users_right.php";
include "include/db_connect.php";
require "routeros/routeros_api.class.php";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/* Redirect Back URL */
if ($_SESSION['details']['role'] == 'Supports' || $_SESSION['details']['role'] == 'Support Manager') {
    echo '<script>window.history.back();</script>';
    exit;
}

$nasipaddress = "Not connected!";
$RouterPortID = "Not Found!";
$DeviceMAC = "Not Found!";
$framedipaddress = "Not connected!";
$offlineHours = "Never connected!";

/*Live Bandwith Traffic Start**/
if (isset($_GET['fetch_bandwith_data']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $username = trim($_GET['username']);

    /* Check if user is online */
    $onlineusr = $con->query("SELECT * FROM radacct WHERE acctstoptime IS NULL AND username='$username'");
    if ($onlineusr->num_rows == 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'User is offline or does not exist']);
        exit; 
    }

    $rowacct = $onlineusr->fetch_assoc();
    $nasipaddress = $rowacct['nasipaddress'] ?? '';

    $CNRT = $con->query("SELECT * FROM nas WHERE nasname='$nasipaddress' LIMIT 1");
    $nas_rows = $CNRT->fetch_assoc();

    $api_usr = $nas_rows['api_user'];
    $api_pswd = $nas_rows['api_password'];
    $api_server = $nas_rows['api_ip'];
    $api_port = $nas_rows['ports'];

    $interface_name = 'pppoe-' . $username;

    $API = new RouterosAPI();
    if ($API->connect($api_server, $api_usr, $api_pswd, $api_port)) {

        /* Get Rx/Tx traffic */
        $API->write('/interface/print');
        $interfaces = $API->read();

        $found_interface = null;
        foreach ($interfaces as $intf) {
            if (strpos($intf['name'], $username) !== false) {
                $found_interface = $intf['name'];
                break;
            }
        }

        if ($found_interface) {
            $API->write('/interface/monitor-traffic', false);
            $API->write('=interface=' . $found_interface, false);
            $API->write('=once=');
            $response = $API->read();

            /*  Get Uptime from PPP active */
            $API->write('/ppp/active/print', false);
            $API->write('?name=' . $username);
            $pppResponse = $API->read();

            $uptime = 'N/A';
            if (!empty($pppResponse) && isset($pppResponse[0]['uptime'])) {
                $uptime = $pppResponse[0]['uptime']; 
            }

            $API->disconnect();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $response,
                'uptime' => custom_time_formate($uptime),
            ]);
            exit; 
        } else {
            echo json_encode(['success' => false, 'message' => 'Interface not found']);
            exit; 
        }
    }
}

/*Create Function For Formatting Time Table*/
function custom_time_formate($uptime) {
    $pattern = '/(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/';
    preg_match($pattern, $uptime, $matches);

    $days    = isset($matches[1]) ? (int)$matches[1] : 0;
    $hours   = isset($matches[2]) ? (int)$matches[2] : 0;
    $minutes = isset($matches[3]) ? (int)$matches[3] : 0;
    $seconds = isset($matches[4]) ? (int)$matches[4] : 0;

    $output = '';
    if ($days > 0)    $output .= $days . ' day' . ($days > 1 ? 's ' : ' ');
    if ($hours > 0)   $output .= $hours . ' hr ';
    if ($minutes > 0) $output .= $minutes . ' min ';
    if ($seconds > 0) $output .= $seconds . ' sec';

    return trim($output);
}


/*Live Bandwith Traffic End**/
if (isset($_GET["clid"])) {
    $clid = $_GET["clid"];

    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$clid'")) {
        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows["id"];
            $fullname = $rows["fullname"];
            $package = $rows["package"];
            $packagename = $rows["package_name"];
            $username = $rows["username"];
            $password = $rows["password"];
            $mobile = $rows["mobile"];
            $pop = $rows["pop"];
            $area = $rows["area"];
            $area_house_id = $rows["area_house_id"];
            $address = $rows["address"];
            $expiredDate = $rows["expiredate"];
            $createdate = $rows["createdate"];
            $profile_pic = $rows["profile_pic"];
            $nid = $rows["nid"];
            $price = $rows["price"];
            $remarks = $rows["remarks"];
            $liablities = $rows["liablities"];
        }
        $onlineusr = $con->query(
            "SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'"
        );
        $onlineusr->num_rows;

        // NAS Info
        $rowacct = $onlineusr->fetch_assoc();
        $nasipaddress = $rowacct["nasipaddress"] ?? "";

        $CNRT = $con->query("SELECT * FROM nas WHERE nasname='$nasipaddress' LIMIT 1");
        while ($nas_rows = $CNRT->fetch_array()) {
            $NASname = $nas_rows["shortname"];
            $nasname = $nas_rows["nasname"];
            $api_usr = $nas_rows["api_user"];
            $api_pswd = $nas_rows["api_password"];
            $api_server = $nas_rows["api_ip"];
            $api_port = $nas_rows["ports"];
        }

        // Disable Enable
        if (isset($_GET["disable"])) {
            /*Check Expire Date */
            $today = date("Y-m-d");
            $expiredate = new DateTime($expiredDate);
            $is_expired = $expiredate < new DateTime($today);

            if ($_GET["disable"] == "true") {
                $con->query("UPDATE customers SET status='0' WHERE id='$clid'");
                $con->query("DELETE FROM radcheck WHERE username='$username'");
                $con->query("DELETE FROM radreply WHERE username='$username'");
                // Disconnect from RT
                $API = new RouterosAPI();
                //$API->debug = true;
                if ($API->connect($api_server, $api_usr, $api_pswd, $api_port)) {
                    $API->write("/ppp/active/print", false);
                    $API->write("?name=" . $username, false);
                    $API->write("=.proplist=.id");
                    $ARRAYS = $API->read();
                    $API->write("/ppp/active/remove", false);
                    $API->write("=.id=" . $ARRAYS[0][".id"]);
                    $READ = $API->read();
                    $API->disconnect();
                }
                header("location:?clid=$clid");
            } elseif ($_GET["disable"] == "false") {
                $con->query("UPDATE customers SET status='1' WHERE id='$clid'");
                 $con->query("INSERT INTO radcheck(username,value,attribute,op) VALUES('$username','$password','Cleartext-Password',':=')");
                if(!$is_expired){
                    $con->query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$packagename')");
                } 
                header("location:?clid=$clid");
            }
        }
    }

    if (isset($_GET["reconnect"])) {
        // Reconnect PPP User

        $API = new RouterosAPI();
        //$API->debug = true;

        if ($API->connect($api_server, $api_usr, $api_pswd, $api_port)) {
            //$API->write('/interface/pppoe-server/remove <pppoe-ml_ataur>',true);
            $API->write("/ppp/active/print", false);
            $API->write("?name=" . $username, false);
            $API->write("=.proplist=.id");
            $ARRAYS = $API->read();
            $API->write("/ppp/active/remove", false);
            $API->write("=.id=" . $ARRAYS[0][".id"]);
            $READ = $API->read();
            $API->disconnect();
            header("location:?clid=$clid");
        }
    }
}

$map_data = [];
/*GET Customer in this Area */
if ($get_customers = $con->query("SELECT * FROM customers WHERE id=$clid")) {
    while ($rows = $get_customers->fetch_array()) {
        $area_house_id = $rows["area_house_id"];
        if ($area_house_id !== "") {
            $get_area_house = $con->query(
                "SELECT * FROM area_house WHERE id='$area_house_id'"
            );
            while ($rows_area = $get_area_house->fetch_array()) {
                $map_data[] = [
                    "lat" => $rows_area["lat"],
                    "lng" => $rows_area["lng"],
                    "house_no" => $rows_area["house_no"],

                    "customer_username" => $rows["username"],
                    "customer_phone_number" => $rows["mobile"],
                ];
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SYSTEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "style.php"; ?>
    <style>
        #bandwidthChart {
            position: relative;
        }

        #bandwidthChart::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px; 
            background: white; 
            z-index: 10;
            pointer-events: none;
        }

    </style>
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php
        $page_title = "Profile";
        include "Header.php";
        ?>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <?php include "Sidebar_menu.php"; ?>
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
                        <div class="">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="d-flex py-2" style="float:right;">
                                        <abbr title="Note">
                                            <button type="button" class="btn-sm btn btn-info"
                                                data-bs-target="#customerRmarksChangeModal" data-bs-toggle="modal">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </abbr>
                                        &nbsp;
                                        <abbr title="Download QR ">
                                            <button type="button" class="btn-sm btn btn-success"
                                                onclick="qr_function(<?php echo $clid; ?>, '<?php echo $fullname; ?>', '<?php echo $mobile; ?>')">
                                                <i class="mdi mdi-qrcode"></i>
                                            </button>
                                        </abbr>

                                        &nbsp;
                                        <abbr title="Password Change">
                                            <button type="button" data-bs-target="#customerPasswordChangeModal"
                                                data-bs-toggle="modal" class="btn-sm btn btn-info">
                                                <i class="mdi mdi-key"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Complain">
                                            <button type="button" data-bs-target="#ticketModal" data-bs-toggle="modal"
                                                class="btn-sm btn btn-warning ">
                                                <i class="mdi mdi-alert-outline"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Recharge">
                                            <button type="button" id="rechargeBtn" class="btn-sm btn btn-primary ">
                                                <i class="mdi mdi mdi-battery-charging-90"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Temp. Recharge">
                                            <button type="button" data-bs-target="#temp_recharge_Modal"
                                                data-bs-toggle="modal" class="btn-sm btn btn-secondary">
                                                <i class="mdi mdi mdi-battery-charging-20"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Payment received">
                                            <button type="button" data-bs-target="#addPaymentModal"
                                                data-bs-toggle="modal" class="btn-sm btn btn-info ">
                                                <i class="mdi mdi mdi-cash-multiple"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <?php
                                        if (
                                            $usrstatus = $con->query(
                                                "SELECT * FROM radcheck WHERE username='$username' LIMIT 1"
                                            )
                                        ) {
                                            $radusrname = $usrstatus->num_rows;
                                        }
                                        if ($radusrname == 1) {
                                            echo '<abbr title="Disable"><a href="?clid=' .
                                                $clid .
                                                '&disable=true"><button type="button"
                                        																			class="btn-sm btn btn-danger">
                                        																			<i class="fas fa-user-slash"></i>
                                        																			</button></a></abbr>';
                                        } else {
                                            echo '<abbr title="Enable"> <a href="?clid=' .
                                                $clid .
                                                '&disable=false"><button type="button"
                                        																				class="btn-sm btn btn-success">
                                        																				<i class="fas fa-user-slash"></i>
                                        																				</button></a></abbr>';
                                        }
                                        ?>
                                        &nbsp;
                                        <abbr title="Reconnect">
                                            <a href="?clid=<?php echo $clid; ?>&reconnect">
                                                <button type="button" id="reconnect" class="btn-sm btn btn-pink">
                                                    <i class="mdi mdi-sync"></i>
                                                </button>
                                            </a>
                                        </abbr>
                                        &nbsp;
                                        <abbr title="Edit Customer">
                                            <a href="profile_edit.php?clid=<?php echo $clid; ?>">
                                                <button type="button" class="btn-sm btn btn-info">
                                                    <i class="mdi mdi-account-edit"></i>
                                                </button></a>
                                        </abbr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="main-body">
                                <div class="row gutters-sm">
                                    <div class="col-md-4 mb-3">
                                        <div class="">
                                            <div class="card  p-3 mb-4 bg-white rounded text-center">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column align-items-center profile">
                                                        <!-- Profile Image -->
                                                        <img src="profileImages/avatar.png"
                                                            class="rounded-circle border border-3 border-primary shadow-sm"
                                                            width="120" height="120" />

                                                        <!-- Profile Details -->
                                                        <div class="mt-3">
                                                            <h4 class="text-primary fw-bold"><?php echo $fullname; ?></h4>
                                                            <p class="text-muted mb-1">
                                                                <span class="badge bg-secondary">#
                                                                    <?php echo $clid; ?></span>
                                                            </p>
                                                            <p class="text-dark fw-semibold">
                                                                <i class="fas fa-phone-alt text-success"></i>
                                                                <?php echo $mobile; ?>
                                                            </p>

                                                            <!-- User Since -->
                                                            <small class="text-muted">
                                                                <i class="far fa-calendar-alt"></i>
                                                                <?php
                                                                $createdate = new DateTime(
                                                                    $createdate
                                                                );
                                                                echo $createdate->format(
                                                                    "d M, Y"
                                                                );
                                                                ?>
                                                            </small>

                                                            <!-- Remarks Section -->
                                                            <?php if (
                                                                !empty($remarks)
                                                            ): ?>
                                                            <div class="mt-2 p-2 bg-light border rounded">
                                                                <i class="fas fa-comment-dots text-info"></i>
                                                                <?php echo $remarks; ?>
                                                            </div>
                                                            <?php endif; ?>

                                                            <!-- Action Buttons -->
                                                            <div class="mt-3">
                                                                <a href="profile_edit.php?clid=<?php echo $clid; ?>"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i> Edit Profile
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card  border-0 rounded-4">
                                            <div class="card-body p-4">
                                                <div class="col-12 bg-white p-0">
                                                    <?php $info = [
                                                        [
                                                            "mdi mdi-marker-check",
                                                            "Fullname",
                                                            $fullname,
                                                        ],
                                                        [
                                                            "mdi mdi-account-circle",
                                                            "Username",
                                                            $username,
                                                        ],
                                                        [
                                                            "fas fa-box",
                                                            "Package",
                                                            $packagename,
                                                        ],
                                                        [
                                                            "fas fa-dollar-sign",
                                                            "Bill Amount",
                                                            "<span class='fw-bold text-success'>৳$price</span>",
                                                        ],
                                                        [
                                                            "fas fa-location-arrow",
                                                            "Area",
                                                            $con
                                                                ->query(
                                                                    "SELECT name FROM area_list WHERE id='$area'"
                                                                )
                                                                ->fetch_array()[
                                                                "name"
                                                            ],
                                                        ],
                                                        [
                                                            "fas fa-home",
                                                            "Address",
                                                            $address,
                                                        ],
                                                        [
                                                            "fas fa-map-marker-alt",
                                                            "Area Location",
                                                            isset(
                                                                $area_house_id
                                                            ) &&
                                                            $area_house_id > 0
                                                                ? $con
                                                                    ->query(
                                                                        "SELECT house_no FROM area_house WHERE id=$area_house_id"
                                                                    )
                                                                    ->fetch_array()[
                                                                    "house_no"
                                                                ]
                                                                : "N/A",
                                                        ],
                                                        [
                                                            "fas fa-file-contract",
                                                            "Liabilities",
                                                            $liablities == 1
                                                                ? '<span class="badge bg-success">Yes</span>'
                                                                : '<span class="badge bg-danger">No</span>',
                                                        ],
                                                        [
                                                            "mdi mdi-phone",
                                                            "Mobile",
                                                            $mobile,
                                                        ],
                                                        [
                                                            "mdi mdi-crosshairs-gps",
                                                            "POP/Branch",
                                                            '<a href="view_pop.php?id=' .
                                                            $pop .
                                                            '" class="text-decoration-none text-dark fw-bold">' .
                                                            $con
                                                                ->query(
                                                                    "SELECT pop FROM add_pop WHERE id='$pop'"
                                                                )
                                                                ->fetch_array()[
                                                                "pop"
                                                            ] .
                                                            "</a>",
                                                        ],
                                                        [
                                                            "fas fa-id-card",
                                                            "Nid No",
                                                            $nid,
                                                        ],
                                                        [
                                                            "fas fa-comment-alt",
                                                            "Remarks",
                                                            $remarks,
                                                        ],
                                                    ]; ?>

                                                    <?php foreach (
                                                        $info
                                                        as $item
                                                    ): ?>
                                                    <div
                                                        class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom border-dotted">
                                                        <p class="mb-0 text-muted"><i
                                                                class="<?= $item[0] ?> me-2 text-primary fs-5"></i>
                                                            <span class="fw-bold"><?= $item[1] ?>:</span></p>
                                                        <span class="fw-semibold text-dark"><?= $item[2] ?></span>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="col-md-8">
                                        <div class="row d-flex">
                                            <div class="col-md-12 mb-4">
                                                <div class="card  shadow py-2" style="border-left:3px solid green;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col">
                                                                <?php
                                                                if (
                                                                    $onlineusr->num_rows ==
                                                                    1
                                                                ) {
                                                                    echo '<span class="badge bg-success">Online</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-danger">Offline</span>';
                                                                }

                                                                if (
                                                                    $DeviceMC = $con->query(
                                                                        "SELECT nasipaddress, nasportid, callingstationid, framedipaddress FROM radacct WHERE username='$username' ORDER BY radacctid DESC LIMIT 1"
                                                                    )
                                                                ) {
                                                                    while (
                                                                        $mac_rows = $DeviceMC->fetch_array()
                                                                    ) {
                                                                        $nasipaddress =
                                                                            $mac_rows[
                                                                                "nasipaddress"
                                                                            ];
                                                                        $RouterPortID =
                                                                            $mac_rows[
                                                                                "nasportid"
                                                                            ];
                                                                        $DeviceMAC =
                                                                            $mac_rows[
                                                                                "callingstationid"
                                                                            ];
                                                                        $framedipaddress =
                                                                            $mac_rows[
                                                                                "framedipaddress"
                                                                            ];
                                                                    }

                                                                    // Router name
                                                                    if (
                                                                        $nasipaddress !=
                                                                        ""
                                                                    ) {
                                                                        $NASFND = $con->query(
                                                                            "SELECT shortname FROM nas WHERE nasname='$nasipaddress' LIMIT 1"
                                                                        );
                                                                        while (
                                                                            $nas_rows = $NASFND->fetch_array()
                                                                        ) {
                                                                            $NASname =
                                                                                $nas_rows[
                                                                                    "shortname"
                                                                                ];
                                                                        }
                                                                    } else {
                                                                        $NASname =
                                                                            "Not Found!";
                                                                    }
                                                                    /**/
                                                                    echo "</br>";
                                                                    echo "<b>Router:</b> " .
                                                                        $NASname .
                                                                        " ~ " .
                                                                        $nasipaddress;
                                                                    echo "</br>";
                                                                    echo "<b>Interface:</b> " .
                                                                        $RouterPortID;
                                                                    echo "</br>";
                                                                    echo "<b>MAC:</b> " .
                                                                        $DeviceMAC;
                                                                    echo "</br>";
                                                                    echo "<b>Remote IP:</b> " .
                                                                        $framedipaddress;
                                                                    echo "</br>";

                                                                    ////////////// Mikrotik package detected
                                                                    $cstpckg = $con->query(
                                                                        "SELECT value FROM radreply WHERE username='$username' LIMIT 1"
                                                                    );
                                                                    if (
                                                                        $cstpckg->num_rows ==
                                                                        1
                                                                    ) {
                                                                        //echo '<br><b><span style="color:red;">Grace Time</span></b><br>';
                                                                        $cpkg_rows = $cstpckg->fetch_array();
                                                                        echo "<b>Detected pkg. </b>" .
                                                                            $cpkg_rows[
                                                                                "value"
                                                                            ] .
                                                                            "</br>";
                                                                    }

                                                                    if (
                                                                        strlen(
                                                                            $DeviceMAC
                                                                        ) > 6
                                                                    ) {
                                                                        $MACaddr = substr(
                                                                            $DeviceMAC,
                                                                            0,
                                                                            8
                                                                        );
                                                                        // Retrive MAC Data from database
                                                                        if (
                                                                            $MC_vend = $con->query(
                                                                                "SELECT vendor FROM mac_vendor WHERE mac='$MACaddr' LIMIT 1"
                                                                            )
                                                                        ) {
                                                                            while (
                                                                                $vend_rows = $MC_vend->fetch_array()
                                                                            ) {
                                                                                $MAC_vendor =
                                                                                    $vend_rows[
                                                                                        "vendor"
                                                                                    ];
                                                                                echo "<b>$MAC_vendor</b>";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col">

                                                                <?php if (
                                                                    $onlineusr->num_rows ==
                                                                    1
                                                                ) {
                                                                    echo '<b><abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr> Online </b> <br/>';
                                                                    $con->query("SET time_zone = '+06:00'");
                                                                    if ($lastuptime = $con->query(
                                                                            "SELECT SEC_TO_TIME(ABS(TIMESTAMPDIFF(SECOND, acctstarttime, NOW()))) AS time FROM radacct WHERE username='$username' AND acctstoptime IS NULL ORDER BY radacctid DESC LIMIT 1")) {
                                                                        $upt_rows = $lastuptime->fetch_array();
                                                                        //$onlineHrs =$upt_rows["time"];
                                                                           $onlineHrs =  "0:00:00";     
                                                                        echo '<span class="far fa-clock"></span> <strong><span style="color:green;" id="uptimeInfo"> ' .$onlineHrs ."</span></strong>  <br/>";

                                                                        if ($ontimes = $con->query(
                                                                                "SELECT acctstarttime, acctinputoctets/1000/1000/1000 AS GB_IN, acctoutputoctets/1000/1000/1000 AS GB_OUT FROM radacct WHERE username='$username' ORDER BY radacctid DESC LIMIT 1") ) {
                                                                            $on_rowss = $ontimes->fetch_array();
                                                                            $Download = number_format(
                                                                                $on_rowss[
                                                                                    "GB_OUT"
                                                                                ],
                                                                                3
                                                                            );
                                                                            $Upload = number_format(
                                                                                $on_rowss[
                                                                                    "GB_IN"
                                                                                ],
                                                                                3
                                                                            );

                                                                            echo '<span class="fas fa-arrow-alt-circle-down" style="color:red;"> ' .
                                                                                $Download .
                                                                                " GB</span><br/>";
                                                                            echo '<span class="fas fa-arrow-alt-circle-up" style="color:purple;"> ' .
                                                                                $Upload .
                                                                                " GB</span><br/>";
                                                                            echo '<span class="fas fa-link text-green"></span><strong><span style="color:blue;"> ' .
                                                                                date(
                                                                                    "h:i:s A",
                                                                                    strtotime(
                                                                                        $on_rowss[
                                                                                            "acctstarttime"
                                                                                        ]
                                                                                    )
                                                                                ) .
                                                                                "</span></strong>";
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo '<b><img src="images/icon/offline.png" height="10" width="10"/> Offline </b> <br/>';

                                                                    if (
                                                                        $offtime = $con->query(
                                                                            "SELECT SEC_TO_TIME(ABS(TIMESTAMPDIFF(SECOND, acctstoptime, NOW()))) AS time FROM radacct WHERE username='$username' ORDER BY radacctid DESC LIMIT 1"
                                                                        )
                                                                    ) {
                                                                        $off_rows = $offtime->fetch_assoc();
                                                                        $offlineHours =
                                                                            $off_rows[
                                                                                "time"
                                                                            ] ??
                                                                            "";

                                                                        echo '<span class="far fa-clock"></span> <strong><span style="color:red;"> ' .
                                                                            $offlineHours .
                                                                            "</span></strong> Hrs <br/>";

                                                                        if (
                                                                            $offtimes = $con->query(
                                                                                "SELECT acctstoptime FROM radacct WHERE username='$username' ORDER BY radacctid DESC LIMIT 1"
                                                                            )
                                                                        ) {
                                                                            $off_rowss = $offtimes->fetch_array();
                                                                            if (
                                                                                $off_rowss[
                                                                                    "acctstoptime"
                                                                                ]
                                                                            ) {
                                                                                echo '<span class="fas fa-unlink text-green"></span><strong><span style="color:grey;"><abbr title="' .
                                                                                    date(
                                                                                        "Y-M-d h:i:s A",
                                                                                        strtotime(
                                                                                            $off_rowss[
                                                                                                "acctstoptime"
                                                                                            ]
                                                                                        )
                                                                                    ) .
                                                                                    '">  ' .
                                                                                    date(
                                                                                        "h:i:s A",
                                                                                        strtotime(
                                                                                            $off_rowss[
                                                                                                "acctstoptime"
                                                                                            ]
                                                                                        )
                                                                                    ) .
                                                                                    "</abbr></span></strong>";
                                                                            } else {
                                                                                echo '<span class="fas fa-unlink text-green"></span><strong><span style="color:grey;">Never connected</span></strong>';
                                                                            }
                                                                        }
                                                                    }
                                                                } ?>

                                                            </div>
                                                            <div class="col">
                                                                <b>Expired Date</b><br>
                                                                <?php
                                                                if (
                                                                    $usrstatus = $con->query(
                                                                        "SELECT * FROM radcheck WHERE username='$username' LIMIT 1"
                                                                    )
                                                                ) {
                                                                    $radusrname =
                                                                        $usrstatus->num_rows;
                                                                }

                                                                if (
                                                                    $radusrname ==
                                                                    1
                                                                ) {
                                                                    if (
                                                                        !empty(
                                                                            $expiredDate
                                                                        ) &&
                                                                        preg_match(
                                                                            '/^\d{4}-\d{2}-\d{2}$/',
                                                                            $expiredDate
                                                                        )
                                                                    ) {
                                                                        $expiredDate = new DateTime(
                                                                            $expiredDate
                                                                        );
                                                                        $expiredDate = $expiredDate->format(
                                                                            "d-M-Y"
                                                                        );
                                                                        echo "<span style='color:green;'><b>Active</b></span>";
                                                                        echo "<br>" .
                                                                            $expiredDate;
                                                                    } else {
                                                                        echo "<span style='color:orange;'><b>Invalid Date</b></span>";
                                                                    }
                                                                } else {
                                                                    echo '<a href="?clid=' .
                                                                        $clid .
                                                                        '&disable=false"><span style="color:red;"><b>Disabled</b></span></a>';
                                                                }

                                                                echo "<br>";
                                                                $gracetime = $con->query(
                                                                    "SELECT DATEDIFF(grace_expired, NOW()) AS time FROM customers WHERE grace_expired>=NOW() AND username='$username'"
                                                                );
                                                                if (
                                                                    $gracetime->num_rows ==
                                                                    1
                                                                ) {
                                                                    echo '<br><b><span style="color:red;">Grace Time</span></b><br>';
                                                                    $grc_rows = $gracetime->fetch_array();
                                                                    echo "<b>" .
                                                                        $grc_rows[
                                                                            "time"
                                                                        ] .
                                                                        "</b> Days";
                                                                }
                                                                ?>
                                                                <b>Monthly Uses</b>
                                                                </br>

                                                                <?php
                                                                $currentMonth = date(
                                                                    "m"
                                                                );
                                                                if (
                                                                    $lastused = $con->query("SELECT SUM(acctinputoctets)/1000/1000/1000 AS GB_IN, SUM(acctoutputoctets)/1000/1000/1000 AS GB_OUT FROM
                                                                                                                         radacct WHERE username='$username' AND  MONTH(acctstarttime)='$currentMonth'")
                                                                ) {
                                                                    $r_usd_rows = $lastused->fetch_array();
                                                                    $Download =
                                                                        $r_usd_rows[
                                                                            "GB_OUT"
                                                                        ];
                                                                    $Download = number_format(
                                                                        $Download,
                                                                        3
                                                                    );
                                                                    $Upload =
                                                                        $r_usd_rows[
                                                                            "GB_IN"
                                                                        ];
                                                                    $Upload = number_format(
                                                                        $Upload,
                                                                        3
                                                                    );

                                                                    echo '<span class=" fas fa-arrow-alt-circle-down" style="color:red;"> ' .
                                                                        $Download .
                                                                        ' GB</span><br/><span class=" fas fa-arrow-alt-circle-up" style="color:purple;"> ' .
                                                                        $Upload .
                                                                        " GB</span><br/>";
                                                                }
                                                                ?>



                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Earnings (Monthly) Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card shadow py-2" style="border-left:3px solid #2A0FF1;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Recharged</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php if (
                                                                        $rchdamt = $con->query(
                                                                            "SELECT SUM(purchase_price) AS Amount FROM customer_rechrg WHERE customer_id='$clid' AND type !='4'"
                                                                        )
                                                                    ) {
                                                                        while (
                                                                            $r_rchd_rows = $rchdamt->fetch_array()
                                                                        ) {
                                                                            $totalrchd =
                                                                                $r_rchd_rows[
                                                                                    "Amount"
                                                                                ];
                                                                        }
                                                                        echo $totalrchd;
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Earnings (Monthly) Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card shadow  py-2" style="border-left:3px solid #27F10F;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                    Total Paid</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php
                                                                    $totalpaid = 0.0;
                                                                    $discount_amount = 0.0;

                                                                    if (
                                                                        $dueamt = $con->query(
                                                                            "SELECT SUM(purchase_price) AS Amount FROM customer_rechrg WHERE customer_id='$clid' AND type != '0'"
                                                                        )
                                                                    ) {
                                                                        if (
                                                                            $r_due_rows = $dueamt->fetch_array()
                                                                        ) {
                                                                            $totalpaid =
                                                                                $r_due_rows[
                                                                                    "Amount"
                                                                                ] ??
                                                                                0.0;
                                                                        }
                                                                    }

                                                                    if (
                                                                        $discount_query = $con->query(
                                                                            "SELECT SUM(discount) AS discount_amount FROM customer_rechrg WHERE customer_id='$clid'"
                                                                        )
                                                                    ) {
                                                                        if (
                                                                            $discount_row = $discount_query->fetch_array()
                                                                        ) {
                                                                            $discount_amount =
                                                                                $discount_row[
                                                                                    "discount_amount"
                                                                                ] ??
                                                                                0.0;
                                                                        }
                                                                    }

                                                                    // Calculate and output the net value
                                                                    echo $totalpaid -
                                                                        $discount_amount ??
                                                                        0.0;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Pending Requests Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card shadow  py-2"
                                                    style="border-left:3px solid red; color:red">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                                    Total Due</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php echo $totalDue =
                                                                        $totalrchd -
                                                                        $totalpaid; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Pending Requests Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card shadow  py-2" style="border-left:3px solid blue;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Due paid</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php if (
                                                                        $duepmt = $con->query(
                                                                            "SELECT SUM(purchase_price) AS Amount FROM customer_rechrg WHERE customer_id='$clid' AND type='4'"
                                                                        )
                                                                    ) {
                                                                        while (
                                                                            $pmt_rows = $duepmt->fetch_array()
                                                                        ) {
                                                                            $totalpmtpaid =
                                                                                $pmt_rows[
                                                                                    "Amount"
                                                                                ] ??
                                                                                0;
                                                                        }
                                                                        echo $totalpmtpaid;
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Pending Requests Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card shadow  py-2" style="border-left:3px solid red;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Discount</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php if (
                                                                        $duepmt = $con->query(
                                                                            "SELECT SUM(discount) AS discount_amount FROM customer_rechrg WHERE customer_id='$clid'"
                                                                        )
                                                                    ) {
                                                                        while (
                                                                            $discount_amount_rows = $duepmt->fetch_array()
                                                                        ) {
                                                                            $_discount_amount =
                                                                                $discount_amount_rows[
                                                                                    "discount_amount"
                                                                                ] ??
                                                                                0;
                                                                        }
                                                                        echo $_discount_amount;
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="chart-container">
                                                <canvas id="liveBandwidthChart"  width="600" height="300"></canvas>
                                            </div>
                                        </div>
                                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                            <script>
                                                $(document).ready(function() {
                                                   const ctx = document.getElementById('liveBandwidthChart').getContext('2d');

                                                    const labels = Array.from({
                                                        length: 30
                                                    }, () => '');
                                                    const downloadData = Array(30).fill(0);
                                                    const uploadData = Array(30).fill(0);

                                                    const bandwidthChart = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: labels,
                                                            datasets: [{
                                                                    label: 'Download (kbps)',
                                                                    data: downloadData,
                                                                    borderColor: '#36A2EB',
                                                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                },
                                                                {
                                                                    label: 'Upload (kbps)',
                                                                    data: uploadData,
                                                                    borderColor: '#FF6384',
                                                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                }
                                                            ]
                                                        },
                                                        options: {
                                                        responsive: true,
                                                        scales: {
                                                            x: {
                                                                ticks: {
                                                                    display: false,
                                                                    maxTicksLimit: 10,
                                                                    autoSkip: true
                                                                },
                                                                grid: {
                                                                    display: false
                                                                }
                                                            },
                                                            y: {
                                                                beginAtZero: true
                                                            }
                                                        }
                                                    }

                                                    });

                                                    function fetch_live_bandwidth_data() {
                                                    $.ajax({
                                                        url: window.location.href,
                                                        method: 'GET',
                                                         data: {
                                                            fetch_bandwith_data: true,
                                                            username: '<?php echo $username; ?>',
                                                        },
                                                        dataType: 'json',
                                                        success: function(response) {
                                                             if (response.success) {
                                                                const data = response.data[0];

                                                                const rx = parseFloat(data['rx-bits-per-second']) / 1024; 
                                                                const tx = parseFloat(data['tx-bits-per-second']) / 1024;
                                                                const uptime = response.uptime;

                                                                const now = new Date().toLocaleTimeString();
                                                                document.getElementById("uptimeInfo").innerText = uptime;
                                                                /* Push new data*/
                                                                bandwidthChart.data.labels.push(now);
                                                                bandwidthChart.data.datasets[0].data.push(rx);
                                                                bandwidthChart.data.datasets[1].data.push(tx);

                                                                if (bandwidthChart.data.labels.length > 20) {
                                                                    bandwidthChart.data.labels.shift();
                                                                    bandwidthChart.data.datasets[0].data.shift();
                                                                    bandwidthChart.data.datasets[1].data.shift();
                                                                }

                                                                bandwidthChart.update();
                                                            }
                                                        },
                                                        // error: function(err) {
                                                        //     console.error("AJAX error:", err);
                                                        // }
                                                    });
                                                }

                                                fetch_live_bandwidth_data();
                                                setInterval(fetch_live_bandwidth_data, 500);
                                                   
                                                });
                                            </script>

                                        
                                        <div class="container">
                                            <div class="row">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab"
                                                                    href="#tickets" role="tab">
                                                                    <span class="d-none d-md-block">Tickets
                                                                    </span><span class="d-block d-md-none"><i
                                                                            class="mdi mdi-home-variant h5"></i></span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#cstmr_recharge" role="tab">
                                                                    <span class="d-none d-md-block">
                                                                        Recharge</span><span
                                                                        class="d-block d-md-none"><i
                                                                            class="mdi mdi-account h5"></i></span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link " data-bs-toggle="tab"
                                                                    href="#usr_usage" role="tab">
                                                                    <span class="d-none d-md-block">User
                                                                        Usage</span><span class="d-block d-md-none"><i
                                                                            class="mdi mdi-email h5"></i></span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#usr_activity" role="tab">
                                                                    <span class="d-none d-md-block">User
                                                                        Activity</span><span
                                                                        class="d-block d-md-none"><i
                                                                            class="mdi mdi-email h5"></i></span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#liabilities_table" role="tab">
                                                                    <span class="d-none d-md-block">User Liabilities</span><span class="d-block d-md-none"><i
                                                                            class="mdi mdi-user h5"></i></span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div class="tab-pane  p-3" id="usr_usage"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-bordered dt-responsive nowrap"
                                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Usage</th>
                                                                                        <th>Duration</th>
                                                                                        <th>Time</th>
                                                                                        <th>Act.</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php if (
                                                                                        $csusage = $con->query("SELECT acctinputoctets/1000/1000/1000 AS GB_IN, acctoutputoctets/1000/1000/1000 AS GB_OUT, TIMEDIFF(acctstoptime,acctstarttime) AS time, acctstoptime, acctterminatecause FROM
                                                                                                                                                         radacct WHERE username='$username' AND acctstoptime IS NOT NULL ORDER BY acctstoptime DESC, radacctid ASC LIMIT 5")
                                                                                    ) {
                                                                                        while (
                                                                                            $r_ussg_rows = $csusage->fetch_array()
                                                                                        ) {
                                                                                            $usgDownload =
                                                                                                $r_ussg_rows[
                                                                                                    "GB_OUT"
                                                                                                ];
                                                                                            $usgDownload = number_format(
                                                                                                $usgDownload,
                                                                                                3
                                                                                            );
                                                                                            $usgUpload =
                                                                                                $r_ussg_rows[
                                                                                                    "GB_IN"
                                                                                                ];
                                                                                            $usgUpload = number_format(
                                                                                                $usgUpload,
                                                                                                3
                                                                                            );
                                                                                            $Usagetime =
                                                                                                $r_ussg_rows[
                                                                                                    "time"
                                                                                                ];
                                                                                            $Usagestoptime =
                                                                                                $r_ussg_rows[
                                                                                                    "acctstoptime"
                                                                                                ];
                                                                                            $Usagestoptime = date(
                                                                                                "h:i:s A ~ d-M-Y",
                                                                                                strtotime(
                                                                                                    $Usagestoptime
                                                                                                )
                                                                                            );
                                                                                            $Usageacctterminatecause =
                                                                                                $r_ussg_rows[
                                                                                                    "acctterminatecause"
                                                                                                ];

                                                                                            //echo '<span class="fas fa-caret-down" style="color:red;"> '.$Download.' GB</span><br/><span class="fas fa-caret-up" style="color:purple;"> '.$Upload.' GB</span><br/>';

                                                                                            echo '
                                                                                                                                                                 <tr>
                                                                                                                                                                 <td><span class="fas fa-caret-down"></span> ' .
                                                                                                $usgDownload .
                                                                                                ' GB<br/><span class="fas fa-caret-up" ></span> ' .
                                                                                                $usgUpload .
                                                                                                ' GB</td>
                                                                                                                                                                     <td>' .
                                                                                                $Usagetime .
                                                                                                '</td>
                                                                                                                                                                     <td>' .
                                                                                                $Usagestoptime .
                                                                                                '</td>
                                                                                                                                                                     <td>' .
                                                                                                $Usageacctterminatecause .
                                                                                                '</td>
                                                                                                                                                                 </tr>
                                                                                                                                                                 ';
                                                                                        }
                                                                                    } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane p-3" id="usr_activity"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-bordered dt-responsive nowrap"
                                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Auth Date</th>
                                                                                        <th>Username</th>
                                                                                        <th>Pass</th>
                                                                                        <th>Reply</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php if (
                                                                                        $usrs_activity = $con->query(
                                                                                            "SELECT * FROM radpostauth WHERE username='$username' ORDER BY authdate DESC LIMIT 5"
                                                                                        )
                                                                                    ) {
                                                                                        while (
                                                                                            $rowsppp = $usrs_activity->fetch_array()
                                                                                        ) {
                                                                                            $usr_act_name =
                                                                                                $rowsppp[
                                                                                                    "username"
                                                                                                ];
                                                                                            $usr_act_pass =
                                                                                                $rowsppp[
                                                                                                    "pass"
                                                                                                ];
                                                                                            $usr_act_reply =
                                                                                                $rowsppp[
                                                                                                    "reply"
                                                                                                ];
                                                                                            $usr_act_auth =
                                                                                                $rowsppp[
                                                                                                    "authdate"
                                                                                                ];
                                                                                            $usr_act_auth = date(
                                                                                                "h:i:s A ~ d-M-Y",
                                                                                                strtotime(
                                                                                                    $usr_act_auth
                                                                                                )
                                                                                            );

                                                                                            if (
                                                                                                $usr_act_reply ==
                                                                                                "Access-Accept"
                                                                                            ) {
                                                                                                $userReplay =
                                                                                                    "<span class='badge bg-success'>Password Matched</span>";
                                                                                            } elseif (
                                                                                                $usr_act_reply ==
                                                                                                "Access-Reject"
                                                                                            ) {
                                                                                                $userReplay =
                                                                                                    "<span class='badge bg-danger'>Password Missmatched</span>";
                                                                                            }

                                                                                            echo '
                                                                                                                                                                 <tr>
                                                                                                                                                                 <td>' .
                                                                                                $usr_act_auth .
                                                                                                '</td>
                                                                                                                                                                     <td>' .
                                                                                                $usr_act_name .
                                                                                                '</td>
                                                                                                                                                                     <td>' .
                                                                                                $usr_act_pass .
                                                                                                '</td>
                                                                                                                                                                     <td>' .
                                                                                                $userReplay .
                                                                                                '</td>
                                                                                                                                                                 </tr>
                                                                                                                                                                 ';
                                                                                        }
                                                                                    } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane active p-3" id="tickets"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="tickets_table"
                                                                                class="table table-bordered dt-responsive nowrap"
                                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Complain Type</th>
                                                                                        <th>Ticket Type</th>
                                                                                        <th>Form Date</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="ticket-list">
                                                                                    <?php
                                                                                    $sql = "SELECT * FROM ticket WHERE customer_id=$lstid  ";
                                                                                    $result = mysqli_query(
                                                                                        $con,
                                                                                        $sql
                                                                                    );

                                                                                    while (
                                                                                        $rows = mysqli_fetch_assoc(
                                                                                            $result
                                                                                        )
                                                                                    ) { ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php
                                                                                            $complain_typeId =
                                                                                                $rows[
                                                                                                    "complain_type"
                                                                                                ];
                                                                                            $ticketsId =
                                                                                                $rows[
                                                                                                    "id"
                                                                                                ];
                                                                                            if (
                                                                                                $allCom = $con->query(
                                                                                                    "SELECT * FROM ticket_topic WHERE id='$complain_typeId' "
                                                                                                )
                                                                                            ) {
                                                                                                while (
                                                                                                    $rowss = $allCom->fetch_array()
                                                                                                ) {
                                                                                                    $topicName =
                                                                                                        $rowss[
                                                                                                            "topic_name"
                                                                                                        ];
                                                                                                    echo '<a href="tickets_profile.php?id=' .
                                                                                                        $ticketsId .
                                                                                                        '">' .
                                                                                                        $topicName .
                                                                                                        "</a>";
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $ticketType =
                                                                                                $rows[
                                                                                                    "ticket_type"
                                                                                                ];
                                                                                            if (
                                                                                                $ticketType ==
                                                                                                "Active"
                                                                                            ) {
                                                                                                echo "<span class='badge bg-success'>Active</span>";
                                                                                            } elseif (
                                                                                                $ticketType ==
                                                                                                "Open"
                                                                                            ) {
                                                                                                echo "<span class='badge bg-info'>Open</span>";
                                                                                            } elseif (
                                                                                                $ticketType ==
                                                                                                "New"
                                                                                            ) {
                                                                                                echo "<span class='badge bg-danger'>New</span>";
                                                                                            } elseif (
                                                                                                $ticketType ==
                                                                                                "Complete"
                                                                                            ) {
                                                                                                echo "<span class='badge bg-success'>Complete</span>";
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo date(
                                                                                                "d F Y",
                                                                                                strtotime(
                                                                                                    $rows[
                                                                                                        "startdate"
                                                                                                    ]
                                                                                                )
                                                                                            ); ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane p-3" id="cstmr_recharge"
                                                                role="tabpanel">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="recharge_data_table"
                                                                                class="table table-bordered dt-responsive nowrap"
                                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Date</th>
                                                                                        <th>Months</th>
                                                                                        <th>Type</th>
                                                                                        <th>Reference</th>
                                                                                        <th>Paid until</th>
                                                                                        <th>Amount</th>
                                                                                        <th></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php 
                                                                                    $all_rows = [];
                                                                                    if ($get_all_recharge_data = $con->query("SELECT * FROM customer_rechrg WHERE customer_id='$lstid'")) {
                                                                                        while ($row = $get_all_recharge_data->fetch_assoc()) {
                                                                                            $all_rows[] = $row;
                                                                                        }
                                                                                        $count = count($all_rows);
                                                                                        for ($i = 0; $i < $count - 1; $i++) {
                                                                                            for ($j = 0; $j < $count - $i - 1; $j++) {
                                                                                                $date1 = strtotime($all_rows[$j]['datetm']);
                                                                                                $date2 = strtotime($all_rows[$j + 1]['datetm']);
                                                                                                if ($date1 < $date2) {
                                                                                                    $temp = $all_rows[$j];
                                                                                                    $all_rows[$j] = $all_rows[$j + 1];
                                                                                                    $all_rows[$j + 1] = $temp;
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    
                                                                                        foreach ($all_rows as $row) {
                                                                                            $r_id        = $row['id'];
                                                                                            $months      = $row['months'];
                                                                                            $ref         = $row['ref'];
                                                                                            $amount      = $row['purchase_price'];
                                                                                            $rchrg_until = (new DateTime($row['rchrg_until']))->format('d-M-Y');
                                                                                            $datetm      = (new DateTime($row['datetm']))->format('d-M-Y');
                                                                                    
                                                                                            $type = $row['type'];
                                                                                            switch ($type) {
                                                                                                case "1": $typeBadge = "<span class='badge bg-success'>Cash</span>"; break;
                                                                                                case "2": $typeBadge = "<span class='badge bg-info'>Bkash</span>"; break;
                                                                                                case "3": $typeBadge = "<span class='badge bg-success'>Nagad</span>"; break;
                                                                                                case "4": $typeBadge = "<span class='badge bg-primary'>Due Paid</span>"; break;
                                                                                                case "0": $typeBadge = "<span class='badge bg-danger'>Credit</span>"; break;
                                                                                                default: $typeBadge = "<span class='badge bg-secondary'>Unknown</span>"; break;
                                                                                            }
                                                                                    
                                                                                            echo "<tr>
                                                                                                    <td>{$datetm}</td>
                                                                                                    <td>{$months}</td>
                                                                                                    <td>{$typeBadge}</td>
                                                                                                    <td>{$ref}</td>
                                                                                                    <td>{$rchrg_until}</td>
                                                                                                    <td>{$amount}</td>
                                                                                                    <td><button type='button' id='recharge_undo' data-id='{$r_id}' class='btn-sm btn btn-danger'><i class='mdi mdi-undo'></i></button></td>
                                                                                                  </tr>";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Customer Liabilities Section -->
                                                            <div class="tab-pane fade show " id="liabilities_table" role="tabpanel">
                                                                <div class="table table-responsive">
                                                                    <table id="customer_device_table"class="table table-bordered dt-responsive nowrap"
                                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                        <thead class="">
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Device Type</th>
                                                                                <th>Name</th>
                                                                                <th>Serial No</th>
                                                                                <th>Assign Date</th>
                                                                                <th>Return Date</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                       <tbody>
                                                                        <?php 
                                                                        $res = $con->query("SELECT * FROM customer_devices WHERE customer_id = $clid");

                                                                        if($res && $res->num_rows > 0){
                                                                            while($row = $res->fetch_assoc()){
                                                                                echo "<tr>";

                                                                                echo "<td>" . (new DateTime($row['created_at']))->format('d-M-Y') . "</td>";

                                                                                echo "<td>";
                                                                                switch($row['device_type']) {
                                                                                    case 'router':
                                                                                        echo "<span class='badge bg-success'>Router</span>";
                                                                                        break;
                                                                                    case 'onu':
                                                                                        echo "<span class='badge bg-dark'>ONU</span>";
                                                                                        break;
                                                                                    case 'fiber':
                                                                                        echo "<span class='badge bg-primary'>Fiber</span>";
                                                                                        break;
                                                                                    default:
                                                                                        echo "<span class='badge bg-secondary'>N/A</span>";
                                                                                }
                                                                                echo "</td>";

                                                                            
                                                                                echo "<td>" . htmlspecialchars($row['device_name']) . "</td>";

                                                                                echo "<td>" . htmlspecialchars($row['serial_number']) . "</td>";

                                                                               
                                                                                echo "<td>" . (!empty($row['assigned_date']) ? (new DateTime($row['assigned_date']))->format('d-M-Y') : '-') . "</td>";

                                                                            
                                                                                echo "<td>" . (!empty($row['returned_date']) ? (new DateTime($row['returned_date']))->format('d-M-Y') : '-') . "</td>";

                                                                           
                                                                                echo "<td>";
                                                                                switch($row['status']) {
                                                                                    case 'assigned':
                                                                                        echo "<span class='badge bg-success'>Assigned</span>";
                                                                                        break;
                                                                                    case 'returned':
                                                                                        echo "<span class='badge bg-danger'>Returned</span>";
                                                                                        break;
                                                                                    case 'damaged':
                                                                                        echo "<span class='badge bg-warning'>Damaged</span>";
                                                                                        break;
                                                                                    default:
                                                                                        echo "<span class='badge bg-secondary'>Unknown</span>";
                                                                                }
                                                                                echo "</td>";

                                                                                echo "<td>" . ($row['status'] == 'assigned' 
                                                                                            ? '<button type="button" data-id="' . $row['id'] . '" class="btn btn-sm btn-danger customer_device_change_status_btn">Return Now</button>' 
                                                                                            : '-') . "</td>";

                                                                                

                                                                                echo "</tr>";
                                                                            }    
                                                                        } 
                                                                        ?>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Modal for customer Remarsk update -->
            <div class="modal fade" id="customerRmarksChangeModal" tabindex="-1" role="dialog"
                aria-labelledby="Profile_pic_upload_Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Profile_pic_upload_Label">Update Customer Remarks</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="from-group d-none">
                                    <label>Customer id:</label>
                                    <input class="" type="text" id="update_customer_id"
                                        value="<?php echo $lstid; ?>">
                                </div>
                                <div class="from-group mb-2">
                                    <label>Customer Remarks</label>
                                    <textarea type="text" id="update_customer_remarks" class="form-control " placeholder="Enter Customer Remarks"
                                        value="<?php echo $remarks; ?>"><?php echo $remarks; ?></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="customer_remarks_update_btn" class="btn btn-primary">Update
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for customer username and password update -->
            <div class="modal fade" id="customerPasswordChangeModal" tabindex="-1" role="dialog"
                aria-labelledby="Profile_pic_upload_Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Profile_pic_upload_Label">Update Customer Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="from-group d-none">
                                    <label>Customer id:</label>
                                    <input class="" type="text" id="update_customer_id"
                                        value="<?php echo $lstid; ?>">
                                </div>
                                <div class="from-group mb-2">
                                    <label>Customer Username:</label>
                                    <input type="text" id="update_customer_username" class="form-control "
                                        placeholder="Enter Customer Username" value="<?php echo $username; ?>">
                                </div>
                                <div class="from-group mb-2">
                                    <label>Customer Password:</label>
                                    <input type="text" id="update_customer_password" class="form-control "
                                        placeholder="Enter Customer Password" value="<?php echo $password; ?>">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="customer_update_btn" class="btn btn-primary">Update
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Ticket -->
            <?php require "modal/tickets_modal.php"; ?>
            <!-- Modal for Recharge -->
            <div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog"
                aria-labelledby="ComplainModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ComplainModalLongTitle">
                                Recharge [<span style="color:red;" id="currentBal">Due Balance: <?php echo $totalDue; ?>
                                </span>]
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="recharge-form" method="POST">
                                <div class="form-group d-none">
                                    <label for="">id</label>
                                    <input id="customer_id" type="text" value="<?php echo $clid; ?>"
                                        class="form-control form-control-sm">
                                    <input id="pop_id" type="text" value="<?php echo $pop; ?>"
                                        class="form-control form-control-sm">
                                </div>
                                <div id="holders">
                                    <div class="form-group mb-1">
                                        <label>Month</label>
                                        <select id="month" class="form-select" name='month'>
                                            <option value="">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label for="">Package</label>
                                        <input id="package" disabled="Disable" name="package"
                                            class="form-control " value="<?php echo $packagename; ?>" />
                                    </div>
                                    <div class="form-group mb-1 ">
                                        <label>Package Price:</label>
                                        <input id="amount" disabled="Disable" type="text"
                                            class="form-control form-control-sm" value="<?php echo $price; ?>">
                                    </div>
                                </div>
                                <div class="form-group mb-1 ">
                                    <label>Payable Amount:</label>
                                    <input id="MainAmount" type="text" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1 ">
                                    <label>Ref No.:</label>
                                    <input id="RefNo" type="text" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label>Transaction Type:</label>
                                    <select id="tra_type" name="tra_type" class="form-select">
                                        <option>---Select---</option>
                                        <option value="1">Cash</option>
                                        <option value="0">On Credit</option>
                                        <option value="2">Bkash</option>
                                        <option value="3">Nagad</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button id="recharge-button" type="button" class="btn btn-success">Recharge Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------temp Customer Recharge------------------->
            <div class="modal fade" id="temp_recharge_Modal" tabindex="-1" role="dialog"
                aria-labelledby="ComplainModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ComplainModalLongTitle">
                                Recharge [<span style="color:red;" id="currentBal">Due Balance: <?php echo $totalDue; ?>
                                </span>]
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="recharge-form" method="POST">
                                <div class="form-group d-none">
                                    <label for="">id</label>
                                    <input id="customer_id" type="text" value="<?php echo $clid; ?>"
                                        class="form-control form-control-sm">
                                    <input id="pop_id" type="text" value="<?php echo $pop; ?>"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-1">
                                    <label>Days</label>
                                    <select id="days" class="form-select">
                                        <option value="">Select</option>
                                        <option value="01">1</option>
                                        <option value="02">2</option>
                                        <option value="03">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="form-group mb-1 ">
                                    <label>Ref No.:</label>
                                    <input id="RefNo" type="text" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label>Transaction Type:</label>
                                    <select id="tra_type" name="tra_type" class="form-select">
                                        <option>---Select---</option>
                                        <option value="0">On Credit</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button id="temp_recharge" type="button" class="btn btn-success"><i
                                    class="mdi mdi-cash"></i> Add Recharge</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------Add Payment received Modal---------------------------->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="addPaymentModal">
                <div class="modal-dialog" role="document">
                    <form id="FormData">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Payment Received</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="d-none" type="text" id="due_recharge_pop_id"
                                        value="<?php echo $pop; ?>">
                                    <input id="due_customer_id" type="text" value="<?php echo $clid; ?>"
                                        class="form-control d-none">
                                    <div class="form-group mb-2">
                                        <label>Amount:</label>
                                        <input type="text" id="addRechargeAmount" placeholder="Enter Your Amount"
                                            class="form-control">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Transaction Type:</label>
                                        <select id="addRechargeTra_type" class="form-select">
                                            <option>---Select---</option>
                                            <option value="1">Cash</option>
                                            <option value="2">Bkash</option>
                                            <option value="3">Nagad</option>
                                            <option value="4">Bank</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Remarks</label>
                                        <textarea id="addRechargeRemarks" class="form-control" placeholder="Enter Remarks"></textarea>
                                    </div>
                                    <div class="form-group d-none">
                                        <label>Recharge By:</label>
                                        <input type="text" id="recharge_by" class="form-control"
                                            value="<?php echo $_SESSION[
                                                "uid"
                                            ]; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-danger">Cancle</button>
                                <button type="button" id="addPaymentBtn" class="btn btn-primary"><i
                                        class="mdi mdi-cash"></i> Add Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-------------------- QR CODE  Modal---------------------------->
            <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div id="qrCodeContainer"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="downloadButton">Download QR
                                Code</button>
                            <button type="button" onclick="copyDetails();" class="btn btn-info" id="copy_qr_code_btn">Copy Url</button>
                            <button type="button" class="btn btn-success" id="print_qr_code_btn">Print QR Code</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "Footer.php"; ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include "script.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <!-- Include Tickets js File -->
    <script src="js/tickets.js"></script>
    <script type="text/javascript">
        $('#customer_device_table').dataTable();
        $('#tickets_table').dataTable();
        $('#recharge_data_table').dataTable({
            "ordering": false 
        });

        $('#user_activity_data_table').dataTable();
        showModal();

        function qr_function(customer_id, customer_name, phone_number) {
            const qrData = `https://sr-wifi.net?clid=${customer_id}`;

            $('#qrCodeContainer').html('');

            QRCode.toDataURL(qrData, {
                width: 200
            }, function(err, url) {
                if (err) {
                    console.error(err);
                    return;
                }

                $('#qrCodeContainer').html(`<img src="${url}" alt="QR Code" class="img-fluid">`);

                $('#downloadButton').off('click').on('click', function() {
                    const downloadLink = document.createElement('a');
                    downloadLink.href = url;
                    downloadLink.download = 'QRCode.png';
                    downloadLink.click();
                });

                $("#print_qr_code_btn").off('click').on('click', function() {
                    const printContent = `
                        <html>
                        <head>
                            <title>Print QR Code</title>
                            <style>
                                @media print {
                                    body {
                                        width: 60mm; /* Perfect for small thermal printers */
										height: 50mm;
                                        font-size: 14px;
                                        margin: 0;
                                        padding: 0;
                                        text-align: center;
                                        font-family: Arial, sans-serif;
                                    }
                                    .content-wrapper {
                                        display: flex;
                                        margin-top:20px;
                                        align-items: center;
                                        padding: 5px;
                                    }
                                    .qr-section {
                                        width: 60%;
										
										padding-left: 10px;
                                        text-align: center;
                                    }
                                    .info-section {
                                        width: 100%;
                                        text-align: left;
                                        padding-left: 20px;
                                    }
                                    .info-section p {
                                        margin: 2px 0;
                                        font-size: 12px;
                                    }
                                    img {
                                        display: block;
                                        margin: 0 auto;
                                        max-width: 100%;
                                    }
                                    .footer {
                                        text-align: center;
										font-size: 14px;
                                        margin-top: 5px;
                                        font-size: 10px;
                                        border-top: 1px dashed #000;
                                        padding-top: 2px;
										
                                    }
                                }
                            </style>
                        </head>
                        <body>
                            <div class="content-wrapper">
							
                                <div class="qr-section">
                                    <img src="${url}" alt="QR Code">
                                </div>
								<p><strong>Please Scan...</strong> 
								<br/>
								<br/>
								For Self Payment & Management.</p>
                            </div>
							
							<div class="info-section">
								<p><strong>ID: #</strong> ${customer_id}</p>
								<p><strong>Name:</strong> ${customer_name}</p>
							</div>
                            <div class="footer">
                                <strong>Support: 01821 600 600</strong>
                            </div>
                        </body>
                        </html>`;

                    const printWindow = window.open('', '__blank', 'width=800,height=800');
                    printWindow.document.open();
                    printWindow.document.write(printContent);
                    printWindow.document.close();

                    printWindow.onload = function() {
                        printWindow.print();
                        printWindow.close();
                    };
                });

                $('#qrCodeModal').modal('show');
            });
        }
        

        function copyDetails() {
    let customer_payment_url = "https://sr-wifi.net?clid=" + <?php echo $lstid; ?>;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(customer_payment_url)
            .then(() => {
                toastr.success("Copied the details:\n" + customer_payment_url); 
            })
            .catch(err => {
                console.error("Failed to copy details: ", err);
                toastr.error("Failed to copy details!"); 
            });
    } else {
        let tempInput = $("<textarea>");
        $("body").append(tempInput);
        tempInput.val(customer_payment_url).select();

        /*Focus before copying for older browsers*/ 
        tempInput[0].focus();
        
        /* Use execCommand to copy text*/
        if (document.execCommand("copy")) {
            toastr.success("Copied the details"); 
        } else {
            toastr.error("Failed to copy details!"); 
        }

        tempInput.remove();
    }

    return false; 
}

        function showModal() {
            $("#rechargeBtn").click(function() {
                $("#rechargeModal").modal('show');
                $("#month").on('change', function() {
                    var month = $("#month").val();
                    var amount = $("#amount").val();
                    totalAmount = (month * amount);
                    $("#MainAmount").val(totalAmount);
                });
            });
        }
        //addRecharge();


        $("#recharge-button").click(function() {
            var customer_id = $("#customer_id").val();
            var month = $("#month").val();
            var package = $("#package").val();
            var mainAmount = $("#MainAmount").val();
            var RefNo = $("#RefNo").val();
            var tra_type = $("#tra_type").val();
            var pop_id = $("#pop_id").val();
            var RechargData =
                "customer_id=" + customer_id +
                "&month=" + month +
                "&package=" + package +
                "&amount=" + mainAmount +
                "&RefNo=" + RefNo +
                "&tra_type=" + tra_type +
                "&pop_id=" + pop_id +
                "&add_recharge_data=0";
            if (month.length == 0 && $("#tra_type").val() != 4) {
                toastr.error("Select Month");
            } else if (mainAmount.length == 0) {
                toastr.error("Payable Amount Required");
            } else if (tra_type === '' || tra_type === null || tra_type === '---Select---') {
                toastr.error("Select Transaction Type");
            } else {
                $("#recharge-button").disabled;
                $.ajax({
                    type: 'POST',
                    url: 'include/customer_recharge_server.php',
                    data: RechargData,
                    success: function(response) {
                        // alert(response);
                        if (response == 1) {
                            toastr.success("Recharge Successful");
                            $("#rechargeModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else if (response == 2) {
                            toastr.error("Please Recharge This POP Account");
                        } else {
                            toastr.error(response);
                        }

                    }
                });
            }

        });

        //add due payment processing
        $(document).on('click', '#addPaymentBtn', function() {
            var pop_id = $("#due_recharge_pop_id").val();
            var recharge_amount = $("#addRechargeAmount").val();
            var due_customer_id = $("#due_customer_id").val();
            var transaction_type = $("#addRechargeTra_type").val();
            var remarks = $("#addRechargeRemarks").val();



            if (recharge_amount.length == 0) {
                toastr.error("Please Enter Amount");
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'include/customer_recharge_server.php',
                    data: {
                        customer_id: due_customer_id,
                        amount: recharge_amount,
                        remarks: remarks,
                        transaction_type: 4,
                        pop_id: pop_id,
                        addCustomerDuePayment: 0
                    },
                    success: function(response) {
                        if (response == 1) {

                            toastr.success("Payment Success");
                            $("#addPaymentModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }
                    }
                });
            }
        });


        $(document).on('click', '#temp_recharge', function() {
            var pop_id = $("#due_recharge_pop_id").val();
            var due_customer_id = $("#due_customer_id").val();
            var days = $("#days").val();

            var RefNo = $("#RefNo").val();
            var tra_type = $("#tra_type").val();


            if (days.length == 0) {
                toastr.error("Please Select Your Days");
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'include/customer_recharge_server.php',
                    data: {
                        customer_id: due_customer_id,
                        pop_id: pop_id,
                        days: days,
                        RefNo: RefNo,
                        transaction_type: tra_type,
                        customer_temp_recharge: 0
                    },
                    success: function(response) {

                        if (response == 1) {
                            toastr.success("Recharge Success");
                            $("#temp_recharge_Modal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }

                    }
                });
            }
        });
        //customer username and password update script
        $("#customer_update_btn").click(function() {
            var customerId = $("#update_customer_id").val();
            var customerUsername = $("#update_customer_username").val();
            var customerPassword = $("#update_customer_password").val();

            if (customerUsername.length == 0) {
                toastr.error("Please Enter Your Username");
            } else if (customerUsername.length == 0) {
                toastr.error("Please Enter Your Password");
            } else {
                $.ajax({
                    url: "include/customers_server.php",
                    method: "POST",
                    data: {
                        customer_id: customerId,
                        customer_username: customerUsername,
                        customer_password: customerPassword,
                        updateCustomerData: 0
                    },
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("Update Success");
                            $("#customerPasswordChangeModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

        });
        //customer Remarks update script
        $("#customer_remarks_update_btn").click(function() {
            var customerId = $("#update_customer_id").val();
            var customerRemarks = $("#update_customer_remarks").val();
            $.ajax({
                url: "include/customers_server.php",
                method: "POST",
                data: {
                    customer_id: customerId,
                    customer_remarks: customerRemarks,
                    update_customer_remarks_data: true,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $("#customerRmarksChangeModal").modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else if (response.success == false) {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        });

        //customer username and password update script
        $("#reconnect").click(function() {
            //var customerId = $("#update_customer_id").val();
            //var customerFramedIP = <?php echo $framedipaddress; ?>;

            alert("customerFramedIP");



        });







        $(document).on('click', '#recharge_undo', function() {

            var rechargeID = $(this).attr("data-id");

            var confrm = confirm("Are you sure undo recharge ?" + rechargeID);


            if (confrm) {

                $.ajax({
                    type: 'POST',
                    url: 'include/customer_recharge_server.php',
                    data: {
                        rechargeID: rechargeID,
                        undo_customer_recharge: 0
                    },
                    success: function(response) {

                        if (response == 1) {
                            toastr.success("Recharge Undone!");
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }

                    }
                });

            }

        });

        /*************************Google Map Load**********************************************************/

         /** Handle Customer Device return button click **/
        $(document).on('click', '.customer_device_change_status_btn', function () {
            let id = $(this).data('id');
            __handle_custom_ajax_action({
                id: id,
                button: this,
                url: 'include/customers_server.php',
                data: {
                    id: id,
                    customer_device_return: true
                },
                method:'POST',
                confirmMessage: 'Are you sure you want to return this customer device?',
                loadingText: 'Returning...',
                successMessage: 'Device returned successfully!',
                buttonText: '<i class="fas fa-arrow-left"></i> Return Now',
                reload: true 
            });
        });

        /*Handle Customer Device return and Customer Recharge undo*/
        function __handle_custom_ajax_action(options) {
            if (confirm(options.confirmMessage)) {
                let button = $(options.button);
                let originalHtml = button.html();
                let row = button.closest("tr");

                button.html('<i class="fas fa-spinner fa-spin"></i> ' + options.loadingText)
                    .prop("disabled", true);

                $.ajax({
                    url: options.url,
                    type: options.method || "GET",
                    data: options.data || {},
                    dataType:'json',
                    success: function(response) {
                        if (response.success) {
                            if (options.reload) {
                                toastr.success(response.message || options.successMessage);
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else if (options.removeRow) {
                                row.fadeOut(300, () => {
                                    row.remove();
                                    toastr.success(options.successMessage);
                                });
                            } else {
                                toastr.success(response.message || options.successMessage);
                            }
                        } else {
                            toastr.error(response.message || 'Operation failed.');
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong!");
                    },
                    complete: function() {
                        button.html(options.buttonText || originalHtml).prop("disabled", false);
                    }
                });
            }
        }
      
        /*** Add ticket Modal Script****/
        ticket_modal();
        loadCustomers(<?php echo $lstid; ?>);
        ticket_assign(<?php echo $lstid; ?>);
        ticket_complain_type();
    </script>
</body>

</html>
