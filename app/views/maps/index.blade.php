@extends('layouts.admin')

@section('content')

<h1>Maps <a class="btn btn-primary maps-upload-btn" href="/admin/maps/upload">Upload</a></h1>


<div role="tabpanel">

  <!-- Nav tabs -->
  <ul id="mapTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#maps" aria-controls="maps" role="tab" data-toggle="tab">Maps</a></li>
    <li role="presentation"><a href="#support-files" aria-controls="support-files" role="tab" data-toggle="tab">Support Files</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="maps">
    	
		@if(count($maps) > 0)
		<table id="maps-list" class="table table-striped maps-list" width="100%">
			<thead>
				<tr>
					<!-- <td>Type</td> -->
					<!-- <td>Name</td> -->
					<td>Status</td>
					<td>Name</td>
					<td><i class="fa fa-thumbs-up"></td>
					<td><i class="fa fa-thumbs-down"></td>
					<td><i class="fa fa-exclamation-triangle"></td>
					<td>Size</td>
					<td>Added</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				@foreach($maps as $map)
				<tr data-id="{{ $map->id }}" data-filename="{{ $map->filename }}" data-filetype="{{ $map->filetype }}">
					<td data-order="{{ (int)$map->remote }}">
						@if($map->remote)
							<button data-action="1" type="button" class="btn btn-success remote-map-action-btn">Online</button>
						@else
							<button data-action="0" type="button" class="btn btn-warning remote-map-action-btn">Offline</button>
						@endif

					</td>
					<!-- <td>{{ $map->mapType->type }}</td> -->
					<td><a href="/admin/maps/{{ $map->id }}/edit">{{ substr($map->filename, 0, -4) }}</a><br><small>{{$map->mapType->name}}</small></td>

					<td><span>{{ $map->feedback->sum('vote_up') }}</span></td>
					<td><span>{{ $map->feedback->sum('vote_down') }}</span></td>
					<td><span>{{ $map->feedback->sum('vote_broken') }}</span></td>

					</td>

					<td data-order="{{ (int)$map->filesize }}">
						{{ $map->filesizeHuman() }}
					</td>

					
					<td data-order="{{ $map->created_at->timestamp }}">{{ date('M jS, Y', $map->created_at->timestamp) }}<br><small> by {{ ucfirst($map->user->username) }}</small></td>
					
					<td>{{ Form::deleteMap('admin/maps/'. $map->id) }}</td>
				</tr>
				@endforeach
			</tbody>
			
		</table>
		@else
		<p>No maps available.</p>
		@endif

    </div>

    <div role="tabpanel" class="tab-pane" id="support-files">

		@if(count($map_files) > 0)

		<table id="maps-files-list" class="table table-striped table-bordered maps-list" width="100%">
			<thead>
				<tr>
					<td>Filename</td>
					<td>Size</td>
					<td>Added</td>
					<td>On Pantheon</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
				@foreach($map_files as $file)
				<tr data-id="{{ $file->id }}" data-filename="{{ $file->filename }}" data-filetype="{{ $file->filetype }}">
					<td>{{ $file->filename }}</td>

					<td data-order="{{ (int)$file->filesize }}">
						{{ $file->filesizeHuman() }}
					</td>

					
					<td>{{ $file->created_at->diffForHumans() }} by {{ $file->user->username }}</td>
					<td>
						@if($file->remote)
							<i style="color:green;" class="fa fa-check-circle"></i>
						@else
							<i style="color:red;" class="fa fa-circle"></i>
						@endif

					</td>
					<td class="actions">
						{{ Form::deleteMap('admin/maps/'. $file->id) }}

						<span data-action="0" class="btn btn-small btn-primary remote-map-action-btn">p+</span>
						<span data-action="1" class="btn btn-small btn-primary remote-map-action-btn">p-</span>

					</td>
				</tr>
				@endforeach
			</tbody>
			
		</table>
		@endif

    </div>
  </div>

</div>

@stop

@section('footer')

<style type="text/css">
	
	/*.dataTables_length, .dataTables_info {
		display: none;
	}
	
	.dataTables_filter {
		float: left;
		text-align: left;
	}*/

</style>



<!-- The container for the uploaded files -->
<!-- <table id="files" class="table table-striped table-bordered" width="100%">
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
</table> -->

<script type="text/javascript">

	function amazonUpload()
	{
		// Change this to the location of your server-side upload handler:
		var url = 'https://{{ $options->bucket }}.s3.amazonaws.com:443/';

		$('.map-upload-input').fileupload({
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
					$('<p/>').text(file.name).appendTo('.map-upload-results');
				});

				$('.map-syncing-info').show();

				$.get("/admin/maps/create", function() {
				  $('.map-syncing-info').hide();
				});
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('.map-progress .progress-bar').css('width',progress + '%').text( progress + '%');
			}
		}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
	}

	$(function () {
    'use strict';

    	var mapsTable = $('#maps-list').dataTable();
		var filesTable = $('#maps-files-list').dataTable();

	    //$('#mapTabs a[href="#maps"]').tab('show'); // Select tab by name
	    //$('#mapTabs a[href="#support-files"]').tab('show');
	    //
	    $('#maps-files-list tbody').on( 'click', 'button.btn-delete-confirm', function (e) {

	    	var el = $(this);
	    	var form = el.closest('form');

	    	el.find('i').addClass('fa-spin fa-cog').removeClass('fa-times');


	    	if(confirm('This action can not be undone, are you sure?'))
	    	{
			    $.post(form.prop('action'), {
		    		_method: 'DELETE',
		    		_token: form.find('input[name="_token"]').val()
		    	}, function()
		    	{
					el.closest('tr').fadeOut(800, function(){
						filesTable
					    	.fnDeleteRow(
					    		el.closest('tr'), null, true
					    	);
					});

					
		    	});

			}
			else
			{
				el.find('i').removeClass('fa-spin fa-cog').addClass('fa-times');
			}

	    	//alert(el.html);

	    	//el.preventDefault();

	    	// if(confirm('This action can not be undone, are you sure?'))
	    	// {
	    	// 	filesTable.rows( el.closest('tr').get(0) )
	    	// 		.remove()
	    	// 		.draw();
	    	// 	//console.log(el.closest('tr').remove());
	    	// }

		    
		});

    	$('.maps-list tbody').on('click', 'button.remote-map-action-btn', function(e){

    		var row = $(this).closest('tr');
    		var action = $(this).attr('data-action');

    		$( "td:nth-child(1)", row).html('<i class="fa fa-cog fa-spin"></i>');

			$.post( '/admin/maps/remote-action-ajax', {

				filename : row.attr('data-filename'),
				filetype : row.attr('data-filetype'),
				action : action

			}, function( data ) {
			  if(data === 1 || data === '1'){
					$( "td:nth-child(5)", row).html('<i style="color:green;" class="fa fa-check-circle"></i>');
				}
				else {
					$( "td:nth-child(5)", row).html('<i style="color:red;" class="fa fa-circle"></i>');
				}
			});

    	});

    	$('.maps-upload-btn').on('click', function(e) {

    		e.preventDefault();

    		var html = $('<div/>', {
    			"class":"map-upload-container"
    		}).append(

    			$('<div/>', { "class":"jumbotron fileinput-button" }).append(

	    			$('<i/>', {
	    				"class":"fa fa-plus"
	    			}),

	    			$('<span/>').html('Click or Drag \'n Drop files here..<br><small>Only .bz2 and .nav files are accepted. No max filesize.</small>'),

	    			$('<input/>', {
	    				"class":"map-upload-input",
	    				"type":"file",
	    				"name":"file",
	    				"accept":"application/x-bzip2, application/nav, text/nav, image/jpg, image/jpeg",
	    				"multiple":"multiple"
	    			})
	    		),

	    		$('<div/>', { "class":"progress progress-striped map-progress" }).append(
	    			$('<div/>', { "class":"progress-bar progress-bar-success" })
	    		),
	    		$('<div/>', {
	    			"class":"map-upload-results"
	    		}),
	    		$('<div/>', { "class":"map-syncing-info" }).append(

    				$('<i/>', { "class":"fa fa-refresh fa-spin" }),
    				$('<span/>').text('Syncing with Amazon.')

	    		).hide()
    		);

    		
    		

    		bootbox.dialog({
                title: "Upload Maps / Support Files",
                message: html,
                className: "map-upload-modal",
            });

            $('.map-upload-modal').on('shown.bs.modal', function (e) {
				amazonUpload();
			});

			$('.map-upload-modal').on('hide.bs.modal', function (e) {
				window.location.replace('/admin/maps');
			});
    	});

	});
		
	
</script>

@stop