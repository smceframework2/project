<?php


error_reporting(E_ALL);
ini_set("display_errors", 1);

use Smce\Core\DI;
use Smce\Core\EventManager;
use Smce\Core\Loader;
use Smce\Mvc\Router;
use Smce\Http\HttpException;
use Smce\Http\Response;
use Smce\Core\SmceFramework;
use Smce\Sm;


class SmceframeworkNet
{

	private $di;

	public function __construct()
	{

		DI::bind("EventManager",function(){
			
			return new EventManager;

		});
		
	}

	private function setTemplate()
	{

		DI::bind("template",function(){
		    $template = new Smce\Mvc\Template;
		    $template->setLayoutDirectory(Sm::app()->baseurl."/main/view/layouts");
		    $template->setViewDirectory(Sm::app()->baseurl."/main/view");
		    $template->setLayout("column1");
		    return $template;
		});


	}


	private function setContent()
	{

		DI::bind("layout",function(){
		    $layout = new Smce\Mvc\Layout;
		    $layout->setContentDirectory(Sm::app()->baseurl."/main/view/layouts");
		    return $layout;
		});
	
	}

	public function config()
	{

		$event=DI::resolve("EventManager");

		$event->bind("config",function(){

			return array(

			
				"db"=>array(
					"db_user" 		=> 'root',
					"db_password" 	=> '*****',
					"db_dbname" 	=> 'dbname',
					"db_host"		=> 'localhost',
					"db_encoding" 	=> 'utf8',
				),


		    	//memcache
		    	"memcache"=>array(
		    		"host"=>"127.0.0.1",
		        	"port"=>"11211"
		    	),

		    	'baseurl'=>dirname(__FILE__),


			);

		});

	}


	private function loader()
	{

		
		DI::bind("loader",function(){

		    $loader=new Loader;

		    $loader->setDir(array(
		        dirname(__FILE__)."/main/controller/",
		        dirname(__FILE__)."/main/model/",
		        dirname(__FILE__)."/main/components/",
		    ));

		    return $loader;
		});

	}


	private function router()
	{

		DI::bind("router",function(){

		    $router = new Router;
		    $router->setDefaultController('site');
		    $router->setDefaultAction('index');
		    $router->handle();

		    return $router;
		});

	}


	private function setDb()
	{
		DI::singleton("db",function(){

			$db=new DB;
			DB::$user = Sm::app()->db["db_user"];
			DB::$password = Sm::app()->db["db_password"];
			DB::$dbName = Sm::app()->db["db_dbname"];
			DB::$host = Sm::app()->db["db_host"];
			DB::$encoding = Sm::app()->db["db_encoding"];

			return $db;

		})->resolveWhen("DBInterface");

	}

	public function response()
	{
		$event=DI::resolve("EventManager");

		$event->push("response",function($code,$msg){

			throw new Response($code,$msg);

		});

	}


	public function make()
	{
		//loader
		$this->loader();

		//config
		$this->config();

		
		$loader=DI::resolve("loader");
		$loader->register();

		//db
		$this->setDb();

		//response
		$this->response();

		//router
		$this->router();

		//template
		$this->setTemplate();
		$this->setContent();

		try{

			$smce=new SmceFramework;
			$smce->make();
		     


		}catch(HttpException $e){


		    echo $e->getHttpCode(). " - ".$e->getMsg();

		}

	}


}


$smceframeworkNet=new SmceframeworkNet();
$smceframeworkNet->make();





