<?php

class PagesController extends \BaseController {

	protected $resource_key = 'home';

	public function home()
	{
		return View::make('home');
	}

	public function survey()
	{
		return View::make('survey');
	}

	public function iwo()
	{
		return View::make('iwo');
	}
} 