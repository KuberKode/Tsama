<?php
namespace Tsama;
define("SERVICE.PAGE.LIBRARY.CATALOG",TRUE);

require_once("article.php");

class LibraryCatalog{
	public static function GetCatalog(){
		//scan for directories
		//get article details for that directory
			//e.g. article.info.php
	}
	
	public static function GetArticle($keyName = 'default'){
		$articleKey = $keyName;
		
		$route = Server::GetRoute();		
		if(count($route) > 1){ //Article should be at 1 e.g. /page/about
			$articleKey = $route[1];
		}

		$pageUrl = '';
		$service = Server::GetService();
		
		if($service != 'page' && $articleKey != 'default'){
			$pageUrl .= $service . '/' . $articleKey;
		}

		$articleNfo = ArticleInfo::GetInfo($articleKey,$pageUrl,ARTICLE_VISIBILITY_PUBLIC);
		
		$article = new Article($articleNfo);

		return $article;
	}
}


 ?>