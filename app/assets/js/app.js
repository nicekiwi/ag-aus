//= include ../../../bower_components/jquery/dist/jquery.js

//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js


//= ../../../bower_components/fancybox/source/jquery.fancybox.js
//= ../../../bower_components/fancybox/source/helpers/jquery.fancybox-media.js
//= ../../../bower_components/unveil/jquery.unveil.js
//= include ../../../bower_components/datatables/media/js/jquery.dataTables.js

//= require https://checkout.stripe.com/checkout.js

//= include ./shared.js
//

$(document).ready(function() {

  var bod = $( document.body );

  $('[data-toggle="tooltip"]').tooltip();

	// $(".fancybox").fancybox({
	// 	width: 1280,
	// 	height: 720,
	// 	helpers : {
	// 		media: true,
	// 		overlay: {
	// 			locked: false
	// 		}
	// 	},
	// 	youtube : {
	// 		autoplay: 1
	// 	}
	// });

	//$("img.unveil").unveil(100);

   //mapDroplist('/maps');

   if(bod.hasClass('donations-page')) {
   	donationPayment();
   }
});
