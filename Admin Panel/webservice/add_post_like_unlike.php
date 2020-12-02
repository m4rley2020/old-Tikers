<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '')
	{
		$user_id = $_REQUEST['user_id'];
		$post_id = $_REQUEST['post_id'];
		
		$check_post_like = "select id from post_like where post_id= '".$_REQUEST['post_id']."' and user_id='".$_REQUEST['user_id']."' ";
		$check_post_like_res = mysql_query($check_post_like) or die(mysql_error());
		if(mysql_num_rows($check_post_like_res)>0)
		{
			$insert_query = "delete from  post_like where  					
				user_id='".$_REQUEST['user_id']."' and post_id='".$_REQUEST['post_id']."' ";
				mysql_query($insert_query)or die(mysql_error());
				
				
				$update_comment_count = "update post set like_count = like_count -1 where id = '".$_REQUEST['post_id']."' ";
				mysql_query($update_comment_count)or die(mysql_error());				
				
				$error = "Unlike Success";
				$result=array('message'=> $error, 'result'=>'1');
		}
		else
		{
			$insert_query = "insert into post_like set 					
				user_id='".$_REQUEST['user_id']."',
				post_id='".$_REQUEST['post_id']."',
				add_date=NOW()";
				mysql_query($insert_query)or die(mysql_error());
				
				$update_comment_count = "update post set like_count = like_count +1 where id = '".$_REQUEST['post_id']."' ";
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
					$noti_message = $sender_user_name.' has like your post.';
					send_notification($user_id,$reciver_id,$noti_type,$noti_message);
					android_notification_function($user_id,$reciver_id,$noti_type,$noti_message);				
					insert_notification2($user_id,$reciver_id,$noti_type,$noti_message,$post_id);	
				}
				
				
				
								
				
				$error = "Like Success";
				$result=array('message'=> $error, 'result'=>'1');
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