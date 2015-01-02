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
    {{ Form::select('map_type_id', $map_types, null, ['class'=>'form-control']) }}
  </div>
</div>

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('name', 'Name', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('name', null, ['class'=>'form-control input-md','required'=>'true'])}}
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('revision', 'Revision', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('revision', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">RC1 or v3.2 for example.</span>
  </div>
</div> -->

<!-- Text input-->
<div class="form-group">
  {{ Form::label('filename', 'Filename', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('filename', null, ['disabled' => true,'class'=>'form-control input-md']) }}
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="images">Image</label>
  <div class="col-md-4">
  	<div class="input-group">
    {{ Form::text('images', null, ['class'=>'form-control input-md','required'=>'true', 'id'=>'images']) }}
    <span class="input-group-btn">
    <span class="btn btn-primary btn-file">
        <i class="fa fa-plus"></i><input id="imageupload" type="file" name="file" accept="image/jpg, image/jpeg, image/png, image/gif">
    </span>
      
    </span>
  </div><!-- /input-group -->
  </div>
</div>

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('video', 'Video', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('video', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">Only YouTube links are supported.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('more_info_url', 'More Info URL', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('more_info_url', null, ['class'=>'form-control input-md','required'=>'true'])}}
    <span class="help-block">Where users can get more info on the map.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('developer', 'Developer', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer', null, ['class'=>'form-control input-md','required'=>'true'])}}
    <span class="help-block">Name / Alias of the map developer.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('developer_url', 'Developer URL', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer_url', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">Link to the developers bio.</span>
  </div>
</div> -->

<!-- Textarea -->
<!-- <div class="form-group">
  {{ Form::label('notes', 'Notes', ['class'=>'col-md-4 control-label'])}}
  <div class="col-md-4">                     
    {{ Form::textarea('desc_md', null, ['class'=>'form-control','placeholder'=>'Made with &lt;3 for the community.']) }}
  </div>
</div> -->

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

  $(function () {
    'use strict';

    $("#imageupload").change(function() {
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result.substr(e.target.result.indexOf(",") + 1, e.target.result.length);
        //$("#image_preview").attr("src", e.target.result);
        $('.btn-file > i').removeClass('fa-plus').addClass('fa-cog fa-spin');
        $.ajax({
            url: 'https://api.imgur.com/3/image',
            headers: {
                'Authorization': 'Client-ID a318c02ce0760fb'
            },
            type: 'POST',
            data: {
                'image': data,
                'type': 'base64'
            },
            success: function(response) {
                $("#images").attr("value", response.data.link);
                $('.btn-file > i').addClass('fa-plus').removeClass('fa-spinner fa-spin');
            }, error: function() {
                alert("Error while uploading...");
            }
        });
      };
      reader.readAsDataURL(this.files[0]);
    });

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

    // $('#imageupload').fileupload({
    //   url: 'https://api.imgur.com/3/image',
    //   headers: {
    //     Authorization: 'Client-ID a318c02ce0760fb'
    //   },
    //   dataType: 'json',
    //   data: {
    //     image: $('#imageupload').val()
    //   },
    //   done: function (e, data) {
    //     $.each(data.result.files, function (index, file) {
    //       $('<p/>').text(file.name).appendTo('#files');
    //     });
    //   },
    //   progressall: function (e, data) {
    //     var progress = parseInt(data.loaded / data.total * 100, 10);
    //     $('#progress .progress-bar').css('width',progress + '%');
    //   }
    // }).prop('disabled', !$.support.fileInput)
    // .parent().addClass($.support.fileInput ? undefined : 'disabled');
  });
</script>

@stop