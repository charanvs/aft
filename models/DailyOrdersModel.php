<?php 
	require dirname(__FILE__).'/../database/DataModel.php';
	
	class DailyOrdersModel extends DataModel{

		public function __construct()
		{
			parent::__construct();
		}

		public function getOrderFilter2($filterArray, $extraCondition = '', $action = '')
		{
		    $flag = false;
            if($action == 'total'){
                $sql = "SELECT count(*) as total "; 
                $flag = true;
            }
            else{
                $sql = "SELECT aft_registration.*,aft_interim_judgements.dol as interim_dol, pdfname, aft_case_type.name as case_type_name, aft_dol_dependency.courtno "; 
            }
			$sql .= "from aft_interim_judgements, aft_registration, aft_dol_dependency, aft_case_type "; 
			$sql .= "WHERE ";
            $sql .= "aft_interim_judgements.regid=aft_registration.id and "; 
            $sql .= "aft_dol_dependency.regid=aft_registration.id and ";
            $sql .= "aft_interim_judgements.dol=aft_dol_dependency.dol and ";
            $sql .= "aft_registration.case_type=aft_case_type.id "; 

			
			$filterCondition = $this->getCondition($filterArray);

			if(!empty($filterCondition)){
				$sql .= ' AND '.$filterCondition;
				
				if(strpos($filterCondition, 'courtno') === false){
                    $sql .= ' and aft_dol_dependency.courtno != 0';
                } 
			}
			elseif($flag){
			    //$temp = [];
			    //$temp = array('total' => 0);
			    //return $temp;
			    return null;
			}
			
			if(!empty($extraCondition)){
			    $sql .= $extraCondition;
			}
			
			
			//echo $sql;
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
		
		public function getOrderFilter($filterArray, $extraCondition = '', $action = '')
		{

			$sql = "SELECT aft_judgement.*,  dol, pdfname FROM aft_interim_judgements, aft_judgement WHERE aft_interim_judgements.regid=aft_judgement.id ";

			
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
// 			echo $sql;
// 			die();
            console.log($sql);
			$results = $this->getQuery($sql);
			if($results != null){
				return $results;
			}
			else{
				return null;
			}
			return $results;
		}
	}
?>