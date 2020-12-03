<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'])
	{
		
		$get_query = "select * from post_like where post_id = '".$_REQUEST['post_id']."' ";
		$get_query_res = mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['user_id'];
				
				$get_user = "select id,username,profile_image,first_name,last_name from user where id = '".$user_id."' ";
				$get_user_res = mysql_query($get_user) or die(mysql_error());
				$get_user_row = mysql_fetch_array($get_user_res);
				
				$username = $get_user_row['username'];
				$first_name = $get_user_row['first_name'];
				$last_name = $get_user_row['last_name'];				
				$profile_image = $get_user_row['profile_image'];
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_image1 = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_image1 = "";
				}
				
				// 0 = follow
				// 1 = requested
				// 2 = following
				$is_follow = "0";
				$check_follow = mysql_query("select status from friend where from_user = '".$_REQUEST['user_id']."' and to_user = '".$user_id."' ") or die(mysql_error()) ;
				
				if(mysql_num_rows($check_follow)>0)
				{
					$follow_data = mysql_fetch_array($check_follow);
					$is_follow = $follow_data['status'];
				}
				
			
				$data[]=array(
						"user_id"=>$user_id, 
						"username"=>$username,
						"first_name"=>$first_name,
						"last_name"=>$last_name,
						"profile_image"=>$profile_image1,
						"is_follow"=>$is_follow
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