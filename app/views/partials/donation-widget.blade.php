<h3>{{ date('M') }} Donations</h3>
<p>${{ $data->total_amount }} of $85 Donated</p>

<div class="radius progress success small-12">
  <span class="meter" style="width: {{ $data->percentage }}%"></span>
</div>

<a href="/donations">
	<button type="button" class="btn btn-primary">Donate Now</button></a>