<?php 
namespace Tsama;

define("SERVICE.PAGE.LAYOUT.DEFAULT.HTML.HEAD",TRUE);

$siteConf = Server::GetWebsiteConfig();

echo '<!DOCTYPE html><html lang="'.$siteConf["LANGUAGE"].'"><head>';
echo '<meta charset="utf-8"/>';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
echo '<title>';
echo $activeArticle->name;

echo ' · '.$siteConf["NAME"].'</title>';

$base = Server::GetBaseUrl();
echo '<base href="'.$base.'"/>';
echo '<link rel="canonical" href="'.$base.'page/'.$activeArticle->keyName.'/">';
echo '<link href="'.$base.'content/pages/themes/'.$activeArticle->theme.'/styles/bootstrap.min.css?1" rel="stylesheet" type="text/css"/>';//should be site theme
		echo '<link href="'.$base.'content/pages/themes/'.$activeArticle->theme.'/styles/default.css?1" rel="stylesheet" type="text/css"/>'; //should be site theme
echo '<script type="text/javascript">var baseUrl = "'.$base.'";</script>';
//TODO: favicon
echo '</head>';
?>