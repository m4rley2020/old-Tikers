<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['packageid'] != '' && $_REQUEST['user_id'] != '')
	{
		$packageid = $_REQUEST['packageid'];
		$userid = $_REQUEST['user_id'];
		
		$get_query2 = "select SC.*, CT.name as chanllenge_type, S.name as store_name, S.rating, SCC.user_id as completed_by_user from store_challenges SC left join challenge_type CT on SC.challenge_type_id = CT.id left join store S on SC.store_id = S.id left join store_challenge_complete_by_user SCC on SC.id = SCC.challenge_id where SC.package like '%$packageid%' and SC.is_deleted = 0 and SC.is_approved = 1 order by SC.id desc";
		
		$get_query_res2 = mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysql_fetch_array($get_query_res2))
			{
				$id = $get_query_date2['id'];
				$challenge_type_id = $get_query_date2['challenge_type_id'];
				$challenge_type_name = $get_query_date2['chanllenge_type'];
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
				
				$rating =  number_format($get_query_date2['rating']);
				if($store_id > 0){
					$store_name = $get_query_date2['store_name'];
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
				
				$is_challenge_completed = "no";
				if($get_query_date2['completed_by_user'] > 0){
					$is_challenge_completed = "yes";
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
				"rating"=>$rating,
				"is_challenge_completed"=>$is_challenge_completed
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