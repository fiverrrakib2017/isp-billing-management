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
    <?php
    
        include 'style.php';
        
        ?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">


        <?php $page_title="Google Map "; include 'Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Google Map</p>
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
                                
                                <div class="card-body">
                                    <div id="map" style="width: 100%; height: 500px;"></div>
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
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    <script>
    function loadMaps() {
        initMap();  
        initMap2();
    }

   /*Multiple Markers Location*/
    function initMap() {
        const mapOptions = {
            center: { lat: 23.5330279, lng: 90.8000572 },
            zoom: 12,
        };

        const map = new google.maps.Map(document.getElementById("map"), mapOptions);

        $.ajax({
            url: 'include/add_area.php?get_locations_for_google_map=true',
            type: 'GET',
            dataType: "json",
            success: function (locations) {
                locations.forEach(location => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(location.lat), lng: parseFloat(location.lng) },
                        map: map,
                        title: location.name,
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: `<h3>${location.name}</h3><p>Coordinates: (${location.lat}, ${location.lng})</p>`,
                    });

                    marker.addListener("click", () => {
                        infoWindow.open(map, marker);
                    });
                });
            },
            error:function(xhr,status,error){
                console.error("AJAX Error:", error);
            }
        });
    }

    function initMap2() {
        const initialLocation = { lat: 23.8103, lng: 90.4125 }; 
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
    $(document).on('click','#add_area',function(){
        // var formData=$("#form-area").serialize();
        var pop_id=$("select[name='pop_id']").val();
        var area=$("input[name='area']").val();
        var lat=$("input[name='lat']").val();
        var lng=$("input[name='lng']").val();
        var formData="pop_id="+pop_id+"&area="+area+"&lat="+lat+"&lng="+lng;
        $.ajax({
            type:'POST',
            url:'include/add_area.php?add_area_for_google_map',
            data:formData,
            cache:false,
            success:function(response){
                if(response==1){
                    toastr.success("Area Added Success");
                    setTimeout(() => {
                        location.reload();     
                    }, 1000);
                   
                }
              
            }
        });
    });
</script>

   <!-- Load Google Maps API --> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&callback=loadMaps" async defer></script>
 

</body>

</html>