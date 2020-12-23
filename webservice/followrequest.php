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
			
				$status = 2;
				$error = "Following successfully";
				$type="Following";
				
			$insert_review = mysqli_query($db,"insert into friend set from_user='".$from_user_id."', to_user='".$to_user_id."', status='".$status."', add_date = NOW() ");

			
			$result=array('message'=> $error, 'result'=>'1');
		}
		else
		{
			
			$result["status"]="0";
			$error = "You alerady following this user.";
			$result=array('message'=> $error, 'result'=>'0'); 	
		}
	}
	else
	{
		$result["status"]="0";
		$error = "Please enter all required field";
		$result=array('message'=> $error, 'result'=>'0');
	}

$result=json_encode($result);
echo $result;
?>