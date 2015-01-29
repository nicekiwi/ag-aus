@extends('layouts.master')

@section('content')

    <section class="content-shade">
        <ul>
        @foreach($posts as $post)
            <li>
                <h3><a href="/news/{{ $post->slug }}/{{ $post->id }}">{{ $post->title }}</a></h3>
                <p><small>{{ $post->date }} - {{ $post->author ?: 'MysteryMeat' }}</small></p>
            </li>
        @endforeach
        </ul>
    </section>

@stop