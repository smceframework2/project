<?php

class PageController extends Controller
{

	// on htaccess
	// http://localhost/smceframework.com/page/show
	
	// off htaccess
	// http://localhost/helloworld/index.php?route=/page/show
	public function actionShow()
	{

		$msg="Page/Show";

		$this->render("site/index",array(
			"msg"=>$msg,
		));
		
	}
}