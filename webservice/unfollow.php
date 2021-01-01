<?php
header("Content-type: application/json");
include "connect.php";



	if($_REQUEST['user_id']!="" && $_REQUEST['following_user_id']!="")
	{
		$from_user_id 	= intval($_REQUEST['user_id']);
		$to_user_id 	= intval($_REQUEST['following_user_id']);
		
		$sel_user_request = mysqli_query($db,"select * from friend where from_user='".$from_user_id."' and to_user='".$to_user_id."'");
		$sel_user_request_rows = mysqli_num_rows($sel_user_request);
		
		if($sel_user_request_rows>0)
		{
			$insert_review = mysqli_query($db,"delete from friend where from_user='".$from_user_id."' and to_user='".$to_user_id."'");
			$result["status"]="1";
			$error = "Unfollow successfully";
			$result["message"]=$error;
		}
		else
		{
			$result["status"]="0";
			$error = "No Data found.";
			$result["message"]=$error; 
		}
	}
	else
	{
		$result["status"]="0";
		$error = "Please enter all required field";
		$result["message"]=$error;
	}

$result=json_encode($result);
echo $result;
?>