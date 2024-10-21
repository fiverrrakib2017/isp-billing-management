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
         $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        echo file_get_contents($url);
        
        ?>
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
        <?php 
           
        $page_title = "Message Template";
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
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">


                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Message Template</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;&nbsp;New Template</button>
                          </div>
                            </div>
                        </div>
                    </div>






                   <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Template</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <form >
                                <div class="form-group mb-2">
                                    <label>Template Name</label>
                                    <input class="form-control" type="text" id="templateName" placeholder="Type Your Text Here"/>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Message Template</label>
                                    <textarea class="form-control" type="text" id="textMessage" placeholder="Type Your Text Here" style="height: 105px;"></textarea> 
                                </div>
                                <div class="form-group mb-2 d-none">
                                    <input class="form-control" type="text" id="pop_id" value="<?php echo $auth_usr_POP_id; ?>" />
                                </div>
                                </form>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary"
                                 data-bs-dismiss="modal">Close</button>
                              <button id="add_template" type="button" class="btn btn-primary">Add Template</button>
                           </div>
                        </div>
                     </div>
                  </div>







                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">


                                    <div class="col-md-6 float-md-right grid-margin-sm-0">



                                    </div>


                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Template Name</th>
                                                    <th>Message Template</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody >
        
         <?php 

                          $sql="SELECT * FROM message_template WHERE pop_id=$auth_usr_POP_id  ";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
        <td><?php echo $rows['id']; ?></td>
        <td>
            <?php 
            echo $rows['template_name']; 
             

            ?>
                
            </td>
        <td >
            <?php
             $textFile= $rows['text'];
            echo  substr($textFile, 0, 50)."......";

            ?>
                
        </td>
       <td style="text-align:right">
        <a   href="message_template_edit.php?id=<?php echo $rows['id']; ?>" class="btn-sm btn btn-info"><i class="fas fa-edit"></i></a>

        <a   href="message_template_delete.php?id=<?php echo $rows['id']; ?>"class="btn-sm btn btn-danger"onclick="return confirm('Are you sure');"><i class="fas fa-trash"></i>
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

    <?php 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
        
        echo file_get_contents($url);
        
    ?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <!-- JAVASCRIPT -->
        <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
            
            echo file_get_contents($url);
            
        ?>


      <script type="text/javascript">
          $(document).ready(function(){
            $(".deleteBtn").click(function(){
                var id=$(this).data('id');
                alert(id);
            });
            $("#add_template").click(function(){
                 var templateName=$("#templateName").val();
                 var message=$("#textMessage").val();
                 var pop_id=$("#pop_id").val();
                 if (message.length==0) {
                    toastr.error("Please Type Your Message");
                 }else if(templateName.length==0){
                     toastr.error("Template Name Require");
                 }
                 else{
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/message.php';
                   var messageDataInsert="0";
                   $.ajax({
                    type:'POST',
                    data:{message:message,messageDataInsert:messageDataInsert,pop_id:pop_id,templateName:templateName},
                    url:url,
                    cache:false,
                    success:function(response){
                        toastr.success(response);
                        $("#addModal").modal('hide');
                         setTimeout(()=>{location.reload();},1000);
                    }
                   });
                 }
            });
          });
      </script>

    </body>
</html>
