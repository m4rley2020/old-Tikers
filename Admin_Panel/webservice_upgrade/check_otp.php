<?php
	header("Content-type: application/json");
	include("connect.php");
	
	//require_once 'Twilio/autoload.php';
	//use Twilio\Rest\Client;

	//$account_sid = 'ACabd012958cf094f9290513f0e953004b'; 
	//$auth_token = 'b84c6bae4f6d228973962984a3b199e6';
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['otp_code'] != '')
	{
		
		$check_customer = mysqli_query($db,"select id,otp_code from user where id='".$_REQUEST['user_id']."' ") or die(mysqli_error($db));
		
		
		if(mysqli_num_rows($check_customer) > 0)
		{	
			$check_customer_date = mysqli_fetch_array($check_customer);
			
			if($check_customer_date['otp_code'] == $_REQUEST['otp_code'])
			{
				$insert_query = "update user set 					
					is_verified='1'
					where 
					id = '".$_REQUEST['user_id']."'	";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					
					
					
				$error = "Account Verified Successfully";
				$result=array('message'=> $error, 'result'=>'1','user_id'=>$_REQUEST['user_id'],'is_verified'=>'1');
			}
			else
			{
				$message = "OTP Code is not correct.";
				$result=array('message'=> $message, 'result'=>'0');
			}
		}		
		else
		{
			$message = "User not found.";
			$result=array('message'=> $message, 'result'=>'0');
		}
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>