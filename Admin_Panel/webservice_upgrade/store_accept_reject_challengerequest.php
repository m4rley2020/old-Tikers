<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['story_id'] != '' && $_REQUEST['type'] != '')
	{
		if($_REQUEST['type'] == "accpet")
		{
			$status = 1;
		}
		elseif($_REQUEST['type'] == "reject")
		{
			$status = 2;
		}
		
		$insert_query = "update store_challenge_complete_by_user set 					
				status='".$status."'
				where 
				id='".$_REQUEST['story_id']."' and 
				store_id='".$_REQUEST['store_id']."' ";
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				$post_id = mysqli_insert_id();
				
				$error = "Story Status Updated Successfully";
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