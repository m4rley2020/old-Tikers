<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['post_id'])
	{
		
		$get_query = "select * from post_like where post_id = '".$_REQUEST['post_id']."' ";
		$get_query_res = mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['user_id'];
				
				$get_user = "select id,username,profile_image from user where id = '".$user_id."' ";
				$get_user_res = mysql_query($get_user) or die(mysql_error());
				$get_user_row = mysql_fetch_array($get_user_res);
				
				$username = $get_user_row['username'];				
				$profile_image = $get_user_row['profile_image'];
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_image1 = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_image1 = "0";
				}
				
				
			
				$data[]=array(
						"user_id"=>$user_id, 
						"username"=>$username,
						"profile_image"=>$profile_image1
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