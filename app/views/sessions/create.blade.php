@extends('layouts.master')

@section('content')

<h1>Login</h1>

{{ Form::open(array('route' => 'sessions.store')) }}
{{ Form::label('username', 'Email:') }}
{{ Form::text('username') }}
{{ Form::label('password', 'Password:') }}
{{ Form::password('password') }}
{{ Form::submit() }}
{{ Form::close() }}

@stop