@extends('layouts.master')

@section('content')



<h1>{{ $map->name }} <small>{{ $map->revision }} - {{ $map->maptype->name }}</small></h1>


<p><a href="/maps">Back to map list</a></p>

<img src="https://i.embed.ly/1/display/crop?key=d5a004fad9d94741b9ea438a9b802b3e&amp;url={{ $map->image }}&amp;height=360&amp;width=800">


<p><a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}">Download</a></p>

@stop