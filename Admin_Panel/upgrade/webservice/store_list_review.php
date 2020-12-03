<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '')
	{
		
		$get_query2 = "select * from store_comment where store_id = '".$_REQUEST['store_id']."' order by id desc";
		$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysql_fetch_array($get_query_res2))
			{
				$id = $get_query_date2['id'];
				$user_id = $get_query_date2['user_id'];
				$store_id = $get_query_date2['store_id'];
				$star = $get_query_date2['star'];
				$comment = $get_query_date2['comment'];
				$add_date = $get_query_date2['add_date'];
				
				$username = GetValue("user","username","id",$user_id);
				
				$profile_image = GetValue("user","profile_image","id",$user_id);
				
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_image1 = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_image1 = "";
				}						
				
				$data[]=array(
				"id"=>$id,
				"user_id"=>$user_id,
				"username"=>$username,
				"profile_image1"=>$profile_image1, 
				"store_id"=>$store_id,
				"star"=>$star,
				"comment"=>$comment,
				"add_date"=>$add_date							
				);
				
			}	
			$message="Store Review found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Store Review not found.";
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