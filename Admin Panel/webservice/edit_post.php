<?php
	header("Content-type: application/json");
	include("connect.php");

	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '' && $_REQUEST['post_description'] != '')
	{
		$userid = $_REQUEST['user_id'];
		$postid = $_REQUEST['post_id'];
		$post_description = $_REQUEST['post_description'];
		
		$get_post_query = "select * from post where id='".$postid."' and user_id='".$userid."' ";
		$get_post_res =   mysql_query($get_post_query)or die(mysql_error());
		
		if(mysql_num_rows($get_post_res)>0)
		{
			$updt_post_query = "update post set description = '".$post_description."' where id='".$postid."' and user_id='".$userid."' ";
			
			if(mysql_query($updt_post_query)){
				$error = "Post updated successfully.";
				$result=array('message'=> $error, 'result'=>'1');
			}
			else{
				$error = "someting is wrong.";
				$result=array('message'=> $error, 'result'=>'0');
			}
		}
		else
		{
			$error = "Post not found.";
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