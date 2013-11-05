@extends('layouts.master')

@section('content')

<h2>Donate</h2>



{{ Form::open(array('url' => '/donate', 'method' => 'post', 'id' => 'donation_form','role' => 'form')) }}
	<div class="panel panel-default">
        <div class="panel-body">
            <fieldset>
                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="steamid">Steam Login ID</label>

                    <div class="col-md-8 form-group">
	  					{{ Form::text('steamid', $value = null, ['class' => 'form-control', 'id' => 'steamid']) }}
	  					<span class="help-block">Leave this field blank to donate annonymously.</span>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="email">Email Address</label>

                    <div class="col-md-8">
	   					{{ Form::email('email', $value = null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => '', 'required' => true]) }}
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label">Credit Card Number</label>

                    <div class="col-md-8">
                        {{ Form::text(null, $value = null, ['class' => 'form-control', 'id' => 'cc-number', 'data-stripe' => 'number', 'placeholder' => '•••• •••• •••• ••••', 'required' => true]) }}
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="cc-expiration-month">Expiration Date</label>

                    <div class="col-md-3">
                        {{ Form::selectMonth(null, null, ['id' => 'cc-exp-month', 'data-stripe' => 'exp-month', 'class' => 'form-control', 'required' => true]) }}
                    </div>
                    <div class="col-md-2">
                        {{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['id' => 'cc-exp-year', 'data-stripe' => 'exp-year', 'class' => 'form-control', 'required' => true])}}
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="cc-cvc">CVC Number</label>

                    <div class="col-md-3">
                        {{ Form::text(null, $value = null, ['class' => 'form-control', 'id' => 'cc-cvc', 'data-stripe' => 'cvc', 'required' => true]) }}
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


            	<!-- Text input-->
                <div class="form-group row">
                    <label class="col-md-4 control-label" for="steamid">Donation Amount</label>

                    <div class="col-md-8">
	  					{{ Form::text('amount', $value = null, ['class' => 'form-control', 'id' => 'donation-amount', 'placeholder' => '$12.00']) }}
                    </div>
                </div>
            </fieldset>
        </div> <!-- panel-body -->

        <div class="panel-footer clearfix">
            <div class="pull-left col-md-7 terms">
                <p>
                    All donations are in Australian Dollars
                </p>
            </div>

            <div class="pull-right sign-up-buttons">
                <button class="btn btn-primary" type="submit">Make Donation</button>
            </div>

            <div class="payment-errors col-md-8 text-danger" style="display:none"></div>
        </div> <!-- panel-footer -->
    </div>

    {{ Form::token(); }}
{{ Form::close() }}

@stop

@section('footer')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="/js/donation.js"></script>

@stop