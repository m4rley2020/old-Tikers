<?php
	header('Content-type: application/json');
	include('connect.php');
	// require_once 'Twilio/autoload.php';
	// use Twilio\Rest\Client;
		
	
	$email=addslashes(trim($_REQUEST['email']));
	$facebook_id = addslashes(trim($_REQUEST['fb_id']));
	$facebook_access_token = addslashes(trim($_REQUEST['fb_token']));
	$username=addslashes(trim($_REQUEST['username']));
	$first_name=addslashes(trim($_REQUEST['first_name']));		
	$last_name=addslashes(trim($_REQUEST['last_name']));		
	$phone_number=addslashes(trim($_REQUEST['phone_number']));
	$profile_image = $_REQUEST['profile_image'];
	$register_type = $_REQUEST['register_type'];
	
	
	function get_facebook_user_avatar($fbId)
	{
		$json = file_get_contents('https://graph.facebook.com/v2.5/'.$fbId.'/picture?type=large&redirect=false');
		$picture = json_decode($json, true);
		return $picture['data']['url'];
	}

	if($facebook_access_token!="" && $facebook_id!="")
	{
		$fb_id=GetValue("user","fb_id","fb_id",$facebook_id);
		$fb_token=GetValue("user","fb_token","fb_token",$facebook_access_token);
		$mobile_no1=GetValue("user","phone_number","phone_number",$phone_number);
		if($email!="") 
		{ 
			$email_id = GetValue("user","email","email",$email); 
		}
		
		if($fb_id!="" || $fb_token!="" || $email_id!="" || $mobile_no1!="")
		{
			if($fb_id!='')			
			{	
				$iid=GetValue("user","id","fb_id",$fb_id);			
			}
			else if($fb_token!='')	
			{	
				$iid=GetValue("user","id","fb_token",$fb_token);	
			}
			else if($email_id!='')	
			{	
				$iid=GetValue("user","id","email",$email_id);		
			}
			else if($mobile_no1!='')
			{	
				$iid=GetValue("user","id","phone_number",$phone_number);	
			}
			
			$friend_image = get_facebook_user_avatar($facebook_id);

			$update_query =	"update user set 
			fb_token = '".$facebook_access_token."' ,
			fb_id = '".$facebook_id."',
			username='".$username."',
			first_name = '".$first_name."',
			last_name = '".$last_name."',			
			profile_image='".$profile_image."',			 
			email='".$email."',  
			phone_number ='".$phone_number."',
			register_type = '".$register_type."'
			where id = '".$iid."' limit 1";
			
			
			
			$update_result	= mysql_query($update_query);
						
			$select_user = "select * from user where id=$iid";
			$result_user = mysql_query($select_user) or die(mysql_error());
			$total_user = mysql_num_rows($result_user);
			$row = mysql_fetch_assoc($result_user);
			
			if($row['user_type'] == "Store")
			{
				$store_type_id = GetValue("store","store_type_id","user_id",$row['id']);
				$store_id = GetValue("store","id","user_id",$row['id']);
				$store_name = GetValue("store","name","user_id",$row['id']);
			}
			else
			{
				$store_type_id = "";
				$store_id = "";
				$store_name = "";
			}
			
			$result['result']="1";
			$Message="Login Successfull";
			$result['message']=$Message;
			$result['responseData'] = array(
				"user_id"=>$row['id'],
				"email"=>stripslashes($row['email']),
				"username"=>stripslashes($row['username']),
				"first_name"=>stripslashes($row['first_name']),
				"last_name"=>stripslashes($row['last_name']),				
				"phone_number"=>stripslashes($row['phone_number']),								
				"fb_id"=>stripslashes($row['fb_id']),
				"fb_token"=>stripslashes($row['fb_token']),				
				"profile_image"=>stripslashes($row['profile_image']),
				"user_type"=>stripslashes($row['user_type']),
				"is_private"=>stripslashes($row['is_private']),
				"is_verified"=>stripslashes($row['is_verified']),
				"store_id"=>$store_id,
				"store_name"=>$store_name,
				"store_type_id"=>$store_type_id,
				"country_code"=>stripslashes($row['country_code']),
				"register_type" =>stripslashes($row['register_type']),
				"add_date" => $row['add_date'],
			);
		}
		else
		{
			$add_date=date('Y-m-d H:i:s');
			
			$friend_image = get_facebook_user_avatar($facebook_id);

			$insert_query	= "insert into user set email='".$email."', fb_id='".$facebook_id."', fb_token='".$facebook_access_token."',username='".$username."',first_name = '".$first_name."', last_name = '".$last_name."', phone_number='".$phone_number."', profile_image='".$profile_image."', is_verified='0', user_type = 'User', register_type = '".$register_type."', add_date=now()";
								
			$insert_result = mysql_query($insert_query) or die(mysql_error());
			$last_inserted_id =	mysql_insert_id();
			
			if($last_inserted_id > 0)
			{
				
				$select_user = "select * from user where id=$last_inserted_id";
				$result_user = mysql_query($select_user) or die(mysql_error());
				$total_user = mysql_num_rows($result_user);
				$row = mysql_fetch_assoc($result_user);
				
				if($row['user_type'] == "Store")
				{
					$store_type_id = GetValue("store","store_type_id","user_id",$row['id']);
					$store_id = GetValue("store","id","user_id",$row['id']);
					$store_name = GetValue("store","name","user_id",$row['id']);
				}
				else
				{
					$store_type_id = "";
					$store_id = "";
					$store_name = "";
				}
				
				$result['result']="1";
				$Message = "User Registered Successfully";
				$result['message']=$Message;
				$result['responseData'] = array(
				"user_id"=>$row['id'],
				"email"=>stripslashes($row['email']),
				"username"=>stripslashes($row['username']),
				"first_name"=>stripslashes($row['first_name']),
				"last_name"=>stripslashes($row['last_name']),				
				"phone_number"=>stripslashes($row['phone_number']),								
				"fb_id"=>stripslashes($row['fb_id']),
				"fb_token"=>stripslashes($row['fb_token']),				
				"profile_image"=>stripslashes($row['profile_image']),
				"user_type"=>stripslashes($row['user_type']),
				"is_private"=>stripslashes($row['is_private']),
				"is_verified"=>stripslashes($row['is_verified']),
				"store_id"=>$store_id,
				"store_name"=>$store_name,
				"store_type_id"=>$store_type_id,
				"country_code"=>stripslashes($row['country_code']),
				"register_type" =>stripslashes($row['register_type']),
				"add_date" => $row['add_date']
				);
			}
			else
			{
				$result["result"]="0";
				$error = "User Not Registered";
				$result["message"]=$error;
			}
		}
	}
	else
	{
		$result["result"]="0";
		$error = "Please pass valid facebook access token and valid facebook id.";
		$result["message"]=$error;
	}
	$result=json_encode($result);
	echo $result;
?>