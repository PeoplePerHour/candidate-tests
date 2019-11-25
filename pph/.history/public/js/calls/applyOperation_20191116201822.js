$('#thetable').find('tr').click(function () {
    alert('You clicked row ' + ($(this).index() + 1));
    var row = $(this).find('td:first').text();
    var fileOperation = $('#foMethod').val();
    var file = 
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/files/settleOperation',
        data: { "fileOperation": fileOperation , "file":file },
        success: function (data) {
            alert("All Ok");
        }
    });
});
