@extends('layouts.master')

@section('content')


<div class="col-sm-12 col-md-3 content-shade" style="float:right;">

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
            <div id="steam_id_valid"></div>

            <div class="form-group">
                    {{ Form::text('steam_id', null, ['class' => 'form-control', 'id' => 'steam_id', 'placeholder' => 'STEAM_X:X:XXXXXX']) }}
            </div>

            <!-- Text input-->
            <div class="form-group">
                    
                {{ Form::number('amount', $value = null, [
                    'class' => 'form-control',
                    'id' => 'donation-amount',
                    'placeholder' => '0.00',
                    'required' => 'required'
                ]) }}
            </div>

            <div class="form-group">
                <button id="donation_submit" class="btn btn-warning btn-block" type="submit">Donate</button>
            </div>
        </fieldset>

    {{ Form::token(); }}
{{ Form::close() }}

</div>





<div class="col-sm-12 col-md-9 content-shade">

    <h1>Donations</h1>

    <p>To support our server costs we offer a Donator satuts on our TF2 servers at $7.00AUD per month, this gives some  exclusive benifets (Not even admins get most of these):</p>

    <ul class="donor-perks">
        <li>Reserved Player Slot <small>Join a game even when its full.</small></li>
        <li>Humiliation-Round immunity <small>If your team loses at the end of a round, you can't be killed.</small></li>
        <li>Special Donator Tag in-game <small>Exclusive Purple? Donator tag on in-game chat.</small></li>
        <li>Golden Frying-Pan <small>During the pre-round team killing, you weild a Golden Frying Pan.</small></li>
    </ul>

    <p>Current quarter Goal: ${{ $goal }}, Donated so far: ${{ $total }}</p>

    <div class="progress progress{{ ($percentage >= 100) ?: '-striped active' }}">
      <div class="progress-bar progress-bar-{{ ($percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($percentage >= 100) ? '100' : $percentage }}%">
        {{ $percentage }}%
      </div>
    </div>

    <div class="col-sm-12">

        @foreach($donations as $donation)
        <div class="col-md-3 donor">

            <img src="/images/avatar/{{ ($donation->player ? urlencode($donation->player->steam_image) : urlencode('http://ag-aus.app/img/anonnymous.jpg') ) }}"> {{ $donation->player->steam_nickname or 'Anonnymous' }}
        </div>
        @endforeach
    </div>
</div>
@stop

@section('footer')

@stop
