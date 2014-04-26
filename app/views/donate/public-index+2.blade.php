@extends('layouts.master')

@section('content')

<h2>Make a Donation</h2>

<h4>Reasons to donate:</h4>
<ul>
    <li>You're supporting the AG Community (Yay).</li>
    <li>You'll get exclusive donator privilages in our Team Fortress 2 Servers.</li>
    <li>Because you're worth it!</li>
</ul>

<h4>Costs Breakdown:</h4>

<p></p>

{{ Form::open([
    'url' => '/donate', 
    'method' => 'post', 
    'id' => 'donation_form',
    'role' => 'form', 
    'autocomplete' => true
]) }}

	<div class="panel panel-default">
        <div class="panel-body">
            <fieldset>
                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="steamid">Steam Login ID</label>

                    <div class="col-md-8 input-group">
                        <span class="input-group-addon">
                            <img width="18" src="/img/icons/steam.png"></span>
	  					{{ Form::text('steam_id', $value = null, [
                            'class' => 'form-control', 
                            'id' => 'steam_id'
                        ]) }}
                    </div>
                </div>

                <div id="steam_id_valid">
                    

                </div>

                <!-- Checkbox input-->
                <div class="form-group row">
                    <div class="col-md-offset-4 col-md-8">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('null', $value = null, false) }} Make my donation anonymous.
                            </label>   
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="email">Email Address</label>

                    <div class="col-md-8">
                        {{ Form::email('email', $value = null, [
                            'class' => 'form-control', 
                            'id' => 'email', 
                            'placeholder' => '', 
                            'required' => true
                        ]) }}
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label">Credit Card Number</label>

                    <div class="col-md-8">
                        {{ Form::text(null, $value = null, [
                            'class' => 'form-control cc-number', 
                            'id' => 'cc-number', 
                            'data-stripe' => 'number', 
                            'placeholder' => '•••• •••• •••• ••••', 
                            //'pattern' => '\d*',
                            'autocompletetype' => 'cc-number',
                            'required' => true
                        ]) }}
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="cc-expiration-month">Expiration Date</label>

                    <div class="col-md-3">
                        {{ Form::selectMonth(null, null, [
                            'id' => 'cc-exp-month', 
                            'data-stripe' => 'exp-month', 
                            'class' => 'form-control', 
                            'required' => true
                        ]) }}
                    </div>
                    <div class="col-md-2">
                        {{ Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                            'id' => 'cc-exp-year', 
                            'data-stripe' => 'exp-year', 
                            'class' => 'form-control', 
                            'required' => true
                        ]) }}
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="cc-cvc">CVC Number</label>

                    <div class="col-md-3">
                        {{ Form::text(null, $value = null, [
                            'class' => 'form-control', 
                            'id' => 'cc-cvc', 
                            'data-stripe' => 'cvc', 
                            'required' => true
                        ]) }}
                    </div>
                </div>
            </fieldset>

            <hr>

            <fieldset>
            	<!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label">Donator Perks</label>

                    <div class="col-md-8">
                    	<p>Donators get a special status ingame, making them invulnerable during the Humiliation mode at the end of a round; and exclusive access to extra player slots on the servers (<a href="/help/donators#player-slots">How do I use this?</a>).</p>
	   					<p><strong>$12 or more</strong> will give the SteamID you provided Donator status on all Alterntive Gaming Team Fortress 2 servers for 3 months.</p><p><strong>$48 or more</strong> gives you the same as above for 15 Months <span class="text-danger">(Saving 25%)</span>.</p>
                    </div>
                </div>

                <hr>

                <!-- Checkbox input-->
                <div class="form-group row">
                    <div class="col-md-offset-4 col-md-8">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('null', $value = null, true) }} Email me when Donators perks about to expire.
                            </label>   
                        </div>
                    </div>
                </div>

                <!-- Checkbox input-->
                <div class="form-group row">
                    <div class="col-md-offset-4 col-md-8">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('null', $value = null, false) }} Email me when Donators perks about to expire.
                            </label>   
                        </div>
                    </div>
                </div>

                

            	<!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="amount">Amount</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                                {{ Form::text('amount', $value = null, [
                                    'class' => 'form-control', 
                                    'id' => 'donation-amount', 
                                    'placeholder' => '0.00'
                                ]) }}
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit">Make Donation</button>
                            </span>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div> <!-- panel-body -->

    </div>

    {{ Form::token(); }}
{{ Form::close() }}

@stop

@section('footer')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
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
    
</script>

@stop