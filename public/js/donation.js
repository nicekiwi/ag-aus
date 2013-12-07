(function() {
	  var check_submit = false;
	  var handler = StripeCheckout.configure({
	    key: $('meta[name="stripe-key"]').attr('content'),
	    image: '/square-image.png',
	    token: function(token, args) {

	    	var this_form = $('#donation_form');
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
			check_submit = true;
	    },
	    opened: function() {
	    	$('#donation_submit').text('Proccessing').prop('disabled', true);
	    },
	    closed: function() {
	    	if(check_submit === false) $('#donation_submit').text('Make Donation').prop('disabled', false);
	    }
	  });

	  document.getElementById('donation_submit').addEventListener('click', function(e) {
		var donation_amount = $('#donation-amount').val();
		var description = null;

		if(donation_amount >= 48) description = '15 Months Donator Perks';
		else if(donation_amount >= 12) description = '3 Months Donator Perks';
		else description = 'Donation';

	    // Open Checkout with further options
	    handler.open({
	      name: 'Alternitive Gaming',
	      description: description,
	      amount: donation_amount,
	      currency: 'AUD',
	      panelLabel: 'Donate',
	    });
	    e.preventDefault();
	  });
})();

var steam_id_valid = false;

$( "#steam_id" ).blur(function() 
{
	if(steam_id_valid) return false;
	var steam_input = $( this );
	$.getJSON( "/check-steamid/"+$(this).val(), function( json ) {

		if(typeof(json.steamid) != "undefined")
		{
			steam_id_valid = true;
			steam_input.css('background-color', 'green');

			$( "#steam_id_valid" ).append( '<strong>'+ json.nickname +'</strong><img src="'+ json.profileImage +'.jpg">' );

			$('<input>', {
				type: 'hidden',
				name: 'steam_image',
				value: json.profileImage
			}).appendTo($('#donation_form'));
		}
		else
		{
			//alert(json.message);
			steam_input.css('background-color', 'yellow');
		}
	});
});