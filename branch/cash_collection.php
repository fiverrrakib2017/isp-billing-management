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
    <?php include '../style.php';?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php $page_title="Cash Collection"; include '../Header.php';?>
        
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
                                    <p class="text-primary mb-0 hover-cursor">Cash Collection</p>
                                 </div>
                              </div>
                              <br>
                           </div>
                           <div class="d-flex justify-content-between align-items-end flex-wrap">
                              
                           </div>
                        </div>
                     </div>
                  </div>
            <div class="row">
                     <div class="col-md-12 stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <span class="card-title"></span>
                              <div class="col-md-6 float-md-right grid-margin-sm-0">
                                 <div class="form-group">
                                    
                                       
                                 </div>
                              </div>
                              <div class="table-responsive">
                              <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cashed Collected From</th>
                                        <th>Cashed Received  By</th>
                                        <th>Collection Date</th>
                                        <th>Total Amount</th>
                                        <th>Received Amount</th>
                                        <th>Remarks</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <?php 
                                    $sql = "SELECT 
                                            cc.id, 
                                            cc.collection_date, 
                                            cc.amount, 
                                            cc.received_amount, 
                                            cc.note, 
                                            u.id AS USERID, 
                                            u.fullname AS user_name, 
                                            uploader.fullname AS uploader_name 
                                        FROM 
                                            cash_collection cc 
                                        LEFT JOIN 
                                            users u ON cc.user_id = u.id 
                                        LEFT JOIN 
                                            users uploader ON cc.uploader_info = uploader.id 
                                        WHERE 
                                            cc.pop_id = '$auth_usr_POP_id'
                                        ORDER BY 
                                            cc.id DESC;
                                        ";

                                    $result = mysqli_query($con, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $collection_date = $rows['collection_date'];
                                        $yearMonth = date("Y-m-d", strtotime($collection_date)); 
                                    ?>
                                    <tr>
                                    <td><?php echo $rows['id']; ?></td>
                                    <td><?php echo $rows["user_name"]; ?></td>
                                    <td><?php echo $rows["uploader_name"]; ?></td>
                                        <td>
                                            <a href="daily_recharge.php?date=<?php echo $yearMonth; ?>&user_id=<?php echo $rows['USERID'];?>">
                                                <?php 
                                                $dateTm = new DateTime($collection_date);
                                                echo $dateTm->format("d-M-Y");
                                                ?>
                                            </a>
                                        </td>
                                        <td><?php echo $rows["amount"]; ?></td>
                                        <td><?php echo $rows["received_amount"]; ?></td>
                                        <td><?php echo $rows["note"]; ?></td>
                                        <td>
                                        <a  href="daily_recharge.php?date=<?php echo $yearMonth; ?>&user_id=<?php echo $rows['USERID'];?>" class="btn-sm btn btn-success"><i class="fas fa-eye"></i> </a>
                                        </td>
                                       
                                    </tr>
                                    <?php } ?>
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

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © IT-FAST.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>





<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
      
        
        <!-- JAVASCRIPT -->
    <?php include '../script.php';?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#select_user_id').change(function() {
                var userId = $(this).val();
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/bill_collection_server.php?show_data_filter';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { user_id: userId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#tableBody').html(data.tableData);
                        $('#pagination').html(data.pagination);
                    }
                });
            });
             /* Filter With Pagination*/
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                var userId = $('#select_user_id').val();
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/bill_collection_server.php?show_data_filter';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { user_id: userId, page: page },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#tableBody').html(data.tableData);
                        $('#pagination').html(data.pagination);
                    }
                });
            });
             /* Only allow one checkbox to be selected*/
            $('#datatable input[type="checkbox"]').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#datatable input[type="checkbox"]').not(this).prop('checked', false);
                }
            });

            /*When the bill button is clicked*/ 
            $("button[name='bill_button']").click(function(){
                 var select_id = [];
                var totalAmount = '';
                var collectionDate=[]
                $('#datatable input[type="checkbox"]:checked').each(function() {
                    select_id.push($(this).data('id'));
                    collectionDate.push($(this).data('collection_date'));

                    /* Get the row's data from the table*/
                    var row = $(this).closest('tr');
                    console.log(row); 
                    totalAmount = row.find('td:eq(2)').text().trim(); 
                });
                /* Set the values in the modal's form fields*/
                $('#total_amount').val(totalAmount);
                $("input[name='collection_date']").val(collectionDate);
                $("input[name='user_id']").val(select_id);

                if (select_id.length > 0) {
                    $("#bill_modal").modal('show');
                } else {
                    toastr.error("Please Select Checkbox");
                }
            });
             /** Store The data from the database table **/
            $('#bill_modal form').submit(function(e){
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                /** Use Ajax to send the delete request **/
                $.ajax({
                type:'POST',
                'url':url,
                data: formData,
                dataType:'json',
                success: function (response) {
                    /* Check if the request was successful*/
                    if (response.success) {
                        /*Hide the modal*/ 
                        $('#bill_modal').modal('hide'); 
                        /*Reset the form*/ 
                        $('#bill_modal form')[0].reset();
                        /* Show success message*/
                        toastr.success(response.message); 

                        /*Reload the page after a short delay*/ 
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                },


                error: function (xhr, status, error) {
                    /** Handle  errors **/
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); 
                        });
                    }
                }
                });
            });
        });

    </script>
    </body>
</html>
