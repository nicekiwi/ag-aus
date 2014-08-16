@extends('layouts.admin')

@section('content')

<h1>New Map List</h1>

<p>Drag and drop the maps from the right to the list on the left, Add desired options and save.</p>

<div class="col-md-8">

	<form id="map-config-form" class="form-horizontal">
		<fieldset>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-2 control-label" for="map_config_name">Name</label>  
			  <div class="col-md-4">
			  <input id="map_config_name" name="map_config_name" type="text" placeholder="" class="form-control input-md" required="">
			    
			  </div>
			</div>

			<!-- Button -->
			<div class="form-group">
				<div class="map-config-list-header col-md-offset-2 col-md-10"><span>Name:</span><span>Admin Menu</span><span>Chooser</span><span>Nominate</span></div>
				<ul class="map-config-list col-md-offset-2 col-md-10">
		
				</ul>
			</div>

			<!-- Button -->
			<div class="form-group">
			  <label class="col-md-2 control-label" for="save_config"></label>
			  <div class="col-md-10">
			    <button id="save_config" name="save_config" class="btn btn-warning">Save</button>
			  </div>
			</div>

		</fieldset>
	</form>
</div>
	
<div class="col-md-4">
	<input type="search" class="search form-control" placeholder="Filter Maps" id="s">
	<ul class="available-maps-list">
		@foreach($maps as $map)
		<li data-id="{{ $map->id }}"><span class="name">{{ substr($map->filename, 0, -8) }}</span></li>
		@endforeach
	</ul>
</div>

@stop

@section('footer')


<script type="text/javascript">
	
	var group = $("ul.map-config-list").sortable({
	  group: 'map-config',
	  delay: 500,
	  onDrop: function (item, container, _super) {
	    //var data = group.sortable("serialize").get();

	    //var jsonString = JSON.stringify(data, null, ' ');

	    //$('#serialize_output2').text(jsonString);
	    var item = $(item);
	   	
	   	if(!item.hasClass('addedx')){
	   		item.append('<input type="checkbox" checked><input name="chooser" type="checkbox" checked><input type="checkbox" checked><i class="fa fa-times-circle-o"></i>');
	    	item.addClass('addedx');
	   	}

	   	item.attr('style','');
	    

	   	_super(item, container);
	  }
	});

	$("ul.available-maps-list").sortable({
	  group: 'map-config',
	  drop: false
	});

	$("#s").on("keyup click input", function () {
		if (this.value.length > 0) {
		  $("ul.available-maps-list li").show().filter(function () {
		    return $(this).find('.name').text().toLowerCase().indexOf($("#s").val().toLowerCase()) == -1;
		  }).hide();
		}
		else {
		  $("ul.available-maps-list li").show();
		}
	});

</script>


@stop