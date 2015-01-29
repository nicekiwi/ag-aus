@extends('layouts.master')

@section('content')

    <section class="content-shade">
        <h2>{{ $event->title }}</h2>
        <p><small>{{ $event->date }} - {{ $event->author }}</small></p>

        <p><img src="{{ $event->logo }}" /></p>

        <div>{{ $event->desc }}</div>

        <p><a target="_blank" href="http://steamcommunity.com/groups/AG-Aus/events/{{ $event->id }}"><i class="fa fa-external-link"></i> View and Comment</a> on Steam Community.</p>
    </section>


@stop