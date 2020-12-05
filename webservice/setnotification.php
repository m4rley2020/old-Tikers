<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['is_private'] != '')
	{
		$check_customer_username = mysqli_query($db,"
		SELECT * FROM `user` WHERE id = '".$_REQUEST['user_id']."' ") or die(mysqli_error($db));	
		 
		if(mysqli_num_rows($check_customer_username) > 0)
		{
			$update_query = "update user set is_private = '".$_REQUEST['is_private']."' where id = '".$_REQUEST['user_id']."' ";
			mysqli_query($db,$update_query)or die(mysqli_error($db));
			$user_id = $_REQUEST['user_id'];
			
			$error = "Profile Updated Successfully";
			$result=array('message'=> $error, 'result'=>'1','user_id'=>$user_id,'is_private'=>$_REQUEST['is_private']);
		}			
		else
		{
			$message = "User with the specified Username already exists.";
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