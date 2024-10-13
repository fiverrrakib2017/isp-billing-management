<?php
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
include("include/pop_security.php");


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
       <?php $page_title="Transaction"; include 'Header.php';?>

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
                        <div class="row">
                            <div class="card ">
                                <div class="container">
                                    <div class="row mb-3 mt-1">
                                        <input id="user_id" class="form-control d-none" type="text" value="<?php if (isset($_SESSION['uid'])) {echo $_SESSION['uid'];} ?>">


                                    </div>
                                    <div class="row mb-3 mt-1">
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Refer No:</label>
                                                <input class="form-control" type="text" placeholder="Type Your Refer No" id="refer_no">
                                            </div>
                                        </div>
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Note:</label>
                                                <input class="form-control" type="text" placeholder="Notes" id="note">
                                            </div>
                                        </div>
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input class="form-control" type="date" id="currentDate" value="<?php echo $date = date('m/d/Y ', time()); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mt-2">
                                                <label for="">Sub Ledger</label>
                                                <select class="form-control select2" id="sub_ledger">

                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group mt-4">
                                                <button class=" btn btn-primary ml-0" type="button" data-bs-toggle="modal" data-bs-target="#addSubLedgerModal" style="margin-top:5px;">+</button>
                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Quantity</label>
                                                <input type="number" id="qty" class="form-control" min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Value</label>
                                                <input type="text" class="form-control" id="value">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Total</label>
                                                <input id="total" type="text" class="form-control">
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="form-group mt-2">
                                                <label for="">Details</label>
                                                <input id="details" type="text" class="form-control" placeholder="Details">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="button" id="submitButton" class=" btn btn-primary " style="margin-top: 25px; width:100%;">Add</button>
                                            </div>
                                        </div>
										
                                    </div>

                                    <div class="row">
                                        <div class=" mt-4">
                                            <div class="col-md-12 col-sm-12" >
                                               <div class="table-responsive" id="sub_ledgr_table1">

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
                <div class="modal fade" id="addSubLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Sub Ledger</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                        <div class="row">
                                            
                                                <div class="form-group mb-2"style="width:100%">
                                                    <label for="">Ledger Name</label>
                                                    <select name="ledger_id" id="sub_ledger_id" class="form-select" >
                                                        <?php
                                                        if ($ledgr = $con->query("SELECT * FROM ledger")) {

                                                            while ($rowsitm = $ledgr->fetch_array()) {
                                                                $ldgritmsID = $rowsitm["id"];
                                                                $ledger_name = $rowsitm["ledger_name"];
                                                                echo '<option value="' . $ldgritmsID . '">' . $ledger_name . '</option>';
                                                            }
                                                        }


                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="">Sub Ledger Name</label>
                                                    <input id="item_name" type="text" class="form-control" placeholder="Enter Item Name">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="">Description</label>
                                                    <input id="subLedgerDescription" type="text" class="form-control" name="description" placeholder="description">
                                                </div>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button id="addSubLedgerBtn" type="submit" class="btn btn-primary">Add Sub Ledger</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php';?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    
    <?php include 'script.php';?>
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#sub_ledgr_table1').html('include/_server.php?show');
            getAllData();
            getLedgerData();

            
            function getLedgerData() {
                $.ajax({
                    url: "include/transactions_server.php?getLedger",
                    method: 'GET',
                    success: function(response) {
                        $('#sub_ledger').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            }

            function getAllData() {
                $.ajax({
                    url: "include/transactions_server.php?show",
                    method: 'GET',
                    success: function(response) {
                        $('#sub_ledgr_table1').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            } 
            //$("#sub_ledger_id").select2();
            $("#sub_ledger").select2();
           
            // Get the value and quantity input elements
            $('#qty').change(calculate);
            $('#value').keyup(calculate);

            function calculate(e) {
                $('#total').val($('#qty').val() * $('#value').val());
            }
            $("#submitButton").click(function() {
                var user_id = $("#user_id").val();
                var refer_no = $("#refer_no").val();
				var details = $("#details").val();
                var note = $("#note").val();
                var currentDate = $("#currentDate").val();

                var sub_ledger = $("#sub_ledger").val();
                var qty = $("#qty").val();
                var value = $("#value").val();
                var total = $("#total").val();

                if (sub_ledger.length == '') {
                    toastr.error('Sub ledger is require');
                }else if(currentDate.length==0){
                    toastr.error('Please Select Your Date');
                }
                
                else if (value.length=='') {
                    toastr.error('Value is require');
                } else if (qty.length=='') {
                    toastr.error('Quantity is require');
                } else if (total.length=='') {
                    total.error('Total Amount is require');
                } else {
                    //alert(sub_ledger);
                    var addTransactionData = 0;
                    $.ajax({
                        type: "POST",
                        data: {
                            addTransactionData: addTransactionData,
                            refer_no: refer_no,
                            note: note,
                            currentDate: currentDate,
                            sub_ledger: sub_ledger,
                            qty: qty,
                            value: value,
                            total: total,
                            user_id: user_id,
							details: details
                        },
                        url: "include/transactions_server.php",
                        cache: false,
                        success: function(response) {
                            if (response == 1) {
                                $("#refer_no").val('');
                                $("#description").val('');
                                $("#qty").val(1);
                                $("#value").val('');
                                $("#total").val('');

                            } else {
                                toastr.error(response);
                            }
                            getAllData();

                        }
                    });
                }

            });
            $("#addSubLedgerBtn").click(function() {
                var sub_ledger_id = $("#sub_ledger_id").val();
                var item_name = $("#item_name").val();
                var subLedgerDescription = $("#subLedgerDescription").val();
                if (sub_ledger_id.length == '') {
                    toastr.error('Select Ledger');
                } else if (item_name.length == 0) {
                    toastr.error('Item is require');
                }  else {
                    var addSubLedgerData = 0;
                    $.ajax({
                        type: "POST",
                        data: {
                            addSubLedgerData: addSubLedgerData,
                            sub_ledger_id: sub_ledger_id,
                            item_name: item_name,
                            description: subLedgerDescription
                        },
                        url: "include/transactions_server.php",
                        cache: false,
                        success: function(response) {
                            if (response == 1) {
                                toastr.success("Add Successfully ");
                                $('#addSubLedgerModal').modal('hide');
                            } else {
                                toastr.error("Please Try Again");
                            }
                            //$('#sub_ledgr_table').load('include/transactions_server.php?show');
                            getLedgerData();
                        }
                    });
                }

            });
            $(document).on('click',".finishedBtn",function(){
                $.ajax({
                    url: "include/transactions_server.php?finishedTransaction",
                    method: 'GET',
                    success: function(response) {
                        if (response==1) {
                            toastr.success("Finish Successfully");
                            getAllData();
                        }
                       // $('#sub_ledger').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            });
            $(document).on('click',"#transaction_deleteBtn",function(){
                var id=$(this).data('id');
                alert(id);
                // $.ajax({
                //     url: "include/transactions_server.php?finishedTransaction",
                //     method: 'GET',
                //     success: function(response) {
                //         if (response==1) {
                //             toastr.success("Finish Successfully");
                //             getAllData();
                //         }
                //        // $('#sub_ledger').html(response);
                //     },
                //     error: function(xhr, status, error) {
                //         // handle the error response
                //         console.log(error);
                //     }
                // });
            });
            function deleteTransaction(dataid){
                alert(dataid);
            }
        });
    </script>


</body>

</html>