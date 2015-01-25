{{ Form::model($map, [ 'method' => 'PUT', 'route' => ['admin.maps.update', $map->id]]) }}

<!-- Select Basic -->
<div class="form-group">
  {{ Form::label('type', 'Map Type', ['class'=>'control-label'])}}
  {{--<div class="col-md-4">--}}
    {{ Form::select('map_type_id', $map_types, null, ['class'=>'form-control']) }}
  {{--</div>--}}
</div>

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('name', 'Name', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('name', null, ['class'=>'form-control input-md','required'=>'true'])}}
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('revision', 'Revision', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('revision', null, ['class'=>'form-control input-md'])}}
    <span class="help-block">RC1 or v3.2 for example.</span>
  </div>
</div> -->

<!-- Text input-->
<div class="form-group">
  {{ Form::label('filename', 'Filename', ['class'=>'control-label'])}}
  {{--<div class="col-md-4">--}}
    {{ Form::text('filename', null, ['disabled' => true,'class'=>'form-control']) }}
  {{--</div>--}}
</div>

<!-- Text input-->
<div class="form-group">
  {{ Form::label('image-preview', 'Image Preview')}}
  <div class="">
    <img class="image-preview" name="image-preview" src="/images/mapthumbnail/{{ ($map->images ? $map->images : urlencode('/img/no-thumb.png')) }}" />
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="control-label" for="images">Image</label>
  {{--<div class="col-md-4">--}}
  	<div class="input-group">
    {{ Form::text('images', null, ['class'=>'form-control', 'id'=>'images']) }}
    <span class="input-group-btn">
    <span class="btn btn-primary btn-file">
        <i class="fa fa-plus"></i><input class="imgur-upload" type="file" name="file" accept="image/jpg, image/jpeg, image/png, image/gif">
    </span>
      
    </span>
  </div><!-- /input-group -->
  {{--</div>--}}
</div>

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('video', 'Video', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('video', null, ['class'=>'form-control'])}}
    <span class="help-block">Only YouTube links are supported.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('more_info_url', 'More Info URL', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('more_info_url', null, ['class'=>'form-control','required'=>'true'])}}
    <span class="help-block">Where users can get more info on the map.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('developer', 'Developer', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer', null, ['class'=>'form-control','required'=>'true'])}}
    <span class="help-block">Name / Alias of the map developer.</span>
  </div>
</div> -->

<!-- Text input-->
<!-- <div class="form-group">
  {{ Form::label('developer_url', 'Developer URL', ['class'=>'control-label'])}}
  <div class="col-md-4">
    {{ Form::text('developer_url', null, ['class'=>'form-control'])}}
    <span class="help-block">Link to the developers bio.</span>
  </div>
</div> -->

<!-- Textarea -->
<!-- <div class="form-group">
  {{ Form::label('notes', 'Notes', ['class'=>'control-label'])}}
  <div class="col-md-4">                     
    {{ Form::textarea('desc_md', null, ['class'=>'form-control','placeholder'=>'Made with &lt;3 for the community.']) }}
  </div>
</div> -->

<!-- Button (Double) -->
<div class="form-group">
  <label class="control-label" for="submit"></label>
  {{--<div class="col-md-8">--}}

    <button id="cancel" name="cancel" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
    <button id="submit" style="float: right;" name="submit" class="btn btn-success">Update</button>
  {{--</div>--}}
</div>
    
{{ Form::close() }}