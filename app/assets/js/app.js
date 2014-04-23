//= include ../../../bower_components/jquery/dist/jquery.js
//= include ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap.js
//= include ../../../bower_components/fancybox/source/jquery.fancybox.js
//= include ../../../bower_components/fancybox/source/helpers/jquery.fancybox-media.js
//= include ../../../bower_components/unveil/jquery.unveil.js

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