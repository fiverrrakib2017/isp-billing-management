 /* Customers load function*/
 ticket_modal()

 function ticket_modal() {
     $("#ticketModal").on('show.bs.modal', function(event) {
         /*Check if select2 is already initialized*/
         if (!$('#ticket_customer_id').hasClass("select2-hidden-accessible")) {
             $("#ticket_customer_id").select2({
                 dropdownParent: $("#ticketModal"),
                 placeholder: "Select Customer"
             });
             $("#ticket_assigned").select2({
                 dropdownParent: $("#ticketModal"),
                 placeholder: "---Select---"
             });
             $("#ticket_complain_type").select2({
                 dropdownParent: $("#ticketModal"),
                 placeholder: "---Select---"
             });
             $("#ticket_priority").select2({
                 dropdownParent: $("#ticketModal"),
                 placeholder: "---Select---"
             });
         }
     });
 }

 function loadCustomers(selectedCustomerId) {
     var protocol = location.protocol;
     var url = protocol + '//' + '103.146.16.154' + '/include/tickets_server.php?get_all_customer=true';
     $.ajax({
         url: "../../include/tickets_server.php?get_all_customer=true",
         type: 'GET',
         dataType: 'json',
         success: function(response) {
             if (response.success == true) {
                 let customerSelect = $("#ticket_customer_id");
                 customerSelect.empty();
                 customerSelect.append('<option value="">---Select Customer---</option>');
                 $.each(response.data, function(index, customer) {
                     customerSelect.append('<option value="' + customer.id + '">[' + customer
                         .id + '] - ' + customer.username + ' || ' + customer.fullname +
                         ', (' + customer.mobile + ')</option>');
                 });
             }
             if (selectedCustomerId) {
                 $("#ticket_customer_id").val(selectedCustomerId);
             }
         }
     });
 }

 /*Ticket assign function*/
 function ticket_assign(customerId) {
     if (customerId) {
         var protocol = location.protocol;
         var url = protocol + '//' + '103.146.16.154' + '/include/tickets_server.php';
         $.ajax({
             url: "../../include/tickets_server.php",
             type: "POST",
             data: {
                 customer_id: customerId,
                 get_area: true,
             },
             success: function(response) {
                 $("#ticket_assigned").html(response);
             }
         });
     } else {
         $(document).on('change', '#ticket_customer_id', function() {
             var protocol = location.protocol;
             var url = protocol + '//' + '103.146.16.154' + '/include/tickets_server.php';
             $.ajax({
                 url: "../../include/tickets_server.php",
                 type: "POST",
                 data: {
                     customer_id: $(this).val(),
                     get_area: true,
                 },
                 success: function(response) {
                     /* Handle the response from the server*/
                     $("#ticket_assigned").html(response);
                 }
             });
         });
     }
 }

 /* Ticket complain type function*/
 function ticket_complain_type() {
     var protocol = location.protocol;
     var url = protocol + '//' + '103.146.16.154' + '/include/tickets_server.php';
     $.ajax({
         url: "../../include/tickets_server.php",
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
                 $.each(response.data, function(index, item) {
                     ticket_complain_type.append('<option value="' + item.id + '">' + item
                         .topic_name + '</option>');
                 });
             }
         }
     });
 }


 $("#ticket_modal_form").submit(function(e) {
     e.preventDefault();

     /* Get the submit button */
     var submitBtn = $(this).find('button[type="submit"]');
     var originalBtnText = submitBtn.html();

     submitBtn.html(
         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>'
     );
     submitBtn.prop('disabled', true);

     var form = $(this);
     var formData = new FormData(this);

     $.ajax({
         type: form.attr('method'),
         url: form.attr('action'),
         data: formData,
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(response) {
             if (response.success) {
                 $("#ticketModal").fadeOut(500, function() {
                     $(this).modal('hide');
                     toastr.success(response.message);
                     $('#tickets_datatable').DataTable().ajax.reload();
                 });

             } else if (!response.success && response.errors) {
                 $.each(response.errors, function(field, message) {
                     toastr.error(message);
                 });
             }
         },
         complete: function() {
             submitBtn.html(originalBtnText);
             submitBtn.prop('disabled', false);
         }
     });
 });

 //ticket_modal();
 loadCustomers();
 ticket_assign();
 ticket_complain_type();