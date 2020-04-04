<?php 
namespace Tsama;
define("DEBUG",TRUE);

class Debug{

	public function __construct(){
		
	}
	
	public static function Log($debugValue){
        global $_WEB_CONFIG, $_DEBUG;
        if($_WEB_CONFIG['DEBUG'] == TRUE){
            $_DEBUG[] = $debugValue;
        }
    }

    public static function Get(){		
		global $_DEBUG;		
		return $_DEBUG;
	}
    
    public static function Show(){
        global $_WEB_CONFIG, $_DEBUG;
        if($_WEB_CONFIG['DEBUG'] == TRUE){
            if(count($_DEBUG)> 0){
                echo '<div class="container"><hr class="my-4"><pre id="debug">';
                    foreach($_DEBUG as $debugValue){
                        echo '> ' . $debugValue . "\n";
                    }
                echo '</pre></div>';
            }
        }
    }
}

?>