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
                $("#getCountriesDropDown").append("<option value = '" + data[i] + "'>" + data[i] + "</option>");
            }
        }
    });
});


$("input#search-textbox").autocomplete({
    source: ["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby"]
});