@if(Session::get('error_message'))
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	@if ( is_array(Session::get('error_message')) )
		{{ head(Session::get('error_message')) }}
	@else
		{{ Session::get('error_message') }}
	@endif
</div>
@endif

@if(Session::get('warning_message'))
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {{ Session::get('warning_message') }}
</div>
@endif

@if(Session::get('info_message'))
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {{ Session::get('info_message') }}
</div>
@endif

@if(Session::get('success_message'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {{ Session::get('success_message') }}
</div>
@endif