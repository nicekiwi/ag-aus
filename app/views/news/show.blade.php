@extends('layouts.master')

@section('content')

    <section class="content-shade">
        <h1>{{ $post->title }}</h1>
        <p><small>{{ $post->date }} - {{ $post->author ?: 'MysteryMeat' }}</small></p>

        <div>{{ $post->descHtml }}</div>

        <p><a target="_blank" href="{{ $post->link }}"><i class="fa fa-external-link"></i> View and Comment</a> on Steam Community.</p>
    </section>


@stop