<?php 
	// define('url', 'https://aftpb.org/aft/');
	define('url', 'http://localhost/aft/');


	if(session_id() == ''){
		session_start();
		session_regenerate_id();
	}

	function setAlert($alert)
	{
		$_SESSION['alert'] = $alert;
	}

	function getAlert()
	{
		$alert = null;
		if(isset($_SESSION['alert'])){
			$alert = $_SESSION['alert'];
			unset($_SESSION['alert']);
		}
		return $alert;
	}

	function setAlertMessage($message, $flag){
		$_SESSION['message'] = $message;
		$_SESSION['flag'] = $flag;
	}

	function getAlertMessage(){
		if(isset($_SESSION['message'])){
			$message = $_SESSION['message'];
			$flag = $_SESSION['flag'];
			unset($_SESSION['message']);
			unset($_SESSION['flag']);
			$msg = '';

			if($flag == true){ // show error message..
				$msg = '<div class="col-md-12 px-0"><div class="alert alert-danger alert-dismissible my-alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Error! </strong>'.$message.'</div></div>';
			}
			else{
				$msg = '<div class="col-md-12 px-0"><div class="alert alert-success alert-dismissible my-alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Success! </strong>'.$message.'</div></div>';
			}
			echo $msg;
			echo '<script>setTimeout(function(){$(".my-alert").slideUp()},3000);</script>';
		}
	}

	function setLocation($location){
	    $abc = url.$location;
	    echo "<script>window.location.href='".$abc."'</script>";
	}
	
	function setSessionValue($key,$message){
		$_SESSION[$key] = $message;
	}

	function getSessionValue($key){
		$msg = '';
		if(isset($_SESSION[$key])){
			$msg = $_SESSION[$key];
			unset($_SESSION[$key]);
		}
		return $msg;
	}

	function removeSessionValue($key){
		if(isset($_SESSION['$key'])){
			unset($_SESSION[$key]);
		}
	}

	function setSessionData($data){
		foreach($data as $key => $value){
			$_SESSION['f_'.$key] = $value;
		}
	}

	function getSessionData($key){
		$msg = '';
		if(isset($_SESSION['f_'.$key])){
			$msg = $_SESSION['f_'.$key];
			unset($_SESSION['f_'.$key]);
		}
		return $msg;	
	}

	function removeSessionData($data){
		foreach($data as $key => $value){
			if(isset($_SESSION['f_'.$key])){
				unset($_SESSION['f_'.$key]);
			}
		}
	}
	
 ?>