@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="small-12 columns">

		<h1>Users<a href="/admin/users/create" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Add User</a></h1>

		<table class="table table-striped table-bordered" width="100%">
			<thead>
				<tr>
					<td>Role</td>
					<td>Username</td>
					<td>Email Address</td>
					<td>Last Login</td>
					<td>Created</td>
					<td>Action</td>
				</tr>
			</thead>

			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{ $user->role->name }}</td>
					<td>{{ $user->username }}</td>
					<td><a href="/admin/users/{{ $user->id }}/edit">{{ $user->email }}</a></td>
					<td>
					@if($user->last_login !== null)
					{{ $user->last_login->diffForHumans() }}
					@endif
					</td>
					<td>{{ $user->created_at->diffForHumans() }}</td>
					<td>
						{{ Form::delete('admin/users/'. $user->id, 'Delete', null, array('class' => 'btn btn-danger btn-sm')) }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop