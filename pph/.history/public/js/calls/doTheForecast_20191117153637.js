$("#doTheCall").click(function () {
    var city = $('#getCitiesDropDown').val();
    var provider = $('#providers').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: "json",
        url: '/forecast/sourceCall',
        data: { "city": city ,"provider"},
        success: function (data) {

            $("#outcome").append(data);

        }

    });
});
