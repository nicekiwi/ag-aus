@extends('layouts.admin')

@section('content')

<h1>News Posts</h1>

<p><a href="/admin/posts/create" class="button"><i class="fa fa-plus-circle"></i> New Post</a></p>

<div class="row">
	<div class="small-12 columns">
		<table style="width:100%;">
			<thead>
				<tr>
					<td>ID</td>
					<td>Image</td>
					<td>Title</td>
					<td>Creator</td>
					<td>Added</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
				@foreach($posts as $post)
				<tr>
					<td>{{ $post->id }}</td>
					<td>
						@if($post->featured_image != '')
							<i class="fa fa-picture-o"></i>
						@endif
					</td>
					<td><a href="/admin/posts/{{ $post->id }}/edit">{{ $post->title }}</a></td>
					<td>{{ $post->user->username }}</td>
					<td>{{ $post->created_at->diffForHumans() }}</td>
					<td>
						{{ Form::open(array('url' => '/admin/posts/' . $post->id, 'class' => 'pull-right')) }}
							{{ Form::hidden('_method', 'DELETE') }}
							{{ Form::submit('Delete', array('class' => 'button tiny alert')) }}
						{{ Form::close() }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
{{ $posts->links() }}

@stop