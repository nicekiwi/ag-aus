@extends('layouts.admin')

@section('content')


    <h1>Donations <small>{{ $quarter->title }}</small></h1>

    <p>Quarter Goal: ${{ $quarter->goal_amount }}, Donated so far: ${{ $quarter->total_amount }}</p>

    <div class="progress progress{{ ($quarter->goal_percentage >= 100) ?: '-striped active' }}">
      <div class="progress-bar progress-bar-{{ ($quarter->goal_percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $pquarter->goal_percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($quarter->goal_percentage >= 100) ? '100' : $quarter->goal_percentage }}%">
        {{ $quarter->goal_percentage }}%
      </div>
    </div>

    <div class="col-sm-12">
        
        @foreach($donations as $donation)
        <div class="col-md-3"><img src="/images/avatar/{{ urlencode($donation->donator->steam_image) }}"> {{ $donation->player->steam_nickname }}</div>
        @endforeach

    </div>

@stop

@section('footer')

@stop