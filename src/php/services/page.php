<?php
namespace Tsama;
define("SERVICE.PAGE",TRUE);

require_once(Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS."catalog.php");

class Page{
	
	private $m_activeArticle = null;
	private $m_public = TRUE;

	public function __construct(){		
		$this->m_activeArticle = LibraryCatalog::GetActiveArticle();
	}

	public function SetPublic($publicConfig = TRUE){
		$this->m_public = $publicConfig;
	}
	
	public function Run($name = 'default'){
		
		$this->m_activeArticle = LibraryCatalog::GetActiveArticle();
		
		$this->m_siteTheme = $this->m_activeArticle->theme;
		
		$basedir = Server::GetFullBaseDir();
		
		$layoutFile = $basedir . DS . "content".DS."pages".DS."layouts".DS. $this->m_activeArticle->layout .DS. $this->m_activeArticle->layout .".php";
		
		if(!file_exists($layoutFile)){
			echo '<div class="container-fluid"><div class="alert alert-danger" role="alert"><p><strong><u>Error:</u></strong></p><ul><li><strong>Page layout [' . $this->m_activeArticle->layout . '] not found.</strong></li></ul></div></div>';
		}else{
			require_once($layoutFile);
		}
		
		Layout::ShowHTMLHead($this->m_activeArticle);
		Layout::StartBody($this->m_activeArticle);
		
		//show page
		$fl = $basedir . DS . "content".DS."pages".DS."library".DS. $this->m_activeArticle->keyName .DS. $this->m_activeArticle->keyName .".php";
		//Get content
		if(!file_exists($fl)){
			$debug = Server::GetWebsiteConfig("DEBUG");
			if($debug){
				echo '<pre>'.$this->m_activeArticle->keyName.'</pre>';
			}
			echo '<div class="container-fluid"><div class="alert alert-danger" role="alert"><p><strong><u>Error:</u></strong></p><ul><li><strong>Page not found.</strong></li></ul></div></div>';
		}else{
			require_once($fl);
		}
		Layout::EndBody($this->m_activeArticle);		
		
	}

}

	
?>