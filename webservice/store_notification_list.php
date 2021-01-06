<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '')
	{
		$userid = $_REQUEST['store_id'];
		$get_noti_query = "select * from notification where receiver_id = '".$userid."'  ";
		$get_noti_res =   mysqli_query($db,$get_noti_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_noti_res)>0)
		{
			while($get_noti_data = mysqli_fetch_array($get_noti_res))
			{
				$sender_user_id = $get_noti_data['sender_id'];
				$noti_message = $get_noti_data['message'];
				$noti_date = $get_noti_data['created_date'];
				
				$get_sender_user = mysqli_query($db,"select * from user where id = '".$sender_user_id."' ") or die(mysqli_error($db));
				
				$sender_user_data = mysqli_fetch_array($get_sender_user);
				
				$sender_username = $sender_user_data['username'];	
				$sender_profile_image = $sender_user_data['profile_image'];
				$sender_is_private = $sender_user_data['is_private'];
				
				if(file_exists("../User_image/".$sender_profile_image) && $sender_profile_image!="")
				{
					$sender_profile_imagel = $SITE_URL."/User_image/".$sender_profile_image;
				}
				else
				{
					$sender_profile_imagel = "";
				}
				
				$data[]=array(
						"user_id"=>$sender_user_id, 
						"username"=>$sender_username,
						"profile_image"=>$sender_profile_imagel,
						"is_private"=>$sender_is_private,
						"notification_message"=>$noti_message,
						"notification_date"=>$noti_date
						);
				
			}
			$message="Notification found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);	
			
		}
		else
		{
			$error = "No notification found.";
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