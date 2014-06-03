@extends('layouts.admin')

@section('content')

<h1>Upload Maps</h1>

<p>It the upload space below or drag 'n drop files to being the upload.</p>

<!-- The fileinput-button span is used to style the file input field as button -->
<div class="jumbotron fileinput-button">
    <i class="fa fa-plus"></i>
    <span>Select or Drag 'n Drop files here..<br><small>Only .bz2 and .nav files are accepted. No max filesize.</small></span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="file" accept="application/bzip2, application/nav, text/nav, image/jpg, image/jpeg" multiple>
</div>
<!-- The global progress bar -->
<div id="progress" class="progress progress-striped">
    <div class="progress-bar progress-bar-success"></div>
</div>

<!-- The container for the uploaded files -->
<table id="files" class="table table-striped table-bordered" width="100%">
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

				console.log(data);

				$.each(data.files, function (index, file) {
					$('<p/>').text(file.name).appendTo('#files');
				});

				$.ajax({
				  type: "GET",
				  url: "/admin/maps/create"
				});
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progress .progress-bar').css('width',progress + '%').text( progress + '%');
			}
		}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});
	
	// $('#maps-list').dataTable({
	// 	"bPaginate": false,
	// 	"sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
	// });
</script>

@stop