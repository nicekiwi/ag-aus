<h3>Servers</h3>
<ul id="master-server-list">
	@foreach($servers as $server)
	<li class="check-server-status" style="background-color: #{{ ($server->offline === 1 ? 'e24648' : '87ef2f') }}" data-id="server-{{ $server->id }}">
		{{ $server->vanilla_name }}<span class="players">{{ $server->players }}</span> / <span class="maxPlayers">{{ $server->maxPlayers }}</span>
	</li>
	@endforeach
</ul>