@extends('layouts.master')

@section('content')

<h1>Maps</h1>

@if(Auth::check())
	<p><a href="/maps/create">Add Map</a></p>
@endif


<dl class="sub-nav">
	<dt>Filter:</dt>
	<dd class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All</a></dd>
	@foreach($map_modes as $mode)
	<dd class="{{ (Input::get('type') == $mode->mode ? 'active' : '') }}"><a href="/maps?type={{ $mode->mode }}">{{ $mode->name }}</a></dd>
	@endforeach
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
			<td>{{ $map->name }}</td>
			<td>{{ $map->size }}</td>
			<td>{{ $map->created_at }}</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@else
<p>No maps available.</p>
@endif

@stop