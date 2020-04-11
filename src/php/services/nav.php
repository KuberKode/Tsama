<?php
namespace Tsama;
define("SERVICE.NAV",TRUE);

require_once(Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS."catalog.php");

class Nav{

    private $m_catalog = null;

	public function __construct(){
	}
	
	public function Run($name = 'main'){

        Debug::Log("Nav->Run(".$name.")");
        
        $this->m_catalog = array( LibraryCatalog::GetArticle('default') );
        
        $fl = Server::GetFullBaseDir() . DS . "content".DS."navs".DS. $name .".php";

		//Get content
		if(file_exists($fl)){
            require($fl);
        }

    }
    
    public function GetCatalog(){
        return $this->m_catalog;
    }

}

?>