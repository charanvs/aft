<?php 
	require dirname(__FILE__).'/../../config/route.php';
	require dirname(__FILE__).'/../models/UserModel.php';
	
	$obj = new User();
    $method = $_REQUEST['action'];
    if(is_callable([$obj, $method])){
    	$obj->$method();
    }
    else{
    	setLocation('admins/404.php');	 
    }

	class User {

		private $user;

		public function __construct()
		{
			$this->model = new UserModel();
		}

		public function users()
		{
			$delete_flag = 0;
			if(isset($_GET['delete_flag'])){
				$delete_flag = $_GET['delete_flag'];
			}
			$results = $this->model->getWhere('users', "is_deleted='$delete_flag'");
			include('../views/header.php');
			include('../views/users/users.php');
			include('../views/footer.php');
		}

		public function user()
		{
			$id = $_POST['id'];
			$results = $this->model->getById('users', 'id', $id);
			echo json_encode($results);
		}		

		public function userAdd()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');

			$data['name'] = $_POST['name'];
			$data['gender'] = $_POST['gender'];
			$data['dob'] = date('Y-m-d', strtotime($_POST['dob']));
			$data['mobile'] = $_POST['mobile'];
			$data['email'] = $_POST['email'];
			$data['qualification'] = $_POST['qualification'];
			$data['profession'] = $_POST['profession'];
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['remarks'] = $_POST['remarks'];
			$data['description'] = $_POST['description'];
			$data['is_active'] = 1;
			$data['created_at'] = $date;
			// echo "<pre>";
			// print_r($data);

			$response = $this->model->add('users', $data);
			if($response != null){
				setAlertMessage("User Successfully Added!", false);
			}		
			else{
				setAlertMessage('Something went wrong, try again!', true);
			}
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userUpdate()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');
		    $id = $_POST['id'];

		    $data['name'] = $_POST['name'];
			$data['gender'] = $_POST['gender'];
			$data['dob'] = date('Y-m-d', strtotime($_POST['dob']));
			$data['mobile'] = $_POST['mobile'];
			$data['email'] = $_POST['email'];
			$data['qualification'] = $_POST['qualification'];
			$data['profession'] = $_POST['profession'];
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['remarks'] = $_POST['remarks'];
			$data['description'] = $_POST['description'];
			$data['updated_at'] = $date;

			// echo "<pre>";
			// print_r($data);
					
			$response = $this->model->update('users', $data, "id='$id'");
			if($response != null){
				setAlertMessage("User Successfully Updated!", false);
			}		
			else{
				setAlertMessage('Something went wrong, try again!', true);
			}
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userDelete(){
			$id = $_GET['id'];
			$flag = $this->model->delete('users', "id='$id'");
			if($flag == true){
				$msg = "User Successfully Deleted!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userDeleteAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->delete('users', "id='$id'");
			}
			if($flag){
				$msg = "User successfully deleted!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userMoveToTrash(){
			$id = $_GET['id'];
			$flag = $this->model->update('users',array('is_deleted' => 1), "id='$id'");
			if($flag == true){
				$msg = "User Successfully Moved to Trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userMoveToTrashAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->update('users',array('is_deleted' => 1), "id='$id'");
			}
			if($flag){
				$msg = "User successfully move to trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userRestore(){
			$id = $_GET['id'];
			$flag = $this->model->update('users',array('is_deleted' => 0), "id='$id'");
			if($flag == true){
				$msg = "User Successfully Restored!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		public function userRestoreAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->update('users',array('is_deleted' => 0), "id='$id'");
			}
			if($flag){
				$msg = "User successfully move to trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}


		public function userActive()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');

			$id = $_GET['id'];
			$active = $_GET['active'];
			$response = $this->model->update('users', array('is_active' => $active, 'updated_at' => $date), "id='$id'");
			if($response == true){
				if($active == 1){
					$msg = "User successfully activated!";
				}
				else{
					$msg = "User successfully inactivated!";
				}
				$error = false;
			}
			else{
				$msg = "Something went wrong, try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=users');	
		}

		// public function add()
		// {
		// 	date_default_timezone_set("Asia/Calcutta");
		//     $date=date('Y-m-d H:i:s');

		// 	$data['name'] = $_POST['name'];
		// 	$data['mobile'] = $_POST['mobile'];
		// 	$data['email'] = $_POST['email'];
		// 	$data['username'] = $_POST['username'];
		// 	$data['password'] = $_POST['password'];
		// 	$data['is_active'] = 1;
		// 	$data['created_at'] = $date;
		// 	// echo "<pre>";
		// 	// print_r($data);

		// 	$response = $this->model->add('users', $data);
		// 	if($response != null){
		// 		setAlertMessage("User Successfully Added!", false);
		// 	}		
		// 	else{
		// 		setAlertMessage('Something went wrong, try again!', true);
		// 	}
		// 	setLocation('admins/controllers/User.php?action=listData');	
		// }

		// public function update()
		// {
		// 	date_default_timezone_set("Asia/Calcutta");
		//     $date=date('Y-m-d H:i:s');
		//     $id = $_POST['id'];
			
		// 	$data['name'] = $_POST['name'];
		// 	$data['mobile'] = $_POST['mobile'];
		// 	$data['email'] = $_POST['email'];
		// 	$data['password'] = $_POST['password'];
		// 	$data['updated_at'] = $date;

		// 	// echo "<pre>";
		// 	// print_r($data);
					
		// 	$response = $this->model->update('users', $data, "id='$id'");
		// 	if($response != null){
		// 		setAlertMessage("User Successfully Updated!", false);
		// 	}		
		// 	else{
		// 		setAlertMessage('Something went wrong, try again!', true);
		// 	}
		// 	setLocation('admins/controllers/User.php?action=listData');	
		// }

		// public function delete(){
		// 	$id = $_GET['id'];
		// 	$flag = $this->model->delete('users', "id='$id'");
		// 	if($flag == true){
		// 		$msg = "User Successfully Deleted!";
		// 		$error = false;
		// 	}
		// 	else{
		// 		$msg = "Something went wrong, please try again!";
		// 		$error = true;
		// 	}
		// 	setAlertMessage($msg, $error);
		// 	setLocation('admins/controllers/User.php?action=listData');	
		// }

		// public function active()
		// {
		// 	$id = $_GET['id'];
		// 	$active = $_GET['active'];
		// 	$response = $this->model->update('users', array('IsAlive' => $active), "id='$id'");
		// 	if($response == true){
		// 		if($active == 1){
		// 			$msg = "User successfully activated!";
		// 		}
		// 		else{
		// 			$msg = "User successfully inactivated!";
		// 		}
		// 		$error = false;
		// 	}
		// 	else{
		// 		$msg = "Something went wrong, try again!";
		// 		$error = true;
		// 	}
		// 	setAlertMessage($msg, $error);
		// 	setLocation('admins/controllers/User.php?action=listData');	
		// }

		// public function listData()
		// {
		// 	$results = $this->model->get("admins");
		// 	include('../views/header.php');
		// 	include('../views/users/user.php');
		// 	include('../views/footer.php');
		// }

		// public function getData()
		// {
		// 	$id = $_POST['id'];
		// 	$results = $this->model->getById('users', 'id', $id);
		// 	echo json_encode($results);
		// }

		public function roles()
		{
			$delete_flag = 0;
			if(isset($_GET['delete_flag'])){
				$delete_flag = $_GET['delete_flag'];
			}
			$results = $this->model->getWhere('roles', "is_deleted='$delete_flag'");
			include('../views/header.php');
			include('../views/users/roles.php');
			include('../views/footer.php');
		}

		public function role()
		{
			$id = $_POST['id'];
			$results = $this->model->getById('roles', 'id', $id);
			echo json_encode($results);
		}		

		public function roleAdd()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');

			$data['role_name'] = $_POST['role_name'];
			$data['description'] = $_POST['description'];
			$data['is_active'] = 1;
			$data['created_at'] = $date;
			// echo "<pre>";
			// print_r($data);

			$response = $this->model->add('roles', $data);
			if($response != null){
				setAlertMessage("User Successfully Added!", false);
			}		
			else{
				setAlertMessage('Something went wrong, try again!', true);
			}
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleUpdate()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');
		    $id = $_POST['id'];

		    $data['role_name'] = $_POST['role_name'];
			$data['description'] = $_POST['description'];
			$data['updated_at'] = $date;

			// echo "<pre>";
			// print_r($data);
					
			$response = $this->model->update('roles', $data, "id='$id'");
			if($response != null){
				setAlertMessage("Role Successfully Updated!", false);
			}		
			else{
				setAlertMessage('Something went wrong, try again!', true);
			}
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleDelete(){
			$id = $_GET['id'];
			$flag = $this->model->delete('roles', "id='$id'");
			if($flag == true){
				$msg = "Role Successfully Deleted!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleDeleteAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->delete('roles', "id='$id'");
			}
			if($flag){
				$msg = "Role successfully deleted!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleMoveToTrash(){
			$id = $_GET['id'];
			$flag = $this->model->update('roles',array('is_deleted' => 1), "id='$id'");
			if($flag == true){
				$msg = "Role Successfully Moved to Trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleMoveToTrashAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->update('roles',array('is_deleted' => 1), "id='$id'");
			}
			if($flag){
				$msg = "Role successfully move to trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleRestore(){
			$id = $_GET['id'];
			$flag = $this->model->update('roles',array('is_deleted' => 0), "id='$id'");
			if($flag == true){
				$msg = "Role Successfully Restored!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function roleRestoreAll(){
			$flag = false;
			$author = explode(',',$_GET['id']);
			for($i = 0; $i < count($author); $i++){
				$id = $author[$i];
				$flag = $this->model->update('roles',array('is_deleted' => 0), "id='$id'");
			}
			if($flag){
				$msg = "Role successfully move to trash!";
				$error = false;
			}
			else{
				$msg = "Something went wrong, Please try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}


		public function roleActive()
		{
			date_default_timezone_set("Asia/Calcutta");
		    $date=date('Y-m-d H:i:s');

			$id = $_GET['id'];
			$active = $_GET['active'];
			$response = $this->model->update('roles', array('is_active' => $active, 'updated_at' => $date), "id='$id'");
			if($response == true){
				if($active == 1){
					$msg = "Role successfully activated!";
				}
				else{
					$msg = "Role successfully inactivated!";
				}
				$error = false;
			}
			else{
				$msg = "Something went wrong, try again!";
				$error = true;
			}
			setAlertMessage($msg, $error);
			setLocation('admins/controllers/User.php?action=roles');	
		}

		public function login()
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(!empty($username) && !empty($password)){
				// $response = $this->model->login($username, $password);
				// if($response != null){
				// 	$_SESSION['admin_id'] = $response['id'];
				// 	$_SESSION['is_logged'] = 1;
				// 	$_SESSION['username'] = $response['name'];
				// 	setLocation('admins/controllers/Dashboard.php?action=dashboard');
				// }
				// else{
				// 	setAlertMessage('Wrong Username and Password,<br>Please try again!', true);
				// 	setLocation('admins/index.php');
				// }

				$_SESSION['admin_id'] = 1;
				$_SESSION['is_logged'] = 1;
				$_SESSION['username'] = 'SuperAdmin';
				setLocation('admins/controllers/Dashboard.php?action=dashboard');
			}
			else{
				setAlertMessage('Username and Password must be entered, Please try again!', true);
				setLocation('admins/index.php');
			}
		}

		public function logout()
		{
			//session_start();
			session_destroy();
			setLocation('/');
		}

		public function test()
		{
			echo "Testing OK!";
		}
	}
 ?>