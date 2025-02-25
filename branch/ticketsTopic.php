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
        <!-- DataTables -->
        <?php 
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/style.php';
        
        echo file_get_contents($url);
    ?>

    </head>

    <body data-sidebar="dark">


        

        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
           
            $page_title = "Tickets Topic";
          
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
               <div class="col-md-12 grid-margin">
                  <div class="d-flex justify-content-between flex-wrap">
                     <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                           <div class="d-flex">
                              <i class="mdi mdi-home text-muted hover-cursor"></i>
                              <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                              </p>
                              <p class="text-primary mb-0 hover-cursor">Ticket</p>
                           </div>
                        </div>
                        <br>
                     </div>
                     <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;Add Ticket</button>
                     </div>
                     <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true" id="addModal">
                     <div class="modal-dialog modal-medium" role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Ticket Topic</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Ticket Topic</label>
                                    <input type="text" id="ticketTopic" class="form-control" placeholder="Enter Ticket Topic">
                                </div>
                                <div class="form-group d-none">
                                    <label>pop id</label>
                                    <input type="text" id="pop_id" class="form-control" value="<?php echo $auth_usr_POP_id; ?>">
                                </div>
                            </form>
                              
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="save">Add Now</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
            <div class="row">
                     <div class="col-md-12 stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <div class="col-md-6 float-md-right grid-margin-sm-0">
                                 <div class="form-group">
                                    
                                 </div>
                              </div>
                              <div class="table-responsive">
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr >
                                            <th>ID</th>
                                            <th>Ticket Topics</th>
                                            <th ></th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                     <?php 
                          $sql="SELECT * FROM ticket_topic WHERE pop_id='$auth_usr_POP_id' AND user_type=$auth_usr_type  ";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
<td><?php echo $rows['id']; ?></td>
<td><?php echo $rows["topic_name"]; ?></td>

<td style="text-align:right">
<a class="btn-sm btn btn-info" href="ticket_topic_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>


<a href="ticket_topic_delete.php?id=<?php echo $rows['id']; ?>" class="btn-sm btn btn-danger deleteBtn" onclick=" return confirm('Are You Sure');" data-id=<?php echo $rows['id']; ?>><i class="fas fa-trash"></i>
</a>

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
         
        <?php

        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/script.php';

        echo file_get_contents($url);

        ?>
         <script type="text/javascript">
            addTicket()
            function addTicket(){
                $("#save").click(function(){
                var ticketTopic=$("#ticketTopic").val();
                var pop_id=$("#pop_id").val();
                var user_type=<?php echo $auth_usr_type;?>;
                if (ticketTopic.length==0) {
                    toastr.error('Ticket Topic Name required');
                }else{
                    var addTicketTopicData="0";
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/tickets_server.php';
                $.ajax({
                    type:"POST",
                    data:{addTicketTopicData:addTicketTopicData,ticketTopic:ticketTopic,pop_id:pop_id,user_type:user_type},
                    url:url,
                    cache:false,
                    success:function(response){
                       if (response==1) {
                            $("#addModal").modal('hide');
                            toastr.success("Add Successfully")
                           setTimeout(()=>{
                            location.reload();
                           },1000);
                       }else{
                        toastr.error("Please try again");
                       }
                    }
                });  
                }
                
            });
            }
        </script>
    </body>
</html>
