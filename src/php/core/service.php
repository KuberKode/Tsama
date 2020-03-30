<?php 
namespace Tsama;
define("SERVICE",TRUE);

require_once( Server::GetFullBaseDir() . DS . "core". DS ."form.php");

class TsamaService{
	public function Load($service,$serviceParam = "default"){
		
		//TODO: Validate input $service. Check for code injections, remote dir listing etc... e.f. serv();echo 'moo';
		$baseDir =  Server::GetFullBaseDir();
		$sfl = $baseDir . DS . "services".DS.$service.".php";
		//$serviceParam = "default";
		
		$us = "Tsama\\".ucwords($service);

		//if service does not exist it could be a page ;)
		if(!file_exists($sfl)){
			$us = "Tsama\\Page";
			$sfl = $baseDir . DS . "services".DS."page.php";
			$serviceParam = $service;
		}
		
		if(!file_exists($sfl)){
			echo '<!DOCTYPE html><html><head></head><body>';
			echo '<div class="notification error"><p><strong><u>Error:</u></strong></p><ul><li><strong>Invalid Service ['.$service.'] not found.</strong></li></ul></div>';
			echo '</body></html>';
			return;
		}
		
		require_once($sfl);		
		$s = new $us();
		
		$s->Run($serviceParam);
	}
}
?>