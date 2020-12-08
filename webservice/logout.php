<?php
	header("Content-type: application/json");
	include("connect.php");
	
	
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['device_type'] != '')
	{	
		if($_REQUEST['device_type'] == "IOS")
		{
			$check_user = mysqli_query("select pid from apns_devices where user_id = '".$_REQUEST['user_id']."' ") or die(mysqli_error());
			if(mysqli_num_rows($check_user)>0)
			{
				$delete_user = mysqli_query("delete from apns_devices where user_id = '".$_REQUEST['user_id']."' "); 
			}
		}
		
		if($_REQUEST['device_type'] == "Android")
		{
			$check_user = mysqli_query("select id from fcm_users where user_id = '".$_REQUEST['user_id']."' ") or die(mysqli_error());
			if(mysqli_num_rows($check_user)>0)
			{
				$delete_user = mysqli_query("delete from fcm_users where user_id = '".$_REQUEST['user_id']."' "); 
			}
		}
		
		$error = "Logout Success";
		$result=array('message'=> $error, 'result'=>'1');
		
	}
	else
	{	
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	
	$result=json_encode($result);
	echo $result;
?>