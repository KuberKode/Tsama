<?php
namespace Tsama;
define("SERVICE.NAV",TRUE);

require_once(Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS."catalog.php");

class Nav{

    private $m_catalog = null;
    private $m_public = TRUE;

	public function __construct(){
	}
	
	public function Run($name = 'main'){

        Debug::Log("Nav->Run(".$name.")");
        
        $this->m_catalog = array( LibraryCatalog::GetArticle('default') );
		
		//Check for maintenance mode
		$conf = Server::GetWebsiteConfig("MAINTENANCE_MODE");
		if(isset($conf["MAINTENANCE_MODE"])){
			if($conf["MAINTENANCE_MODE"] == TRUE){
				$this->m_catalog = array( );
				return;
			}
		}
        
        $fl = Server::GetFullBaseDir() . DS . "content".DS."navs".DS. $name .".php";

		//Get content
		if(file_exists($fl)){
            require($fl);
        }

    }

    public function SetPublic($publicConfig = TRUE){
		$this->m_public = $publicConfig;
	}
    
    
    public function GetCatalog(){
        return $this->m_catalog;
    }

}

?>