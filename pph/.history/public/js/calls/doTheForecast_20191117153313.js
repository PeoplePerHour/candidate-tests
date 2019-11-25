$("#doTheCall").click(function () {
    var city = $('#getCitiesDropDown').val();
    alert(city);
  
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: "json",
        url: '/forecast/sourceCall',
        data: { "city":city},
        success: function (data) {
           
                    $("#getCitiesDropDown").append("<option  class='form-control' value = '" + data[i]['id'] + "'>" + data[i]['city_name'] + "</option>");
                
            }
        }
    });
  });
