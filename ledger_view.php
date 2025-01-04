<?php
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
include("include/pop_security.php");
?>
<?php

include "include/db_connect.php";
if (isset($_GET['id'])) {
    $id = $_GET["id"];
    if ($ledgr = $con->query("SELECT * FROM ledger WHERE id='$id'")) {


        while ($rows = $ledgr->fetch_assoc()) {
            $ledger_id = $rows["id"];
            $ledger = $rows["mstr_ledger_id"];
            $name = $rows["ledger_name"];
        }
    }
    //$con->close();
}

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

       <?php $page_title="Ledger View"; include 'Header.php'; ?>


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
                                            <p class="text-primary mb-0 hover-cursor">Ledger View</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New Sub Ledger</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="addModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content col-md-10">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-lan mdi-18px"></span> &nbsp;New Sub Ledger</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div>
                                    <!--ledger form start-->
                                    <form id="ledger-frm">
                                        <div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <form class="form-sample">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group ">
                                                                    <input type="hidden" class="form-control" name="ledgerId" placeholder="Ledger Id" value="<?php echo $id; ?>">
                                                                </div>
                                                                <div class="form-group ">
                                                                    <input type="text" class="form-control" name="name" placeholder="Item Name" id="name">
                                                                </div><br>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input class="form-control" placeholder="Enter description" name="discription" id="description">

                                                                    </input>
                                                                </div><br>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="save">Save</button>
                                        </div>
                                    </form>
                                    <!--ledger form end-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title">Sub Ledger</span>
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="row mt-5  p-2">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="mb-0">Master Ledger:  <span class="col text-secondary">
                                                        <?php 
                                                        if($ledger==1){
                                                            echo "Income";
                                                        } else if($ledger==2){
                                                            echo "Expense";
                                                        }else if($ledger==3){
                                                            echo "Asset";
                                                        }else if($ledger==4){
                                                            echo "Liabilities";
                                                        }
                                                        ?>
                                                </span> </h6>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="mb-0">Ledger:   <span class="col text-secondary"><?php echo $name; ?></span> </h6>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    if ($sbledger = $con->query("SELECT * FROM  legder_sub WHERE ledger_id='$ledger_id'")) {
                                                        while ($rows = $sbledger->fetch_assoc()) {
                                                            $id = $rows["id"];
                                                            $ledgerId = $rows["ledger_id"];
                                                            $name = $rows["item_name"];
                                                            $description = $rows["description"];

                                                            echo '
                                                            <tr>
                                                            <td>' . $name . '</td>
                                                            <td><a class="btn-sm btn btn-success" href="#"><i class="fas fa-eye"></i></a></td>
                                                            
                                                            </tr>
                                                            ';
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
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <?php include 'script.php'; ?>

    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#ledger_view").DataTable();
           

            // $("#save").click(function() {
            //     var name = $("#name").val();
            //     var description = $("#description").val();
            //     if (name.length == 0) {
            //         toastr.error("name is required");
            //     }  else {
            //         var formData = $("#ledger-frm").serialize();
            //         console.log(formData); 
            //         return false; 
            //         $.ajax({
            //             type: "GET",
            //             url: "include/sub_ledger.php?add",
            //             data: formData,
            //             cache: false,
            //             success: function(response) {
            //                 if (response == 1) {
            //                     $("#addModal").modal('hide');
            //                     toastr.success("Sub Ledger Add Successfully");
            //                     setTimeout(() => {
            //                         location.reload();
            //                     }, 1000);
            //                 } else {
            //                     toastr.error("Please Try Again");
            //                 }


                            
            //             }
            //         });
            //     }


            // });
            $("#save").click(function() {
                var item_name = $("#name").val();
                var subLedgerDescription = $("#description").val();
                if (item_name.length == 0 ||item_name == null || item_name == undefined) {
                    toastr.error('Item is require');
                    return false; 
                } 
                var addSubLedgerData = 0;
                $.ajax({
                    type: "POST",
                    data: {
                        addSubLedgerData: addSubLedgerData,
                        sub_ledger_id: <?php echo $ledger_id;?>,
                        item_name: item_name,
                        description: subLedgerDescription
                    },
                    url: "include/transactions_server.php",
                    cache: false,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("Add Successfully ");
                            $('#addModal').modal('hide');
                        } else {
                            toastr.error("Please Try Again");
                        }
                    }
                });


            });
        });
    </script>

</body>

</html>