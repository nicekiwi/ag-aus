@extends('layouts.master')

@section('content')

<h2>Donation Confirmation</h2>

<p>Congratulations, you have successfully donated {{ $donation->amount }}</p>

<p><strong>Donations in 2013</strong></p>

@stop