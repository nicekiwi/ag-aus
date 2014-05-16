@extends('layouts.email')

@section('content')

<h2>Alternative Gaming Donation Receipt</h2>

<p>You donated: {{ $data->amount }}</p>

<p>Hey,</p>
<p>Cheers for your donation, from this creditcard:</p>
<p>**** **** **** {{ $data->last4 }}, {{ $data->exp_month }}/{{ $data->exp_year }}</p>

<p>You get Donator Perks until {{ $data->perks_end_date }}</p>

<small>This donation is not tax deductable.</small>

@stop