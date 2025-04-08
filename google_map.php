<!DOCTYPE html>
<html lang="en">

<head>
    <title>Find Location</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="https://admin.futureictbd.com/Backend/dist/css/adminlte.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #info-box {
            margin-top: 15px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header ">
                        <h4>Find Route</h4>
                    </div>
                    <div class="card-body">
                        <!-- Location selection method -->
                        <div class="form-group">
                            <label for="">Select Route Type</label>
                            <select id="routeOption" class="form-control">
                                <option value="input" selected>Enter Locations Manually</option>
                                <option value="click">Click to Select on Map</option>
                            </select>
                        </div>

                        <div id="manual-input" class="route-options">
                            <div class="form-group">
                                <label for="">Current Location</label>
                                <input type="text" class="form-control mb-2" id="origin" placeholder="Enter current location">
                            </div>
                            <div class="form-group">
                                <label for="">Destination Location</label>
                                <input type="text" class="form-control mb-2" id="destination" placeholder="Enter destination">
                            </div>
                            <div class="form-group">
                                <button id="findRoute" class="btn btn-primary">Find Route</button>
                            </div>
                        </div>

                        <div id="click-select" class="route-options" style="display:none;">
                            <p>Click on the map to select your locations.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="map"></div>
                <div id="info-box"></div>
            </div>
        </div>
    </div>

    <!-- Google Maps JavaScript API -->
    <script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&libraries=places"></script>

    <script type="text/javascript">
        /*Initialize Google Maps*/ 
        let map, directionsService, directionsRenderer;
        let clickCount = 0;
        let originMarker = null;
        let destinationMarker = null;
        let originLatLng, destinationLatLng;

        function initialize() {
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: {
                    lat: 23.8103,
                    lng: 90.4125
                }
            });

            directionsRenderer.setMap(map);

            // Auto-location suggestion
            const originInput = document.getElementById("origin");
            const destinationInput = document.getElementById("destination");

            const autocompleteOrigin = new google.maps.places.Autocomplete(originInput);
            const autocompleteDestination = new google.maps.places.Autocomplete(destinationInput);

            map.addListener("click", function(e) {
                if (document.getElementById("routeOption").value === "click") {
                    clickCount++;
                    if (clickCount === 1) {
                        if (originMarker) originMarker.setMap(null);
                        originLatLng = e.latLng;
                        originMarker = new google.maps.Marker({
                            position: originLatLng,
                            map: map,
                            label: "A"
                        });
                    } else if (clickCount === 2) {
                        if (destinationMarker) destinationMarker.setMap(null);
                        destinationLatLng = e.latLng;
                        destinationMarker = new google.maps.Marker({
                            position: destinationLatLng,
                            map: map,
                            label: "B"
                        });

                        calculateAndDisplayRoute();
                        clickCount = 0; // reset click
                    }
                }
            });
        }

        // Function to calculate and display route
        function calculateAndDisplayRoute() {
            directionsService.route({
                origin: originLatLng,
                destination: destinationLatLng,
                travelMode: google.maps.TravelMode.DRIVING
            }, (response, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(response);

                    const route = response.routes[0].legs[0];
                    const distance = route.distance.text;
                    const duration = route.duration.text;

                    document.getElementById("info-box").innerHTML = `
                        <div>Distance: ${distance}</div>
                        <div>Estimated Time: ${duration}</div>
                    `;
                } else {
                    alert("Directions request failed due to " + status);
                }
            });
        }

        // Handle route option change
        document.getElementById("routeOption").addEventListener("change", function() {
            if (this.value === "input") {
                document.getElementById("manual-input").style.display = "block";
                document.getElementById("click-select").style.display = "none";
                originMarker?.setMap(null);
                destinationMarker?.setMap(null);
            } else {
                document.getElementById("manual-input").style.display = "none";
                document.getElementById("click-select").style.display = "block";
            }
        });

        window.onload = initialize;




        document.getElementById("findRoute").addEventListener("click", function() {
    const routeOption = document.getElementById("routeOption").value;

    if (routeOption === "input") {
        const origin = document.getElementById("origin").value;
        const destination = document.getElementById("destination").value;

        if (origin && destination) {
            const geocoder = new google.maps.Geocoder();

            /* Geocode the origin*/
            geocoder.geocode({ address: origin }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    originLatLng = results[0].geometry.location;

                    /*Geocode the destination*/ 
                    geocoder.geocode({ address: destination }, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            destinationLatLng = results[0].geometry.location;

                            calculateAndDisplayRoute();
                        } else {
                            alert("Destination not found");
                        }
                    });
                } else {
                    alert("Origin not found");
                }
            });
        } else {
            alert("Error!!");
        }
    }
});

    </script>
</body>

</html>
