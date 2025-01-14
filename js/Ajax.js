// function get_area(pop_id=null){
//     $.ajax({
//         url: 'include/add_area.php?get_area_data=1',
//         type: 'POST',
//         data:{pop_id:pop_id},
//         dataType: 'json',
//         success: function(response) {
//             if (response.success == true) {
//                 var areaOptions = '<option value="">--Select Area--</option>';

//                 $.each(response.data, function(key, data) {
//                     areaOptions += '<option value="' + data.id + '">' + data.pop +
//                         '</option>';
//                 });

//                 $('select[name="area_id"]').html(areaOptions);
//                 $('#changePopModal').modal('show');
//                 $('#changePopModal').on('shown.bs.modal', function() {
//                     if (!$('select[name="area_id"]').hasClass(
//                             "select2-hidden-accessible")) {
//                         $('select[name="area_id"]').select2({
//                             dropdownParent: $('#changePopModal')
//                         });
//                     }
//                 });
//             }
//         }
//     });
// }

