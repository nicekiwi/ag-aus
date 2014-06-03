@extends('layouts.admin')

@section('content')

<h1>Map Configs <a class="btn btn-primary" href="/admin/maps/configs/create">New Map Config file</a></h1>

<p>Here are all the Map Config files for the servers. Here you can create, edit, enable, disable, shedule and remove Configurations.</p>

@if(count($configs) > 0)
<table id="config-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Name</td>
			<td>Assigned</td>
			<td>Sheduled</td>
			<td>Updated</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($configs as $config)
		<tr>
			<td>
				<a href="/admin/maps/configs/{{ $config->id }}/edit">{{ $config->name }}</a>
			</td>
			<td>
				{{ $config->server->name }}
			</td>
			<td>
				{{ $config->start_at }} - {{ $config->end_at }}
			</td>
			<td>
				{{ $config->updated_at->diffForHumans() }} by {{ $config->user->username }}
			</td>
			<td>
				{{ Form::delete('admin/maps/'. $config->id) }}
			</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@else
<p>No maps available.</p>
@endif

@stop