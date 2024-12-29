function loadMaps(pop_id, area_id) {
    _load_google_map_script()
        .then(() => {
            initMap(pop_id, area_id);
        })
        .catch((error) => {
            console.error("Failed to load Google Maps API:", error);
        });
}

function _load_google_map_script() {
    return new Promise((resolve, reject) => {
        if (window.google && window.google.maps) {
            /* Google Maps API already loaded*/
            resolve(window.google.maps);
            return;
        }

        const script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs";
        script.async = true;
        script.defer = true;

        script.onload = () => {
            resolve(window.google.maps);
        };

        script.onerror = (error) => {
            reject(error);
        };

        document.body.appendChild(script);
    });
}

function initMap(pop_id, area_id) {
    const mapOptions = {
        center: { lat: 23.5330279, lng: 90.8000572 },
        zoom: 12,
    };

    const map = new google.maps.Map(document.getElementById("map"), mapOptions);

    $.ajax({
        url: 'http://103.146.16.154/include/add_area.php?get_locations_for_google_map=true',
        type: 'GET',
        data: { pop_id: pop_id, area_id: area_id },
        dataType: "json",
        success: function (locations) {
            locations.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(location.lat), lng: parseFloat(location.lng) },
                    map: map,
                    title: location.house_no,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `<h3>${location.house_no}</h3><p>Coordinates: (${location.lat}, ${location.lng})</p>`,
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}
