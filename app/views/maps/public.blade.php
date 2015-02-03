@extends('layouts.master')

@section('content')

	<div class="col-sm-12">
		<section class="content-shade">

			<h1>Maps</h1>

			<div class="form-group">
				<label>Filter</label>
				<input type="text" class="filter form-control" />
			</div>

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
				<span class="vote-options {{ ($map->feedbackScore() >= 0) ? 'vote-positive' : 'vote-negative' }}">
		    	<a class="vote-btn vote-up" data-map-id="{{ $map->id }}" data-action="up" href="/maps"><i class="fa fa-thumbs-up"></i></a>
					{{ $map->hasVoted() }}
					<a class="vote-btn vote-down" data-map-id="{{ $map->id }}" data-action="down" href="/maps"><i class="fa fa-thumbs-down"></i></a>
				</span>
									<a class="vote-btn vote-broken" data-filename="{{ substr($map->filename, 0, -8) }}" data-map-id="{{ $map->id }}" data-action="broken" href="/maps"><span>{{ $map->feedback->sum('vote_broken') }}</span> <i class="fa fa-exclamation-triangle"></i></a>
								</p>

							</div>
						</li>
					@endforeach
				@else
					<li>No maps found.</li>
				@endif
			</ul>

		</section>
	</div>

	{{--<div class="col-sm-12 col-md-4">--}}
		{{--<section class="content-shade">--}}
			{{----}}
		{{--</section>--}}
	{{--</div>--}}



@include('maps/partials/_report-form')

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

	var brokenModel = $('#report-broken-modal');


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

			var el = $(this);

			if(typeof loggedIn === 'undefined') {
				alert('You must be logged in to vote on maps, click the Login with Steam link.');
				return;
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

			if($(this).hasClass('vote-broken')) {
				brokenModel.modal('show');
				brokenModel.on('shown.bs.modal', function (e) {

					$('.broken-map-name').text(el.attr('data-filename'));
					$('input[name="map_id"]').val(el.attr('data-map-id'));
				})
			}
		});
		

	});
	
	// $('#maps-list').dataTable({
	// 	'bPaginate': false
	// });
</script>

@stop