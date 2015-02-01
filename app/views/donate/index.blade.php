@extends('layouts.admin')

@section('content')

    <h1>Donations</h1>
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul id="donateTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#donations" aria-controls="donations" role="tab"
                                                      data-toggle="tab">Donations</a></li>
            <li role="presentation"><a href="#quarters" aria-controls="quarters" role="tab"
                                                      data-toggle="tab">Quarters</a></li>
            <li role="presentation"><a href="#players" aria-controls="players" role="tab" data-toggle="tab">Players</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="donations">

                <div>
                    <h2>{{ $quarters[0]->year }}, Q{{ $quarters[0]->quarter }} <small>${{ $quarters[0]->total }} / ${{ $quarters[0]->goal }}</small></h2>

                    <div class="progress progress{{ ($quarters[0]->percentage >= 100) ?: '-striped active' }}">
                        <div class="progress-bar progress-bar-{{ ($quarters[0]->percentage >= 100) ? 'success' : 'info' }}"
                             role="progressbar" aria-valuenow="{{ $quarters[0]->percentage }}" aria-valuemin="0"
                             aria-valuemax="100"
                             style="width: {{ ($quarters[0]->percentage >= 100) ? '100' : $quarters[0]->percentage }}%">
                            {{ $quarters[0]->percentage }}%
                        </div>
                    </div>

                </div>

                <table class="table table-hover table-data">
                    <thead>
                    <tr>
                        <td>Amount</td>
                        <td>Email</td>
                        <td>CC Details</td>
                        <td>Status</td>
                        <td>Date</td>
                        @if(Auth::user()->hasRole('Owner'))
                        <td></td>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($quarters[0]->donations as $donation)
                        <tr>
                            <td>${{ $donation->amount }}</td>
                            <td>{{ $donation->email }}</td>
                            <td><img style="max-height: 16px;"
                                     src="/img/{{ strtolower($donation->card_type) }}.png"/> {{ $donation->card_last4 }}, {{ $donation->card_month }}
                                /{{ substr($donation->card_year, -2) }}</td>

                            @if($donation->status == 0)
                                <td>Valid</td>
                            @elseif($donation->status == 5)
                                <td>Refunded</td>
                            @endif

                            <td>{{ $donation->created_at }}</td>
                            @if(Auth::user()->hasRole('Owner'))
                            <td><a class="btn btn-xs btn-primary" href="/admin/donations/{{ $donation->id }}/refund">Refund</a></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div role="tabpanel" class="tab-pane" id="quarters">
                <table class="table table-hover table-data">
                    <thead>
                    <tr>
                        <td>Year</td>
                        <td>Quarter</td>
                        <td>Percentage</td>
                        <td>Total</td>
                        <td>Goal</td>
                        <td>Donors</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($quarters as $quarter)
                        <tr>
                            <td>{{ $quarter->year }}</td>
                            <td>Q{{ $quarter->quarter }}</td>
                            <td>
                                <div class="progress progress{{ ($quarter->percentage >= 100) ?: '-striped active' }}">
                                    <div class="progress-bar progress-bar-{{ ($quarter->percentage >= 100) ? 'success' : 'info' }}"
                                         role="progressbar" aria-valuenow="{{ $quarter->percentage }}" aria-valuemin="0"
                                         aria-valuemax="100"
                                         style="width: {{ ($quarter->percentage >= 100) ? '100' : $quarter->percentage }}%">
                                        {{ $quarter->percentage }}%
                                    </div>
                                </div>
                            </td>

                            <td>${{ $quarter->total }}</td>
                            <td>${{ $quarter->goal }}</td>
                            <td>{{ $quarter->donations->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="players">

                <table class="table table-hover table-data">
                    <thead>
                    <tr>
                        <td>Nickname</td>
                        <td>Steam ID32</td>
                        <td>Expires</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>{{ htmlspecialchars($player->steam_nickname) }}</td>

                            <td>{{ $player->steam_id }}</td>

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

                    $('select').on('change', function () {
                        var el = $(this);
                        var year = el.find('option:selected').text();
                        window.location.replace('/admin/donations/' + year);
                    });

                });


            </script>
@stop