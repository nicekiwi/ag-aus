var updateServers = function()
{
	var serverURL = "/server-info";

	$.getJSON( serverURL )
	  .done(function( json ) 
	  {
	  	$.each( json, function( index, data ) 
    	{
    		listItem = $('li[data-id="server-'+ data.id +'"]');

    		if(data.offline === 1){
	  		listItem.css('background-color', '#e24648');
		  	} else if(data.offline === 0) {
		  		listItem.css('background-color', '#87ef2f');
		  	}

		  	$('.players',listItem).text(data.players);
    	});
	  }).fail(function( jqxhr, textStatus, error ) 
	  {
	  	$('#master-server-list li').css('background-color', '#f4de4a');
	    //var err = textStatus + ", " + error;
	    //console.log( "Request Failed: " + err );
	});
}

$(document).ready(function() 
{
	setInterval(updateServers, 15000);
	$(".fancybox").fancybox();
});
