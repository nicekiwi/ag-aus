<h3>{{ date('M') }} Donations</h3>
<div class="progress-percent">${{ $data->total_amount }} of $85 Donated</div>
<div class="progress progress-striped">
	<div class="progress-bar progress-bar-{{ $data->class }}" role="progressbar" aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->percentage }}%;">
		<span class="sr-only">{{ $data->percentage }}% Complete</span>
	</div>
</div>

<a href="/donate">
	<button type="button" class="btn btn-primary">Donate Now</button></a>