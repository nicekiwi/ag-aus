@extends('layouts.admin')

@section('content')

<h1>Edit Map: {{ $map->name }}</h1>

{{ Form::model($map, [ 'method' => 'PUT', 'route' => ['admin.maps.update', $map->id]]) }}

<fieldset>

<!-- Form Name -->
<legend>Change Map</legend>

<!-- Select Basic -->
<div class="form-group">
  {{ Form::label('type', 'Map Type', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::select('type', $map_types, ['class'=>'form-control']); }}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="revision">Revision</label>  
  <div class="col-md-4">
  <input id="revision" name="revision" type="text" placeholder="" class="form-control input-md" required="">
  <span class="help-block">RC1 or v3.2 for example.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="s3_path">Amazon S3 Path</label>  
  <div class="col-md-4">
  <input id="s3_path" name="s3_path" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="images">Images</label>
  <div class="col-md-4">
    <input id="images" name="images" class="input-file" type="file">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="video">Video</label>  
  <div class="col-md-4">
  <input id="video" name="video" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Only YouTube links are supported.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="more_info_url">More Info URL</label>  
  <div class="col-md-4">
  <input id="more_info_url" name="more_info_url" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Where users can get more info on the map.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="developer">Developer</label>  
  <div class="col-md-4">
  <input id="developer" name="developer" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Name/Call-sign of the map developer</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="developer_url">Developer URL</label>  
  <div class="col-md-4">
  <input id="developer_url" name="developer_url" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Link to the developers bio.</span>  
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="desc">Notes</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="desc" name="desc">Made with &lt;3 for the community.</textarea>
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
</form>

{{ Form::label('name', 'Map Name')}}
{{ Form::text('name') }}

{{ Form::label('revision', 'Map Revision')}}
{{ Form::text('revision') }}

{{ Form::label('more_info_url', 'More map info')}}
{{ Form::text('more_info_url') }}

{{ Form::label('s3_path', 'Path to Amazon S3 file')}}
{{ Form::text('s3_path', null, ['disabled' => true]) }}

{{ Form::label('image', 'Image of Map')}}
{{ Form::text('image') }}

{{ Form::label('video', 'Video Review or Demo of Map')}}
{{ Form::text('video') }}

{{ Form::label('developer', 'Map Developer')}}
{{ Form::text('developer') }}

{{ Form::label('developer_url', 'Map Developer URL')}}
{{ Form::text('developer_url') }}

{{ $errors->desc_md }}
{{ Form::label('desc_md', 'Map Notes')}}
{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}

{{ Form::submit() }}
    
{{ Form::close() }}

@stop

@section('footer')
<script type="text/javascript">
  var editor = new EpicEditor(opts).load();
</script>
@stop