<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query = "select to_user from friend where from_user = '".$_REQUEST['user_id']."'";
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysqli_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['to_user'];
				
				$get_user = mysqli_query($db,"select * from user where id = '".$user_id."' ") or die(mysqli_error($db));
				
				$get_user_data = mysqli_fetch_array($get_user);
				
				$username = $get_user_data['username'];
				$first_name = $get_user_data['first_name'];
				$last_name = $get_user_data['last_name'];				
				$profile_image = $get_user_data['profile_image'];
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_imagel = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_imagel = "";
				}
				
			
				$data[]=array(
						"user_id"=>$user_id, 
						"username"=>$username,
						"first_name"=>$first_name,
						"last_name"=>$last_name,
						"profile_image"=>$profile_imagel
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