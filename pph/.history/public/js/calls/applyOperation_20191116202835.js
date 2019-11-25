// $("#applyOperation").click(function () {
//     var $row = $(this).closest("tr");    // Find the row
//     var $text = $row.find(".nr").text(); // Find the text
//     var fileOperation = $('#foMethod').val();
//     var file =
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             type: 'GET',
//             url: '/files/settleOperation',
//             data: { "fileOperation": fileOperation, "file": file },
//             success: function (data) {
//                 alert("All Ok");
//             }
//         });
// });


$(function () {
 $("#applyOperation").click(function () {
        let tr = $(this).closest('tr');
        let a = tr.find('td:eq(1) input').val();
        let b = tr.find('td:eq(2) input').val();
        alert('Table 1: ' + a + ' ' + b);
    });
});
