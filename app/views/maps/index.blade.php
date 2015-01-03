@extends('layouts.admin')

@section('content')

<h1>Maps <a class="btn btn-primary" href="/admin/maps/upload">Upload</a></h1>
<!-- <ul class="nav nav-tabs">
  <li class="active"><a href="#">Maps</a></li>
  <li class=""><a href="#">Configs</a></li>
  <li class=""><a href="#">Trash</a></li>
</ul> -->


<!-- 	<select class="form-control map-filter">
		<option value="all">All ({{ $map_total }})</option>
		@foreach($map_types as $type)
		@if($type->maps->count() > 0)
		<option value="{{ $type->type }}">{{ $type->name }} ({{ $type->maps->count() }})</option>
		@endif
		@endforeach
	</select> -->


@if(count($maps) > 0)
<table id="maps-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Type</td>
			<!-- <td>Name</td> -->
			<td>Filename</td>
			<td>Size</td>
			<td>Added</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->mapType->type }}</td>
			<td><a href="/admin/maps/{{ $map->id }}/edit">{{ $map->filename }}</a></td>

			<td data-sort="{{ $map->filesize }}">
				{{ $map->filesizeHuman() }}
			</td>

			
			<td>{{ $map->created_at->diffForHumans() }} by {{ $map->user->username }}</td>
			<td>{{ Form::delete('admin/maps/'. $map->id) }}</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@else
<p>No maps available.</p>
@endif

@if(count($map_files) > 0)

<h3>Map files without accosiated Maps.</h3>

<table id="maps-files-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Name</td>
			<td>Type</td>
			<td>Size (MB)</td>
			<td>Added</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($map_files as $file)
		<tr>
			<td>{{ $file->filename }}</td>
			<td>{{ $file->filetype }}</td>
			<td>{{ round(($file->filesize/1048576), 2) }}</td>
			<td>{{ $file->created_at->diffForHumans() }}</td>
			<td>{{ Form::delete('admin/maps/'. $file->id) }}</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@endif

@stop

@section('footer')

<style type="text/css">
	
	/*.dataTables_length, .dataTables_info {
		display: none;
	}
	
	.dataTables_filter {
		float: left;
		text-align: left;
	}*/

</style>

<script type="text/javascript">
	
	$('#maps-list').dataTable({
		//"bPaginate": false,
		// "aoColumns": [
		// 	null,
		// 	null,
		// 	{ "sType": "numeric" },
		// 	null,
		// 	null,

		// ],

		//"sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
	});
</script>

@stop