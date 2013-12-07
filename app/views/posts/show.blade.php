@extends('layouts.master')

@section('content')

<h1>{{ $post->title }}</h1>
<p><small>Posted by {{ $post->author }} on {{ date('D, d M Y', strtotime($post->created_at)) }}</small></p>
{{ $post->desc }}

<a href="/posts/{{ $post->id }}/edit">Edit post</a>
@stop