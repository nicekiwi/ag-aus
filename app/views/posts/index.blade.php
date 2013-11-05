@extends('layouts.master')

@section('content')

<div class="news-posts">
	@foreach($posts as $post)
	<section class="post">
		<h2 class="post-title">{{ $post->title }}</h2>
		<p class="expert">{{ preg_replace('/\s+?(\S+)?$/', '', substr($post->desc, 0, 201)); }}</p>
	</section>
	@endforeach
	{{ $posts->links() }}
</div>

@stop