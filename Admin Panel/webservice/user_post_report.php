<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '' && $_REQUEST['reason'] != '')
	{
		$check_post = "select id from post_report where user_id='".$_REQUEST['user_id']."' and post_id='".$_REQUEST['post_id']."'";
		$check_post_res = mysql_query($check_post) or die(mysql_error());
		if(mysql_num_rows($check_post_res) == 0)
		{
			$insert_query = "insert into post_report set 					
					user_id='".$_REQUEST['user_id']."',
					post_id='".$_REQUEST['post_id']."',
					reason='".$_REQUEST['reason']."',
					message='".$_REQUEST['message']."',
					add_date=NOW()";
					mysql_query($insert_query)or die(mysql_error());
					$post_id = mysql_insert_id();
					
					$add_date = GetValue("post_report","add_date","id",$post_id);
					
					//$update_comment_count = "update post set comment_count = comment_count +1 where id = '".$_REQUEST['post_id']."' ";
					//mysql_query($update_comment_count)or die(mysql_error());				
					
					
					
					$error = "Post Reported Successfully";
					$result=array('message'=> $error, 'result'=>'1','post_id'=>$_REQUEST['post_id'],'add_date'=>$add_date);
		}
		else
		{
			$error = "You have already reported this post.";
			$result=array('message'=> $error, 'result'=>'0');
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