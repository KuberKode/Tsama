<?php 
namespace Tsama;
define("SERVICE",TRUE);

require_once( Server::GetFullBaseDir() . DS . "core". DS ."form.php" );

$_SERV_CONFIG = array();
require_once( Server::GetFullBaseDir() . DS . "core". DS ."serv".DS."conf.php" );

class TsamaService{

	private $m_service = null;

	public function __construct(){
	}

	public function Load($service,$serviceParam = "default"){
		global $_SERV_CONFIG;
		$servConfKey = strtoupper($service) . ".PUBLIC";

		//TODO: Validate input $service. Check for code injections, remote dir listing etc... e.g. serv();echo 'moo';
		$baseDir =  Server::GetFullBaseDir();
		$sfl = $baseDir . DS . "services".DS.$service.".php";
		
		$us = "Tsama\\".ucwords($service);

		//if service does not exist it could be a page ;)
		if(!file_exists($sfl)){
			$us = "Tsama\\Page";
			$sfl = $baseDir . DS . "services".DS."page.php";
			$serviceParam = $service;
			$servConfKey = "PAGE.PUBLIC";
		}
		
		if(!file_exists($sfl)){
			echo '<!DOCTYPE html><html><head></head><body>';
			echo '<div class="notification error"><p><strong><u>Error:</u></strong></p><ul><li><strong>Invalid Service ['.$service.'] not found.</strong></li></ul></div>';
			echo '</body></html>';
			return;
		}
		
		require_once($sfl);		
		$this->m_service = new $us();		
		
		if(isset($_SERV_CONFIG[$servConfKey])){
			$this->m_service->SetPublic($_SERV_CONFIG[$servConfKey]);
		}
		$this->m_service->Run($serviceParam);
	}

	public function GetService(){
		return $this->m_service;
	}
}
?>