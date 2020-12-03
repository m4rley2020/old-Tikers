<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '')
	{
		$post_id = $_REQUEST['post_id'];
		$get_query2 = "select * from post_comment where post_id='".$post_id."' order by id desc";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			
			
			
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$comment_id = $get_query_date2['id'];
				$user_id1 = $get_query_date2['user_id'];
				$comment = $get_query_date2['comment'];
				$add_date = $get_query_date2['add_date'];
				$username = GetValue("user","username","id",$user_id1);
				$profile_image1 = GetValue("user","profile_image","id",$user_id1);
				if(file_exists("../User_image/".$profile_image1) && $profile_image1!="")
				{
					$profile_image11 = $SITE_URL."/User_image/".$profile_image1;
				}
				else
				{
					$profile_image11 = "";
				}						
				
				$data[]=array(
				"post_id"=>$post_id,
				"comment_id"=>$comment_id, 
				"user_id"=>$user_id1,
				"comment"=>$comment,
				"add_date"=>$add_date,
				"username"=>$username,
				"profile_image"=>$profile_image11
				);
				
			}	
			$message="Comment found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Post Comment not found.";
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