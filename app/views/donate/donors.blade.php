@extends('layouts.master')

@section('content')

<h2>Donors</h2>

<p><strong>Donations in 2013</strong></p>
<ul>
@foreach ($data->donations as $donation)
	<li>
		<img src="{{ ($donation->donator->steam_image != '' ? $donation->donator->steam_image.'.jpg' : Gravatar::src($donation->donator->email, 24)) }}" class="">
		@if($donation->donator->steam_id != '')
			{{ $donation->donator->steam_id }}
		@endif
		
		${{ $donation->amount }}
	</li>
@endforeach
</ul>

<h5>${{ $data->total_amount }}.00 / $1,000</h5>
<div class="progress">
  <div class="progress-bar progress-bar-{{ $data->class }}"  role="progressbar" aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->percentage }}%">
    <span class="sr-only">{{ $data->percentage }}%x Complete</span>
  </div>
</div>

@stop