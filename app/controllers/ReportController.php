<?php

class ReportController extends BaseController {

	protected $layout = 'layouts.admin';


	/**
	 *
     */
	public function index()
	{
		$reports = Report::all();

		// Return donate with quarter data
		$this->layout->bodyClass = 'reports';
		$this->layout->content = View::make('reports.index')->with(compact('reports'));
	}

}