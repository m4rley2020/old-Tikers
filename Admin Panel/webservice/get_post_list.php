<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0 && $_REQUEST['ad'] != '' && $_REQUEST['ad'] >= 0)
	{
		
		$follow_uid = $_REQUEST['user_id'];
		$post_start_limit = $_REQUEST['start'];
		$ad_start_limit = $_REQUEST['ad'];
			
		$get_follow = mysql_query("select to_user from friend where from_user = '".$_REQUEST['user_id']."' and status = '2' ") or die(mysql_error()) ;
				
		if(mysql_num_rows($get_follow)>0)
		{
			while($get_follow_data = mysql_fetch_array($get_follow))
			{
				$follow_uid = $follow_uid.",".$get_follow_data['to_user'];
			}
			
		}
		
		$follow_uid = trim($follow_uid,",");
		
		
		
		$get_query = "select * from post where user_id in (".$follow_uid.") order by add_date desc limit $post_start_limit,10";
		$get_query_res =   mysql_query($get_query) or die(mysql_error());
		//$get_query_res = $prs_pageing->number_pageing($get_query,10,200000,'N','Y');
		
		if(mysql_num_rows($get_query_res) > 0)
		{ 
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
				$user_id = $get_query_date['user_id'];				
				$is_private = GetValue("user","is_private","id",$user_id);
				$username = GetValue("user","username","id",$user_id);
				$profile_image = GetValue("user","profile_image","id",$user_id);
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_imagel = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_imagel = "";
				}
				
				$check_like = "select id from post_like where post_id = $post_id and user_id = '".$_REQUEST['user_id']."' ";
				$check_like_res = mysql_query($check_like) or die(mysql_error());
				$is_like = 0;
				if(mysql_num_rows($check_like_res)>0)
				{
					$is_like = 1;
				}
				
				$get_query1 = "select * from post_media where post_id='".$post_id."'";
				$get_query_res1 = mysql_query($get_query1)or die(mysql_error());
				
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
						$username2 = GetValue("user","username","id",$user_id1);
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
						"username"=>$username2,
						"profile_image"=>$profile_image11
						);
						
					}
				}
						
				$data[]=array(
						"post_id"=>$post_id, 
						"description"=>$description,
						"comment_count"=>$comment_count11,
						"like_count"=>$like_count,
						"add_date"=>$add_date,
						"address"=>$address,
						"latitude"=>$latitude,
						"longitude"=>$longitude,
						"user_id"=>$user_id,
						"username"=>$username, 
						"profile_image"=>$profile_imagel,
						"is_private"=>$is_private,
						"is_like"=>$is_like,
						"type"=>'Post',
						"post_media"=>$post_media_array,
						"post_comment"=>$post_comment_array);
				
				$post_comment_array = null;
				
			}
			
			$get_advertise = "select * from advertise order by id desc limit $ad_start_limit,1";
			$get_advertise_result =  mysql_query($get_advertise)or die(mysql_error());

			if(mysql_num_rows($get_advertise_result)>0)
			{
				$advertise_data = mysql_fetch_array($get_advertise_result);

				$ads_id = $advertise_data['id'];
				$title = $advertise_data['title'];
				$message = $advertise_data['message'];
				$file_type = "";
					
				$ads_image = $advertise_data['ads_image'];				
				$ads_video = $advertise_data['ads_video'];				
				
				if(file_exists("../ads_images/".$ads_image) && $ads_image!="")
				{
					$file_url = $SITE_URL."/ads_images/".$ads_image;
					$file_type = "image";
				}
				else if(file_exists("../ads_video/".$ads_video) && $ads_video!="")
				{
					$file_url = $SITE_URL."/ads_video/".$ads_video;
					$file_type = "video";
				}
				else
				{
					$file_url = "";
				}

				/*array(
					"ads_id"=>$ads_id,
					"title"=>$title, 
					"message"=>$message,
					"type"=>'Advertise',
					"ads_image"=>$ads_image1, 
					"ads_video1"=>$ads_video1			
				);*/
				
				array_push($data,array(
					"ads_id"=>$ads_id,
					"title"=>$title, 
					"message"=>$message,
					"type"=>'Advertise',
					"file_type"=>$file_type, 
					"file_url"=>$file_url			
				));
			}
			
			$message="Post found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);	
			
		}
		else
		{
			$error = "Post not found.";
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