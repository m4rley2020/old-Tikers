<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{
		$post_start_limit = $_REQUEST['start'];
		$get_query = "select * from post where store_id='".$_REQUEST['store_id']."'  limit $post_start_limit,10 ";
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				$store_name = GetValue("store","name","id",$get_query_date['store_id']);
				$store_image = GetValue("store","name","id",$get_query_date['store_image']);
				if(file_exists("../store_image/".$store_image) && $store_image!="")
				{
					$store_image1 = $SITE_URL."/store_image/".$store_image;
				}
				else
				{
					$store_image1 = "";
				}
				
				$post_id = $get_query_date['id'];
				$store_id = $get_query_date['store_id'];
				$description = $get_query_date['description'];				
				$comment_count11 = $get_query_date['comment_count'];				
				$like_count = $get_query_date['like_count'];
				$address = $get_query_date['address'];
				$latitude = $get_query_date['latitude'];
				$longitude = $get_query_date['longitude'];				
				$add_date = $get_query_date['add_date'];
				
				$check_like = "select id from post_like where post_id = $post_id ";
				$check_like_res = mysql_query($check_like) or die(mysql_error());
				$is_like = 0;
				if(mysql_num_rows($check_like_res)>0)
				{
					$is_like = 1;
				}
				
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
					$post_media_array = array();
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
					$post_comment_array = array();
				}
								
				
			
				$data[]=array(
						"post_id"=>$post_id,
						"store_id"=>$store_id,
						"store_name"=>$store_name,
						"store_image"=>$store_image1, 
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