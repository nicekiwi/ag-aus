@extends('layouts.master')

@section('content')

<h1>Maps</h1>

<div class="well col-sm-12">
	<select class="form-control">
		<option value="all">All ({{ $map_total }})</option>
		@foreach($map_types as $type)
		@if($type->maps->count() > 0)
		<option value="{{ $type->type }}">{{ $type->name }} ({{ $type->maps->count() }})</option>
		@endif
		@endforeach
	</select>
</div>

<table id="maps-list" class="table table-hover table-bordered table-striped	table-responsive">
	<thead>
		<tr>
			<td><!-- Type --></td>
			<!-- <td>Name</td> -->
			<td>Filename</td>
			<!-- <td>Popularity</td> -->
			<td>Size</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@if(count($maps) > 0)
		@foreach($maps as $map)
		<tr>
			<td><!-- {{ $map->maptype->type }} --></td>
			<!-- <td><a href="/maps/{{ $map->slug }}">{{ $map->name }} {{ $map->revision }}</a></td> -->
			<td>
				{{ $map->filename }}
				@if($map->mapFiles->count() > 0)
				@foreach($map->mapFiles as $file)
				<span class="label label-primary" style="text-transform:uppercase;">{{ $file->filetype }}</span>
				@endforeach
				@endif
			</td>

			<!-- <td><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i></td> -->

			@if ($map->filesize >= 1048576)
	            <td>{{ number_format($map->filesize / 1048576, 2) . ' MB' }}</td>
	        @elseif ($map->filesize >= 1024)
	            <td>{{ number_format($map->filesize / 1024, 2) . ' KB' }}</td>
	        @endif
			
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