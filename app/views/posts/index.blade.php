@extends('layouts.master')

@section('content')

<h1>News</h1>
@if(Auth::check())

<a href="/posts/create">Create Post</a>

@endif

@foreach($posts as $post)
<section class="post">
	<div class="medium-3 columns">
		<img class="th" src="https://i.embed.ly/1/display/crop?key=d5a004fad9d94741b9ea438a9b802b3e&amp;url={{ $post->featured_image }}&amp;height=150&amp;width=200">
	</div>
	<h2 class="post-title"><a href="/news/{{ $post->slug }}">{{ $post->title }}</a></h2>
	<p class="expert">{{ preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post->desc), 0, 201)); }}</p>
</section>
@endforeach
{{ $posts->links() }}

@stop