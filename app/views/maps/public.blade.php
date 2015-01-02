@extends('layouts.master')

@section('content')

<section class="content-shade">

<h1>Maps</h1>

@if(Session::has('public-auth-true') && Session::has('player'))

	<p><img src="/images/avatar/{{ (Session::get('player')->steam_image ? urlencode(Session::get('player')->steam_image) : urlencode('http://ag-aus.app/img/anonnymous.jpg') ) }}"> {{ Session::get('player')->steam_nickname }}</p>

	<p>Yay you're logged in. <a href="/maps/logout">Logout</a></p>
@else
	<p><a href="{{ SteamLogin::url(Config::get('steam.login')) }}">Login via Steam!</a></p>
@endif



<ul class="maps-list">
@if(count($maps) > 0)
@foreach($maps as $map)
	<li class="col-sm-4">

		<div class="map-thumbnail">
			<a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}">
				<span class="download-link"><i class="fa fa-cloud-download"></i><br>Download</span>
				@if($map->images)
					<img src="/images/mapthumbnail/{{ $map->images }}" />
				@else
					<img src="/images/mapthumbnail/{{ urlencode(url('/img/no-thumb.png')) }}" />
				@endif
				
			</a>
		</div>
		
		<div class="map-desc">

			@if ($map->filesize >= 1048576)
		        <p>{{ substr($map->filename, 0, -8) }}<br><small>{{ number_format($map->filesize / 1048576, 2) . ' MB' }}</small></p>
		    @elseif ($map->filesize >= 1024)
		        <p>{{ substr($map->filename, 0, -8) }}<br><small>{{ number_format($map->filesize / 1024, 2) . ' KB' }}</small></p>
		    @endif

		    <p>
		    	<a class="vote-up" href="/maps/{{ $map->id }}/feedback/vote-up">{{ $map->feedback->sum('vote_up') }} <i class="fa fa-thumbs-up"></i></a>
		    	<a class="vote-down" href="/maps/{{ $map->id }}/feedback/vote-down">{{ $map->feedback->sum('vote_down') }} <i class="fa fa-thumbs-down"></i></a>
		    	<a class="vote-broken" href="/maps/{{ $map->id }}/feedback/broken">{{ $map->feedback->sum('vote_broken') }} Broken?</a>
		    </p>

		</div>
	</li>
@endforeach
@else
	<li>No maps found.</li>
@endif
</ul>

</section>

@stop

@section('footer')

<style type="text/css">
	
	.dataTables_length, .dataTables_info {
		display: none;
	}
	
	.dataTables_filter {
		float: left;
		text-align: left;
	}

</style>

<script type="text/javascript">
	
	// $('#maps-list').dataTable({
	// 	'bPaginate': false
	// });
</script>

@stop