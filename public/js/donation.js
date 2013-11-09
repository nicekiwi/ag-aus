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
				name: 'stripe-token',
				value: response.id
			}).appendTo(this.form);

			$('<input>', {
				type: 'hidden',
				name: 'stripe-data',
				value: response.card.type+','+response.card.last4+','+response.card.exp_month+','+response.card.exp_year
			}).appendTo(this.form);

			this.form[0].submit();
		}
	}

	DonationProccess.init();
})();