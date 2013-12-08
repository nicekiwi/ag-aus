@extends('layouts.master')

@section('content')

<h1>Donations</h1>

<p><a href="/donors">See list of donors.</a></p>

<h4>Reasons to donate:</h4>
<ul>
    <li>You're supporting the AG Community (Yay).</li>
    <li>You'll get exclusive donator privilages in our Team Fortress 2 Servers.</li>
    <li>Because you're worth it!</li>
</ul>

<h4>Costs Breakdown:</h4>

<p></p>

<h4>Donatoer Perks:</h4>

<p>Donators get a special status ingame, making them invulnerable during the Humiliation mode at the end of a round; and exclusive access to extra player slots on the servers (<a href="/help/donators#player-slots">How do I use this?</a>).</p>
<p><strong>$12 or more</strong> will give the SteamID you provided Donator status on all Alterntive Gaming Team Fortress 2 servers for 3 months.</p><p><strong>$48 or more</strong> gives you the same as above for 15 Months <span class="text-danger">(Saving 25%)</span>.</p>


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

                <div id="steam_id_valid"></div>
            </fieldset>

            <hr>

            <fieldset>
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
                    <label class="col-md-4 control-label" for="amount">Amount</label>

<div id="slider"></div>

                    <div class="col-md-8">
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
                </div>
            </fieldset>
        </div> <!-- panel-body -->

    </div>

    

    {{ Form::token(); }}
{{ Form::close() }}

@stop

@section('footer')

<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript" src="/js/donation.js"></script>

@stop