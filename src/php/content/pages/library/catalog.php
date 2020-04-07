<?php
namespace Tsama;
define("SERVICE.PAGE.LIBRARY.CATALOG",TRUE);

require_once("article.php");

class LibraryCatalog{
	
	public static function GetArticle($keyName = 'default',$customName = null){
		$articleKey = $keyName;

		$pageUrl = $articleKey;
		if($articleKey == 'default'){
			$pageUrl = "";
		}

		$articleNfo = ArticleInfo::GetInfo($articleKey,$pageUrl,ARTICLE_VISIBILITY_PUBLIC);		
		$article = new Article($articleNfo);
		//set custom article name
		if(!is_null($customName)){
			$article->name = $customName;
		}
		//check if article is active article
		if(LibraryCatalog::GetActiveArticleName() == $articleKey){
			$article->active = true;
		}

		return $article;
	}
	public static function GetArticles($filter = null){
		$articles = array();
		//if null return full catalog. not recommended if articles is allot.
		if(is_null($filter)){
			$basedir = Server::GetFullBaseDir();
			$location = $basedir . DS . "content".DS."pages".DS."library";
			$library = array_diff(scandir($location), array('..', '.'));
	
			foreach ($library as $articleKey)
			{
				if (is_dir($location . DS . $articleKey)){
					$articles[] = LibraryCatalog::GetArticle($articleKey);
				}
			}

			return $articles;
		}
		//TODO:
		//return catalog according to filter array. E.g. array("default","my-awesome-article","you-rock")
			//scan for directories
			//get article details for that directory
				//e.g. article.info.php
	}

	public static function GetActiveArticleName(){

		$keyName = 'default';

		$route = Server::GetRoute();

		if(isset($route[0])){
			$keyName = $route[0];
		}		
		if(count($route) > 1){ //Article should be at 1 e.g. /page/about ... or /[page]
			$keyName = $route[0];
			if($route[0] == "page"){
				$keyName = $route[1];
			}
		}

		return $keyName;
	}

	public static function GetActiveArticle(){
		
		$article = LibraryCatalog::GetArticle(LibraryCatalog::GetActiveArticleName());
		$article->active = true;
		return $article;

	}
}


 ?>