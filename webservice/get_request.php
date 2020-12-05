<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query = "select * from friend where to_user='".$_REQUEST['user_id']."' and status = '1' ";
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			while($get_query_date = mysql_fetch_array($get_query_res))
			{
				$user_id = $get_query_date['from_user'];
				$add_date = $get_query_date['add_date'];
				$username = GetValue("user","username","id",$user_id);
				$first_name = GetValue("user","first_name","id",$user_id);
				$last_name = GetValue("user","last_name","id",$user_id);
				$is_private = GetValue("user","is_private","id",$user_id);
				$profile_image = GetValue("user","profile_image","id",$user_id);
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
						"add_date"=>$add_date,
						"username"=>$username,
						"first_name"=>$first_name,
						"last_name"=>$last_name,
						"profile_imagel"=>$profile_imagel,
						"is_private"=>$is_private
						);
				
			}
			$message="Request found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);	
			
		}
		else
		{
			$error = "Request not found.";
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