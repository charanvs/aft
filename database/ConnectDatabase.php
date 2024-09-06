<?php 
	require dirname(__FILE__).'/../config/dbconstant.php';

	class ConnectDatabase {
		protected $conn;

		public function __construct()
		{
			$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if($this->conn->connect_error){
				die('Database Connection Error!');
			}
		}

		public function connect()
		{
			return $this->conn;
		}
	}

	new ConnectDatabase();
 ?>