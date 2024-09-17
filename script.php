<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script> 
<script src="assets/libs/node-waves/waves.min.js"></script> 
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script> 

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Toastr -->
<script src="js/toastr/toastr.min.js"></script>
<script src="js/toastr/toastr.init.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>

<!-- App Js -->
<script src="assets/js/app.js"></script>

<!-- Peity chart -->
<script src="assets/libs/peity/jquery.peity.min.js"></script> 

<!-- C3 Chart -->
<script src="assets/libs/d3/d3.min.js"></script>
<script src="assets/libs/c3/c3.min.js"></script> 

<!-- jQuery Knob -->
 <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>

<!-- Dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<!-- Fluid Meter -->
 <script src="assets/js/js-fluid-meter.js"></script>
<!-- Form Advanced Init -->
 <!-- <script src="assets/js/pages/form-advanced.init.js"></script>  -->

<!-- Plugin Js for Charts -->
<script src="assets/libs/chartist/chartist.min.js"></script>
<script src="assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js"></script>




<script type="text/javascript">
$(document).ready(function() {
    // console.log('rakib');
    async function loadCustomerOptions() {
        try {
            let response = await $.ajax({
                url: 'include/tickets_server.php?get_all_customer=true',
                type: 'GET',
                dataType: 'json'
            });
            if (response.success === true) {
                var customerOptions = '<option value="">--- Select Customer ---</option>'; 

                $.each(response.data, function(key, customer) {
                    customerOptions += '<option value="' + customer.id + '">[' + customer.id + '] - ' + customer.username + ' || ' + customer.fullname + ', (' + customer.mobile + ')</option>';
                });

                $('select[name="menu_select_box"]').html(customerOptions);
                $('select[name="menu_select_box"]').select2({
                    placeholder: '---Select Customer---',
                });
            }

        } catch (error) {
            console.error('Error fetching customer options:', error);
        }
    }

    if ($('select[name="menu_select_box"]').length > 0) {
        loadCustomerOptions(); 
    }

    $('select[name="menu_select_box"]').on('change', function() {
        var customerId = $(this).val(); 
        if(customerId) {
            window.location.href = 'profile.php?clid=' + customerId;
        }
    });

});
</script> 


