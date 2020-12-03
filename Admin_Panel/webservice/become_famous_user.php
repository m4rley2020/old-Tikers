<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['is_famous'] != '' && $_REQUEST['social_media_type'] != '' && $_REQUEST['social_media_name'] != '')
	{
		$check_customer_username = mysql_query("SELECT * FROM `user` WHERE id = '".$_REQUEST['user_id']."' ") or die(mysql_error());	
		if(mysql_num_rows($check_customer_username) > 0)
		{
			
			$check_is_store = mysql_query("select id from store where user_id='".$_REQUEST['user_id']."' and is_Store_req = '1' ") or die(mysql_error());
			if(mysql_num_rows($check_is_store) > 0)
			{
				$message = "User has already requested for Store account.";
				$result=array('message'=> $message, 'result'=>'0');
			}
			else
			{
				//$update_query = "update user set user_type = 'Famous' where id = '".$_REQUEST['user_id']."' ";
				$update_query = "update user set is_Famous_Req = '1', social_media_type = '".$_REQUEST['social_media_type']."', social_media_name = '".$_REQUEST['social_media_name']."' where id = '".$_REQUEST['user_id']."' ";
				
				mysql_query($update_query)or die(mysql_error());
				$user_id = $_REQUEST['user_id'];
				
				$error = "Famous Account Request Sent Successfully";
				$result=array('message'=> $error, 'result'=>'1','user_id'=>$user_id);
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