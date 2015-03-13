<?php

class PageController extends Controller
{

	// on htaccess
	// http://localhost/project/page/show
	
	// off htaccess
	// http://localhost/project/index.php?route=/page/show
	public function actionShow()
	{

		$msg="Page/Show";

		$this->render("site/index",array(
			"msg"=>$msg,
		));
		
	}
}