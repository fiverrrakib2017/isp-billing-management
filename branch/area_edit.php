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

if (isset($_GET["id"])) {
    $areaId=$_GET['id'];
    if ($POP=$con->query("SELECT * FROM area_list WHERE id='$areaId'")) {
        while($rows=$POP->fetch_array()){
            $id=$rows["id"];
            $area_name=$rows["name"];
        }
    }
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
           
           $page_title = "Area Update";
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
                <div class="col-md-4 m-auto">
                    <div class="card">
                        <div class="card-header text-center bg-dark text-white">Area Update</div>
                        <div class="card-body">
                            <form id="updateArea">
                                <div class="form-group">
                                    <label>Area Location*</label>
                                    <input class="d-none" type="text" value="<?php echo $id; ?>" name="id">
                                    <input id="form" name="area" class="form-control " type="text" value="<?php echo $area_name; ?>">
                                    <br>
                                    <button id="up_area_button" class="btn btn-primary mr-1">Update</button>
                                   <button type="button" onclick="history.back();"  class="btn btn-danger mr-1">Back</button>
                                </div>
                            </form>
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
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/add_area.php?update';
                $("#up_area_button").click(function(e){
                    e.preventDefault();
                    var formData=$("#updateArea").serialize();
                    $.ajax({
                        type:"GET",
                        url: url,
                        data:formData,
                        cache:false,
                        success:function(){
                            toastr.success("Data Update Success!");
                        }
                    });
                });
            });
        </script>
    </body>
</html>
