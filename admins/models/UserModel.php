<?php 
	require dirname(__FILE__).'/../../database/DataModel.php';
	
	class UserModel extends DataModel{

		public function __construct()
		{
			parent::__construct();
		}
		
		public function login($username, $password)
		{
			$username = $this->conn->real_escape_string($username);
			$password = $this->conn->real_escape_string($password);
			
			$query_result = null;
			$sql = "SELECT * from users WHERE username=? and password=?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('ss',$username, $password);
			$stmt->execute();
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()){
				$query_result = $row;
			}
			return $query_result;
		}

		public function mobileExist($mobile)
		{
			$result = $this->getWhere('users',"mobile='$mobile'");
			if($result != null){
				return true;
			}
			else{
				return false;
			}
		}
	}
?>