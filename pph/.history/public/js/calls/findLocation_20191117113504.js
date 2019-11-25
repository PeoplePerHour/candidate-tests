$('a[id^="applyOperation"]').click(function (event) {
    var fileOperation = $('#foMethod').val();
    var str = event.target.id;
    var res = str.split("-");
    var file = res[1];
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/files/settleOperation',
        data: { "fileOperation": fileOperation, "file": file },
        success: function (data) {
            alert("All Ok");
            window.reload();
        }
    });
});