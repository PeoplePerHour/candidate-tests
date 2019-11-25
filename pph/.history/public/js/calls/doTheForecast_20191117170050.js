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
            if (data['status'] == 500) {
                alert("Chosen Provider not yet available. Try WeatherBit for the time being");
            }
            else {
                console.log(data);
                $('#outcomeFromApi').css("display", "");
                $("#outcomeFromApi").empty();
                $("#outcomeWeatherDescription").append(data['desc']);
                $("#outcomeTemp").append(data['temp']);
            }
        }

    });
});
