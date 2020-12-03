<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '')
	{
		$user_id = $_REQUEST['user_id'];
		$get_query = "select * from post where id = '".$_REQUEST['post_id']."' ";
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
				
				$user_query = "select id,username, profile_image, is_private from user where id = '".$user_id."' ";

				$user_query_res =   mysql_query($user_query)or die(mysql_error());
				$user_data = mysql_fetch_array($user_query_res);
				$user_id11 = $user_data['id'];
				$username1 = $user_data['username'];
				$is_private11 = $user_data['is_private'];
				$profile_image1 = $user_data['profile_image'];
				if(file_exists("../User_image/".$profile_image1) && $profile_image1!="")
				{
					$profile_imagel1 = $SITE_URL."/User_image/".$profile_image1;
				}
				else
				{
					$profile_imagel1 = "";
				}
				$isFrined = 0;
				$isFrined_q = "select id from friend where status = 2 and (from_user = $user_id and to_user = $user_id11 ) or (from_user = $user_id11 and to_user = $user_id )  ";
				$isFrined_res = mysql_query($isFrined_q);
				if(mysql_num_rows($isFrined_res) > 0)
				{
					$isFrined = 1;
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
						"user_id"=>$user_id11,
						"username"=>$username1,
						"is_private"=>$is_private11,
						"isFrined"=>$isFrined,
						"profile_image"=>$profile_imagel1, 						
						"post_media"=>$post_media_array,
						"post_comment"=>$post_comment_array);
				
			}
			$message="Post found.";
			$result=array('message'=> $message, 'result'=>'1','responsePostData'=>$postdata);	
			
		}
		else
		{
			$postdata=array();
			$error = "Post not found.";
			$result=array('message'=> $error, 'result'=>'1','responsePostData'=>$postdata);	
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