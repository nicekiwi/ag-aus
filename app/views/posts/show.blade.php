@extends('layouts.master')

@section('content')

<h1>{{ $post->title }}</h1>
<p>Posted by <a href="/users/{{ $post->user->username }}">{{ $post->user->username }}</a> {{ $post->created_at->diffForHumans() }}</p>
{{ $post->desc }}

<a href="/posts/{{ $post->id }}/edit">Edit post</a>
@stop