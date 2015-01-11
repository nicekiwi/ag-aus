@extends('layouts.admin')

@section('content')


<div role="tabpanel">

  <!-- Nav tabs -->
  <ul id="donateTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#quarter" aria-controls="quarter" role="tab" data-toggle="tab">Quarter</a></li>
    <li role="presentation"><a href="#players" aria-controls="players" role="tab" data-toggle="tab">Players</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="quarter">

    
        
    <div>

    <select class="form-control input-lg" style="float:left;width:80px">
    @foreach($yearList as $item)
        <option {{ ($item->year === $quarter->year ? 'selected' : '' ) }}>{{ $item->year }}</option>
    @endforeach
    </select>

    <select class="form-control input-lg" style="float:left;width:60px">
    @foreach($quarterList as $item)
        <option {{ ($item->quarter === $quarter->quarter ? 'selected' : '') }}>Q{{ $item->quarter }}</option>
    @endforeach
    </select>

    </div>

    <div>

    <p>Goal: ${{ $quarter->goal }}, Total: ${{ $quarter->total }}</p>

    <div class="progress progress{{ ($quarter->percentage >= 100) ?: '-striped active' }}">
      <div class="progress-bar progress-bar-{{ ($quarter->percentage >= 100) ? 'success' : 'info' }}"  role="progressbar" aria-valuenow="{{ $pquarter->percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($quarter->percentage >= 100) ? '100' : $quarter->percentage }}%">
        {{ $quarter->percentage }}%
      </div>
    </div>

    </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Amount</td>
                    <td>Email</td>
                    <td>CC Details</td>
                    <td>Date</td>
                </tr>
            </thead>

            <tbody>
                @foreach($quarter->donations as $donation)
                <tr>
                    <td>{{ $donation->amount }}</td>
                    <td>{{ $donation->email }}</td>
                    <td><img style="max-height: 16px;" src="/img/{{ strtolower($donation->card_type) }}.png"/> {{ $donation->card_last4 }} {{ $donation->card_month }}/{{ substr($donation->card_year, -2) }}</td>
                    <td>{{ $donation->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div role="tabpanel" class="tab-pane" id="players">

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
                    <td>{{ htmlspecialchars($player->steam_nickname) }}</td>
                    
                    @if($player->donation_expires->gte($today))
                        <td>{{ $player->donation_expires->diffForHumans() }}</td>
                    @else
                        <td class="expired">EXPIRED</td>
                    @endif
                    
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@stop

@section('footer')
    <script type="text/javascript">

    $(function () {
    'use strict';

        $('select').on('change', function()
        {
            var el = $(this);
            var year = el.find('option:selected').text();
            window.location.replace('/admin/donations/' + year);
        });

    });


    </script>
@stop