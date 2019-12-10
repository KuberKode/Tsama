<?php 
namespace Tsama;

define("SERVICE.PAGE.LIBRARY.ARTICLE",TRUE);

define("ARTICLE_VISIBILITY_PUBLIC", 0);
define("ARTICLE_VISIBILITY_REGISTERED", 1);

require_once("articleinfo.php");

//Keeps track of all pages.

class Article{
	public $keyName = '';
	public $url = "";
	public $name = "";
	public $icon = "";
	public $visibility = ARTICLE_VISIBILITY_REGISTERED;
	
	
	public $layout = "default";
	public $theme = "default";
	public $children;
	public $active = false;
	
	public function __construct($options = array()){
		
		//first get site default configs		
		$siteConf = Server::GetWebsiteConfig();
		$this->layout = $siteConf["LAYOUT"];
		$this->theme = $siteConf["THEME"];		
		
		//Then get article custom configs
		if(count($options) > 0){
			if(isset($options[0])){
				$this->keyName = $options[0];
			}
			
			if(isset($options[1])){
				$this->url = $options[1];
			}
			
			if(isset($options[2])){
				$this->name = $options[2];
			}
			
			if(isset($options[3])){
				$this->icon = $options[3];
			}
			
			if(isset($options[4])){
				$this->visibility = $options[4];
			}
			
			if(isset($options[5])){
				$this->layout = $options[5];
			}
			
			if(isset($options[6])){
				$this->theme = $options[6];
			}
		}
		$this->children = array();
	}
}

?>