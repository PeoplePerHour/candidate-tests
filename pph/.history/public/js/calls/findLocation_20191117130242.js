$("#countryId").keyup(function () {
    var country = $('#countryId').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/forecast/returnAjaxCountry',
        data: { "country": country },
        success: function (data) {
            for (i = 0; i <= data.length; i++) {
                    
            }
        }
    });
});