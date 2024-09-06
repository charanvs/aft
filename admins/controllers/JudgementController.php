<?php 
	require dirname(__FILE__).'/../../config/route.php';
	require dirname(__FILE__).'/../models/JudgementModel.php';
	
	$obj = new JudgementController();
    $method = $_REQUEST['action'];
    if(is_callable([$obj, $method])){
    	$obj->$method();
    }
    else{
    	setLocation('admins/404.php');	 
    }
	class JudgementController {

		private $model;

		public function __construct()
		{
			$this->model = new JudgementModel();
		}

		public function index()
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');

			  $year = '';
		      if(isset($_GET['year'])){
		        $year = $_GET['year'];
		        $_SESSION['year'] = $year;
		      }
		      elseif(isset($_SESSION['year'])){
		        $year = $_SESSION['year'];
		      }

		      $case_type = '';
		      if(isset($_GET['case_type'])){
		        $case_type = $_GET['case_type'];
		        $_SESSION['case_type'] = $case_type;
		      }
		      elseif(isset($_SESSION['case_type'])){
		        $case_type = $_SESSION['case_type'];
		      }

		      $file_no = '';
		      if(isset($_GET['file_no'])){
		        $file_no = $_GET['file_no'];
		        $_SESSION['file_no'] = $file_no;
		      }
		      elseif(isset($_SESSION['file_no'])){
		        $file_no = $_SESSION['file_no'];
		      }

		      $regno = '';
		      if(isset($_GET['regno'])){
		        $regno = $_GET['regno'];
		        $_SESSION['regno'] = $regno;
		      }
		      elseif(isset($_SESSION['regno'])){
		        $regno = $_SESSION['regno'];
		      }

		      $subject = '';
		      if(isset($_GET['subject'])){
		        $subject = $_GET['subject'];
		        $_SESSION['subject'] = $subject;
		      }
		      elseif(isset($_SESSION['subject'])){
		        $subject = $_SESSION['subject'];
		      }

		      $filterData['year'] = $year;
		      $filterData['case_type'] = $case_type;
		      $filterData['file_no'] = $file_no;
		      $filterData['regno'] = $regno;
		      $filterData['subject'] = $subject;

		      $record_per_page = 10;
		      if(isset($_GET['record_per_page'])){
		        $record_per_page = $_GET['record_per_page'];
		      }
		      $startPage = $this->model->page($record_per_page);

		      $search = '';
		      $totalRecords = 0;
		      if(isset($_GET['search'])){
		        $search = $_GET['search'];
		        $searchData['regno'] = $search;
		        $searchData['file_no'] = $search;
		        $searchData['subject'] = $search;
		        $searchData['petitioner'] = $search;
		        $searchData['respondent'] = $search;
		        $searchData['padvocate'] = $search;
		        $searchData['radvocate'] = $search;
		        $searchData['corum'] = $search;
		        $results = $this->model->search('aft_judgement',$searchData ," limit $startPage, $record_per_page");
		        if($results != null){
		          $totalRecords = count($this->model->search('aft_judgement',$searchData));
		        }
		      }
		      else{
		        $results = $this->model->getFilter('aft_judgement',$filterData, " limit $startPage, $record_per_page");
		        if($results != null){
		          $totalRecords = count($this->model->getFilter('aft_judgement',$filterData));
		        }
		      }
			
			include('../views/header.php');
			include('../views/judgements/index.php');
			include('../views/footer.php');
		}

		public function view() 
		{
		  	$id = $_GET['id'];
	      	$result = $this->model->getById('aft_judgement', 'id', $id);

	      	$regid = $result['id'];
	      	$interim_judgements = $this->model->getWhere('aft_interim_judgements', "regid='$regid'");

	      	$corunIds = $result['corum'];
	      	$aft_corums = null;
	      	if(!empty($corunIds)){
	        	$sql = 'select * from aft_corum where id in ('.$corunIds.')';
	        	$aft_corums = $this->model->getQuery('select * from aft_corum where id in ('.$corunIds.')');
	      	}

		    include('../views/header.php');
			include('../views/judgements/view.php');
			include('../views/footer.php');
		}
	}
 ?>