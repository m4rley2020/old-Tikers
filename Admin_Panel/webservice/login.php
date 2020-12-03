<?php
	header("Content-type: application/json");
	include("connect.php");
	
	
			 
	if($_REQUEST['user_login'] != '' && $_REQUEST['password'] != '')
	{	
		$check_customer_mobile = mysql_query("select * from user where 
		(email='".$_REQUEST['user_login']."' or
		phone_number='".$_REQUEST['user_login']."' or
		username='".$_REQUEST['user_login']."')
		and password='".$_REQUEST['password']."' ") or die(mysql_error());		
		
		if(mysql_num_rows($check_customer_mobile) > 0)
		{
			$row = mysql_fetch_array($check_customer_mobile);
			
				if($row['profile_image'] != "")
				{
					$profile_image = $SITE_URL."/User_image/".$row['profile_image'];
				}
				else
				{
					$profile_image = "";
				}
				
				if($row['user_type'] == "Store")
				{
					$get_store_detail = mysql_query("select id,store_type_id,name,boost_code from store where user_id = '".$row['id']."' ");
					if(mysql_num_rows($get_store_detail) > 0){
						$store_data = mysql_fetch_array($get_store_detail);
						$store_type_id = $store_data['store_type_id'];
						$store_id = $store_data['id'];
						$store_name = $store_data['name'];
						$boost_code = $store_data['boost_code'];
					}
					else{
						$store_type_id = "";
						$store_id = "";
						$store_name = "";
						$boost_code = "";
					}
				}
				else
				{
					$store_type_id = "";
					$store_id = "";
					$store_name = "";
					$boost_code = "";
				}
				
				$data = array(
				'user_id' => $row['id'],
				'email' => $row['email'],
				'phone_number' => $row['phone_number'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'username' => $row['username'],
				'password' => $row['password'],			
				'profile_image' => $profile_image,
				'is_verified' => $row['is_verified'],
				'user_type' => $row['user_type'],
				'store_id' => $store_id,
				'store_name'=>$store_name,
				'store_type_id' => $store_type_id,
				'boost_code'=>$boost_code,
				'country_code' => $row['country_code'],
				'register_type' => $row['register_type'],
				'is_private' => $row['is_private'],
				'add_date' => $row['add_date'],
				
				); 
				$message="Login Successful";
				$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);			
		}		
		else
		{
			$message = "Login failed please enter correct login detail.";
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