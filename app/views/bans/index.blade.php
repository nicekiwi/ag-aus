@extends('layouts.admin')

@section('content')

    <h1>Banned Users</h1>

    <table class="table">
    	<thead>
    		<tr>
    			<td></td>
    			<td>Name</td>
    			<td></td>
    			<td></td>
    		</tr>
    	</thead>
	    <tbody>
	    	<tr>
	        @foreach($bans as $ban)
	            <td><img src="{{ $ban->player->steam_image }}" /></td>
	            <td><a href="http://steamcommunity.com/profiles/{{ $ban->player->steam_64id }}" target="_blank">{{ $ban->player->steam_nickname }}<br><small>{{ $steam_id }}</small></a></td>
	            <td>{{ $ban->banned_for }}</td>
	        @endforeach
	    	</tr>
	    </tbody>
    </table>

@stop