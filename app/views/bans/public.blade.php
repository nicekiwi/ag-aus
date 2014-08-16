@extends('layouts.master')

@section('content')

    <h1>Wall of Shame <small>Banned Users</small></h1>

    <p>If you have ben banned and would like to protest, feel free to msg one of our Mods or Admins on the Steam group.</p>

    <table class="table">
    	<thead>
    		<tr>
    			<td></td>
    			<td>Name</td>
    			<td>Banned for</td>
    			<td>By</td>
    		</tr>
    	</thead>
	    <tbody>
	    	<tr>
	        @foreach($bans as $ban)
	            <td><img src="/images/avatar/{{ $ban->player->steam_image }}" /></td>
	            <td><a href="http://steamcommunity.com/profiles/{{ $ban->player->steam_64id }}" target="_blank">{{ $ban->player->steam_nickname }}<br><small>{{ $ban->player->steam_id }}</small></a></td>
	            <td>{{ $ban->banned_for }}</td>
	            <td><img src="/images/avatar/{{ $ban->bannedBy->steam_image }}" /> {{ $ban->bannedBy->steam_nickname }}</td>
	        @endforeach
	    	</tr>
	    </tbody>
    </table>

@stop