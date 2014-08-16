//= include ../../../bower_components/jquery/dist/jquery.js

//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js

//= include ../../../bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js
//= include ../../../bower_components/blueimp-file-upload/js/jquery.iframe-transport.js
//= include ../../../bower_components/blueimp-file-upload/js/jquery.fileupload.js
//= include ../../../bower_components/datatables/media/js/jquery.dataTables.js

//= include ../../../bower_components/jquery-sortable/source/js/jquery-sortable-min.js

//= include ./shared.js


$(document).ready(function() {
	mapDroplist('/admin/maps');	

	$( "#map-config-form" ).on( "submit", function( event ) {
		event.preventDefault();

		$( '#map-config-list' ).filter('li').each(function(index)
		{
			console.log($(this).prop('data-id') + index);
		});

		//console.log( $( this ).serializeArray() );
	});
});
