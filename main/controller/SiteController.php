<?php

class SiteController extends Controller
{
	// on htaccess
	// http://localhost/project/site/index
	
	// off htaccess
	// http://localhost/project/index.php?route=/site/index
	public function actionIndex()
	{

		$msg="Hello World";

		$this->render("site/index",array(
			"msg"=>$msg,
		));
		
	}
}