var Users = {
	
	'init': function() {

		$("#filter_active").select2({
			allowClear: true,
			width: null,
			theme: 'bootstrap',
			placeholder: 'Select active status'
		});

		if($("#gender").length > 0)
		{
			$("#gender").select2({
				width: null,
				theme: 'bootstrap',
				placeholder: 'Select Gender'
			});
		}

        if($("#birthdate").length > 0)
        {
            $("#birthdate").datetimepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                pickTime: false,
                minView: 2,
                maxView: 4,
            });
        }

        $(document)
            .on('click', '#select_all', function(e){
                if($(this).is(':checked'))
                {
                    $('.item-checkbox').each(function(index, value) {
                        if($(this).prop('checked') == false)
                        {
                            $(this).prop('checked', true);
                            $(this).trigger('change');
                        }
                    })
                }
                else
                {
                    $('.item-checkbox').each(function(index, value) {
                        if($(this).prop('checked') == true)
                        {
                            $(this).prop('checked', false);
                            $(this).trigger('change');
                        }
                    })
                }
            })
			.on('change', '#filter_role, #filter_active', function(){
            	$('#search_list').submit();
        	});
	}
};

Users.init();