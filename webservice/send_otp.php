<?php
	header("Content-type: application/json");
	include("connect.php");
	
	require_once 'Twilio/autoload.php';
	use Twilio\Rest\Client;

	$account_sid = 'AC22804b80866745cf56e1c7cc469da300'; 
	$auth_token = '40f104749b1268308496dd9065bd3300';
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['phone_number'] != '' && $_REQUEST['country_code'] != ''  && $_REQUEST['country_code'] > 0)
	{
		
			$check_customer_mobile = mysqli_query($db,"select id,phone_number from user where phone_number='".$_REQUEST['phone_number']."' and country_code = '".$_REQUEST['country_code']."'  && id='".$_REQUEST['user_id']."' ") or die(mysqli_error($db));
		
		
		if(mysqli_num_rows($check_customer_mobile) > 0)
		{	
			$characters = '0123456789';
			$random_string_length = 5;
			$otp = '';
			$max = strlen($characters) - 1;
			
			for ($i = 0; $i < $random_string_length; $i++) 
			{
				 $otp .= $characters[mt_rand(0, $max)];
			}
		
			$insert_query = "update user set 					
					otp_code='".$otp."'
					where 
					id = '".$_REQUEST['user_id']."'	";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					
					$phone = "+".$_REQUEST['phone_number'];
					$client = new Client($account_sid, $auth_token); 
					$text = 'Your Tikers Account Verification Code is: '.$otp.'.';
					$messages = $client->messages->create($phone, array( 
						'From' => '+19383003902',
						'Body' => $text
					));
					
					$error = "OTP Send Successfully";
					$result=array('message'=> $error, 'result'=>'1','user_id'=>$_REQUEST['user_id'],'otp_code'=>$otp,'is_verified'=>'0');
			
		}		
		else
		{
			$message = "User with the specified phone number already exists.";
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