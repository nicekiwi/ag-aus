@extends('layouts.email')

@section('content')

<h2>New Donation!</h2>

@if($data['nickname'])

  <p>{{ $data['nickname'] }} has donated ${{ $data['amount'] }}, Yay.</p>

  <p>&nbsp;</p>

  <h3>Step 1. Add their Donator Status</h3>

  <p>Add the following code to <code>/tf/addons/sourcemod/config/admins.txt</code></p>
  <pre>{{ $data['admin'] }}</pre>

  <p>Then add the following code to <code>/tf/addons/sourcemod/config/donators.txt</code></p>
  <pre>{{ $data['sprite'] }}</pre>

  <h3>Step 2. Confirm the Donation and Notify the Player.</h3>

  <p>Click the link below confirm this donation and send a confirmation to the player that their Donator Status has been added and will be availble by the next map change.</p>

  <p>{{ secure_url('/admin/donations/confirm/' . $data['code']) }}</p>

@else

  <p>An annonymous angel has donated ${{ $data['amount'] }}, Yay.</p>

  <p>No further action is required.</p>

@endif


@stop
