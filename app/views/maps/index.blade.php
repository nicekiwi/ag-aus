@extends('layouts.admin')

@section('content')

    <h1>Maps <a class="btn btn-primary maps-upload-btn" href="/admin/maps/upload">Upload</a></h1>


    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul id="mapTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#maps" aria-controls="maps" role="tab" data-toggle="tab">Maps</a>
            </li>
            <li role="presentation"><a href="#support-files" aria-controls="support-files" role="tab" data-toggle="tab">Support
                    Files</a></li>
            <li role="presentation"><a href="#broken-reports" aria-controls="broken-reports" role="tab"
                                       data-toggle="tab">Broken Reports</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="maps">

                @if(count($maps) > 0)
                    <table id="maps-list" class="table table-striped maps-list" width="100%">
                        <thead>
                        <tr>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Size</td>

                            <td>Rating</td>
                            <td><i class="fa fa-exclamation-triangle fa-lg"></i></td>
                            <td><i class="fa fa-steam fa-lg"></i></td>
                            <td><i class="fa fa-globe fa-lg"></i></td>

                            <td>Added</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($maps as $map)
                            <tr data-id="{{ $map->id }}" data-filename="{{ $map->filename }}"
                                data-filetype="{{ $map->filetype }}">

                                {{-- Thumbnail --}}
                                <td data-order="{{ ($map->images !== '') ? 1 : 0 }}">
                                    <img style="max-height:40px;"
                                         src="/images/mapthumbnail/{{ $map->mapThumbnail() }}"/>
                                </td>

                                {{-- Name / Type --}}
                                <td>
                                    <a class="map-edit-btn" href="/admin/maps/{{ $map->id }}/edit">
                                        {{ substr($map->filename, 0, -4) }}
                                    </a><br>
                                    <small>{{$map->mapType->name}}</small>
                                </td>

                                {{-- Filesize --}}
                                <td data-order="{{ (int)$map->filesize }}">
                                    {{ $map->filesizeHuman() }}
                                </td>

                                {{-- Score --}}
                                <td><span>{{ $map->feedbackScore() }}</span></td>

                                {{-- Broken Reports --}}
                                <td><span>{{ $map->feedback->sum('vote_broken') }}</span></td>

                                {{-- On Remote Server --}}
                                <td data-order="{{ (int)$map->remote }}">
                                    @if($map->remote === 1)
                                        <button data-action="remove-remote" type="button" class="access-action-btn"><i
                                                    class="fa fa-circle"></i></button>
                                    @else
                                        <button data-action="add-remote" type="button" class="access-action-btn"><i
                                                    class="fa fa-circle-o"></i></button>
                                    @endif
                                </td>

                                {{-- On Public Website --}}
                                <td data-order="{{ (int)$map->website }}">
                                    @if($map->website === 1)
                                        <button data-action="remove-website" type="button" class="access-action-btn"><i
                                                    class="fa fa-circle"></i></button>
                                    @else
                                        <button data-action="add-website" type="button" class="access-action-btn"><i
                                                    class="fa fa-circle-o"></i></button>
                                    @endif
                                </td>

                                {{-- Date Added / By Whomb--}}
                                <td data-order="{{ $map->created_at->timestamp }}">
                                    {{ date('M jS, Y', $map->created_at->timestamp) }}
                                    <br><small> by {{ ucfirst($map->user->username) }}</small>
                                </td>

                                {{-- Delete Action --}}
                                <td>
                                    {{ Form::deleteMap('admin/maps/'. $map->id) }}
                                </td>
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
                            <tr data-id="{{ $file->id }}" data-filename="{{ $file->filename }}"
                                data-filetype="{{ $file->filetype }}">
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

                                    <span data-action="0"
                                          class="btn btn-small btn-primary remote-map-action-btn">p+</span>
                                    <span data-action="1"
                                          class="btn btn-small btn-primary remote-map-action-btn">p-</span>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                @endif

            </div>
        </div>

    </div>

    @include('maps/partials/_upload-form')
    @include('maps/partials/_edit-form')

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

        function amazonUpload() {
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

                    $.get("/admin/maps/create", function () {
                        $('.map-syncing-info').hide();
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.map-progress .progress-bar').css('width', progress + '%').text(progress + '%');
                }
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        }

        $(function () {
            'use strict';


            var mapsTable = $('#maps-list');
            mapsTable.dataTable();

            var filesTable = $('#maps-files-list');
            filesTable.dataTable();

            //$('#mapTabs a[href="#maps"]').tab('show'); // Select tab by name
            //$('#mapTabs a[href="#support-files"]').tab('show');
            //
            mapsTable.find('tbody').on('click', 'button.btn-delete-confirm', function (e) {

                var el = $(this);
                var form = el.closest('form');

                el.find('i').addClass('fa-spin fa-cog').removeClass('fa-times');


                if (confirm('This action can not be undone, are you sure?')) {
                    $.post(form.prop('action'), {
                        _method: 'DELETE',
                        _token: form.find('input[name="_token"]').val()
                    }, function () {
                        el.closest('tr').fadeOut(800, function () {
                            filesTable
                                    .fnDeleteRow(
                                    el.closest('tr'), null, true
                            );
                        });


                    });

                }
                else {
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

            mapsTable.find('tbody').on('click', 'button.access-action-btn', function (e) {

                var responseAction = function(data,btn)
                {
                    if (data === 1 || data === '1') {
                        btn.html('<i class="fa fa-circle"></i>');
                    }
                    else {
                        btn.html('<i class="fa fa-circle-o"></i>');
                    }
                };

                var btn = $(this);
                var row = btn.closest('tr');
                var action = btn.attr('data-action');
                var url = '/admin/maps/website-action-ajax';

                btn.html('<i class="fa fa-cog fa-spin"></i>');

                if (/remote/i.test(action)){
                    url = '/admin/maps/remote-action-ajax';
                }

                $.post(url, {

                    filename: row.attr('data-filename'),
                    filetype: row.attr('data-filetype'),
                    action: action

                }, function (data) {
                    responseAction(data,btn);
                });

            });

            mapsTable.find('tbody').on('click', '.map-edit-btn', function (e) {

                e.preventDefault();

                var mapEditModal = $('#map-edit-modal');
                var mapEditUrl = $(this).prop('href');

                mapEditModal.on('change', '.imgur-upload', function () {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var data = e.target.result.substr(e.target.result.indexOf(",") + 1, e.target.result.length);
                        //$(".image-preview").prop("src", '/images/mapthumbnail/' + e.target.result);
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
                            success: function (response) {
                                $("#images").attr("value", response.data.link);
                                $('.btn-file > i').addClass('fa-plus').removeClass('fa-spinner fa-spin');
                                $(".image-preview").prop("src", '/images/mapthumbnail/' + response.data.link);
                            }, error: function () {
                                alert("Error while uploading...");
                            }
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                });

                $.get(mapEditUrl, function (data) {
                    mapEditModal.find('.modal-body').html(data);
                    mapEditModal.modal('show');

                    var editForm = mapEditModal.find('form');

                    editForm.on('submit', function (e) {
                        e.preventDefault();

                        $.post(editForm.prop('action'), editForm.serialize(), function (response) {
                            mapEditModal.find('.modal-body').html(response);
                        });
                    });
                });

            });

            $('.maps-upload-btn').on('click', function (e) {

                e.preventDefault();

                var mapUploadModal = $('#map-upload-modal');

                mapUploadModal.modal('show');

                mapUploadModal.on('shown.bs.modal', function (e) {
                    amazonUpload();
                });

                mapUploadModal.on('hide.bs.modal', function (e) {
                    window.location.replace('/admin/maps');
                });
            });

        });


    </script>

@stop