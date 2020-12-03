<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{
		$post_start_limit = $_REQUEST['start'];
		$search_val = $_REQUEST['search_val'];
		if($search_val != "")
		{
			$get_query = "select F.from_user, F.to_user, F.status from friend as F left join user as U on F.from_user = U.id  where U.username like '%".$search_val."%' and (F.to_user = '".$_REQUEST['user_id']."' OR F.from_user = '".$_REQUEST['user_id']."') and F.status = 2  limit $post_start_limit,10 ";
		}
		else
		{
			$get_query = "select from_user, to_user, status from friend where (to_user = '".$_REQUEST['user_id']."' OR from_user = '".$_REQUEST['user_id']."') and status = 2  limit $post_start_limit,10 ";	
		}
		
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				
				if($_REQUEST['user_id'] == $get_query_date['from_user'])
				{
					$user_id = $get_query_date['to_user'];	
				}
				
				if($_REQUEST['user_id'] == $get_query_date['to_user'])
				{
					$user_id = $get_query_date['from_user'];	
				}
				
				$is_follow = $get_query_date['status'];
				
				//echo "select * from user where id = '".$user_id."'";
				
				$get_user = mysql_query("select * from user where id = '".$user_id."' ") or die(mysql_error());
				
				$get_user_data = mysql_fetch_array($get_user);
				
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
						"profile_image"=>$profile_imagel,
						"is_follow"=>$is_follow,
						"is_private"=>$is_private
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