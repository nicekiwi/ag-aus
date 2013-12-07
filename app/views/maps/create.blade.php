@extends('layouts.master')

@section('content')

<h1>Add a new Map</h1>

<?php $up_id = uniqid() ?>

{{ Form::model($post, [ 'method' => 'POST', 'route' => 'maps.store', 'files' => true, 'id' => 'map-upload-form', 'target' => 'result_frame' ]) }}

{{ Form::label('type', 'Map Type')}}
{{ Form::select('size', $map_modes); }}

{{ $errors->name }}
{{ Form::label('name', 'Map Name')}}
{{ Form::text('name') }}

{{ Form::label('revision', 'Map Revision')}}
{{ Form::text('revision') }}

{{ Form::label('more_info_url', 'More map info')}}
{{ Form::text('more_info_url') }}

{{ Form::label('image', 'Image of Map')}}
{{ Form::text('image') }}

{{ Form::label('developer', 'Map Developer')}}
{{ Form::text('developer') }}

{{ Form::label('developer_url', 'Map Developer URL')}}
{{ Form::text('developer_url') }}

{{ $errors->desc_md }}
{{ Form::label('desc_md', 'Map Notes')}}
{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

<!--APC hidden field--> 
    <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="{{ $up_id }}"/> 
<!----> 

{{ Form::file('map_file', ['id' => 'file']); }}

<!--Include the iframe--> 
    <br /> 
    <iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" > </iframe> 
    <br /> 
<!----> 

<div class="progress">
	<div class="bar"></div >
	<div class="percent">0%</div >
</div>

{{ Form::submit() }}
    
{{ Form::close() }}

@stop

@section('footer')

<style type="text/css">
	
/*iframe*/
#upload_frame {
	border:0px;
	height:40px;
	width:400px;
	/*display:none;*/
}

#progress_container {
	width: 300px; 
	height: 30px; 
	border: 1px solid #CCCCCC; 
	background-color:#EBEBEB;
	display: block; 
	margin:5px 0px -15px 0px;
}

#progress_bar {
	position: relative; 
	height: 30px; 
	background-color: #F3631C; 
	width: 0%; 
	z-index:10; 
}

#progress_completed {
	font-size:16px; 
	z-index:40; 
	line-height:30px; 
	padding-left:4px; 
	color:#FFFFFF;
}

</style>
<script type="text/javascript" src="/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/js/vendor/epiceditor.min.js"></script>
<script type="text/javascript">
	var opts = {
	  container: 'epiceditor',
	  textarea: 'desc_md_textarea',
	  clientSideStorage: false,
	  theme: {
	    base: 'http://ag-aus.dev/themes/base/epiceditor.css',
	    //preview: 'http://ag-aus.dev/themes/preview/preview-dark.css',
	    editor: 'http://ag-aus.dev/themes/editor/epic-dark.css'
	  },
	  button: {
	    preview: true,
	    fullscreen: false,
	    bar: "auto"
	  },
	  focusOnLoad: false,
	  autogrow: true
		};
var editor = new EpicEditor(opts).load();
	
$(document).ready(function() {
//show the progress bar only if a file field was clicked 
    var show_bar = 0; 
    $('input[type="file"]').click(function(){ 
        show_bar = 1; 
    }); 

//show iframe on form submit 
    $("#map-upload-form").submit(function(){ 
        if (show_bar === 1) {  
            $('#upload_frame').show(); 
            function set () { 
                $('#upload_frame').attr('src','/maps/upload-progress?up_id={{ $up_id}}'); 
            } 
            setTimeout(set); 
        } 
    }); 

    //$('#upload_frame').attr('src','/maps/upload-progress?up_id={{ $up_id}}'); 
// 

}); 
</script>


@stop