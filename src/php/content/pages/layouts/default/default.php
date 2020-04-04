<?php 
namespace Tsama;

define("SERVICE.PAGE.LAYOUT.DEFAULT",TRUE);


class Layout{
	
	//Required methods
	public static function ShowHTMLHead($activeArticle){ 
		require_once("html.head.php");
	}
	
	public static function StartBody($activeArticle){
		echo '<body>';
		
		//custom layout stuff		
		Layout::ShowHeader($activeArticle);		
		Layout::StartMain();
		Layout::StartSidebar();
		//branding and left nav
		Layout::ShowLeftNav();
		Layout::EndSidebar();
		Layout::StartContent();
	}
	
	public static function EndBody($activeArticle){
		
		Debug::Show();

		Layout::EndContent();
		Layout::EndMain();
		Layout::StartFooter();
		Layout::EndFooter();
		
		$base = Server::GetBaseUrl();
		echo '<script type="text/javascript" src="'.$base.'content/pages/themes/'.$activeArticle->theme.'/scripts/jquery-3.4.1.min.js?1"></script>';
		echo '<script type="text/javascript" src="'.$base.'content/pages/themes/'.$activeArticle->theme.'/scripts/bootstrap.bundle.min.js?1"></script>';
		echo '</body></html>';
	}
	
	//Custom methds that can be used in start body and end body
	//Create Layout //header, footers, menus etc.
	//header, branding and top navigation
	public static function ShowHeader($activeArticle){
		echo '<header>';
		Layout::ShowMainNav($activeArticle);
		echo '</header>';
	}
	
	public static function ShowMainNav($activeArticle){
		$base = Server::GetBaseUrl();
		$articles = PageWorker::GetLibraryCatalog();
		//echo '<div class="w-100">';
		echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainnav">';
		//logo
		$siteConf = Server::GetWebsiteConfig();
		echo '<a class="navbar-brand col-sm-3 col-md-2" href="'.$base.'"><img src="'.$base.'content/media/visual/images/'.$activeArticle->theme.'/'.$siteConf["LOGO"].'" height="48" alt="'.$siteConf["NAME"].'" border="0" class="d-inline-block align-top" /></a>';
		
		//top navs
		echo '<ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
		foreach($articles as $article){
			echo '<li class="nav-item text-nowrap">';
			echo PageWorker::GetArticleAnchor($article);
			echo '</li>';
		}
		echo '</ul>';
		echo '</nav>';
		
	}
	public static function StartMain(){
		echo '<main class="row no-gutters">';
	}
	public static function StartSidebar(){
		echo '<div class="col-md-2 d-none d-md-block bg-light sidebar">';
	}
	//branding and left nav
	public static function ShowLeftNav(){}
	public static function EndSidebar(){
		echo '</div>';
	}
	public static function StartContent(){
		echo '<div class="col-md-9 ml-sm-auto col-lg-10" id="main-content">';
	}
		
	//------>
		
	public static function EndContent(){
		echo '</div>';
	}
	public static function EndMain(){
		echo '</main>';
	}
	public static function StartFooter(){
		
		$siteConf = Server::GetWebsiteConfig("NAME");
		
		echo '<footer class="navbar fixed-bottom navbar-light bg-light">';		
echo '<ul class="footer-menu"><li class="title"><h4>'.$siteConf["NAME"].'</h4></li></ul>';
$thisYear = date("Y");
echo '<div class="copyright">Copyright &copy; '.$thisYear.' '.$siteConf["NAME"].' All Rights Reserved</div>';
	}
	public static function EndFooter(){
		echo '</footer>';
	}
}
?>