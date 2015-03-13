<?php 

use Smce\Core\DI;

class Controller
{


	protected function render($view, $arr=array())
	{

		$template=DI::resolve("template");
		$template->setView($view, $arr);
		$template->run();

	}


	public static function renderContent($view, $arr=array())
	{

		$layout=DI::resolve("layout");
		$layout->setContent($view, $arr);
		$layout->run();

	}

	
}