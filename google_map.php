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
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"> Add Area</button>
                                </div>
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
    /* Initialize and display the map*/
    function initMap() {
      const mapOptions = {
        center: { lat: 23.8103, lng: 90.4125 }, 
        zoom: 12,
      };

      /* Create a map instance*/
      const map = new google.maps.Map(document.getElementById("map"), mapOptions);

      /*Define multiple store locations*/ 
      const locations = [
        { name: "Store 1", lat: 23.8103, lng: 90.4125 },
        { name: "Store 2", lat: 23.8150, lng: 90.4250 },
        { name: "Store 3", lat: 23.8200, lng: 90.4050 },
        { name: "Store 4", lat: 23.8050, lng: 90.4300 },
      ];

      /*** Add markers for each location */ 
      locations.forEach(location => {
        const marker = new google.maps.Marker({
          position: { lat: location.lat, lng: location.lng },
          map: map,
          title: location.name,
        });

        // Add an info window for each marker
        const infoWindow = new google.maps.InfoWindow({
          content: `<h3>${location.name}</h3><p>Coordinates: (${location.lat}, ${location.lng})</p>`,
        });

        // Show info window on marker click
        marker.addListener("click", () => {
          infoWindow.open(map, marker);
        });
      });
    }
  </script>

   <!-- Load Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&callback=initMap" async defer></script>

</body>

</html>