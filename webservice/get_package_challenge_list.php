<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['packageid'] != '')
	{
		$packageid = $_REQUEST['packageid'];
		$get_query2 = "select * from store_challenges where package like '%$packageid%'";
		$get_query_res2 = mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
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
				$challenge_creatd_by = '';
				$store_name = '';
				
				$rating = number_format(GetValue("store","rating","id",$store_id),2) ;
				if($store_id > 0){
					$store_name = GetValue("store","name","id",$store_id) ;
					$challenge_creatd_by = "Store";
				}
				else{
					$challenge_creatd_by = "Admin";
				}
				
				if(file_exists("../challenge_image/".$challeng_image) && $challeng_image!="")
				{
					$challeng_image = $SITE_URL."/challenge_image/".$challeng_image;
				}
				else
				{
					$challeng_image = "";
				}						
				
				$data[]=array(
				"challenge_id"=>$id,
				"challenge_type_id"=>$challenge_type_id,
				"challenge_type_name"=>$challenge_type_name,
				"challenge_name"=>$challenge_name, 
				"challeng_image"=>$challeng_image,
				"description"=>$description,
				"location"=>$location,
				"lattitude"=>$lattitude,
				"longitude"=>$longitude,
				"points"=>$points,
				"created_by"=>$challenge_creatd_by,
				"store_id"=>$store_id,
				"store_name"=>$store_name,
				"rating"=>$rating				
				);
				
			}	
			$message="Package Challenge found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Package Challenge not found.";
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