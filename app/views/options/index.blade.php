@extends('layouts.admin')

@section('content')

<h1>Options</h1>

{{ Form::model($options, [ 'method' => 'PUT', 'route' => ['admin.options.update', $options->id], 'class'=>'form-horizontal']) }}

<fieldset>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('donation_quarter_goal', 'Donation Quarter Goal', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('donation_quarter_goal', null, ['class'=>'form-control input-md']) }}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('donation_monthly_cost', 'Donation Monthly Cost', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('donation_monthly_cost', null, ['class'=>'form-control input-md']) }}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('donation_maximum_amount', 'Donation Maximum Amount', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('donation_maximum_amount', null, ['class'=>'form-control input-md']) }}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('donation_admin_email1', 'Donation Admin Email', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('donation_admin_email1', null, ['class'=>'form-control input-md']) }}
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-8">
    <button id="submit" name="submit" class="btn btn-success">Submit Changes</button>
    <button id="cancel" name="cancel" class="btn btn-danger">Cancel</button>
  </div>
</div>

</fieldset>
    
{{ Form::close() }}

@stop