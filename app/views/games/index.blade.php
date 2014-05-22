@extends('layouts.admin')

@section('content')

<h1>Maps <a class="btn btn-primary" href="/admin/games/create">Add Game</a></h1>

<ul>
@if(count($games) > 0)
	@foreach($games as $game)
	
	@endforeach
@endif
<li>Add Game</li>
</ul>

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