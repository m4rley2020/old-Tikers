<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['password'] != '')
	{
		
			$update_query = "update user set 					
					password='".$_REQUEST['password']."'
					where id = '".$_REQUEST['user_id']."' ";
					mysqli_query($db,$update_query)or die(mysqli_error($db));
					$user_id = $_REQUEST['user_id'];
					
					$error = "Account Password Updated Successfully";
					$result=array('message'=> $error, 'result'=>'1','user_id'=>$user_id);
		
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>