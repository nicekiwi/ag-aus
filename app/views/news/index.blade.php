@extends('layouts.master')

@section('content')

    <ul>
    @foreach($posts as $post)
        <li>{{ $post->date }} - <a href="/news/{{ $post->slug }}">{{ $post->title }}</a></li>
    @endforeach
    </ul>

@stop