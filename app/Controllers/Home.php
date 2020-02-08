<?php namespace App\Controllers;


class Home extends BaseControllers
{
	public function index()
	{
		$template = view("elements/content_start")
					.view("elements/Header")
					.view("home_view")
					.view("elements/Footer")
					.view("elements/content_end");
        return $template;
	}


}
