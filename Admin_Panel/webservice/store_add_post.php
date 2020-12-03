<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['description'] != '' && $_REQUEST['address'] != '')
	{
		$user_id = GetValue("store","user_id","id",$_REQUEST['store_id']);
		$latitude = $_REQUEST['latitude'];
		$longitude = $_REQUEST['longitude'];		
		
		$insert_query = "insert into post set 					
				user_id='".$user_id."',
				store_id='".$_REQUEST['store_id']."',
				description='".$_REQUEST['description']."',
				add_date = NOW(),
				address	= '".$_REQUEST['address']."',
				latitude = '".$_REQUEST['latitude']."',
				longitude = '".$_REQUEST['longitude']."'";
				mysql_query($insert_query)or die(mysql_error());
				$post_id = mysql_insert_id();
				
				
				$image_count = $_REQUEST['image_count'];		
				if($image_count>0)
				{
					for($i=1;$i<=$image_count;$i++)
					{ 
						if($_FILES['image_'.$i]['name']!="")
						{	
							$image_file_name = str_replace(" ","_",rand(1,999).trim($_FILES['image_'.$i]['name']));
							move_uploaded_file($_FILES["image_".$i]["tmp_name"],"../post_media/".$image_file_name);
		                 
							$query1 = "insert into post_media set post_id='".$post_id."', file_type = 'image', file_name='".$image_file_name."'";
							mysql_query($query1) or die(mysql_error());
						}
					}
				}
				
				$video_count = $_REQUEST['video_count'];		
				if($video_count>0)
				{
					for($i=1;$i<=$video_count;$i++)
					{ 
						if($_FILES['video_'.$i]['name']!="")
						{	
							$video_file_name = str_replace(" ","_",rand(1,999).trim($_FILES['video_'.$i]['name']));
							move_uploaded_file($_FILES["video_".$i]["tmp_name"],"../post_media/".$video_file_name);
		                 
							$query1 = "insert into post_media set post_id='".$post_id."', file_type = 'video', file_name='".$video_file_name."'";
							mysql_query($query1) or die(mysql_error());
						}
					}
				}
				
				$user_query = "select user.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(user.latitude ) ) * cos( radians( user.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(user.latitude ) ) ) ) AS range1 from user where user_type != 'Store' having range1 <= '60' ";
				$user_query_res =   mysql_query($user_query)or die(mysql_error());
				if(mysql_num_rows($user_query_res)>0)
				{
					while($user_data = mysql_fetch_array($user_query_res))
					{
						$reciver_id = $user_data['id'];						
						$sender_user_name =  GetValue('store','name','id',$_REQUEST['store_id']);
						$noti_type = 'add_post';
						$noti_message = $sender_user_name.' has posted new post.';
						send_notification($user_id,$reciver_id,$noti_type,$noti_message);
						android_notification_function($user_id,$reciver_id,$noti_type,$noti_message);				
						insert_notification2($user_id,$reciver_id,$noti_type,$noti_message,$post_id);
					}
				}
				
				$error = "Post Added Successfully";
				$result=array('message'=> $error, 'result'=>'1','post_id'=>$post_id);
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>