<?php
	header("Content-type: application/json");
	include("connect.php");
	
	function randomPassword() 
	{
    	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    	$pass = array(); //remember to declare $pass as an array
    	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    
    	for ($i = 0; $i < 8; $i++)
    	{
        	$n = rand(0, $alphaLength);
        	$pass[] = $alphabet[$n];
    	}
    	return implode($pass); //turn the array into a string
	}
	
	if($_REQUEST['email'] != '')
	{
		$check_customer_mobile = mysql_query("select * from user where email='".$_REQUEST['email']."' ") or die(mysql_error());		
		
		if(mysql_num_rows($check_customer_mobile) > 0)
		{
			$check_customer_row = mysql_fetch_array($check_customer_mobile);
			$new_pass = randomPassword();
			
			
			$update_customer = mysql_query("update user set password = '".$new_pass."' where email='".$_REQUEST['email']."' ") or die(mysql_error());	
			
			$subject = "AME - Forgot Password";
			
			
			$message=	file_get_contents('forgot_password_template.php');
			$message= str_replace(array('[[SITE_URL]]','[[name]]','[[password]]'),array($SITE_URL,$check_customer_row['username'],$new_pass),$message);
			
			
			$to1 = $_REQUEST['email'];
			$from1 = 'admin@ame.com';
			SendHTMLMail1($to1,$subject,$message,$from1,$cc="");
			
			$message="New Password is sent to your registered email address.";			
			$result=array('message'=> $message, 'result'=>'1');
			
			
		}		
		else
		{
			$message = "This email address is not registered.";
			$result=array('message'=> $message, 'result'=>'0');
			
		}
	}
	else
	{
		
		$error = "Please enter all required fields";
		$result=array('message'=> $message, 'result'=>'0');
		
	}	
	
	$result=json_encode($result);
	echo $result;
?>