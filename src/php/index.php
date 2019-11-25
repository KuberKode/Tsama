<?php 
namespace Tsama;
define("TSAMA",TRUE);

require_once("server.php");
require_once( Server::GetFullBaseDir() .DS."core".DS."router.php");

$route = Server::GetRoute();
$router = new TsamaRouter();

$router->ProcessRoute($route);
	
?>
