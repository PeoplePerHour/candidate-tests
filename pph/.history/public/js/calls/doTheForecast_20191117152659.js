$("#doTheCall").click(function () {
    $('#countryId').val($('#getCountriesDropDown').val());
    $('#cityId').prop("disabled", false);
    $('#countryId').css("display", "none");
    getCities();
});

function getCities() {
    $("#getCitiesDropDown").empty();
    var city = $('#cityId').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: "json",
        url: '/forecast/returnAjaxCity',
        data: { "country": $('#countryId').val() },
        success: function (data) {
            for (i = 0; i <= data.length; i++) {
                if (data[i] !== 'undefined') {
                    $("#getCitiesDropDown").append("<option  class='form-control' value = '" + data[i]['id'] + "'>" + data[i]['city_name'] + "</option>");
                }
            }
        }
    });
}
