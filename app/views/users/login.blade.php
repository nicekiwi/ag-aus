@extends('layouts.master')

@section('content')

<h1>Login</h1>
<form class="form-horizontal" method="POST" action="{{{ Confide::checkAction('UserController@do_login') ?: URL::to('/user/login') }}}" accept-charset="UTF-8">

<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('email', 'Email Address', ['class'=>'col-md-4 control-label']) }}
  <div class="col-md-4">
  	{{ Form::text('email', null, ['class'=>'form-control input-md','required'=>'']) }}
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  {{ Form::label('password', 'Password', ['class'=>'col-md-4 control-label']) }}
  <div class="col-md-4">
    {{ Form::password('password', ['class'=>'form-control input-md','required'=>'']) }}
    <span class="help"><small><a href="{{{ (Confide::checkAction('UserController@forgot_password')) ?: 'forgot' }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a></small></span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-success">Login</button>
  </div>
</div>

</fieldset>
{{ Form::close() }}
@stop