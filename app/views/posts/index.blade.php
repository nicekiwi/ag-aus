@extends('layouts.master')

@section('content')

@if(Auth::check())

<a href="/posts/create">
<button type="button" class="btn btn-success">Create Post</button></a>

@endif

<div class="news-posts">
	@foreach($posts as $post)
	<section class="post">
		<h2 class="post-title">{{ $post->title }} {{ ($post->event ? '<small>{Event}</small>' : '') }}</h2>
		<p class="expert">{{ preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post->desc), 0, 201)); }}</p>
	</section>
	@endforeach
	{{ $posts->links() }}
</div>

@stop