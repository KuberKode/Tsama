<?php 
namespace Tsama;
define("FORM",TRUE);

class TsamaForm{

	private $m_token = null;
	private $m_acceptCharset = "";
	private $m_action = "";
	private $m_autocomplete = "";
	private $m_enctype = "";
	private $m_method = "";
	private $m_name = "";
	private $m_noValidate = "";
	private $m_target = "";
	private $m_id = "";
	
	public function __construct($options = null){
		/* array( accept-charset, action, autocomplete, enctype, method, name, novalidate, target, id ) */

		//first load core form config
		$this->LoadConfig();
		//now override
		$this->LoadOptions($options);

	}

	private function LoadConfig(){
		$route = Server::GetRoute();
		$basedir = Server::GetFullBaseDir();
		$_FORM_CONFIG = array();

		$formCfg = $basedir . DS . "core".DS."form".DS."conf.php";
		
		if(file_exists($formCfg)){
			require($formCfg);
			if(count($_FORM_CONFIG) > 0){
				if(isset($_FORM_CONFIG["accept-charset"])){
					$this->m_acceptCharset = $_FORM_CONFIG["accept-charset"];
				}
	
				if(isset($_FORM_CONFIG["action"])){
					$this->m_action = $_FORM_CONFIG["action"];
				}
	
				if(isset($_FORM_CONFIG["autocomplete"])){
					$this->m_autocomplete = $_FORM_CONFIG["autocomplete"];
				}
				
				if(isset($_FORM_CONFIG["enctype"])){
					$this->m_enctype = $_FORM_CONFIG["enctype"];
				}
	
				if(isset($_FORM_CONFIG["method"])){
					$this->m_method = $_FORM_CONFIG["method"];
				}
	
				if(isset($_FORM_CONFIG["name"])){
					$this->m_name = $_FORM_CONFIG["name"];
				}
	
				if(isset($_FORM_CONFIG["novalidate"])){
					$this->m_noValidate = $_FORM_CONFIG["novalidate"];
				}
	
				if(isset($_FORM_CONFIG["target"])){
					$this->m_target = $_FORM_CONFIG["target"];
				}
	
				if(isset($_FORM_CONFIG["id"])){
					$this->m_id = $_FORM_CONFIG["id"];
				}
			}

		}
	}

	private function LoadOptions($options){

		if(!is_null($options)){
			if(isset($options["accept-charset"])){
				$this->m_acceptCharset = $options["accept-charset"];
			}

			if(isset($options["action"])){
				$this->m_action = $options["action"];
			}

			if(isset($options["autocomplete"])){
				$this->m_autocomplete = $options["autocomplete"];
			}
			
			if(isset($options["enctype"])){
				$this->m_enctype = $options["enctype"];
			}

			if(isset($options["method"])){
				$this->m_method = $options["method"];
			}

			if(isset($options["name"])){
				$this->m_name = $options["name"];
			}

			if(isset($options["novalidate"])){
				$this->m_noValidate = $options["novalidate"];
			}

			if(isset($options["target"])){
				$this->m_target = $options["target"];
			}

			if(isset($options["id"])){
				$this->m_id = $options["id"];
				if(empty($this->m_name)){
					$this->m_name = $this->m_id;   //for usage: document.forms.name
				}
			}		
			
		}
	}

	public function GenerateToken(){
		$sec = new TsamaSecurity();
		$token = $sec->GenerateULID();
		$subStart = rand ( 0 , 12 );
		$key = strrev( base64_encode( substr($token,$subStart,6) ) );

		$formKey = "formKey";
		if(!empty($this->m_id)){
			$formKey = $this->m_id;
		}
		
		$_SESSION[$formKey] = $key;
		$_SESSION[$key] = $token;
		
		return array( $key => $token );
	}

	public static function TokenIsValid($formId = ""){

		$formKey = "formKey";
		if(!empty($formId)){
			$formKey = $formId;
		}

		$key = $_SESSION[$formKey];

		if(isset($_POST[$key])){
			$token = $_SESSION[$key];
			if($token == $_POST[$key]){ return TRUE;}
		}

		return FALSE;
	}

	private function Start(){
		echo '<form';

		if(!empty($this->m_acceptCharset)){
			echo ' accept-charset="'.$this->m_acceptCharset.'"';
		}		
		if(!empty($this->m_action)){
			echo ' action="'.$this->m_action.'"';
		}
		if(!empty($this->m_autocomplete)){
			echo ' autocomplete="'.$this->m_autocomplete.'"';
		}
		if(!empty($this->m_enctype)){
			echo ' enctype="'.$this->m_enctype.'"';
		}
		if(!empty($this->m_method)){
			echo ' method="'.$this->m_method.'"';
		}
		if(!empty($this->m_name)){
			echo ' name="'.$this->m_name.'"';
		}
		if(!empty($this->m_noValidate)){
			echo ' novalidate';
		}
		if(!empty($this->m_target)){
			echo ' target="'.$this->m_target.'"';
		}
		if(!empty($this->m_id)){
			echo ' id="'.$this->m_id.'"';
		}

		echo '>';
	}
	
	public function Show($customForm = 'default'){

		$route = Server::GetRoute();
		
		$form = $customForm;

		$basedir = Server::GetFullBaseDir();

		$formSrc = $basedir . DS . "content".DS."forms".DS.$form.".php";
		
		if(!file_exists($formSrc)){
			echo '<div class="notification error"><p><strong><u>Error:</u></strong></p><ul><li><strong>Form ['.$form.'] not found.</strong></li></ul></div>';
			return;
		}

		$this->Start();

		require_once($formSrc);

		$this->End();
	}

	private function End(){

		$token = $this->GenerateToken();

		$key = key($token);

		echo '<input type="hidden" name="'.$key.'" value="'.$token[$key].'" />';

		echo '</form>';
	}
}

?>