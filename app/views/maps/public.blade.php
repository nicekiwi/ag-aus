@extends('layouts.master')

@section('content')

<h1>Maps</h1>

<p>
<ul class="nav nav-pills">
	<li class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All ({{ count($maps) }})</a></li>
	@foreach($map_types as $type)
	<li class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/maps?type={{ $type->type }}">{{ $type->name }} ({{ $type->maps->count() }})</a></li>
	@endforeach
</ul>
</p>

<table id="maps-list" class="table table-hover table-bordered table-striped table-responsive">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Filename</td>
			<td>Size (MB)</td>
			<td>Popularity</td>
			<td>Added</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@if(count($maps) > 0)
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->maptype->type }}</td>
			<td><a href="/maps/{{ $map->slug }}">{{ $map->name }} {{ $map->revision }}</a></td>
			<td>{{ $map->filename }}</td>
			<td>{{ round(($map->filesize/1048576), 0) }}</td>
			<td><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i></td>
			<td>{{ $map->created_at->diffForHumans() }}</td>
			<td><a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}"><i class="fa fa-cloud-download fa-lg"></i> Download</a></td>
		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="7">No maps found.</td>
		</tr>
		@endif
	</tbody>
	
</table>

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