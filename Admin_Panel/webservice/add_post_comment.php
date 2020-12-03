<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
	
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '' && $_REQUEST['comment'] != '')
	{
		$user_id = $_REQUEST['user_id'];
		$post_id = $_REQUEST['post_id'];
		
		$insert_query = "insert into post_comment set 					
				user_id='".$_REQUEST['user_id']."',
				post_id='".$_REQUEST['post_id']."',
				add_date=NOW(),				
				comment	= '".$_REQUEST['comment']."'";
				mysql_query($insert_query)or die(mysql_error());
				
				
				$add_date = GetValue("post_comment","add_date","id",$post_id);
				
				$update_comment_count = "update post set comment_count = comment_count +1 where id = '".$_REQUEST['post_id']."' ";
				mysql_query($update_comment_count)or die(mysql_error());				
				
				$get_post = mysql_query("select user_id, store_id from post where id = $post_id ") or die(mysql_error()); 
				$get_post_data = mysql_fetch_array($get_post);
				if($get_post_data['user_id'] != "0")
				{
					$reciver_id = $get_post_data['user_id'];
				}
				else if($get_post_data['store_id'] != "0")
				{
					$reciver_id = GetValue("store","user_id","id",$get_post_data['store_id']);
				}
				
				if($reciver_id != $user_id)
				{
					$sender_user_name =  GetValue('user','username','id',$user_id);
					$noti_type = 'like_comment';
					$noti_message = $sender_user_name.' has commented on your post.';
					
					send_notification($user_id,$reciver_id,$noti_type,$noti_message);
					android_notification_function($user_id,$reciver_id,$noti_type,$noti_message);
					insert_notification2($user_id,$reciver_id,$noti_type,$noti_message,$post_id);	
				}
				
				
				
				$error = "Comment Added Successfully";
				$result=array('message'=> $error, 'result'=>'1','post_id'=>$post_id,'add_date'=>$add_date);
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>