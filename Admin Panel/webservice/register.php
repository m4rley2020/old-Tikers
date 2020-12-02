<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['type'] != '' && $_REQUEST['type'] == 'email'){
		if($_REQUEST['email'] != "" && $_REQUEST['username'] != "" && $_REQUEST['password'] != "" && $_REQUEST['longitude'] != "" && $_REQUEST['latitude'] != "")
		{
			$check_customer_email = mysql_query("select id,email from user where email='".$_REQUEST['email']."' and username = '".$_REQUEST['username']."' ") or die(mysql_error());	
			if(mysql_num_rows($check_customer_email) > 0)
			{
				$message = "User with the specified email or username already exists.";
				$result=array('message'=> $message, 'result'=>'0');	
			}	
			else{
				$insert_query = "insert into user set 					
					email='".$_REQUEST['email']."',
					username='".$_REQUEST['username']."',
					password='".$_REQUEST['password']."',
					user_type = 'User',
					is_verified	= '0',
					register_type = '".$_REQUEST['type']."',
					longitude = '".$_REQUEST['longitude']."',
					latitude = '".$_REQUEST['latitude']."',
					add_date=NOW()";
					mysql_query($insert_query)or die(mysql_error());
					$user_id = mysql_insert_id();
					
					$error = "Account Registered Successfully";
					$result=array(
						'message'=> $error,
						'result'=>'1',
						'user_id'=>$user_id,
						'email'=>$_REQUEST['email'],
						'username'=>$_REQUEST['username'],
						'password'=>$_REQUEST['password'],
						'is_verified'=>'0',
						'user_type'=>'User',
						'register_type'=>$_REQUEST['type'],
						'is_private'=> '0');
				
			}
			
		}
		else
		{
			$error = "Please enter all required fields";
			$result=array('message'=> $error, 'result'=>'0');
		}	
	}
	else if($_REQUEST['type'] != '' && $_REQUEST['type'] == 'phone'){
		if($_REQUEST['phone_number'] != "" && $_REQUEST['country_code'] != '' && $_REQUEST['username'] != "" && $_REQUEST['password'] != "" && $_REQUEST['longitude'] != "" && $_REQUEST['latitude'] != "")
		{
			$check_customer_mobile = mysql_query("select id,email from user where email='".$_REQUEST['phone_number']."' and country_code = '".$_REQUEST['country_code']."' and username = '".$_REQUEST['username']."' ") or die(mysql_error());	
			if(mysql_num_rows($check_customer_mobile) > 0)
			{
				$message = "User with the specified phone number or username already exists.";
				$result=array('message'=> $message, 'result'=>'0');	
			}	
			else{
				$insert_query = "insert into user set 					
					phone_number='".$_REQUEST['phone_number']."',
					country_code='".$_REQUEST['country_code']."',
					username='".$_REQUEST['username']."',
					password='".$_REQUEST['password']."',
					user_type = 'User',
					is_verified	= '0',
					register_type = '".$_REQUEST['type']."',
					longitude = '".$_REQUEST['longitude']."',
					latitude = '".$_REQUEST['latitude']."',
					add_date=NOW()";
					mysql_query($insert_query)or die(mysql_error());
					$user_id = mysql_insert_id();
					
					$error = "Account Registered Successfully";
					$result=array(
						'message'=> $error,
						'result'=>'1',
						'user_id'=>$user_id,
						'phone_number'=>$_REQUEST['phone_number'],
						'country_code'=>$_REQUEST['country_code'],
						'username'=>$_REQUEST['username'],
						'password'=>$_REQUEST['password'],
						'is_verified'=>'0',
						'user_type'=>'User',
						'register_type'=>$_REQUEST['type'],
						'is_private'=> '0');
				
			}
			
		}
		else
		{
			$error = "Please enter all required fields";
			$result=array('message'=> $error, 'result'=>'0');
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