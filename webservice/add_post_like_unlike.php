<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '')
	{
		$check_post_like = "select id from post_like where post_id= '".$_REQUEST['post_id']."' and user_id='".$_REQUEST['user_id']."' ";
		$check_post_like_res = mysqli_query($db,$check_post_like) or die(mysqli_error($db));
		if(mysqli_num_rows($check_post_like_res)>0)
		{
			$insert_query = "delete from  post_like where  					
				user_id='".$_REQUEST['user_id']."' and post_id='".$_REQUEST['post_id']."' ";
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				
				
				$update_comment_count = "update post set like_count = like_count -1 where id = '".$_REQUEST['post_id']."' ";
				mysqli_query($db,$update_comment_count)or die(mysqli_error($db));				
				
				$error = "Unlike Success";
				$result=array('message'=> $error, 'result'=>'1');
		}
		else
		{
			$insert_query = "insert into post_like set 					
				user_id='".$_REQUEST['user_id']."',
				post_id='".$_REQUEST['post_id']."',
				add_date=NOW()";
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				
				$update_comment_count = "update post set like_count = like_count +1 where id = '".$_REQUEST['post_id']."' ";
				mysqli_query($db,$update_comment_count)or die(mysqli_error($db));				
				
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