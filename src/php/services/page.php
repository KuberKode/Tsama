<?php
namespace Tsama;
define("SERVICE.PAGE",TRUE);

require_once("page/pageworker.php");

class Page{
	
	private $m_articles = null; //visible articles
	private $m_activeArticle = null;

	public function __construct(){
		
		$this->m_articles = PageWorker::GetLibraryCatalog();
		$this->m_activeArticle = PageWorker::GetActiveArticle();
			}
	
	public function Run($name = 'default'){
		
		$this->m_activeArticle = PageWorker::GetActiveArticle($name);
		
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
			echo '<div class="container-fluid"><div class="alert alert-danger" role="alert"><p><strong><u>Error:</u></strong></p><ul><li><strong>Page not found.</strong></li></ul></div></div>';
		}else{
			require_once($fl);
		}
		Layout::EndBody($this->m_activeArticle);		
		
	}

	public function ShowLeftNav(){		
		
		/*$navs = array(
			new NavItem('users','page/users/you','
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg> Your Profile'),
			new NavItem('farms','page/farms/yours','
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg> Your Farm<!--s <span class="badge badge-dark">0</span>-->'),
			*//*new NavItem('market','page/market','
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> The Market'),*//*
			new NavItem('knowledgebase','page/knowledgebase','<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Knowledgebase')
		);
		
		$base = Server::GetBaseUrl();
		
		echo '<ul class="nav flex-column" id="leftnav">';
		foreach($navs as $obj){
			echo '<li class="nav-item">';
			
			echo '<a href="'.$base.$obj->url.'" class="nav-link ';
			if($obj->keyName == $this->activePage){
				echo 'active';
			}
			echo '">'.$obj->name.'</a> ';
			echo '</li>';
		}
		echo '</ul>';*/
		
	}

}

	
?>