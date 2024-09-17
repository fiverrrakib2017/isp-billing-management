// Customers load function
export function loadCustomers(selectedCustomerId) {
    $.ajax({
        url: 'include/tickets_server.php?get_all_customer=true',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success == true) {
                let customerSelect = $("#ticket_customer_id");
                customerSelect.empty();
                customerSelect.append('<option value="">---Select Customer---</option>');
                $.each(response.data, function (index, customer) {
                    customerSelect.append('<option value="' + customer.id + '">[' + customer.id + '] - ' + customer.username + ' || ' + customer.fullname + ', (' + customer.mobile + ')</option>');
                });
            }
            if (selectedCustomerId) {
                $("#ticket_customer_id").val(selectedCustomerId);
            }
        }
    });
}

// Ticket assign function
export function ticket_assign(customerId) {
    if (customerId) {
        $.ajax({
            url: "include/tickets_server.php",
            type: "POST",
            data: {
                customer_id: customerId,
                get_area: true,
            },
            success: function(response) {
                $("#ticket_assigned").html(response);
            }
        });
    }
}

// Ticket complain type function
export function ticket_complain_type() {
    $.ajax({
        url: "include/tickets_server.php",
        type: "POST",
        data: {
            get_complain_type: true,
        },
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                let ticket_complain_type = $("#ticket_complain_type");
                ticket_complain_type.empty();
                ticket_complain_type.append('<option value="">---Select---</option>');
                $.each(response.data, function (index, item) {
                    ticket_complain_type.append('<option value="' + item.id + '">'+item.topic_name+'</option>');
                });
            }
        }
    });
}
