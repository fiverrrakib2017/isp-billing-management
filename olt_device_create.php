<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php';?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title="OLT Device List";  include 'Header.php';  ?>

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
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-server"></i>&nbsp; Add OLT Device
                </h3>

            </div>
            <form action="{{ route('admin.olt.store') }}" method="POST" id="addOltForm">
                @csrf
                <div class="card">
                    <div class="card-body row">

                        <div class="form-group col-md-4">
                            <label for="name">OLT Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. OLT-Basundhara"
                                required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="brand">Brand <span class="text-danger">*</span></label>
                            <select name="brand" class="form-control" required>
                                <option value="">-- Select Brand --</option>
                                @foreach (['Huawei', 'ZTE', 'Fiberhome', 'VSOL', 'BDCOM', 'CDATA', 'Opton', 'Tenda', 'TP-Link', 'Nokia', 'DZS', 'Zhone', 'Edgecore', 'Netlink', 'Corelink', 'ECOM', 'TBS', 'Alcatel', 'Cisco', 'Raisecom', 'Skyworth', 'Planet', 'Visiontek', 'Other'] as $brand)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="mode">Mode</label>
                            <select name="mode" class="form-control" required>
                                <option value="">--- Select Mode ---</option>
                                @foreach (['GPON', 'XG-PON', 'EPON', 'XGS-PON', 'NG-PON2'] as $mode)
                                    <option value="{{ $mode }}">{{ $mode }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ip_address">IP Address <span class="text-danger">*</span></label>
                            <input type="text" name="ip_address" class="form-control" placeholder="e.g. 192.168.0.1"
                                required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="port">Port</label>
                            <input type="text" name="port" class="form-control" value="22">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="protocol">Protocol</label>
                            <select name="protocol" class="form-control">
                                <option value="SSH" selected>SSH</option>
                                <option value="Telnet">Telnet</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="snmp_community">SNMP Community</label>
                            <input type="text" name="snmp_community" class="form-control" placeholder="e.g. public">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="snmp_version">SNMP Version</label>
                            <select name="snmp_version" class="form-control">
                                <option value="">-- Select Version --</option>
                                <option value="v1">v1</option>
                                <option value="v2c" selected>v2c</option>
                                <option value="v3">v3</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="username">Login Username</label>
                            <input type="text" name="username" class="form-control" placeholder="e.g. username" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="password">Login Password</label>
                            <input type="password" name="password" placeholder="e.g. password" class="form-control"
                                required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="vendor">Vendor</label>
                            <input type="text" name="vendor" placeholder="e.g. Huawei" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="model">Model</label>
                            <input type="text" name="model" placeholder="e.g. ZTE" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" name="serial_number" placeholder="e.g. ZTE" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="firmware_version">Firmware Version</label>
                            <input type="text" name="firmware_version" placeholder="e.g. ZTE" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="location">Location</label>
                            <input type="text" name="location" placeholder="e.g. Dhanmondi" class="form-control"
                                placeholder="e.g. Dhanmondi POP Room">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Optional remarks about this OLT"></textarea>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.olt.index') }}" class="btn btn-danger">Back to OLT List</a>
                        <button type="submit" class="btn btn-primary">Create New OLT</button>
                    </div>
                </div>
            </form>
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
    <?php include 'script.php';?>
    
</body>

</html>