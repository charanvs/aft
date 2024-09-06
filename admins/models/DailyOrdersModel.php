<?php 
	require dirname(__FILE__).'/../../database/DataModel.php';	
	
	class DailyOrdersModel extends DataModel{

		public function __construct()
		{
			parent::__construct();
		}
	}
?>