@extends('layouts.admin')

@section('content')

<h1>Maps <a class="btn btn-primary" href="/admin/maps/upload">Upload</a></h1>

<ul class="map-filter">
	
	<li class="{{ (!Input::has('type') ? 'active' : '') }}"><a href="/admin/maps">All Maps</a></li>
	@foreach($map_types as $type)
	@if($type->maps->count() > 0)
	<li class="{{ (Input::get('type') == $type->type ? 'active' : '') }}"><a href="/admin/maps?type={{ $type->type }}">{{ $type->name }} ({{ $type->maps->count() }})</a></li>
	@endif
	@endforeach
	
</ul>

@if(count($maps) > 0)
<table id="maps-list" class="table table-striped table-bordered" width="100%">
	<thead>
		<tr>
			<td>Type</td>
			<!-- <td>Name</td> -->
			<td>Filename</td>
			<td>Size</td>
			<td>Added</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($maps as $map)
		<tr>
			<td>{{ $map->mapType->type }}</td>
			<!-- <td>
				<a href="/admin/maps/{{ $map->id }}/edit">{{ $map->name }} - {{ $map->revision }}</a> 
			</td>-->
			<td>
				{{ $map->filename }}
				@if($map->mapFiles->count() > 0)
				@foreach($map->mapFiles as $file)
				<span class="label label-primary" style="text-transform:uppercase;">{{ $file->filetype }}</span>
				@endforeach
				@endif
			</td>
			@if ($map->filesize >= 1048576)
	            <td>{{ number_format($map->filesize / 1048576, 2) . ' MB' }}</td>
	        @elseif ($map->filesize >= 1024)
	            <td>{{ number_format($map->filesize / 1024, 2) . ' KB' }}</td>
	        @endif
			<td>{{ $map->created_at->diffForHumans() }} by {{ $map->created_by->username }}</td>
			<td>Delete Btn</td>
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
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($map_files as $file)
		<tr>
			<td>{{ $file->filename }}</td>
			<td>{{ $file->filetype }}</td>
			<td>{{ round(($file->filesize/1048576), 2) }}</td>
			<td>{{ $file->created_at->diffForHumans() }}</td>
			<td>delete</td>
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
	
	// $('#maps-list').dataTable({
	// 	"bPaginate": false,
	// 	"aoColumns": [
	// 		null,
	// 		null,
	// 		{ "sType": "numeric" },
	// 		null,
	// 		null,

	// 	],

	// 	"sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
	// });
</script>

@stop