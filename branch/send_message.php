 <?php 
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
}
?>

<!doctype html>
<html lang="en">
    <head>
    
          <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
         $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
         $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/style.php';
        echo file_get_contents($url);
        
        ?>
        <style type="text/css">
            span.select2-selection.select2-selection--single {
                 height: 35px;
            }
        </style>
    </head>

    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <?php 
           
                $page_title = "Send Message";
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
                $url = $protocol . $_SERVER['HTTP_HOST'] . '/Header.php';
                include '../Header.php';
              
            ?>


        
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
                     <div class="col-md-12 ">
                <div class="card">
                <div class="card-body  shadow">
                    <form class="row g-3 align-items-end" id="search_box">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pop_id" class="form-label">POP/Branch Name <span class="text-danger">*</span></label>
                                <select name="pop_id" id="pop_id" class="form-select" style="width: 100%;">
                                    <option>---Select---</option>
                                    <?php 
                                    if ($allPOPuSR = $con->query("SELECT * FROM add_pop WHERE id = $auth_usr_POP_id")) {
                                        while ($rows = $allPOPuSR->fetch_array()) {
                                            //$selected = ($rows['id'] == $auth_usr_POP_id) ? 'selected' : '';
                                            echo '<option value="'.$rows['id'].'" >'.$rows['pop'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="area" class="form-label">Area</label>
                                <select name="area" id="area" class="form-select" style="width: 100%;">
                                    <option>---Select---</option> 
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer_status" class="form-label">Status </label>
                                <select name="customer_status" id="customer_status" class="form-select" style="width: 100%;" >
                                    <option value="">---Select---</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="expired">Expired</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="due">Due</option>
                                    <option value="free">Free</option>
                                    <option value="active">Active</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Expire Date  <span class="text-danger">*</span></label>
                                <input type="date" name="customer_expire_date" id="customer_expire_date" class="form-control" required>
                                    
                            </div>
                        </div>

                        <div class="col-md-3 d-grid">
                            <div class="form-group">
                                <button type="button" name="search_btn" class="btn btn-success">
                                    <i class="fas fa-search me-1"></i> Search Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                    <div class="card-body d-none" id="print_area">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" id="send_message_btn" class="btn btn-danger mb-2"><i class="far fa-envelope"></i>
                                    Process </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive responsive-table">

                            <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>

                                        <th class=""><input type="checkbox" id="selectAll"
                                                class="form-check-input customer-checkbox"></th>
                                        <th class="">ID.</th>
                                        <th class="">Username</th>
                                        <th class="">Package </th>
                                        <th class="">Expire Date </th>
                                        <th class="">POP/Branch</th>
                                        <th class="">Area</th>
                                        <th class="">Phone Number</th>
                                        <th class="">Address</th>
                                    </tr>
                                </thead>
                                <tbody id="_data">
                                    <tr id="no-data">
                                        <td colspan="10" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div>
                     </div>
                 </div> <!-- container-fluid -->
             </div>
                <!-- End Page-content -->

                <?php 
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
                    $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
                    
                    echo file_get_contents($url);
                    
                ?>

            </div>
            <!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

<!-- Modal for Send Message -->
<div class="modal fade bs-example-modal-lg" id="sendMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                        &nbsp;Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="paymentForm" method="POST">

                        <div class="form-group mb-2">
                            <label>Message Template</label>
                            <select class="form-select" name="message_template">
                                <option>---Select---</option>
                                <?php
                                if ($allCstmr = $con->query("SELECT * FROM message_template WHERE pop_id=".$auth_usr_POP_id." ")) {
                                    while ($rows = $allCstmr->fetch_array()) {
                                        echo '<option value=' . $rows['id'] . '>' . $rows['template_name'] . '</option>';
                                    }
                                }
                                
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Message</label>
                            <textarea id="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="button" name="send_message_btn" class="btn btn-success">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <!-- JAVASCRIPT -->
        <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/script.php';
            
            echo file_get_contents($url);
            
        ?>

      <script type="text/javascript">
            $(document).on('change','#cstmr_ac',function(){
                var customerID = $(this).val();
                if(customerID){
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    type: 'POST',
                    url: url, 
                    data: {get_customer_phone_number: customerID},
                    success: function(response){
                        $("#phone").val(response);
                    }
                });
                }else{
                    $("#phone").val('Phone Number');
                }
            });
           
      </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var protocol = location.protocol;
            $('#pop_id').select2({
                placeholder: 'Select POP/Branch',
                allowClear: false
            });
            $('#area').select2({
                placeholder: 'Select Area',
                allowClear: false
            });
            $('#customer_status').select2({
                placeholder: 'Select Status',
                allowClear: false
            });
           
            $("select[name='pop_id']").on('change', function() {
                var pop_id = $(this).val();
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/add_pop.php';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {pop_id: pop_id},
                    success: function(data) {
                        console.log(data);
                        $('#area').html(data).select2({
                            placeholder: 'Select Area',
                            allowClear: false
                        });
                    }
                });
            });

            /***Load Customer **/
            $("button[name='search_btn']").click(function() {
                var button = $(this); 

                button.html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                button.attr('disabled', true);
                var pop_id = $("#pop_id").val();
                var area_id = $("#area").val();
                var customer_status = $("#customer_status").val();
                var customer_expire_date = $("#customer_expire_date").val() || '';
                if ( $.fn.DataTable.isDataTable("#datatable1") ) {
                    $("#datatable1").DataTable().destroy();
                }
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php?get_customer_data_for_message=true';
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {pop_id: pop_id, area_id: area_id, customer_status: customer_status, customer_expire_date:customer_expire_date},
                    success: function(response) {
                        if(response.success==true){
                            
                            $("#print_area").removeClass('d-none');
                            $("#_data").html(response.data);
                            $("#datatable1").DataTable({
                                "paging": true,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                            });
                            
                            $('#selectAll').on('click', function() {
                                $('.customer-checkbox').prop('checked', this.checked);
                            });
                            
                            $('.customer-checkbox').on('click', function() {
                                if ($('.customer-checkbox:checked').length == $('.customer-checkbox').length) {
                                    $('#selectAll').prop('checked', true);
                                } else {
                                    $('#selectAll').prop('checked', false);
                                }
                            }); 
                        }
                        
                        if(response.success==false) {
                            toastr.error(response.message);
                            $("#_data").html('<tr id="no-data"><td colspan="10" class="text-center">No data available</td></tr>');
                        }
                    },
                    complete: function() {
                        button.html('<i class="fas fa-search me-1"></i> Search Now');
                        button.attr('disabled', false);
                    }
                });
            });
            $(document).on('click', '#send_message_btn', function(event) {
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var countText = "You have selected " + selectedCustomers.length + " customers.";
            $("#selectedCustomerCount").text(countText);
            $('#sendMessageModal').modal('show');

        });
        $(document).on('click', 'button[name="send_message_btn"]', function(e) { 
            e.preventDefault();
             var $button = $(this);
            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/message_server.php?bulk_message=true';
          
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    /*sending the array of customer IDs*/
                    customer_ids: selectedCustomers,
                    message: $("#message").val(),
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#sendMessageModal').modal('hide');
                        //$('#customers_table').DataTable().ajax.reload();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred: " + error);
                },
                complete: function() {
                    $button.prop('disabled', false).html('Send Message');
                }
            });
        });
        $('select[name="message_template"]').on('change', function() {
            var name = $(this).val();
            var currentMsgTemp = "0";
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/message.php';
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    currentMsgTemp: currentMsgTemp
                },
                url: url,
                success: function(response) {
                    $("#message").val(response);
                }
            });
        });
    });


     </script>

    </body>
</html>
