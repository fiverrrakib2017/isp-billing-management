<?php
   include "include/security_token.php";
   include "include/db_connect.php";
   include "include/pop_security.php";
   include "include/users_right.php";
   
   ?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />

    <style>
        

    </style>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">


        <?php $page_title="Area/House"; include 'Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Area/House no</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"  data-bs-toggle="modal" data-bs-target="#addModal"> Add Area</button>
                                </div>
                                <div class="card-body">
                                <table id="areaDataTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
    <thead>
        <!-- <tr>
            <th>Area Name</th>
        </tr> -->
    </thead>
    <tbody id="area_table">
    <div id="areaTree">
    <ul>
        <?php
        $query = "
            SELECT 
                h.area_id,
                ar.name AS area_name,
                GROUP_CONCAT(h.house_no SEPARATOR ', ') AS house_numbers
            FROM 
                area_house h
            JOIN 
                area_list ar 
            ON 
                h.area_id = ar.id
            GROUP BY 
                h.area_id, ar.name
        ";

        $result = $con->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li>';
                    echo '<span>' . $row['area_name'] . '</span>';
                    echo '<ul>';
                    $house_numbers = explode(', ', $row['house_numbers']);
                    foreach ($house_numbers as $house_no) {
                        echo '<li>House No: ' . $house_no . '</li>';
                    }
                    echo '</ul>';
                    echo '</li>';
                }
            } else {
                echo '<li>No data available</li>';
            }
        } else {
            echo '<li>Error in query execution: ' . $con->error . '</li>';
        }
        ?>
    </ul>
</div>

    </tbody>
</table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include 'footer.php';?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-area">
                                <div class="form-group mb-1">
                                    <label>POP/Area</label>
                                    <select class="form-select" name="area_id" id="area_id">
                                        <option value="">Select</option>
                                        <?php
                                        if ($pop = $con->query("SELECT * FROM area_list")) {
                                            while ($rows = $pop->fetch_array()) {
                                                $id = $rows['id'];
                                                $name = $rows['name'];
                                                echo '<option value="' . $id . '">' . $name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-1">
                                    <label>House-Building No.</label>
                                    <input class="form-control" type="text" name="house_no" id="house_no" placeholder="Type  House-Building No." />
                                  
                                </div>
                                <div class="form-group mb-1">
                                    <label>Note</label>
                                    <input class="form-control" type="text" name="note" id="note" placeholder="Type Your Note" />
                                  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="add_area" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function () {
            $('#areaTree').jstree({
                "core": {
                    "themes": {
                        "responsive": true
                    }
                },
                "plugins": ["wholerow"]
            }).on('ready.jstree', function (e, data) {
                data.instance.open_all();
            });

            $(document).on('click','#add_area',function(){
                // var formData=$("#form-area").serialize();
                var area_id=$("select[name='area_id']").val();
                var house_no=$("input[name='house_no']").val();
                var note=$("input[name='note']").val();
                var formData="area_id="+area_id+"&house_no="+house_no+"&note="+note;
                $.ajax({
                    type:'POST',
                    url:'include/add_area.php?add_area_house',
                    data:formData,
                    cache:false,
                    success:function(response){
                        if(response==1){
                            $("#addModal").modal('hide');
                            toastr.success("Successfully Added");
                            setTimeout(() => {
                                location.reload();     
                            }, 500);
                        }
                    }
                });
            });
        });

    </script>
</body>

</html>