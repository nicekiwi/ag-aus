@extends('layouts.admin')

@section('content')

<ol class="breadcrumb">
  <li><a href="/admin">Admin</a></li>
  <li><a href="/admin/users">Users</a></li>
  <li class="active">Add User</li>
</ol>

<h2>Create User</h2>

<form method="POST" class="form-horizontal" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

    <fieldset>

		<!-- Text input-->
		<div class="form-group">
    		{{ Form::label('role_id', 'Role', ['class'=>'col-md-4 control-label']) }}
    		<div class="col-md-4">
				{{ Form::select('role_id', $roles, null, ['class'=>'form-control input-md','required'=>'']) }}
		  	</div>
		</div>

        <!-- Text input-->
		<div class="form-group">
		  {{ Form::label('username', 'Username', ['class'=>'col-md-4 control-label']) }}
		  <div class="col-md-4">
		  	{{ Form::text('username', null, ['class'=>'form-control input-md','required'=>'']) }}
		  </div>
		</div>

        <!-- Text input-->
		<div class="form-group">
		  {{ Form::label('email', 'Email Address', ['class'=>'col-md-4 control-label']) }}
		  <div class="col-md-4">
		  	{{ Form::text('email', null, ['class'=>'form-control input-md','required'=>'']) }}
		  	<!-- <span class="label label-info"><small>Confirmation Required</small></span> -->
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  {{ Form::label('password', 'Password', ['class'=>'col-md-4 control-label']) }}
		  <div class="col-md-4">
		  	{{ Form::password('password', ['class'=>'form-control input-md','required'=>'']) }}
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  {{ Form::label('password_confirmation', 'Password Confirmation', ['class'=>'col-md-4 control-label']) }}
		  <div class="col-md-4">
		  	{{ Form::password('password_confirmation', ['class'=>'form-control input-md','required'=>'']) }}
		  </div>
		</div>

        <div class="form-actions form-group">
        	<div class="col-md-offset-4 col-sm-8">
          		<button type="submit" class="btn btn-primary input-md">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
          	</div>
        </div>

    </fieldset>
</form>

@stop
