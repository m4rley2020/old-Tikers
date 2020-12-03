<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{ 
		$post_start_limit = $_REQUEST['start'];
		$get_query1 = "select * from store_challenge_complete_by_user where store_id = '".$_REQUEST['store_id']."' and is_approve = 1 order by add_date desc limit $post_start_limit,10 ";
		$get_query_res1 =   mysql_query($get_query1)or die(mysql_error());
		if(mysql_num_rows($get_query_res1)>0)
		{
			while($get_query_date1 = mysql_fetch_array($get_query_res1))
			{
				$get_challenge = "select * from store_challenges where id = '".$get_query_date1['challenge_id']."' ";
				$get_challenge_res = mysql_query($get_challenge) or die(mysql_error());
				$get_challenge_row = mysql_fetch_array($get_challenge_res);
				
				$challeng_image = $get_challenge_row['challeng_image'];
				$challenge_type = GetValue("challenge_type","name","id",$get_challenge_row['challenge_type_id']);
				
				if(file_exists("../challenge_image/".$challeng_image) && $challeng_image!="")
				{
					$challeng_image1 = $SITE_URL."/challenge_image/".$challeng_image;
				}
				else
				{
					$challeng_image1 = "0";
				}
				
				$get_user = "select username,profile_image,first_name,last_name from user where id = '".$get_query_date1['user_id']."' ";
				$get_user_res = mysql_query($get_user) or die(mysql_error());
				$get_user_row = mysql_fetch_array($get_user_res);
				
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
						"id"=>$get_query_date1['id'],
						"challenge_id"=>$get_query_date1['challenge_id'],
						"challenge_name"=>$get_challenge_row['name'],
						"challeng_image"=>$challeng_image1,
						"challenge_type"=>$challenge_type,
						"user_id"=>$get_query_date1['user_id'],
						"username"=>$get_user_row['username'],
						"first_name"=>$get_user_row['first_name'],
						"last_name"=>$get_user_row['last_name'],
						"profile_image"=>$profile_image1,
						"add_date"=>$get_query_date1['add_date']
						);	
					$message="Challenge found.";
					$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
			}
		}
		else
		{
			$error = "Challenge not found.";
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