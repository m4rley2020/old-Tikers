<?php
	header("Content-type: application/json");
	include "connect.php";

	// 0 = follow
	// 1 = requested
	// 2 = following
		
	if($_REQUEST['user_id']!="" && $_REQUEST['following_user_id']!="")
	{
		$from_user_id 	= intval($_REQUEST['user_id']);
		$to_user_id 	= intval($_REQUEST['following_user_id']);
		
		$sel_user_request = mysqli_query($db,"select * from friend where from_user='".$from_user_id."' and to_user='".$to_user_id."'");
		$sel_user_request_rows = mysqli_num_rows($sel_user_request);
		
		if($sel_user_request_rows==0)
		{
			$to_user_is_private = GetValue("user","is_private","id",$to_user_id);
			
			if($to_user_is_private == 1)
			{
				$status = 1;
				$error = "Following request sent successfully";
				$type="Requested";
			}
			else
			{
				$status = 2;
				$error = "Following successfully";
				$type="Following";
			}
			
			
			$insert_review = mysqli_query($db"insert into friend set from_user='".$from_user_id."', to_user='".$to_user_id."', status='".$status."', add_date = NOW() ");
			$last_requested_id = mysqli_insert_id();
			
			if($last_requested_id>0)
			{
				$result["status"]="1";
				$result['type'] = $type;
				$result["message"]=$error;
			}
			else
			{
				$result["status"]="0";
				$error = "Something went wrong.";
				$result["message"]=$error; 
			}
		}
		else
		{
			
			$sel_user_request_data = mysqli_fetch_array($sel_user_request);
			
			$req_status = $sel_user_request_data['status'];
			if($req_status == '1')
			{
				$result["status"]="0";
				$error = "You have alerady sent follow request to this user.";
				$result["message"]=$error; 	
			}
			if($req_status == '2')
			{
				$result["status"]="0";
				$error = "You alerady following this user.";
				$result["message"]=$error; 	
			}
			
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