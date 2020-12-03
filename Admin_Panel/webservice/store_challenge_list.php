<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{
		$post_start_limit = $_REQUEST['start'];
		$get_query2 = "select * from store_challenges where store_id = '".$_REQUEST['store_id']."' and is_deleted = 0 and is_approved = 1 order by id desc limit $post_start_limit,10 ";
		$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysql_fetch_array($get_query_res2))
			{
				$id = $get_query_date2['id'];
				$challenge_type_id = $get_query_date2['challenge_type_id'];
				$challenge_type_name = GetValue("challenge_type","name","id",$challenge_type_id);
				$challenge_name = $get_query_date2['name'];
				$challeng_image = $get_query_date2['challeng_image'];
				$description = $get_query_date2['description'];
				$location = $get_query_date2['location'];
				$lattitude = $get_query_date2['lattitude'];
				$longitude = $get_query_date2['longitude'];
				$points = $get_query_date2['points'];
				$store_id = $get_query_date2['store_id'];
				$created_date = $get_query_date2['created_date'];
				$approved_date = $get_query_date2['approved_date'];
				$expired_date = $get_query_date2['expired_date'];
				$is_boost = $get_query_date2['is_boost'];
				$is_expired = 0;
				
				$rating = number_format(GetValue("store","rating","id",$store_id),2) ;
				
				if(file_exists("../challenge_image/".$challeng_image) && $challeng_image!="")
				{
					$challeng_image = $SITE_URL."/challenge_image/".$challeng_image;
				}
				else
				{
					$challeng_image = "";
				}						
				
				if($expired_date < date("Y-m-d"))
				{
					$is_expired = 1;
				}
				$data[]=array(
					"id"=>$id,
					"challenge_type_id"=>$challenge_type_id,
					"challenge_type_name"=>$challenge_type_name,
					"challenge_name"=>$challenge_name, 
					"challeng_image"=>$challeng_image,
					"description"=>$description,
					"location"=>$location,
					"lattitude"=>$lattitude,
					"longitude"=>$longitude,
					"points"=>$points,
					"rating"=>$rating,
					"created_date"=>$created_date,
					"approved_date"=>$approved_date,
					"expired_date"=>$expired_date,
					"is_expired"=>$is_expired,
					"is_boost"=>$is_boost
				);
				
			}	
			$message="Challenge found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
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