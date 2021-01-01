<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['searchname'])
	{
		
		$get_query = "select * from user where username like '%".$_REQUEST['searchname']."%' and id != '".$_REQUEST['user_id']."'";
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysqli_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['id'];
				$username = $get_query_date['username'];
				$first_name = $get_query_date['first_name'];
				$last_name = $get_query_date['last_name'];				
				$profile_image = $get_query_date['profile_image'];
				$is_private = $get_query_date['is_private'];
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_imagel = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_imagel = "";
				}
				
				// 0 = follow
				// 1 = requested
				// 2 = following
				$is_follow = "0";
				$check_follow = mysqli_query($db,"select status from friend where from_user = '".$_REQUEST['user_id']."' and to_user = '".$user_id."' ") or die(mysqli_error($db)) ;
				
				if(mysqli_num_rows($check_follow)>0)
				{
					$follow_data = mysqli_fetch_array($check_follow);
					$is_follow = $follow_data['status'];
				}
				
			
				$data[]=array(
						"user_id"=>$user_id, 
						"username"=>$username,
						"first_name"=>$first_name,
						"last_name"=>$last_name,
						"profile_image"=>$profile_imagel,
						"is_follow"=>$is_follow,
						"is_private"=>$is_private,
						);
				
			}
			$message="User found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);	
			
		}
		else
		{
			$error = "User not found.";
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