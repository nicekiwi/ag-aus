(function() {
	var DonationProccess = {
		init: function() {
			this.form = $('#donation_form');
			this.submitButton = this.form.find('button[type="submit"]');
			this.submitButtonValue = this.submitButton.text();

			var stripeKey = $('meta[name="stripe-key"]').attr('content');
			Stripe.setPublishableKey(stripeKey);

			this.bindEvents();
		},

		bindEvents: function() {
			this.form.on('submit', $.proxy(this.sendToken, this));
		},

		sendToken: function(event) {
			this.submitButton.text('Validating').prop('disabled',true);

			Stripe.createToken(this.form, $.proxy(this.pinResponseHandler, this));
			event.preventDefault();
		},

		pinResponseHandler: function(status, response) {
			if(response.error) {
				this.form.find('.payment-errors').show().text(response.error.message);
				return this.submitButton.prop('disabled',false).text(this.submitButtonValue);
			}

			$('<input>', {
				type: 'hidden',
				name: 'stripe_token',
				value: response.id
			}).appendTo(this.form);

			$('<input>', {
				type: 'hidden',
				name: 'stripe_data',
				value: response.card.type+','+response.card.last4+','+response.card.exp_month+','+response.card.exp_year
			}).appendTo(this.form);

			this.form[0].submit();
		}
	}

	DonationProccess.init();
})();

$('#cc-number').formance('format_credit_card_number');
$('#cc-expiry').formance('format_credit_card_expiry');
$('#cc-cvc').formance('format_credit_card_cvc');

$( "#cc-number" ).keypress(function() {
	$(this).css('background', 'url(/img/icons/'+ $.formance.creditCardType($(this).val()) +'.png) no-repeat right');
});

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
		}
		else
		{
			//alert(json.message);
			steam_input.css('background-color', 'yellow');
		}
	});
});