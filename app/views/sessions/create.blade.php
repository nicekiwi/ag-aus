@extends('layouts.master')

@section('content')

<h1>Login</h1>

{{ Form::open(array('route' => 'sessions.store','class'=>'form-horizontal')) }}
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