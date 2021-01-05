<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '')
	{
		
		$get_query2 = "select * from store_challenges where store_id = '".$_REQUEST['store_id']."'";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$id = $get_query_date2['id'];
				$challenge_type_id = $get_query_date2['challenge_type_id'];
				$challenge_type_name = GetValue("challenge_type","name","id",$challenge_type_id,$db);
				$challenge_name = $get_query_date2['name'];
				$challeng_image = $get_query_date2['challeng_image'];
				$description = $get_query_date2['description'];
				$location = $get_query_date2['location'];
				$lattitude = $get_query_date2['lattitude'];
				$longitude = $get_query_date2['longitude'];
				$points = $get_query_date2['points'];
				$store_id = $get_query_date2['store_id'];
				
				$rating = number_format(GetValue("store","rating","id",$store_id),2) ;
				
				if(file_exists("../challenge_image/".$challeng_image) && $challeng_image!="")
				{
					$challeng_image = $SITE_URL."/challenge_image/".$challeng_image;
				}
				else
				{
					$challeng_image = "";
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
				"rating"=>$rating				
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