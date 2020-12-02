<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		$user_id = $_REQUEST['user_id'];
			
		$user_query = "select U.username, U.profile_image, U.bio, count(F.from_user) as following_counter from user U left join friend F on U.id = F.from_user where U.id = '".$user_id."' and F.status = 2 ";

		$user_query_res =   mysql_query($user_query)or die(mysql_error());
		if(mysql_num_rows($user_query_res)>0)
		{
			$user_data = mysql_fetch_array($user_query_res);
			$username = $user_data['username'];
			$profile_image = $user_data['profile_image'];
			$total_following = $user_data['following_counter'];
			$total_follow = GetFollowCounter('friend','to_user','to_user',$user_id);
			$user_bio = $user_data['bio'];

			if(file_exists("../User_image/".$profile_image) && $profile_image!="")
			{
				$profile_imagel = $SITE_URL."/User_image/".$profile_image;
			}
			else
			{
				$profile_imagel = "";
			}
			$challengestot = 0;
			$challengestot = mysql_num_rows(mysql_query("select id from store_challenge_complete_by_user where user_id = '".$user_id."' "));
			$userdata[]=array(
				"user_id"=>$user_id,
				"username"=>$username, 
				"profile_image"=>$profile_imagel,
				"total_following"=>$total_following,
				"total_follows"=>$total_follow,
				"challengestot"=>$challengestot,
				"user_bio"=>$user_bio
			);	
		}
		
		$get_query = "select * from post where user_id='".$_REQUEST['user_id']."'";
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{			
			$postdata=array();
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				$post_id = $get_query_date['id'];
				$description = $get_query_date['description'];				
				$comment_count11 = $get_query_date['comment_count'];				
				$like_count = $get_query_date['like_count'];
				$address = $get_query_date['address'];
				$latitude = $get_query_date['latitude'];
				$longitude = $get_query_date['longitude'];
				$add_date = $get_query_date['add_date'];				
				
				$get_query1 = "select * from post_media where post_id='".$post_id."'";
				$get_query_res1 =   mysql_query($get_query1)or die(mysql_error());
				
				if(mysql_num_rows($get_query_res1)>0)
				{
					$post_media_array = array();
					while($get_query_date1 = mysql_fetch_array($get_query_res1))
					{
						$media_id = $get_query_date1['id'];
						$file_name = $get_query_date1['file_name'];
						$file_type = $get_query_date1['file_type'];
						
						if(file_exists("../post_media/".$file_name) && $file_name!="")
						{
							$file_name1 = $SITE_URL."/post_media/".$file_name;
						}
						else
						{
							$file_name1 = "";
						}
						
						$post_media_array[]=array(
						"media_id"=>$media_id, 
						"file_name1"=>$file_name1,
						"file_type"=>$file_type);
						
					}
				}
				else
				{
					$post_media_array=array();
				}
				
				$get_query2 = "select * from post_comment where post_id='".$post_id."' order by id desc limit 2";
				$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
				
				if(mysql_num_rows($get_query_res2)>0)
				{
					$post_comment_array = array();
					while($get_query_date2 = mysql_fetch_array($get_query_res2))
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
						
						$post_comment_array[]=array(
						"comment_id"=>$comment_id, 
						"user_id"=>$user_id1,
						"comment"=>$comment,
						"add_date"=>$add_date,
						"username"=>$username,
						"profile_image"=>$profile_image11
						);
						
					}
				}
				else
				{
					$post_comment_array=array();
				}
				
				$is_like = 0;
				$check_like = "select id from post_like where post_id= '".$post_id."' and user_id = '".$_REQUEST['user_id']."' ";
				$check_like_res = mysql_query($check_like) or die(mysql_error());
				if(mysql_num_rows($check_like_res)>0)
				{
					$is_like = 1;
				}
				
				$postdata[]=array(
						"post_id"=>$post_id, 
						"description"=>$description,
						"comment_count"=>$comment_count11,
						"like_count"=>$like_count,
						"add_date"=>$add_date,
						"address"=>$address,
						"latitude"=>$latitude,
						"longitude"=>$longitude,
						"is_like"=>$is_like, 						
						"post_media"=>$post_media_array,
						"post_comment"=>$post_comment_array);
				
			}
			$message="Post found.";
			$result=array('message'=> $message, 'result'=>'1','responseUserData'=>$userdata,'responsePostData'=>$postdata);	
			
		}
		else
		{
			$postdata=array();
			$error = "Post not found.";
			$result=array('message'=> $error, 'result'=>'1','responseUserData'=>$userdata,'responsePostData'=>$postdata);	
			//$result=array('message'=> $error, 'result'=>'0');
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