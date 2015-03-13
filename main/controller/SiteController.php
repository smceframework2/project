<?php

class SiteController extends Controller
{
	// on htaccess
	// http://localhost/smceframework.com/site/index
	
	// off htaccess
	// http://localhost/helloworld/index.php?route=/site/index
	public function actionIndex()
	{

		$msg="Hello World";

		$this->render("site/index",array(
			"msg"=>$msg,
		));
		
	}
}