<?php
	header("Content-type: application/json");
	include("connect.php");

	if($_REQUEST['type'] != '' && $_REQUEST['type'] == 'email' && $_REQUEST['email'] != ''){
		$check_customer_email = mysql_query("select id,email from user where email='".$_REQUEST['email']."' ") or die(mysql_error());	
		if(mysql_num_rows($check_customer_email) > 0){
			$message = "User with the specified email already exists.";
			$result=array('message'=> $message, 'result'=>'0');	
		}
		else{
			$message = "User with the specified email is not exists.";
			$result=array('message'=> $message, 'result'=>'1');	
		}
			
	}
	else if($_REQUEST['type'] != '' && $_REQUEST['type'] == 'phone' && $_REQUEST['phone'] != ''){
		$check_customer_mobile = mysql_query("select id,phone_number from user where phone_number='".$_REQUEST['phone']."' ") or die(mysql_error());		
		if(mysql_num_rows($check_customer_mobile) > 0){
			$message = "User with the specified phone number already exists.";
			$result=array('message'=> $message, 'result'=>'0');	
		}
		else{
			$message = "User with the specified phone number is not exists.";
			$result=array('message'=> $message, 'result'=>'1');	
		}
	}
	else if($_REQUEST['type'] != '' && $_REQUEST['type'] == 'user' && $_REQUEST['user'] != ''){
		$check_customer_username = mysql_query("select id,username from user where username='".$_REQUEST['user']."' ") or die(mysql_error());		
		if(mysql_num_rows($check_customer_username) > 0){
			$message = "User with the specified name already exists.";
			$result=array('message'=> $message, 'result'=>'0');	
		}
		else{
			$message = "User with the specified name is not exists.";
			$result=array('message'=> $message, 'result'=>'1');	
		}
	}
	else{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	

	$result=json_encode($result);
	echo $result;
	
?>