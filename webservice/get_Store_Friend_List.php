<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{
		$post_start_limit = $_REQUEST['start'];
		
		$search_val = $_REQUEST['search_val'];
		if($search_val != "")
		{
			$get_query = "select F.to_user, F.status from friend as F left join user as U on F.to_user = U.id where U.username like '%".$search_val."%' and F.from_user = '".$_REQUEST['user_id']."' and F.status = 2 and U.user_type = 'Store' limit $post_start_limit,10";
		}
		else
		{
			//$get_query = "select to_user, status from friend where from_user = '".$_REQUEST['user_id']."' and status = 2  limit $post_start_limit,10";
			
			$get_query = "select F.to_user, F.status from friend as F left join user as U on F.to_user = U.id where F.from_user = '".$_REQUEST['user_id']."' and F.status = 2 and U.user_type = 'Store' limit $post_start_limit,10";
		}
		
		
		
		$get_query_res =   mysqli_query($get_query)or die(mysqli_error());
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysqli_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['to_user'];
				$is_follow = $get_query_date['status'];
				
				$get_user = mysqli_query("select * from user where id = '".$user_id."' ") or die(mysqli_error());
				
				$get_user_data = mysqli_fetch_array($get_user);
				
				$username = $get_user_data['username'];
				$first_name = $get_user_data['first_name'];
				$last_name = $get_user_data['last_name'];				
				$profile_image = $get_user_data['profile_image'];
				$is_private = $get_user_data['is_private'];
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_imagel = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_imagel = "";
				}
				
				$get_store_user = mysqli_query("select * from store where user_id = '".$user_id."' ") or die(mysqli_error());
				
				$get_store_data = mysqli_fetch_array($get_store_user);
				
				$store_id = $get_store_data['id'];
				$store_name = $get_store_data['name'];				
				$store_image = $get_store_data['store_image'];
				
				
				if(file_exists("../store_image/".$store_image) && $store_image!="")
				{
					$store_imagel = $SITE_URL."/store_image/".$store_image;
				}
				else
				{
					$store_imagel = "";
				}
				
				
			
				$data[]=array(
						"user_id"=>$user_id, 
						"username"=>$username,
						"first_name"=>$first_name,
						"last_name"=>$last_name,
						"profile_image"=>$profile_imagel,						
						"is_private"=>$is_private,
						"store_id"=>$store_id,
						"store_name"=>$store_name,
						"store_image"=>$store_imagel,
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