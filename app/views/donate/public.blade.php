@extends('layouts.master')

@section('content')

    <div class="col-sm-12 col-md-8">

        <section class="content-shade">
            <h1>Donate</h1>

            <p>To support our server costs we offer a Donator satuts on our TF2 servers at ${{ $options->donation_monthly_cost }}AUD per month, this gives some  exclusive benifets (Not even admins get most of these):</p>

            <ul class="donor-perks">
                <li><i class="fa fa-star"></i> Reserved Player Slot<br><small>Join a game even when its full. (Up to 32 Players)</small></li>
                <li>Humiliation-Round immunity<br><small>If your team loses at the end of a round, you can't be killed.</small></li>
                <li><i class="fa fa-tag"></i> Special Donator Tag in-game<br><small>Exclusive Purple? Donator tag on in-game chat.</small></li>
                <li>Golden Frying-Pan<br><small>During the pre-round team killing, you weild a Golden Frying Pan.</small></li>
            </ul>

            <h3>Exultant Donors</h3>

            <ul class="donators-avatar-list">

                @foreach($quarter->donations as $donation)
                    <li><img data-toggle="tooltip" data-placement="bottom" title="{{ htmlspecialchars($donation->player->steam_nickname) }}" src="/images/donatoravatar/{{ ($donation->player ? urlencode($donation->player->steam_image) : urlencode('/img/anonnymous.jpg') ) }}"></li>
                @endforeach
            </ul>

            <h5>Refunds</h5>
            <p>Refunds are available only in the following two cases:</p>
            <ol>
                <li>If a technical fault causes the AG/DoP TF2 servers unplayable for an extended period of time (being empty does not count);</li>
                <li>Or if </li>
            </ol>

            If something were to happen to the TF2 servers that made them unusable before your Donator Status expires (Being empty does not count), we can easily refund you for the months remaining on your donator status.</p>
        </section>


    </div>

<div class="col-sm-12 col-md-4">

    <section class="content-shade">

    <h3>{{ $quarter->quarter }}st Quarter <small>${{ $quarter->total }} / ${{ $quarter->goal }}</small></h3>

    <div class="progress progress{{ ($quarter->percentage >= 100) ?: '-striped active' }}">
        <div class="progress-bar progress-bar-{{ ($quarter->percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $quarter->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($quarter->percentage >= 100) ? '100' : $quarter->percentage }}%">
            {{ $quarter->percentage }}%
        </div>
    </div>

    <div class="donation-excitement-meter">
        @if($quarter->percentage >= 100)
            <img src="/img/donate/goal-complete.png" />
        @elseif($quarter->percentage >= 90)
            <img src="/img/donate/goal-90.png" />
        @elseif($quarter->percentage >= 75)
            <img src="/img/donate/goal-75.png" />
        @elseif($quarter->percentage >= 50)
            <img src="/img/donate/goal-50.png" />
        @elseif($quarter->percentage >= 25)
            <img src="/img/donate/goal-25.png" />
        @else
            <img src="/img/donate/goal-incomplete.png" />
        @endif
    </div>

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
                {{ Form::label('steam_id', 'Your SteamID (ID32)') }}
                {{ Form::text('steam_id', Session::get('player')->steam_id ?: null, ['class' => 'form-control', 'id' => 'steam_id', 'placeholder' => 'STEAM_X:X:XXXXXX']) }}
            </div>

            <!-- Text input-->
                {{ Form::label('amount', 'Donation Amount') }}
                <div class="input-group">

                    {{ Form::number('amount', $value = null, [
                    'class' => 'form-control',
                    'id' => 'donation-amount',
                    'placeholder' => ($options->donation_monthly_cost * 2).'.00',
                    'required' => 'required'
                ]) }}
                    <span class="input-group-btn">
                        <button id="donation_submit" class="btn btn-warning">Donate</button>
                    </span>
                </div>

                <img src="/img/payment-icons.png" style="width:100%"/>
        </fieldset>

    {{ Form::token(); }}
{{ Form::close() }}

    </section>

</div>






@stop

@section('scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@stop
