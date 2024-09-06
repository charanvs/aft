<?php 
	require dirname(__FILE__).'/../../config/route.php';
	require dirname(__FILE__).'/../models/DiaryModel.php';
	
	$obj = new DiaryController();
    $method = $_REQUEST['action'];
    if(is_callable([$obj, $method])){
    	$obj->$method();
    }
    else{
    	setLocation('admins/404.php');	 
    }
	class DiaryController {

		private $model;

		public function __construct()
		{
			$this->model = new DiaryModel();
		}

		public function index()
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');

			  $diary_no = '';
		      if(isset($_GET['diary_no'])){
		        $diary_no = $_GET['diary_no'];
		        $_SESSION['diary_no'] = $diary_no;
		      }
		      elseif(isset($_SESSION['diary_no'])){
		        $diary_no = $_SESSION['diary_no'];
		      }

		      $nature_of_doc = '';
		      if(isset($_GET['nature_of_doc'])){
		        $nature_of_doc = $_GET['nature_of_doc'];
		        $_SESSION['nature_of_doc'] = $nature_of_doc;
		      }
		      elseif(isset($_SESSION['nature_of_doc'])){
		        $nature_of_doc = $_SESSION['nature_of_doc'];
		      }

		      $file_no = '';
		      if(isset($_GET['presented_by'])){
		        $presented_by = $_GET['presented_by'];
		        $_SESSION['presented_by'] = $presented_by;
		      }
		      elseif(isset($_SESSION['presented_by'])){
		        $presented_by = $_SESSION['presented_by'];
		      }


		      $filterData['diary_no'] = $diary_no;
		      $filterData['nature_of_doc'] = $nature_of_doc;
		      $filterData['presented_by'] = $presented_by;

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