<?php 
namespace Tsama;
define("FORM",TRUE);

class TsamaForm{
	
	public function __construct(){
		
	}
	
	public function Show($customForm = 'default'){

		$route = Server::GetRoute();
		
		$form = $customForm;

		$basedir = Server::GetFullBaseDir();
		
		$formSrc = $basedir . DS . "content".DS."forms".DS.$form.".php";
		
		if(!file_exists($formSrc)){
			echo '<div class="notification error"><p><strong><u>Error:</u></strong></p><ul><li><strong>Form ['.$form.'] not found.</strong></li></ul></div>';
		}
		
		require_once($formSrc);
	}
}

?>