<?php 
namespace Tsama;


class ArticleInfo{
	public static function GetInfo($articleKey,$pageUrl,$visibility){
		return array(
			$articleKey,
			$pageUrl,
			"Home",
			"",
			$visibility,
			"default"
		);
	}
}
?>