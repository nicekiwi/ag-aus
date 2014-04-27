//= include ../../../bower_components/jquery/jquery.js

//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js

//= include ../../../bower_components/fancybox/source/jquery.fancybox.js
//= include ../../../bower_components/fancybox/source/helpers/jquery.fancybox-media.js
//= include ../../../bower_components/unveil/jquery.unveil.js
//= include ../../../bower_components/datatables/media/js/jquery.dataTables.js

$(document).ready(function() {
	$(".fancybox").fancybox({
		width: 1280,
		height: 720,
		helpers : {
			media: true,
			overlay: {
				locked: false
			}
		},
		youtube : {
			autoplay: 1
		}
	});

	$("img.unveil").unveil(100);
});