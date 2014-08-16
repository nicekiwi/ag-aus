@extends('layouts.master')

@section('content')

<h1>Maps</h1>

<ul style="list-style:none;">
@if(count($maps) > 0)
@foreach($maps as $map)
	<li class="col-sm-4">
		<img style="width:100%;max-height:189px;" src="/img/mapthumbs/{{ substr($map->filename,0,-8) }}.jpg" />
		<h4>{{ $map->name }} <small>{{ $map->revision }}</small></h4>
		<!-- <td><a href="/maps/{{ $map->slug }}">{{ $map->name }} {{ $map->revision }}</a></td> -->
		<td>
			{{ $map->filename }}
			@if($map->mapFiles->count() > 0)
			@foreach($map->mapFiles as $file)
			<span class="label label-primary" style="text-transform:uppercase;">{{ $file->filetype }}</span>
			@endforeach
			@endif
		</td>

		<!-- <td><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i></td> -->

		@if ($map->filesize >= 1048576)
	        <td>{{ number_format($map->filesize / 1048576, 2) . ' MB' }}</td>
	    @elseif ($map->filesize >= 1024)
	        <td>{{ number_format($map->filesize / 1024, 2) . ' KB' }}</td>
	    @endif
		
		<!-- <td>{{ $map->created_at->diffForHumans() }}</td> -->
		<td><a target="_blank" href="https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/{{ $map->s3_path }}"><i class="fa fa-cloud-download fa-lg"></i> Download</a></td>
	</li>
@endforeach
@else
	<li>No maps found.</li>
@endif
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
	
	// $('#maps-list').dataTable({
	// 	'bPaginate': false
	// });
</script>

@stop