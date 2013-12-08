@extends('layouts.master')

@section('content')

<h1>Maps</h1>

@if(Auth::check())
	<p><a href="/maps/create">Sync with Amazon</a> <i class="fa fa-refresh"></i></p>
@endif


<dl class="sub-nav">
	<dt>Filter:</dt>
	<dd class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All</a></dd>
	@foreach($map_types as $type)
	<dd class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/maps?type={{ $type->type }}">{{ $type->name }}</a></dd>
	@endforeach
	<dd class="{{ (Input::get('type') == 'new' ? 'active' : '') }}"><a href="/maps?type=new">New</a></dd>
</dl>

@if(count($maps) > 0)
<table id="maps-list">
	<thead>
		<tr>
			<td>Name</td>
			<td>Size</td>
			<td>Created At</td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td><a href="/maps/{{ $map->id }}/edit">{{ $map->name }}x</a></td>
			<td>{{ round(($map->filesize/1048576), 2) }}</td>
			<td><a href="/maps/{{ $map->slug }}">{{ $map->created_at }}</a></td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@else
<p>No maps available.</p>
@endif

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
	
	$('#maps-list').dataTable({
		'bPaginate': false
	});
</script>

@stop