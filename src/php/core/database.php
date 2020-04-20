<?php 
namespace Tsama;
define("DATABASE",TRUE);

class TsamaDatabase{
	private $m_connection = null;

	public function __construct(){}

	public static function IsConfigured(){
		$dbConf = Server::GetFullBaseDir().DS.'conf'.DS.'db.conf.php';

		if(file_exists($dbConf)){
			return TRUE;
		}
		return FALSE;
	}

	public function IsActive(){
		if($this->m_connection != null){
			return TRUE;
		}
		return FALSE;
	}

	public function CheckVersion(){

	}
	public function CheckUpdate(){

	}
	public function Install(){

	}

	public function Query($sql,$params = null){
		try{
			if (!$this->Connect()){
				return null;
			}

			$sth = null;

			$conn = $this->m_connection;
			if(!$this->IsActive() && !is_object($conn)){
				return null;
			}

			$sth = $conn->prepare($sql);
			if($params){
				$sth->execute($params);
			}else{
				$sth->execute();
			}

			return $sth;
		}catch(\PDOException $e) {
			Debug::Log("Database Error!: " . $e->getMessage());
			return null;
		}

	}

	public function Connect($attempts = 0){
		global $_DB_CONFIG;

		try{

			if( $this->m_connection != null && is_object($this->m_connection) ){
				//assume connected
				return TRUE;	
			}

			$this->m_connection = new \PDO( strtolower($_DB_CONFIG['Driver']).':host='.$_DB_CONFIG['Host'].';dbname='.$_DB_CONFIG['Name'], $_DB_CONFIG['Username'],$_DB_CONFIG['Password'] );
			$this->m_connection->setAttribute( \PDO::ATTR_PERSISTENT, true );

			Debug::Log("Database [".$_DB_CONFIG['Name']."@".$_DB_CONFIG['Host']."] connected.");

		}catch(\PDOException $e) {

			//For error:  MySQL server has gone away 
				//Sometimes after long period of inactivity the conn will go away, so try again
			if($attempts==0){
				return $this->Connect(1);
			}

			Debug::Log("Database Error!: " . $e->getMessage());

			$this->m_connection = null;
			Debug::Log("Database  [".$_DB_CONFIG['Name']."@".$_DB_CONFIG['Host']."] NOT connected.");
			return FALSE;
		}
		
		return TRUE;
	}
}

?>