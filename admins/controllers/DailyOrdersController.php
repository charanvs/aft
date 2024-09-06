<?php 
	require dirname(__FILE__).'/../../config/route.php';
	require dirname(__FILE__).'/../models/DailyOrdersModel.php';
	
	$obj = new DailyOrdersController();
    $method = $_REQUEST['action'];
    if(is_callable([$obj, $method])){
    	$obj->$method();
    }
    else{
    	setLocation('admins/404.php');	 
    }
	class DailyOrdersController {

		private $model;

		public function __construct()
		{
			$this->model = new DailyOrdersModel();
		}

		public function index()
		{
			$courtno = '';
		      if(isset($_GET['courtno'])){
		        $courtno = $_GET['courtno'];
		        $_SESSION['courtno'] = $courtno;
		      }
		      elseif(isset($_SESSION['courtno'])){
		        $courtno = $_SESSION['courtno'];
		      }

		      $registration_no = '';
		      if(isset($_GET['registration_no'])){
		        $registration_no = $_GET['registration_no'];
		        $_SESSION['registration_no'] = $registration_no;
		      }
		      elseif(isset($_SESSION['registration_no'])){
		        $registration_no = $_SESSION['registration_no'];
		      }

		      $applicant = '';
		      if(isset($_GET['applicant'])){
		        $applicant = $_GET['applicant'];
		        $_SESSION['applicant'] = $applicant;
		      }
		      elseif(isset($_SESSION['applicant'])){
		        $applicant = $_SESSION['applicant'];
		      }

		      $filterData['courtno'] = $courtno;
		      $filterData['registration_no'] = $registration_no;
		      $filterData['applicant'] = $applicant;

		      $record_per_page = 10;
		      if(isset($_GET['record_per_page'])){
		        $record_per_page = $_GET['record_per_page'];
		      }
		      $startPage = $this->model->page($record_per_page);

		      $search = '';
		      $totalRecords = 0;
		      if(isset($_GET['search'])){
		        $search = $_GET['search'];
		        $searchData['registration_no'] = $search;
		        $searchData['courtno'] = $search;
		        $searchData['applicant'] = $search;
		        $results = $this->model->search('aft_hkt_dailyorders',$searchData ," limit $startPage, $record_per_page");
		        if($results != null){
		          $totalRecords = count($this->model->search('aft_hkt_dailyorders',$searchData));
		        }
		      }
		      else{
		        $results = $this->model->getFilter('aft_hkt_dailyorders',$filterData, " limit $startPage, $record_per_page");
		        if($results != null){
		          $totalRecords = count($this->model->getFilter('aft_hkt_dailyorders',$filterData));
		        }
		      }
			include('../views/header.php');
			include('../views/dailyorders/index.php');
			include('../views/footer.php');
		}
	}
?>