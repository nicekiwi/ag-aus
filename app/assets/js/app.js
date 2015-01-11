//= include ../../../bower_components/jquery/dist/jquery.js

//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js
//= require ../../../bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js


//= ../../../bower_components/fancybox/source/jquery.fancybox.js
//= ../../../bower_components/fancybox/source/helpers/jquery.fancybox-media.js
//= ../../../bower_components/unveil/jquery.unveil.js
//= include ../../../bower_components/datatables/media/js/jquery.dataTables.js

//= require https://checkout.stripe.com/checkout.js

//= include ./shared.js
//


function donationPayment() {

  var check_submit 		= false;
  var this_form 			= $('#donation_form');
  var sbumit_btn      = $('#donation_submit');
  var donation_amount = $('#donation-amount').val();
  var handler 				= StripeCheckout.configure({

    key: $('meta[name="stripe-key"]').attr('content'),
    image: '/img/ag-logo-stripe.png',
    token: function(token, args) {

        check_submit = true;

        sbumit_btn.text('Proccessing').prop('disabled', true);

        // Use the token to create the charge with a server-side script.
        $('<input>', {
            type: 'hidden',
            name: 'email',
            value: token.card.name
        }).appendTo(this_form);

        $('<input>', {
            type: 'hidden',
            name: 'stripe_token',
            value: token.id
        }).appendTo(this_form);

        $('<input>', {
            type: 'hidden',
            name: 'stripe_data',
            value: token.card.type+','+token.card.last4+','+token.card.exp_month+','+token.card.exp_year
        }).appendTo(this_form);

        this_form.submit();

    },
    opened: function() {
       sbumit_btn.text('Proccessing').prop('disabled', true);
    },
    closed: function() {
      if(check_submit === false) {
      	sbumit_btn.text('Make Donation').prop('disabled', false);
      }
    }
  });

	sbumit_btn.on('click', function(e){
		// Open Checkout with further options
    handler.open({
      name: 'Alternitive Gaming Australia',
      description: 'Donation',
      amount: donation_amount * 100,
      currency: 'AUD',
      panelLabel: 'Donate',
    });
    e.preventDefault();
	});

	var steam_id_valid = false;

	$( "#steam_id" ).blur(function() {

    var this_form = $('#donation_form');

    if(steam_id_valid) return false;
    var steam_input = $( this );

    if(steam_input.val() === '') return false;

    $.getJSON( "/check-steamid/"+$(this).val(), function( json ) {

      json = json.players[0];

      if(typeof(json.steam_url) !== "undefined")
      {
        steam_id_valid = true;
        steam_input.css('background-color', 'green');

        $( "#steam_id_valid" ).append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_id  );

        $('<input>', { type: 'hidden', name: 'steam_image', value: json.steam_image }).appendTo(this_form);
        $('<input>', { type: 'hidden', name: 'steam_nickname', value: json.steam_nickname }).appendTo(this_form);
        $('<input>', { type: 'hidden', name: 'steam_id', value: json.steam_id }).appendTo(this_form);
        $('<input>', { type: 'hidden', name: 'steam_64id', value: json.steam_64id }).appendTo(this_form);
        $('<input>', { type: 'hidden', name: 'steam_url', value: json.steam_url }).appendTo(this_form);
      }
      else
      {
         steam_input.css('background-color', 'yellow');
      }
    });
	});
}

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

   mapDroplist('/maps');

   if(bod.hasClass('donations-page')) {
   	donationPayment();
   }
});
