<?php 
namespace Tsama;
define("SERVICE",TRUE);

class TsamaService{
	public function Load($service){
		
		//TODO: Validate input $service. Check for code injections, remote dir listing etc... e.f. serv();echo 'moo';
		
		$sfl = Server::GetFullBaseDir() . DS . "services".DS.$service.".php";
		
		$us = "Tsama\\".ucwords($service);
		
		if(!file_exists($sfl)){
			echo '<!DOCTYPE html><html><head></head><body>';
			echo '<div class="notification error"><p><strong><u>Error:</u></strong></p><ul><li><strong>Invalid Service ['.$service.'] not found.</strong></li></ul></div>';
			echo '</body></html>';
			return;
		}
		
		require_once($sfl);		
		$s = new $us();
		
		$s->Run();
	}
}
?>