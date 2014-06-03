<?php

Class Generator extends Eloquent  {
	
	public function donators()
	{
		$donators = Donator::where('donation_expires','>', strtotime('today'))->get();

		$n 	= "\n";
		$t 	= "\t";
		$c 	= 0;

		$list = '<pre>';
		
		foreach ($donators as $donator)
		{
			$list .= '{' . $n;
			$list .= $t . '// ' . $donator->steam_nickname . $n;
			$list .= $t . '// Expires ' . date('d/m/Y', strtotime($donator->donation_expires)) . $n;
			$list .= $t . $donator->steam_id . $n;
			$list .= '}';

			if($donators->count() < $c)
			{
				$list .= ',';
				$c++;
			}
		}

		$list .= '</pre>';

		return $list;
	}

}