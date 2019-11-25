<?php 
namespace Tsama;
define("ROUTER",TRUE);

require_once( Server::GetFullBaseDir() . DS . "core". DS ."service.php");

class TsamaRouter{
	public function ProcessRoute($route){
		
		$firstPath = "page"; //Always default service
		
		if(count($route) > 0){
			//Get the service
			$firstPath = $route[0]; //service always first item in route
		}
		
		$service = new TsamaService();
		
		$service->Load($firstPath);

	}
}

?>