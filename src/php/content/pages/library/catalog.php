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

		//get article details for that directory
		//e.g. articleKey.info.php
		
		$articleNfo = array(
			$articleKey,
			$pageUrl,
			"Article",
			"",
			ARTICLE_VISIBILITY_PUBLIC,
			"default"
		);
		
		//show page
		$fl = Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS. $articleKey .DS. $articleKey .".info.php";
		//Get content
		if(file_exists($fl)){
			require_once($fl);
			
			$articleNfo = ArticleInfo::GetInfo($articleKey,$pageUrl,ARTICLE_VISIBILITY_PUBLIC);
		}
		
		$article = new Article($articleNfo);

		return $article;
	}
}


 ?>