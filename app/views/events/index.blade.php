@extends('layouts.master')

@section('content')

    <h2>Upcoming Events:</h2>
    <ul>
        @foreach($events as $event)
            <li>{{ $event->date }} - <a href="/events/{{ $event->slug }}">{{ $event->title }}</a></li>
        @endforeach
    </ul>

    <h3>Past Events:</h3>
    <ul>
        @foreach($pastEvents as $event)
            <li>{{ $event->date }} - <a href="/events/{{ $event->slug }}">{{ $event->title }}</a></li>
        @endforeach
    </ul>

@stop