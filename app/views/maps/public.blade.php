@extends('layouts.master')

@section('content')

<h1>Maps</h1>

<p>Filter by Type:</p>
<p>
<ul class="nav nav-pills">
	<li class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All</a></li>
	@foreach($map_types as $type)
	<li class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/maps?type={{ $type->type }}">{{ $type->name }} ({{ $type->maps->count() }})</a></li>
	@endforeach
</ul>
</p>

<p>Filter by Tag:</p>
<p>List tags here</p>

<table id="maps-list" class="table table-hover table-bordered table-striped	 table-responsive">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Filename</td>
			<td>Size (MB)</td>
			<td>Popularity</td>
			<!-- <td>Added</td> -->
		</tr>
	</thead>
	<tbody>
		@if(count($maps) > 0)
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->maptype->type }}</td>
			<td><a href="/maps/{{ $map->slug }}">{{ $map->name }} {{ $map->revision }}</a></td>
			<td>
				{{ $map->filename }}
				@if($map->mapFiles->count() > 0)
				@foreach($map->mapFiles as $file)
				<span class="label label-primary" style="text-transform:uppercase;">{{ $file->filetype }}</span>
				@endforeach
				@endif
			</td>

			@if ($map->filesize >= 1048576)
	            <td>{{ number_format($map->filesize / 1048576, 2) . ' MB' }}</td>
	        @elseif ($map->filesize >= 1024)
	            <td>{{ number_format($map->filesize / 1024, 2) . ' KB' }}</td>
	        @endif

			<td><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i></td>
			<!-- <td>{{ $map->created_at->diffForHumans() }}</td> -->
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