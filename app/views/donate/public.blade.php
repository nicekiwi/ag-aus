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


    
</script>

@stop