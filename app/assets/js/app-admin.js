//= include ../../../bower_components/jquery/dist/jquery.js

//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js
//
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js

//= include ../../../bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js
//= include ../../../bower_components/blueimp-file-upload/js/jquery.iframe-transport.js
//= include ../../../bower_components/blueimp-file-upload/js/jquery.fileupload.js
//= include ../../../bower_components/datatables/media/js/jquery.dataTables.js
//= include ../../../bower_components/datatables-bootstrap3/BS3/assets/js/datatables.js

//= include ../../../bower_components/jquery-sortable/source/js/jquery-sortable-min.js
//= include ../../../bower_components/bootbox/bootbox.js

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

	// $('.btn-delete-confirm').on('click', function(){

	// 	var form = $(this).closest('form');

	// 	bootbox.confirm("Are you sure?", function(result){

	// 		if(result) {
	// 			form.submit();
	// 		}
			
	// 	});

	// });
	

});
