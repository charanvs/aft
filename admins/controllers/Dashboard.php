<?php 
	require dirname(__FILE__).'/../../config/route.php';
	require dirname(__FILE__).'/../models/DashboardModel.php';
	
	$obj = new Dashboard();
    $method = $_REQUEST['action'];
    if(is_callable([$obj, $method])){
    	$obj->$method();
    }
    else{
    	setLocation('admins/404.php');	 
    }
	class Dashboard {

		private $model;

		public function __construct()
		{
			$this->model = new DashboardModel();
		}

		public function dashboard()
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');
			
			include('../views/header.php');
			include('../views/dashboard.php');
			include('../views/footer.php');
		}
	}
 ?>