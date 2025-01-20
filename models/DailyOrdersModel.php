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

    // Select columns based on the action
    if ($action == 'total') {
        $sql = "SELECT count(*) as total ";
        $flag = true;
    } else {
        $sql = "SELECT 
                    aft_registration.*,
                    aft_interim_judgements.dol as interim_dol,
                    pdfname,
                    aft_case_type.name as case_type_name,
                    aft_dol_dependency.courtno,
                    aft_registration.applicant,
                    aft_registration.respondent,
                    aft_registration.padvocate,
                    aft_registration.radvocate ";
    }

    // Base query
    $sql .= "FROM 
                aft_interim_judgements, 
                aft_registration, 
                aft_dol_dependency, 
                aft_case_type ";
    $sql .= "WHERE 
                aft_interim_judgements.regid = aft_registration.id AND 
                aft_dol_dependency.regid = aft_registration.id AND 
                aft_interim_judgements.dol = aft_dol_dependency.dol AND 
                aft_registration.case_type = aft_case_type.id ";

    // Get additional filter conditions
    $filterCondition = $this->getCondition($filterArray);

    if (!empty($filterCondition)) {
        $sql .= ' AND ' . $filterCondition;

        // Ensure courtno is not 0 unless already specified
        if (strpos($filterCondition, 'courtno') === false) {
            $sql .= ' AND aft_dol_dependency.courtno != 0';
        }
    } elseif ($flag) {
        return null; // If no conditions and 'total' action, return null
    }

    // Append extra conditions if provided
    if (!empty($extraCondition)) {
        $sql .= $extraCondition;
    }

    // Execute the query
    $results = $this->getQuery($sql);
    return $results ?: null;
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