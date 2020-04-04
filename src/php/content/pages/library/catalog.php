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

		$pageUrl = $articleKey;
		if($articleKey == 'default'){
			$pageUrl = "";
		}

		$articleNfo = ArticleInfo::GetInfo($articleKey,$pageUrl,ARTICLE_VISIBILITY_PUBLIC);
		
		$article = new Article($articleNfo);

		return $article;
	}
}


 ?>