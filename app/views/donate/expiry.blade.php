@extends('layouts.admin')

@section('content')

        <!-- <div class="col-md-3"><img src="/images/avatar/{{ urlencode($donation->donator->steam_image) }}"> {{ $donation->player->steam_nickname }}</div> -->

        <table class="table table-hover">
            <thead>
                <tr>
                    <td>steamID</td>
                    <td>Nickname</td>
                    <td>Expires</td>
                </tr>
            </thead>

            <tbody>
                @foreach($players as $player)
                <tr>
                    <td>{{ $player->steam_id }}</td>
                    <td>{{ $player->steam_nickname }}</td>
                    
                    @if($player->donation_expires->gte($today))
                        <td>{{ $player->donation_expires->diffForHumans() }}</td>
                    @else
                        <td class="expired">EXPIRED</td>
                    @endif
                    
                </tr>
                @endforeach
            </tbody>
        </table>

@stop