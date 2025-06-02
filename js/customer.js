
$(document).on('keyup', '#customer_username', function() {
    var customer_username = $("#customer_username").val();
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        data: {
            current_username: customer_username
        },
        success: function(response) {
            $("#usernameCheck").html(response);
        }
    });
});

$(document).on('change', '#customer_pop', function() {
    var pop_id = $("#customer_pop").val();
    // alert(pop_id);
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        data: {
            current_pop_name: pop_id
        },
        success: function(response) {
            $("#customer_area").html(response);
        }
    });
});
$(document).on('change', '#customer_pop', function() {
    var pop_id = $("#customer_pop").val();
    // alert(pop_id);
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        data: {
            pop_name: pop_id,
            getCustomerPackage: 0
        },
        success: function(response) {
            $("#customer_package").html(response);
        }
    });
});
$(document).on('change', '#customer_package', function() {
    var packageId = $("#customer_package").val();
    var pop_id = $("#customer_pop").val();
    // alert(pop_id);
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        data: {
            package_id: packageId,
            pop_id: pop_id,
            getPackagePrice: 0
        },
        success: function(response) {
            $("#customer_price").val(response);
        }
    });
});
$(document).on('change', '#customer_area', function() {
    var area_id = $("#customer_area").val();
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        dataType: 'json',
        data: {
            area_id: area_id,
            get_billing_cycle: 1
        },
        success: function(response) {
            if (response.length > 0) {
                var options = "";
                response.forEach(function (item) {
                    options += '<option value="' + item + '">' + item + '</option>';
                });
                $("#customer_expire_date").html(options);
            } else {
                console.log("No data received.");
            }
        },
        error: function() {
            console.error("An error occurred while fetching billing cycle.");
        }
    });
});


$("#customer_add").click(function() {
    var customer_request_id = $("#customer_request_id").val();
    var fullname = $("#customer_fullname").val();
    var package = $("#customer_package").val();
    var username = $("#customer_username").val();
    var password = $("#customer_password").val();
    var mobile = $("#customer_mobile").val();
    var address = $("#customer_address").val();
    var expire_date = $("#customer_expire_date").val();
    var area = $("#customer_area").val();
    var pop = $("#customer_pop").val();
    var nid = $("#customer_nid").val();
    var con_charge = $("#customer_con_charge").val();
    var price = $("#customer_price").val();
    var remarks = $("#customer_remarks").val();
    var status = $("#customer_status").val();
    var liablities = $("#customer_liablities").val();
    var customer_houseno = $("#customer_houseno").val();
    var customer_connection_type = $("#customer_connection_type").val();
    var customer_onu_type = $("#customer_onu_type").val();
    var send_message = $('#sendMessageCheckbox').is(':checked') ? $('#sendMessageCheckbox').val() : '0';

    var user_type = 1;
   customerAdd(customer_request_id,user_type, fullname, package, username, password, mobile, address, expire_date, area, customer_houseno, pop,con_charge, price, remarks,liablities, nid, status,customer_connection_type,customer_onu_type,send_message);

});

function customerAdd(customer_request_id,user_type, fullname, package, username, password, mobile, address, expire_date, area, customer_houseno, pop,con_charge, price, remarks,liablities, nid, status,customer_connection_type,customer_onu_type,send_message) {
    if (fullname.length == 0) {
        toastr.error("Customer name is require");
    } else if (package.length == 0) {
        toastr.error("Customer Package is require");
    } else if (username.length == 0) {
        toastr.error("Username is require");
    } else if (password.length == 0) {
        toastr.error("Password is require");
    } else if (mobile.length == 0) {
        toastr.error("Mobile number is require");
    } else if (expire_date.length == 0) {
        toastr.error("Expire Date is require");
    } else if (pop.length == 0) {
        toastr.error("POP/Branch is require");
    } else if (area.length == 0) {
        toastr.error("Area is require");
    }else if (con_charge.length == 0) {
        toastr.error("Connection Charge is require");
    } else if (price.length == 0) {
        toastr.error("price is require");
    } else if (status.length == 0) {
        toastr.error("Status is require");
    } else if (liablities.length == 0) {
        toastr.error("Liablities is require");
    }else if(customer_connection_type.length==0){
        toastr.error("Connection Type is require");
    }else if(customer_onu_type.length==0){
         toastr.error("Onu Type is require");
    } else {
        $("#customer_add").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $("#customer_add").prop("disabled", true);
        var addCustomerData = 0;
        $.ajax({
            type: 'POST',
            url: 'include/customers_server.php',
            data: {
                addCustomerData: addCustomerData,
                customer_request_id:customer_request_id,
                fullname: fullname,
                package: package,
                username: username,
                password: password,
                mobile: mobile,
                address: address,
                expire_date: expire_date,
                area: area,
                customer_houseno: customer_houseno,
                pop: pop,
                con_charge: con_charge,
                price: price,
                remarks: remarks,
                liablities: liablities,
                nid: nid,
                status: status,
                user_type: user_type,
                customer_connection_type:customer_connection_type,
                customer_onu_type:customer_onu_type,
                send_message:send_message
            },
            success: function(responseData) {
                $("#customer_add").html('Add Customer');
                $("#customer_add").prop("disabled", false);
                if (responseData == 1) {
                    toastr.success("Added Successfully");
                     /*GET Last id With callback function */
                        get_customer_last_id(function(last_id) {
                        //$('#customers_table').DataTable().ajax.reload();
                        $("#addCustomerModal").modal('hide');
                        $("#customer_details_show_modal").modal('show');
                        $("#details-name").html(fullname);
                        $("#details-username").html(username);
                        $("#details-mobile").html(mobile);
                        $("#details-address").html(address);
                        $(".go_to_profile").attr("href", "profile.php?clid=" + last_id);
                    });
                } else {
                    toastr.error(responseData);
                    $("#customer_add").html('Add Customer');
                    $("#customer_add").prop("disabled", false);
                }
            }
        });
    }
}
function get_customer_last_id(callback) {
    $.ajax({
        type: 'POST',
        url: "include/customers_server.php",
        data: {
            get_customer_last_id: 1
        },
        success: function(response) {
            /*Response Customer Callback function*/
            callback(response); 
        }
    });
}

function copyDetails() {
    let customerDetails = "";

    /* Collect customer details*/
    $('#customer-details p').each(function() {
        customerDetails += $(this).text() + "\n";
    });

    if (navigator.clipboard) {
        navigator.clipboard.writeText(customerDetails)
            .then(() => {
                toastr.success("Copied the details:\n" + customerDetails); 
            })
            .catch(err => {
                console.error("Failed to copy details: ", err);
                toastr.error("Failed to copy details!"); 
            });
    } else {
        let tempInput = $("<textarea>");
        $("body").append(tempInput);
        tempInput.val(customerDetails).select();

        /*Focus before copying for older browsers*/ 
        tempInput[0].focus();
        
        /* Use execCommand to copy text*/
        if (document.execCommand("copy")) {
            toastr.success("Copied the details"); 
        } else {
            toastr.error("Failed to copy details!"); 
        }

        tempInput.remove();
    }

    return false; 
}



function copyDetailsssss() {

    let customerDetails = "";

    $('#customer-details p').each(function() {
        customerDetails += $(this).text() + "\n";
    });

    if (navigator.clipboard) {
        navigator.clipboard.writeText(customerDetails)
            .then(() => {
                toastr.success("Copied the details:\n" + customerDetails); 
            })
            .catch(err => {
                console.error("Failed to copy details: ", err);
                alert("Failed to copy details!");
            });
    } else {
        let tempInput = $("<textarea>");
        $("body").append(tempInput);
        tempInput.val(customerDetails).select();

        document.execCommand("copy");

        tempInput.remove();

        toastr.success("Copied the details"); 
    }

    return false;
    

    return false;
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(customerDetails).then(() => {
            toastr.success("Copied the details");
        }).catch((err) => {
            console.error("Failed to copy details: ", err);
            toastr.error("Failed to copy details!");
        });
    } else {
        let tempTextarea = document.createElement("textarea");
        tempTextarea.value = customerDetails;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        tempTextarea.setSelectionRange(0, 99999);

        try {
            document.execCommand("copy");
            toastr.success("Copied the details");
        } catch (err) {
            console.error("Fallback: Failed to copy details: ", err);
            toastr.error("Fallback: Failed to copy details!");
        }

        document.body.removeChild(tempTextarea);
    }
}


$("#addCustomerModal").on('show.bs.modal', function (event) {
    /*Check if select2 is already initialized*/
    if (!$('#customer_area').hasClass("select2-hidden-accessible")) {
        $("#customer_area").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
    if (!$('#customer_houseno').hasClass("select2-hidden-accessible")) {
        $("#customer_houseno").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
    if (!$('#customer_package').hasClass("select2-hidden-accessible")) {
        $("#customer_package").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
    if (!$('#customer_status').hasClass("select2-hidden-accessible")) {
        $("#customer_status").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
    if (!$('#customer_liablities').hasClass("select2-hidden-accessible")) {
        $("#customer_liablities").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
    if (!$('#customer_pop').hasClass("select2-hidden-accessible")) {
        $("#customer_pop").select2({
            dropdownParent: $("#addCustomerModal"),
            placeholder: "---Select---"
        });
    }
}); 
$("#addHouseModal").on('show.bs.modal', function (event) {
    /*Check if select2 is already initialized*/
    if (!$('#area_id').hasClass("select2-hidden-accessible")) {
        $("#area_id").select2({
            dropdownParent: $("#addHouseModal"),
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
                $("#addHouseModal").modal('hide');
                toastr.success("Successfully Added");
                load_house_no(); 
            }
        }
    });
});
load_house_no(); 
function load_house_no() {
    $.ajax({
        type: "POST",
        url: "include/add_area.php?load_house_no",
        success: function(response) {
            $("#customer_houseno").html(response);
        }
    });
}

function loadGoogleMapsScript() {
    return new Promise((resolve, reject) => {
        if (window.google) {
            resolve(window.google); 
            return;
        }
        
        const script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&callback=initMap2";
        script.async = true;
        script.defer = true;

        script.onload = () => {
            resolve(window.google);
        };

        script.onerror = (error) => {
            reject(error);
        };

        document.body.appendChild(script);
    });
}

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


(async () => {
    try {
        await loadGoogleMapsScript();
        initMap2(); 
    } catch (error) {
        console.error("Google Maps API:", error);
    }
})();


