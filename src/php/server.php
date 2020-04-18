<?php
namespace Tsama;
if(!defined("TSAMA")){ header("Location: /"); return; };

define("SERVER",TRUE);

session_start();

define('DS', DIRECTORY_SEPARATOR);

$_DB_CONFIG = array(
	'Active' => FALSE,
	'Connection' => null,
	'Driver' => 'mysql',
	'Host' => 'localhost',
	'Username' => '',
	'Password' => '',
	'Name' => ''
);

$_WEB_CONFIG = array(
	'NAME' => 'Tsama',
	'LOGO' => 'tsama.png',
	'THEME' => 'default',
	'LAYOUT' => 'default',
	'LANGUAGE' => 'en',
	'DEBUG' => FALSE
);

$_DEBUG = array();

//Example
//----------------------------------------------------
//Given a url
// http://example.com/page/index.php?request=example
//or
// http://example.com/page/?request=example
//

class Server{
	
	public static function GetProtocol(){
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
		return $protocol;
	}
	
	public static function GetBaseDir(){
		$basedir = dirname(__FILE__);
		return $basedir;
	}
	
	public static function GetDocumentRoot(){
		$docroot = $_SERVER['DOCUMENT_ROOT'];
		return $docroot;
	}
	
	public static function GetDomain(){
		$domain = $_SERVER['SERVER_NAME'];
		return $domain;
	}
	public static function GetPort(){
		$port = $_SERVER['SERVER_PORT'];
		return $port;
	}
	
	public static function GetSubDir(){
		$subdir =  str_replace(realpath(Server::GetDocumentRoot()),'',Server::GetBaseDir());
		if(!empty($subdir)){
			$subdir = str_replace("\\","/",$subdir); //fix for url in windows
			if(substr($subdir,0,1) == '/'){
				$subdir = substr($subdir,1);
			}
		}
		return $subdir;
	}
	
	public static function GetBaseUrl(){
		$base = Server::GetProtocol() . '://'. Server::GetDomain();
		$port = Server::GetPort();
		if($port != '80'){
			$base .= ':' . $port;
		}
		$base .= '/';
		$subdr = Server::GetSubDir();
		if(!empty($subdir)){
			$base .= $subdir . '/';
		}
		return $base;
	}
	
	public static function GetFullBaseDir(){
		$fullbasedir = Server::GetBaseDir() ;
		return $fullbasedir;
	}
	
	public static function GetFullSubDir(){
		$fullsubdir = '/' . Server::GetSubdir() . '/';
	}
	
	public static function GetRoute(){
		//get the route
		//E.g. Route = array( 'page', '?request=example' )
		$route = explode("/",substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI'])-1));
		//check the route for requests
		$lastKey = count($route)-1;
		$lastItem = $route[$lastKey];
		
		$reqPosition = strpos($lastItem,'?');
		if($reqPosition !== FALSE){
			$route[$lastKey] = substr($lastItem,0,$reqPosition);
		}
		if(empty($route[$lastKey])){
			//remove last item as it is only requests			
			unset($route[$lastKey]); 
			//refresh array values
			$route = array_values($route);
		}
		
		//adjust route accordingly
		$remArr =  explode("/",Server::GetSubDir());
		if(count($remArr)>0){
			$route = array_values(array_diff_assoc($route,$remArr));
		}
		
		return $route;
	}
	
	public static function GetService(){
		$service = "page"; //Always default service
		$route = Server::GetRoute();
		if(count($route) > 0){
			//Get the service
			$service = $route[0]; //service always first item in route
		}
		
		return $service;
	}
	
	public static function GetWebsiteConfig($configName = null){
		global $_WEB_CONFIG;
		//Defaults. do not edit. Add conf/site.conf.php file instead
		$_WEB_CONFIG = array(
			'NAME' => 'Tsama',
			'LOGO' => 'tsama.png',
			'THEME' => 'default',
			'LAYOUT' => 'default',
			'LANGUAGE' => 'en',
			'DEBUG' => FALSE
		);
		
		$site_file = Server::GetFullBaseDir() .DS.'conf'.DS.'site.conf.php';
		if(file_exists($site_file)){
			include($site_file);
		}
		
		//Return specific website config?
		if(!is_null($configName)){
			if(isset($_WEB_CONFIG[$configName])){
				return array($configName => $_WEB_CONFIG[$configName]);
			}
		}

		return $_WEB_CONFIG;
	}
	
	public static function GetDatabaseConfig($configName = null){
		global $_DB_CONFIG;
		$_DB_CONFIG = array(
			'Active' => FALSE,
			'Connection' => null,
			'Driver' => 'mysql',
			'Host' => 'localhost',
			'Username' => '',
			'Password' => '',
			'Name' => ''
		);

		$db_file = Server::GetFullBaseDir() .DS.'conf'.DS.'db.conf.php';

		if(file_exists($db_file)){
			include($db_file);
		}
		
		//Return specific db config?
		if(!is_null($configName)){
			if(isset($_DB_CONFIG[$configName])){
				return array($configName => $_DB_CONFIG[$configName]);
			}
		}
		
		return $_DB_CONFIG;
	}
	
}

Server::GetWebsiteConfig();
Server::GetDatabaseConfig();
?>
