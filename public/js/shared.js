var mapDroplist = function(url)
{
	$('.map-filter').on('change', function(e)
	{
		var loc = '';

		if ($(this).val().length > 0) 
			loc = '?type=' + $(this).val();

		window.location.href = url + loc;
	});
};