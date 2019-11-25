$("#countryId").keyup(function () {
    $("#getCountriesDropDown").empty();
    var country = $('#countryId').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: "json",
        url: '/forecast/returnAjaxCountry',
        data: { "country": country },
        success: function (data) {
            for (i = 0; i <= data.length; i++) {
                if (data[i]['country_name'] !== 'undefined') {
                    $("#getCountriesDropDown").append("<option  class='form-control' value = '" + data[i]['country_name'] + "'>" + data[i]['country_name'] + "</option>");
                }
            }
        }
    });
});

$("#getCountriesDropDown").click(function () {
    $('#countryId').val($('#getCountriesDropDown').val());
    $('#cityId').prop("disabled", false);
    $('#countryId').css("display", "none");
});

$("#getCitiesDropDown").click(function () {
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
                if (data[i]['country_name'] !== 'undefined') {
                $("#getCitiesDropDown").append("<option  class='form-control' value = '" + data[i] + "'>" + data[i] + "</option>");
            }
        }
    });
});

