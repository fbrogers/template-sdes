<?php
class db{
	//single instance property
	private static $db_instance;

	//connection variable
	private $cstring;
	private $connected;
	private $conn;
	
	//to prevent cloning
	protected function __clone(){
		//empty
	}

	//to prevent object instantiation
	private function __construct(){
		//empty
	}

	//getter for $connected
	public function isConnected(){
		return self::$db_instance->connected;
	}

	//set the connection string parameters
	public function connection_string($server, $database, $user, $pass){
		//assign array indices
		$this->cstring['server'] = $server;
		$this->cstring['database'] = $database;
		$this->cstring['user'] = $user;
		$this->cstring['pass'] = $pass;
	}

	public static function connect(){
		//check for existing connection
		if(self::$db_instance->conn != NULL){
			return self::$db_instance->conn;
		}

		if(!isset(
			self::$db_instance->cstring['database'],
			self::$db_instance->cstring['user'],
			self::$db_instance->cstring['pass'],
			self::$db_instance->cstring['server']			
		)){
			throw new Exception("Database connection string parameters not set.", 1);			
		}

		//connection settings
		$settings = [
			"Database" => self::$db_instance->cstring['database'],
			"UID"=> self::$db_instance->cstring['user'],
			"PWD"=> self::$db_instance->cstring['pass'],
			"CharacterSet" => "UTF-8",
			"ReturnDatesAsStrings" => 1
		];

		//connect to sql
		$conn = sqlsrv_connect(self::$db_instance->cstring['server'], $settings);

		//check for error
		if(!$conn){		
			throw new Exception(print_r(sqlsrv_errors(), true), 1);
		}

		//set bit flag for connection
		self::$db_instance->connected = true;

		//set in private property
		self::$db_instance->conn = $conn;
		
		//return connection pointer
		return $conn;
	}

	//static method to connect to the database
	public static function instance(){

		//if no instance is set, create one
		if(!self::$db_instance){
			self::$db_instance = new db();
		}

		//return active instance
		return self::$db_instance;
	}
}
?>