<h3>Servers</h3>
<dl class="accordion" data-accordion>
	@foreach($servers as $server)
	<dd>
		<a style="background-color: #{{ ($server->offline === 1 ? 'e24648' : '87ef2f') }};padding:0.5rem;" data-id="server-{{ $server->id }}" href="#server-{{ $server->id }}">{{ $server->vanilla_name }} <span class="players">{{ $server->players }}</span> / <span class="maxPlayers">{{ $server->maxPlayers }}</span></a>
		<div id="server-{{ $server->id }}" class="content">
		<p>{{ $server->ip }}:{{ $server->port }}</p>
		</div>
	</dd>
	@endforeach
</dl>