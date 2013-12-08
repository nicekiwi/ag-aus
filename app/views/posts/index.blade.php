@extends('layouts.master')

@section('content')

<h1>News</h1>
@if(Auth::check())

<a href="/posts/create">Create Post</a>

@endif

<div class="row">
	<ul style="list-style:none;padding:0;margin:0;">
		@foreach($posts as $post)
		<li style="margin:12px 0;" class="post medium-12 columns">
			<div class="medium-3 columns">
				<img class="th" src="https://i.embed.ly/1/display/crop?key=d5a004fad9d94741b9ea438a9b802b3e&amp;url={{ $post->featured_image }}&amp;height=150&amp;width=200">
			</div>
			<div class="medium-9 columns">
				<h3 class="post-title"><a href="/news/{{ $post->slug }}">{{ $post->title }}</a></h3>
				<p class="expert" style="margin-bottom:0;">{{ preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post->desc), 0, 101)); }}</p>
			</div>
		</li>
		@endforeach	
	</ul>
</div>
{{ $posts->links() }}

@stop