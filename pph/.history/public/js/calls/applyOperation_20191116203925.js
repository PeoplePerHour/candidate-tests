$('a[id^="applyOperation"]').click(function (event) {
    var fileOperation = $('#foMethod').val();
    $("a").click(function (event) {
        alert(event.target.id);
    });
    var file =
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/files/settleOperation',
            data: { "fileOperation": fileOperation, "file": file },
            success: function (data) {
                alert("All Ok");
            }
        });
});

