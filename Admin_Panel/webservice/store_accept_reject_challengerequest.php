<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['story_id'] != '' && $_REQUEST['type'] != '')
	{
		if($_REQUEST['type'] == "accpet")
		{
			$status = 1;
			$noti_message = 'Store accepted your story request.';
		}
		elseif($_REQUEST['type'] == "reject")
		{
			$status = 2;
			$noti_message = 'Store rejected your story request.';
		}
		
		 	$insert_query = "update store_challenge_complete_by_user set 					
				is_approve ='".$status."'
				where 
				id='".$_REQUEST['story_id']."' and 
				store_id='".$_REQUEST['store_id']."' ";
				mysql_query($insert_query)or die(mysql_error());
				$post_id = mysql_insert_id();
				
				$sender_id = GetValue("store","user_id","id",$_REQUEST['store_id']);
				$reciver_id = GetValue("store_challenge_complete_by_user","user_id","id",$_REQUEST['story_id']);
				$noti_type = 'story_request';
				send_notification($sender_id,$reciver_id,$noti_type,$noti_message);
				android_notification_function($sender_id,$reciver_id,$noti_type,$noti_message);
				insert_notification($sender_id,$reciver_id,$noti_type,$noti_message);
				
				
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