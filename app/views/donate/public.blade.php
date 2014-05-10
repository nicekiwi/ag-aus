@extends('layouts.master')

@section('content')



<div class="col-sm-12 col-md-3" style="float:right;">

    <!-- <div class="donation-options">

        <div class="form-group">
            
            {{ Form::radio('donation', '3months', null, ['id'=>'donation1']) }}
            <label for="donation1" class="btn btn-primary btn-lg btn-block">
                <b>3 Months</b><br>
                $18.00 AUD
            </label>

        </div>

        <div class="form-group">
            
            {{ Form::radio('donation', '6months', null, ['id'=>'donation2']) }}
            <label for="donation2" class="btn btn-primary btn-lg btn-block">
                <b>6 Months</b><br>
                $32.00 AUD
            </label>

        </div>

        <div class="form-group">
            
            {{ Form::radio('donation', '12months', null, ['id'=>'donation3']) }}
            <label for="donation3" class="btn btn-primary btn-lg btn-block">
                <b>1 Year</b><br>
                $60.00 AUD
            </label>

        </div>
        
    </div> -->

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
                                'placeholder' => '5.00'
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

    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-{{ ($quarter->percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $pquarter->ercentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $quarter->percentage }}%">
        {{ $quarter->percentage }}%
      </div>
    </div>

    <ul class="col-sm-12">
        
        @foreach($donations as $donation)
        <li class="col-md-3"><img src="{{ $donation->donator->steam_image }}"> {{ $donation->donator->nickname }}</li>
        @endforeach

    </ul>

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
        image: 'https://pbs.twimg.com/profile_images/3397355192/f5964922332680947969dcf44e2a7d13.jpeg',
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

    if(steam_input.val() == '') return false;

    $.getJSON( "/check-steamid/"+$(this).val(), function( json ) {

        if(typeof(json.steamId) != "undefined")
        {
            steam_id_valid = true;
            steam_input.css('background-color', 'green');

            $( "#steam_id_valid" ).append( '<img src="'+ json.profileImage +'.jpg"><strong>'+ json.nickname +'</strong><br>' + json.id2  );

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