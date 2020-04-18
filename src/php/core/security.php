<?php
namespace Tsama;
if(!defined("TSAMA")){ header("Location: /"); return; };

define("SECURITY",TRUE);

define("NL","\n");


$_SEC_CONFIG = array(
	'INT32' => FALSE
);

class TsamaSecurity{

    //Crockford's Base32
	private $m_base32 = array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","J","K","M","N","P","Q","R","S","T","V","W","X","Y","Z");
	private $m_int32 = FALSE;

	public function __construct(){
		//get security config
		$conf = $this->GetConfig("INT32");
		$this->SetInt32($conf["INT32"]);
	}
	
	private function GetConfig($configName = null){
		global $_SEC_CONFIG;
		$_SEC_CONFIG = array(
			'INT32' => FALSE
		);

		$sec_file = Server::GetFullBaseDir() .DS.'core'.DS.'sec'.DS.'conf.php';

		if(file_exists($sec_file)){
			include($sec_file);
		}
		
		//Return specific db config?
		if(!is_null($configName)){
			if(isset($_SEC_CONFIG[$configName])){
				return array($configName => $_SEC_CONFIG[$configName]);
			}
		}
		
		return $_SEC_CONFIG;
	}
    
    public function Run($parameter = 'default'){}

	public function GenerateULID(){
		$ulid = $this->CreateULID();
		$udid = $this->ConvertUlidToBase32($ulid);
		return $udid;
	}

	public function SetInt32($isInt32 = FALSE){
		$this->m_int32 = $isInt32;
	}

	 //UseCase: Convert Ulid to Crockford's Base32
	private function ConvertUlidToBase32($ulid){
		$encoded = array();

		//base32 encode
		// 10 byte timestamp
		$encoded[0] = $this->m_base32[($ulid[0] & 224)>> 5];
		$encoded[1] = $this->m_base32[$ulid[0] & 31];
		$encoded[2] = $this->m_base32[($ulid[1] & 248) >> 3];
		$encoded[3] = $this->m_base32[(($ulid[1] & 7) << 2) | (($ulid[2] & 192) >> 6)];
		$encoded[4] = $this->m_base32[($ulid[2] & 62) >> 1];
		$encoded[5] = $this->m_base32[(($ulid[2] & 1) << 4) | (($ulid[3] & 240) >> 4)];
		$encoded[6] = $this->m_base32[(($ulid[3] & 15) << 1) | (($ulid[4] & 128) >> 7)];
		$encoded[7] = $this->m_base32[($ulid[4] & 124) >> 2];
		$encoded[8] = $this->m_base32[(($ulid[4] & 3) << 3) | (($ulid[5] & 224) >> 5)];
		$encoded[9] = $this->m_base32[$ulid[5] & 31];

		// 16 bytes of randomness
		$encoded[10] = $this->m_base32[($ulid[6] & 248) >> 3];
		$encoded[11] = $this->m_base32[(($ulid[6] & 7) << 2) | (($ulid[7] & 192) >> 6)];
		$encoded[12] = $this->m_base32[($ulid[7] & 62) >> 1];
		$encoded[13] = $this->m_base32[(($ulid[7] & 1) << 4) | (($ulid[8] & 240) >> 4)];
		$encoded[14] = $this->m_base32[(($ulid[8] & 15) << 1) | (($ulid[9] & 128) >> 7)];
		$encoded[15] = $this->m_base32[($ulid[9] & 124) >> 2];
		$encoded[16] = $this->m_base32[(($ulid[9] & 3) << 3) | (($ulid[10] & 224) >> 5)];
		$encoded[17] = $this->m_base32[$ulid[10] & 31];
		$encoded[18] = $this->m_base32[($ulid[11] & 248) >> 3];
		$encoded[19] = $this->m_base32[(($ulid[11] & 7) << 2) | (($ulid[12] & 192) >> 6)];
		$encoded[20] = $this->m_base32[($ulid[12] & 62) >> 1];
		$encoded[21] = $this->m_base32[(($ulid[12] & 1) << 4) | (($ulid[13] & 240) >> 4)];
		$encoded[22] = $this->m_base32[(($ulid[13] & 15) << 1) | (($ulid[14] & 128) >> 7)];
		$encoded[23] = $this->m_base32[($ulid[14] & 124) >> 2];
		$encoded[24] = $this->m_base32[(($ulid[14] & 3) << 3) | (($ulid[15] & 224) >> 5)];
		$encoded[25] = $this->m_base32[$ulid[15] & 31];

		$this->m_value = implode($encoded);

		return $this->m_value;
	}

    //UseCase: Create a Unique Lexicographically Identifier
	private function CreateULID(){

        $ulid = array();
		
		//get time
		$timestamp = (int)(microtime(true));

		if($this->m_int32){
			$ulid[0] = (int)(((int)($timestamp >> 20))%255);
			$ulid[1] = (int)(((int)($timestamp >> 16))%255);
			$ulid[2] = (int)(((int)($timestamp >> 12))%255);
			$ulid[3] = (int)(((int)($timestamp >> 8))%255);
			$ulid[4] = (int)(((int)($timestamp >> 4))%255);
			$ulid[5] = (int)($timestamp%255);
		}else{
			$ulid[0] = (int)(((int)($timestamp >> 40))%255);
			$ulid[1] = (int)(((int)($timestamp >>32))%255);
			$ulid[2] = (int)(((int)($timestamp >> 24))%255);
			$ulid[3] = (int)(((int)($timestamp >> 16))%255);
			$ulid[4] = (int)(((int)($timestamp >> 8))%255);
			$ulid[5] = (int)($timestamp%255);
		}

		$randseed = (int)( ( rand() * $timestamp ) / getrandmax() );
		srand( $randseed );

		$ulid[6] = (int)( rand() * 255 ) / getrandmax();
		$ulid[7] = (int)( rand() * 255 ) / getrandmax();
		$ulid[8] = (int)( rand() * 255 ) / getrandmax();
		$ulid[9] = (int)( rand() * 255 ) / getrandmax();
		$ulid[10] = (int)( rand() * 255 ) / getrandmax();
		$ulid[11] = (int)( rand() * 255 ) / getrandmax();
		$ulid[12] = (int)( rand() * 255 ) / getrandmax();
		$ulid[13] = (int)( rand() * 255 ) / getrandmax();
		$ulid[14] = (int)( rand() * 255 ) / getrandmax();
		$ulid[15] = (int)( rand() * 255 ) / getrandmax();

        return $ulid;
    }
}
?>