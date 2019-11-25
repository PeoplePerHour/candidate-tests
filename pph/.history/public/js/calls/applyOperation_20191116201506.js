$('#applyOperation').on('click', function () {
    var fileOperation = $('#foMethod').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/files/settleOperation',
        data: { "fileOperation": fileOperation , "file" },
        success: function (data) {
            alert("All Ok");
        }
    });
});
