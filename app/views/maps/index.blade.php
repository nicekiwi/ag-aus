@extends('layouts.master')

@section('content')

<div class="btn-group">
	<button type="button" class="active btn btn-default">All</button>
	<button type="button" class="btn btn-default">CP</button>
	<button type="button" class="btn btn-default">CTF</button>
	<button type="button" class="btn btn-default">PL</button>
	<button type="button" class="btn btn-default">KOTH</button>
</div>

{{ Form::text('search') }}

<p>&nbsp;</p>

<table>
	<thead>
		<tr>
			<td>Mode</td>
			<td>Name</td>
			<td>Size</td>
			<td>Date Added</td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td>{{ strtoupper($map->mode) }}</td>
			<td><a href="{{ $map->filename }}">{{ $map->name }}</a> <small>v{{ $map->revision }}</td>
			<td>{{ $map->size }}</td>
			<td>{{ $map->created_at }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

@stop