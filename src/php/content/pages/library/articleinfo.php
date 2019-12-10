<?php 
namespace Tsama;

class ArticleInfo{
	public static function GetInfo($articleKey,$pageUrl,$visibility){
        //get article details for that directory
		//e.g. articleKey.info.php
		
		$articleNfo = array(
			$articleKey,
			$pageUrl,
			"Home",
			"",
			ARTICLE_VISIBILITY_PUBLIC,
			"default"
        );
        
        $fl = Server::GetFullBaseDir() . DS . "content".DS."pages".DS."library".DS. $articleKey .DS. $articleKey .".info.php";
		//Get content
		if(file_exists($fl)){
            require_once($fl);
        }

        return $articleNfo;
	}
}
?>