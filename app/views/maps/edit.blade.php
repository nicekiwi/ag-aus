@extends('layouts.admin')

@section('content')

<h1>Edit Map: {{ $map->name }}</h1>

{{ Form::model($map, [ 'method' => 'PUT', 'route' => ['admin.maps.update', $map->id], 'class'=>'form-horizontal']) }}

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
  {{ Form::label('name', 'Name', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('name', null, ['class'=>'form-control input-md','required'=>'true'])}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('revision', 'Revision', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('revision', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">RC1 or v3.2 for example.</span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('s3_path', 'Amazon S3 Path', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('s3_path', null, ['disabled' => true,'class'=>'form-control input-md']) }}
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="images">Image</label>
  <div class="col-md-4">
  	{{ Form::text('images', null, ['class'=>'form-control input-md','required'=>'true']) }}
    <!-- The fileinput-button span is used to style the file input field as button -->
    <!-- <span class="btn btn-success fileinput-button">
        <i class="fa fa-plus"></i>
        <span>Upload images...</span> -->
        <!-- The file input field used as target for the file upload widget -->
        <!-- <input id="imageupload" type="file" name="file" accept="image/jpg, image/jpeg, image/png, image/gif" multiple> -->
    <!-- </span>
    <br>
    <br> -->
    <!-- The global progress bar -->
    <!-- <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div> -->
    <!-- <span class="help-block">Up to 5 images of the map. JPEG/PNG Only. Max 1MB.</span> -->
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('video', 'Video', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('video', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">Only YouTube links are supported.</span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('more_info_url', 'More Info URL', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('more_info_url', null, ['class'=>'form-control input-md','required'=>'true'])}}
    <span class="help-block">Where users can get more info on the map.</span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('developer', 'Developer', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer', null, ['class'=>'form-control input-md','required'=>'true'])}}
    <span class="help-block">Name / Alias of the map developer.</span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('developer_url', 'Developer URL', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer_url', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">Link to the developers bio.</span>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  {{ Form::label('notes', 'Notes', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">                     
    {{ Form::textarea('desc_md', null, ['class'=>'form-control','placeholder'=>'Made with &lt;3 for the community.']) }}
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

@section('footer')
<script type="text/javascript">

  // $(function () {
  //   'use strict';

  //   // try {
  //   //     var img = document.getElementById('myCanvas').toDataURL('image/jpeg', 0.9).split(',')[1];
  //   // } catch(e) {
  //   //     var img = document.getElementById('myCanvas').toDataURL().split(',')[1];
  //   // }

  //   function readImage(input) {
  //     if ( input.files && input.files[0] ) {
  //         var FR= new FileReader();
  //         FR.onload = function(e) {
  //              $('#img').attr( "src", e.target.result );
  //              $('#base').text( e.target.result );
  //         };       
  //         FR.readAsDataURL( input.files[0] );
  //     }
  //   }

  //   $('#imageupload').fileupload({
  //     url: 'https://api.imgur.com/3/image',
  //     headers: {
  //       Authorization: 'Client-ID a318c02ce0760fb'
  //     },
  //     dataType: 'base64',
  //     data: {
  //       image: 'file'
  //     },
  //     done: function (e, data) {
  //       $.each(data.result.files, function (index, file) {
  //         $('<p/>').text(file.name).appendTo('#files');
  //       });
  //     },
  //     progressall: function (e, data) {
  //       var progress = parseInt(data.loaded / data.total * 100, 10);
  //       $('#progress .progress-bar').css('width',progress + '%');
  //     }
  //   }).prop('disabled', !$.support.fileInput)
  //   .parent().addClass($.support.fileInput ? undefined : 'disabled');
  // });
</script>

@stop