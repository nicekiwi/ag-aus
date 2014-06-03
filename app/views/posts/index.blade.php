@extends('layouts.admin')

@section('content')

<h1>News Posts</h1>

<p><a href="/admin/posts/create" class="button"><i class="fa fa-plus-circle"></i> New Post</a></p>

<div class="row">
	<div class="small-12 columns">
		<table class="table table-striped table-bordered" width="100%">
			<thead>
				<tr>
					<td>ID</td>
					<td>Title</td>
					<td>Added</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
				@foreach($posts as $post)
				<tr>
					<td>{{ $post->id }}</td>
					<td>
						<a href="/admin/posts/{{ $post->id }}/edit">{{ $post->title }}</a>
						@if($post->featured_image != '')
							<i class="fa fa-picture-o"></i>
						@endif
					</td>
					<td>{{ $post->created_at->diffForHumans() }} by {{ $post->user->username }}</td>
					<td>
						{{ Form::delete('/admin/posts/' . $post->id) }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
{{ $posts->links() }}

@stop