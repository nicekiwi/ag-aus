@extends('layouts.admin')

@section('content')

<h1>Maps</h1>

@if(Auth::check())
	<p><a href="/admin/maps/create">Sync with Amazon</a> <i class="fa fa-refresh"></i></p>
@endif

<!-- The fileinput-button span is used to style the file input field as button -->
<span class="btn btn-success fileinput-button">
    <i class="fa fa-plus"></i>
    <span>Upload maps...</span>
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="file" accept="application/bzip2, text/nav" multiple>
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


<ul class="nav nav-pills">
	<li class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/maps">All</a></li>
	@foreach($map_types as $type)
	<li class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/maps?type={{ $type->type }}">{{ $type->name }}</a></li>
	@endforeach
</ul>

@if(count($maps) > 0)
<table id="maps-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Filename</td>
			<td>Nav</td>
			<td>Size (MB)</td>
			<td>Added</td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->maptype->type }}</td>
			<td>
				<a href="/admin/maps/{{ $map->id }}/edit">{{ $map->name }} {{ $map->revision }}</a>
			</td>
			<td>{{ $map->filename }}</td>
			<td>
			@if($map->hasNav)
				<i style="color:green" class="fa fa-circle"></i>
			@endif
			</td>
			<td>{{ round(($map->filesize/1048576), 2) }}</td>
			<td>{{ $map->created_at->diffForHumans() }}</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@else
<p>No maps available.</p>
@endif

@if(count($map_files) > 0)
<table id="maps-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Type</td>
			<td>Name</td>
			<td>Size (MB)</td>
			<td>Added</td>
		</tr>
	</thead>
	<tbody>
		@foreach($map_files as $file)
		<tr>
			<td>{{ $file->filename }}</td>
			<td>{{ $file->filetype }}</td>
			<td>{{ round(($file->filesize/1048576), 2) }}</td>
			<td>{{ $file->created_at->diffForHumans() }}</td>
		</tr>
		@endforeach
	</tbody>
	
</table>
@endif

@stop

@section('footer')

<style type="text/css">
	
	.dataTables_length, .dataTables_info {
		display: none;
	}
	
	.dataTables_filter {
		float: left;
		text-align: left;
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