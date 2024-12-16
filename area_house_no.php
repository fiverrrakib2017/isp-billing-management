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
                                        <tr>
                                            <th>ID</th>
                                            <th>Area Name</th>
                                            <th>House/Holding No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="area_table">
    <?php 
    if ($area_list = $con->query("SELECT al.id AS area_id, al.name AS area_name, GROUP_CONCAT(ah.house_no SEPARATOR ', ') AS house_numbers FROM area_list al LEFT JOIN area_house ah ON al.id = ah.area_id GROUP BY al.id, al.name")) {
        while ($rows = $area_list->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['area_id'] . '</td>';
            echo '<td>' . $rows['area_name'] . '</td>';
            
            if (!empty($rows['house_numbers'])) {
                $house_numbers = explode(', ', $rows['house_numbers']); 
                
                echo '<td><ul>';
                foreach ($house_numbers as $house_no) {
                    echo '<li><a href="new_page.php?area_id=' . $rows['area_id'] . '&house_no=' . $house_no . '">' . $house_no . '</a></li>';
                }
                echo '</ul></td>';
            } else {
                echo '<td></td>';
            }
            
            echo '<td>
                    <a href="new_page.php?area_id=' . $rows['area_id'] . '" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                  </td>';
            echo '</tr>';
        }
    }
    ?>
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
                                    <label>Area</label>
                                    <select class="form-select" name="area_id" id="area_id" style="width: 100%;">
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
                                    <label>House/Building No.</label>
                                    <input class="form-control" type="text" name="house_no" id="house_no" placeholder="Type  House-Building No." />
                                  
                                </div>
                                <div class="form-group mb-1">
                                    <label>Note</label>
                                    <input class="form-control" type="text" name="note" id="note" placeholder="Type Your Note" />
                                </div>
                                <div class="d-none">
                                    <input type="hidden" id="lat" name="lat">
                                    <input type="hidden" id="lng" name="lng">
                                </div>
                                <div class="form-group mb-1">
                                    <label>Map Location</label>
                                    <div id="show_map" style="width: 100%; height: 400px;"></div>
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
    <script type="text/javascript">
       $(document).ready(function () {
            $("#areaDataTable").DataTable();
            $("#addModal").on('show.bs.modal', function (event) {
            /*Check if select2 is already initialized*/
            if (!$('#area_id').hasClass("select2-hidden-accessible")) {
                    $("#area_id").select2({
                        dropdownParent: $("#addModal"),
                        placeholder: "---Select---"
                    });
                }
            }); 

            $(document).on('click','#add_area',function(){
                // var formData=$("#form-area").serialize();
                var area_id=$("select[name='area_id']").val();
                var house_no=$("input[name='house_no']").val();
                var note=$("input[name='note']").val();
                var lat=$("input[name='lat']").val();
                var lng=$("input[name='lng']").val();
                var formData = "area_id=" + area_id + 
                                "&house_no=" + house_no + 
                                "&note=" + note + 
                                "&lat=" + lat + 
                                "&lng=" + lng;
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
    function initMap2() {
        const initialLocation = { lat: 23.5565964, lng: 90.7866716 }; 
        const map = new google.maps.Map(document.getElementById("show_map"), {
            center: initialLocation,
            zoom: 12,
        });

        let marker;

        map.addListener("click", (event) => {
            const clickedLocation = event.latLng;
            if (!marker) {
                marker = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                });
            } else {
                marker.setPosition(clickedLocation);
            }

            document.getElementById("lat").value = clickedLocation.lat();
            document.getElementById("lng").value = clickedLocation.lng();
        });
    }
    </script>
    <!-- Load Google Maps API --> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&callback=initMap2" async defer></script>
</body>

</html>