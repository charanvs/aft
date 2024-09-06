<?php 
	require dirname(__FILE__).'/../database/DataModel.php';
	
	class JudgementModel extends DataModel{

		public function __construct()
		{
			parent::__construct();
		}
    
        public function getJudgements($filterArray, $extraCondition = '', $action = '')
		{

			$sql = "select aft_judgement.*, dol, pdfname from aft_judgement, aft_disposedof, aft_interim_judgements where aft_judgement.regno=aft_disposedof.regno and aft_disposedof.regid=aft_interim_judgements.regid";

			
			if(!empty($action)){
				$filterCondition = $this->getCondition($filterArray);
			}
			else{
				$filterCondition = $this->getSearchCondition($filterArray);
			}

			if(!empty($filterCondition)){
				$sql .= ' AND '.$filterCondition;
			}
			
			$limitOrder = substr($extraCondition, 0,6);
			if($limitOrder == ' limit'){
				$sql .= $extraCondition;
			} 
			elseif($limitOrder == ' order'){
				$sql .= $extraCondition;
			}
			elseif(strlen($extraCondition) > 0){
				$sql .= ' AND '.$extraCondition;
			}
			//echo $sql.'</br></br>';
			//die();
			$results = $this->getQuery($sql);
			if($results != null){
				return $results;
			}
			else{
				return null;
			}
			return $results;
		}
		
		function getTotalJudgements($filterArray, $action = ""){
		    $sql = "select count(*) as total from aft_judgement, aft_disposedof, aft_interim_judgements where aft_judgement.regno=aft_disposedof.regno and aft_disposedof.regid=aft_interim_judgements.regid";
		    $$filterCondition = "";
		    if(!empty($action)){
				$filterCondition = $this->getCondition($filterArray);
			}
			else{
				$filterCondition = $this->getSearchCondition($filterArray);
			}

			if(!empty($filterCondition)){
				$sql .= ' AND '.$filterCondition;
			}
			
			//echo $sql;
			$results = $this->getQuery($sql);
			if($results != null){
				return $results[0]["total"];
			}
			else{
				return 0;
			}
			return $results;
		}
	}
?>