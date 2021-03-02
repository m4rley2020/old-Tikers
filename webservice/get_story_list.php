<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{ 
	
		$follow_uid = $_REQUEST['user_id'];
		
		$get_follow = mysqli_query($db,"select to_user from friend where from_user = '".$_REQUEST['user_id']."' and status = '2' ") or die(mysqli_error($db)) ;
				
		if(mysqli_num_rows($get_follow)>0)
		{
			while($get_follow_data = mysqli_fetch_array($get_follow))
			{
				$follow_uid = $follow_uid.",".$get_follow_data['to_user'];
			}
			
		}

		
		
		
		$follow_uid = trim($follow_uid,",");
	
		$get_query1 = "select * from store_challenge_complete_by_user where user_id in (".$follow_uid.") order by add_date desc";
		$get_query_res1 =   mysqli_query($db,$get_query1)or die(mysqli_error($db));
		if(mysqli_num_rows($get_query_res1)>0)
		{
			while($get_query_date1 = mysqli_fetch_array($get_query_res1))
			{
				$challenge_image = $get_query_date1['challenge_image'];
				$challenge_id = $get_query_date1['id'];
				$is_liked = mysqli_query($db,"select * from story_like where liked_by ='".$_REQUEST['user_id']."' and story_id = $challenge_id") or die(mysqli_error($db));
				
				if(mysqli_num_rows($is_liked)>0)
		{
			$is_liked = 'Yes';
		}		else{
			$is_liked = 'No';
		}
				if(file_exists("../complete_challenge_image/".$challenge_image) && $challenge_image!="")
				{
					$challenge_image1 = $SITE_URL."/complete_challenge_image/".$challenge_image;
				}
				else
				{
					$challenge_image1 = "";
				}
				
				$get_user = "select username,profile_image,first_name,last_name from user where id = '".$get_query_date1['user_id']."' ";
				$get_user_res = mysqli_query($db,$get_user) or die(mysqli_error($db));
				$get_user_row = mysqli_fetch_array($get_user_res);
				
				
				$profile_image = $get_user_row['profile_image'];
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
						"username"=>GetValue("user","username","id","user_id"),
						"story_image"=>$challenge_image1,						
						"user_id"=>$get_query_date1['user_id'],						
						"profile_image"=>$profile_image1,
						"store_id"=>$get_query_date1['store_id'],
						"challenge_id"=>$get_query_date1['challenge_id'],
						"is_liked"=>$is_liked,
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