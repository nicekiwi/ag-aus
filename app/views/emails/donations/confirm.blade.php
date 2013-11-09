<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Alternitive Gamers Donation Receipt</h2>

		<p>You donated: {{ $data->amount }}</p>

		<p>Hey,</p>
		<p>Cheers for your donation mate from this creditcard:</p>
		<p>**** **** **** {{ $data->last4 }}, {{ $data->exp_month }}/{{ exp_year }}</p>

		<p>You get Donator Perks until {{ $data->perks_end_date }}</p>

		<small>This donation is not tax deductable.</small>
	</body>
</html>