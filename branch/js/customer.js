
$(document).on('keyup', '#customer_username', function() {
    var customer_username = $("#customer_username").val();
    $.ajax({
        type: 'POST',
        url: "../../include/customers_server.php",
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
        url: "../../include/customers_server.php",
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
        url: "../../include/customers_server.php",
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
        url: "../../include/customers_server.php",
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
        url: "../../include/customers_server.php",
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

$("#customer_add").click(function() {
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
    var user_type = 1;

    customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop,
        con_charge, price, remarks,liablities, nid, status)

});

function customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop,
    con_charge, price, remarks,liablities, nid, status) {
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
    } else if (con_charge.length == 0) {
        toastr.error("Connection Charge is require");
    } else if (price.length == 0) {
        toastr.error("price is require");
    } else if (status.length == 0) {
        toastr.error("Status is require");
    } else if (liablities.length == 0) {
        toastr.error("Liablities is require");
    }else {
        $("#customer_add").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        var addCustomerData = 0;
        $.ajax({
            type: 'POST',
            url: '../../include/customers_server.php',
            data: {
                addCustomerData: addCustomerData,
                fullname: fullname,
                package: package,
                username: username,
                password: password,
                mobile: mobile,
                address: address,
                expire_date: expire_date,
                area: area,
                pop: pop,
                con_charge: con_charge,
                price: price,
                remarks: remarks,
                liablities: liablities,
                nid: nid,
                status: status,
                user_type: user_type,
            },
            success: function(responseData) {
                if (responseData == 1) {
                    toastr.success("Added Successfully");
                    $('#customers_table').DataTable().ajax.reload();
                    $("#addCustomerModal").modal('hide');
                    $("#customer_details_show_modal").modal('show');
                    $("#details-name").html(fullname);
                    $("#details-username").html(username);
                    $("#details-mobile").html(mobile);
                    $("#details-address").html(address);
                    // setTimeout(() => {
                    //     location.reload();
                    // }, 1000);
                } else {
                    toastr.error(responseData);
                }
            }
        });
    }
}