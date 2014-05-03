@extends('layouts.admin')

@section('content')

<h1>Upload Maps</h1>

<p>It the upload space below or drag 'n drop files to being the upload.</p>

<!-- The fileinput-button span is used to style the file input field as button -->
<span class="jumbotron fileinput-button">
    <i class="fa fa-plus"></i>
    <span>Upload maps...</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="file" accept="application/bzip2, application/nav, text/nav, image/jpg, image/jpeg" multiple>
</span>
<br>
<br>
<!-- The global progress bar -->
<div id="progress" class="progress">
    <div class="progress-bar progress-bar-success"></div>
</div>
<!-- The container for the uploaded files -->
<div id="files" class="files"></div>

<p>Only .bz2 and .nav files are accepted. No max filesize.</p>

<table id="maps-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Filename</td>
			<td>Size</td>
			<td>Added</td>
		</tr>
	</thead>
	<tbody>
		
		<tr>
			<td colspan="5">No Maps Uploaded.</td>
		</tr>

	</tbody>
	
</table>

@stop

@section('footer')

<style type="text/css">
	.fileinput-button {
	  position: relative;
	  overflow: hidden;
	}
	.fileinput-button input {
	  position: absolute;
	  top: 0;
	  right: 0;
	  margin: 0;
	  opacity: 0;
	  -ms-filter: 'alpha(opacity=0)';
	  font-size: 200px;
	  direction: ltr;
	  cursor: pointer;
	}

	/* Fixes for IE < 8 */
	@media screen\9 {
	  .fileinput-button input {
	    filter: alpha(opacity=0);
	    font-size: 100%;
	    height: 100%;
	  }
	}
</style>

<script type="text/javascript">

	$(function () {
		'use strict';
		// Change this to the location of your server-side upload handler:
		var url = 'https://{{ $options->bucket }}.s3.amazonaws.com:443/';

		$('#fileupload').fileupload({
			url: url,
			formData: {
		        'key': "{{ $options->key }}/${filename}",
		        'acl': "{{ $options->acl }}",
		        'AWSAccessKeyId': "{{ $options->accessKey }}",
		        'policy': "{{ $options->policy }}",
		        'signature': "{{ $options->signature }}"
		    },
			dataType: 'json',
			done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					$('<p/>').text(file.name).appendTo('#files');
				});
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progress .progress-bar').css('width',progress + '%');
			}
		}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});
	
	$('#maps-list').dataTable({
		"bPaginate": false,
		"sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
	});
</script>

@stop