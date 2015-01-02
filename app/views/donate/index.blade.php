@extends('layouts.admin')

@section('content')


    

    @foreach($quarters as $quarter)
        
    <h1>{{ $quarter->year }},  Q{{ $quarter->quarter }}</h1>

    <p>Goal: ${{ $quarter->goal }}, Total: ${{ $quarter->total }}</p>

    <div class="progress progress{{ ($quarter->percentage >= 100) ?: '-striped active' }}">
      <div class="progress-bar progress-bar-{{ ($quarter->percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $pquarter->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($quarter->percentage >= 100) ? '100' : $quarter->percentage }}%">
        {{ $quarter->percentage }}%
      </div>
    </div>

    <div class="col-sm-12">

   
        
        
        <!-- <div class="col-md-3"><img src="/images/avatar/{{ urlencode($donation->donator->steam_image) }}"> {{ $donation->player->steam_nickname }}</div> -->

        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Amount</td>
                    <td>Email</td>
                    <td>Date</td>
                </tr>
            </thead>

            <tbody>
                @foreach($quarter->donations as $donation)
                <tr>
                    <td>{{ $donation->amount }}</td>
                    <td>{{ $donation->email }}</td>
                    <td>{{ $donation->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        

    </div>

    @endforeach

@stop