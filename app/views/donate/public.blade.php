@extends('layouts.master')

@section('content')

<div class="col-sm-12 col-md-3" style="float:right;">

{{ Form::open([
    'url' => '/donate', 
    'method' => 'post', 
    'id' => 'donation_form',
    'role' => 'form', 
    'autocomplete' => true,
    'class'=>'form-horozontal'
]) }}


        <fieldset>
            <!-- Text input-->
            <div class="form-group">
                    {{ Form::text('steam_id', null, ['class' => 'form-control', 'id' => 'steam_id', 'placeholder' => 'STEAM_X:X:XXXXXX']) }}
            </div>

            <div id="steam_id_valid"></div>    

            <!-- Text input-->
            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                            {{ Form::text('amount', $value = null, [
                                'class' => 'form-control', 
                                'id' => 'donation-amount', 
                                'placeholder' => '0.00'
                            ]) }}
                        <span class="input-group-btn">
                            <button id="donation_submit" class="btn btn-success" type="submit">Make Donation</button>
                        </span>
                    </div>
            </div>
        </fieldset>

    {{ Form::token(); }}
{{ Form::close() }}

</div>





<div class="col-sm-12 col-md-9">
    <h1>Donations <small>{{ $quarter->title }}</small></h1>

    <p>Quarter Goal: ${{ $quarter->goal_amount }}, Donated so far: ${{ $quarter->total_amount }}</p>

    <div class="progress progress{{ ($quarter->goal_percentage >= 100) ?: '-striped active' }}">
      <div class="progress-bar progress-bar-{{ ($quarter->goal_percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $pquarter->goal_percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($quarter->goal_percentage >= 100) ? '100' : $quarter->goal_percentage }}%">
        {{ $quarter->goal_percentage }}%
      </div>
    </div>

    <div class="col-sm-12">
        
        @foreach($donations as $donation)
        <div class="col-md-3"><img src="/images/avatar/{{ urlencode($donation->donator->steam_image) }}"> {{ $donation->donator->steam_nickname }}</div>
        @endforeach

    </div>

    <h4>Donatoer Perks:</h4>

    <p>Donators get a special status ingame, making them invulnerable during the Humiliation mode at the end of a round; and exclusive access to extra player slots on the servers (<a href="/help/donators#player-slots">How do I use this?</a>).</p>
</div>
@stop

@section('footer')

<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    (function() {
      var check_submit = false;
      var handler = StripeCheckout.configure({
        key: $('meta[name="stripe-key"]').attr('content'),
        image: '/img/ag-logo-stripe.png',
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

        // if(donation_amount >= 48) description = '15 Months Donator Perks';
        // else if(donation_amount >= 12) description = '3 Months Donator Perks';
        // else description = 'Donation';

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
})();

var steam_id_valid = false;

$( "#steam_id" ).blur(function() 
{
    var this_form = $('#donation_form');

    if(steam_id_valid) return false;
    var steam_input = $( this );

    if(steam_input.val() == '') return false;

    $.getJSON( "/check-steamid/"+$(this).val(), function( json ) {

        if(typeof(json.steam_url) != "undefined")
        {
            steam_id_valid = true;
            steam_input.css('background-color', 'green');

            $( "#steam_id_valid" ).append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_id  );

            $('<input>', {
                type: 'hidden',
                name: 'steam_image',
                value: json.steam_image
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_nickname',
                value: json.steam_nickname
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_id',
                value: json.steam_id
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_64id',
                value: json.steam_64id
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_url',
                value: json.steam_url
            }).appendTo(this_form);
        }
        else
        {
            steam_input.css('background-color', 'yellow');
        }
    });
});
    
</script>

@stop