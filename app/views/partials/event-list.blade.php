<h3>Events</h3>
<ul>
@if(count($events) > 0)
	@foreach($events as $event)
		<li>
			<img src="/img/icons/games/{{ $event->event_game }}.png">
			<a href="/news/{{ $event->slug }}"><strong>{{ $event->title }}</strong></a><br>
			<small>{{ date('nS M, g:ha TO', $event->event_datetime) }}</small>
		</li>
	@endforeach
@else
	No Events Coming up.
@endif
</ul>