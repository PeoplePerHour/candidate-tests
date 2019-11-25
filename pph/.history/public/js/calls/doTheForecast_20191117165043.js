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
        data: { "cityId": city ,"provider":provider},
        success: function (data) {
            if (data['error'] == 500) {
                alert("Den einai akoma diathesimo.");
            }
            $("#outcome").empty();
            $("#outcome").append(data);

        }

    });
});
