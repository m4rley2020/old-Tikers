<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['date_time'] && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{ 
	
		$follow_uid = $_REQUEST['user_id'];
		$post_start_limit = $_REQUEST['start'];
		
		$get_follow = mysql_query("select to_user from friend where from_user = '".$_REQUEST['user_id']."' and status = '1' ") or die(mysql_error()) ;
				
		if(mysql_num_rows($get_follow)>0)
		{
			while($get_follow_data = mysql_fetch_array($get_follow))
			{
				$follow_uid = $follow_uid.",".$get_follow_data['to_user'];
			}
			
		}
		
		$follow_uid = trim($follow_uid,",");
		$date_time1 = date("Y-m-d H:i:s",strtotime($_REQUEST['date_time']));
		$date_time2 = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($_REQUEST['date_time'])));
				
		$get_query1 = "select * from store_challenge_complete_by_user where user_id in (".$follow_uid.") and status = 1 and (add_date BETWEEN '".$date_time2."' AND '".$date_time1."')  order by add_date desc limit $post_start_limit,10";
		
		//echo $get_query1;
		
		$get_query_res1 =   mysql_query($get_query1)or die(mysql_error());
		if(mysql_num_rows($get_query_res1)>0)
		{
			while($get_query_date1 = mysql_fetch_array($get_query_res1))
			{
				$challenge_image = $get_query_date1['challenge_image'];
				if(file_exists("../complete_challenge_image/".$challenge_image) && $challenge_image!="")
				{
					$challenge_image1 = $SITE_URL."/complete_challenge_image/".$challenge_image;
				}
				else
				{
					$challenge_image1 = "";
				}
				
				$get_user = "select username,profile_image,first_name,last_name from user where id = '".$get_query_date1['user_id']."' ";
				$get_user_res = mysql_query($get_user) or die(mysql_error());
				$get_user_row = mysql_fetch_array($get_user_res);
				
				$profile_image = $get_user_row['profile_image'];
				$username = $get_user_row['username'];
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_image1 = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_image1 = "";
				}
				
					
					$data[]=array(
						"story_id"=>$get_query_date1['id'],
						"story_image"=>$challenge_image1,						
						"user_id"=>$get_query_date1['user_id'],
						"user_name"=>$username,						
						"profile_image"=>$profile_image1,
						"store_id"=>$get_query_date1['store_id'],
						"challenge_id"=>$get_query_date1['challenge_id'],
						"add_date"=>$get_query_date1['add_date']
						);	
					$message="Favorite Challenge found.";
					$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
				
				
			}
		}
		else
		{
			$error = "Story not found.";
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