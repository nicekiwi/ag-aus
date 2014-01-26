@extends('layouts.master')

@section('content')

<h1>Maps</h1>

<dl class="sub-nav">
	<dt>Filter:</dt>
	<dd class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All</a></dd>
	@foreach($map_types as $type)
	<dd class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/maps?type={{ $type->type }}">{{ $type->name }}</a></dd>
	@endforeach
	<!-- <dd class="{{ (Input::get('type') == 'new' ? 'active' : '') }}"><a href="/maps?type=new">New</a></dd> -->
</dl>

@if(count($maps) > 0)
<table id="maps-list">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Size (MB)</td>
			<td>Added</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->maptype->type }}</td>
			<td><a href="/maps/{{ $map->slug }}">{{ $map->name }} {{ $map->revision }}</a></td>
			<td>{{ round(($map->filesize/1048576), 2) }}</td>
			<td>{{ $map->created_at->diffForHumans() }}</td>
			<td><a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}"><i class="fa fa-cloud-download"></i> Download</a></td>
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