@extends('layouts.master')

@section('content')

<section class="content-shade">

<h1>Maps</h1>

@if(Session::has('public-auth-true') && Session::has('player'))

	<p><img src="/images/avatar/{{ (Session::get('player')->steam_image ? urlencode(Session::get('player')->steam_image) : urlencode('http://ag-aus.app/img/anonnymous.jpg') ) }}"> {{ Session::get('player')->steam_nickname }}</p>

	<p>You may only vote on a map once. If you up-vote and map, then down-vote it; your up-vote will be removed.</p>

	<p>Yay you're logged in. <a href="/maps/logout">Logout</a></p>

	<script type="text/javascript">var loggedIn = true;</script>
@else
	<p><a href="{{ SteamLogin::url(Config::get('steam.login')) }}">Login via Steam!</a></p>
@endif

<p><input type="text" class="filter" /></p>

<ul class="maps-list">
@if(count($maps) > 0)
@foreach($maps as $map)
	<li class="col-sm-4">

		<div class="map-thumbnail">
			<a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}">
				<span class="download-link"><i class="fa fa-cloud-download"></i><br>Download</span>
				<img src="/images/mapthumbnail/{{ $map->mapThumbnail() }}" />
			</a>
		</div>
		
		<div class="map-desc">
			
			<p class="filename">{{ substr($map->filename, 0, -8) }}<br><small>{{ $map->filesizeHuman() }}</small></p>

		    <p>
		    	<a class="vote-btn vote-up" data-map-id="{{ $map->id }}" data-action="up" href="/maps"><span>{{ $map->feedback->sum('vote_up') }}</span> <i class="fa fa-thumbs-up"></i></a>
		    	<a class="vote-btn vote-down" data-map-id="{{ $map->id }}" data-action="down" href="/maps"><span>{{ $map->feedback->sum('vote_down') }}</span> <i class="fa fa-thumbs-down"></i></a>
		    	<a class="vote-btn vote-broken" data-map-id="{{ $map->id }}" data-action="broken" href="/maps"><span>{{ $map->feedback->sum('vote_broken') }}</span> <i class="fa fa-exclamation-triangle"></i></a>
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


	$(function () {
    'use strict';

    	$('input.filter').on('keyup', function(){

        	var value = $(this).val();

        	//alert(value);

        	$('p.filename:not(:contains(' + value + '))').closest('li').hide(); 
			$('p.filename:contains(' + value + ')').closest('li').show();
        });
		
		$('a.vote-btn').on('click', function(e) {

			e.preventDefault();

			if(typeof loggedIn === 'undefined') {
				alert('You must be logged in to vote on maps, click the Login with Steam link.');
			}
			else {

				var span = $(this).find('span');

				if(!span.hasClass('voted')){
					span.text(Number(span.text()) + 1);
					span.addClass('voted');
				}

				$.post( "/maps/feedback", { 
					action: $(this).attr('data-action'), 
					map_id: $(this).attr('data-map-id')
				});
			}
		});
		

	});
	
	// $('#maps-list').dataTable({
	// 	'bPaginate': false
	// });
</script>

@stop