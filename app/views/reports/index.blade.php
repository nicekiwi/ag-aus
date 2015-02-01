@extends('layouts.admin')

@section('content')

    <h2>Reports <small>Where all if visible</small></h2>

    <table class="table table-border table-data">
        <thead>
            <tr>
                <th>Report</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->desc }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@stop