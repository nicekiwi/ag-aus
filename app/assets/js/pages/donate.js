/**
 * Created by Ezra on 7/02/15.
 */
var donationPayment = function() {

    var donationForm 			= $('#donate-form');
    var donationAmount          = $('input[name="amount"]', donationForm).val();
    var submitBtn               = $('button[type="submit"]', donationForm);
    var steamId                 = $('input[name="steamId32"]', donationForm);
    var checkSubmit 		    = false;
    var handler 				= StripeCheckout.configure({

        key: $('meta[name="stripe-key"]').attr('content'),
        image: '/img/ag-logo-stripe.png',
        token: function(token, args) {

            checkSubmit = true;

            submitBtn.text('Processing').prop('disabled', true);

            // Use the token to create the charge with a server-side script.
            donationForm.append(
                $('<input/>', {
                    type: 'hidden',
                    name: 'email',
                    value: token.card.name
                }),
                $('<input/>', {
                    type: 'hidden',
                    name: 'stripe_token',
                    value: token.id
                }),
                $('<input/>', {
                    type: 'hidden',
                    name: 'stripe_data',
                    value: token.card.type+','+token.card.last4+','+token.card.exp_month+','+token.card.exp_year
                })
            );

            donationForm.submit();

        },
        opened: function() {
            submitBtn.text('Proccessing').prop('disabled', true);
        },
        closed: function() {
            if(checkSubmit === false) {
                submitBtn.text('Make Donation').prop('disabled', false);
            }
        }
    });

    submitBtn.on('click', function(e){
        // Open Checkout with further options
        handler.open({
            name:           'Alternative Gaming Australia',
            description:    '$' + donationAmount + ' Donation',
            amount:         donationAmount * 100,
            currency:       'AUD',
            panelLabel:     'Donate'
        });
        e.preventDefault();
    });

    steamId.blur(function() {

        var validationPanel = $('.id-validation');
        var steamId32 = $(this).val();

        validationPanel.html('');

        if(steamId32 === '') return false;

        $.post('/validate-steam-id32', { 'id32': steamId32 }, function(data){

            validationPanel.append(
                $('<span/>', {
                    "class":"label label-error",
                    "text":"ID is invalid."
                })
            );

            if(data) {
                validationPanel.addClass('success').text('Valid ID');
            }
            else
            {
                validationPanel.addClass('error').text('Invalid ID');
            }

        }).fail(function() {
            validationPanel.addClass('error').text('ID could ne be validated.');
        });
    });
};