<?php 
namespace Tsama;
if(!defined("TSAMA")){ header("Location: /"); return; };
if(!defined("SERVICE.PAGE")){ header("Location: /"); return; };

define("SERVICE.PAGE.PAGEWORKER",TRUE);

require_once(Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS."catalog.php");

class PageWorker{
	public static function GetActiveArticle($keyName = 'default'){
		$article = LibraryCatalog::GetArticle($keyName);
		$article->active = true;
		return $article;
	}
	
	public static function GetLibraryCatalog(){
		$catalog = array(
			PageWorker::GetActiveArticle()
		);
		
		return $catalog;
	}
	
	public static function GetArticleAnchor($pg){
		$base = Server::GetBaseUrl();
		$a = '<a href="'.$base . $pg->url.'" class="nav-link ';
		if($pg->active){ $a .= 'active'; }
		$a .= '">'.$pg->name.'</a>';
		return $a;
	}
}

?>