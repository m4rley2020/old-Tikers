<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		$famous_user_id = $_REQUEST['user_id'];
		
		$get_boosted_challenge_qury = mysql_query("select * from store_challenges where is_boost = 1 and famous_user_id = $famous_user_id ");
		
		if(mysql_num_rows($get_boosted_challenge_qury) > 0){
			while($boosted_challenge_data = mysql_fetch_array($get_boosted_challenge_qury)){
					$challenge_id = $boosted_challenge_data['id'];
					$challenge_type_id = $boosted_challenge_data['challenge_type_id'];
					$challenge_type_name = GetValue("challenge_type","name","id",$challenge_type_id);
					$challenge_name = $boosted_challenge_data['name'];
					$challeng_image = $boosted_challenge_data['challeng_image'];
					$description = $boosted_challenge_data['description'];
					$location = $boosted_challenge_data['location'];
					$lattitude = $boosted_challenge_data['lattitude'];
					$longitude = $boosted_challenge_data['longitude'];
					$points = $boosted_challenge_data['points'];
					$created_date = $boosted_challenge_data['created_date'];
					$approved_date = $boosted_challenge_data['approved_date'];
					$expired_date = $boosted_challenge_data['expired_date'];
					$is_boost = $boosted_challenge_data['is_boost'];
					$is_expired = 0;
					
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
						"famous_user_id"=>$famous_user_id,
						"challenge_id"=>$challenge_id,
						"challenge_type_id"=>$challenge_type_id,
						"challenge_name"=>$challenge_name, 
						"challenge_type_name"=>$challenge_type_name,
						"challeng_image"=>$challeng_image,
						"description"=>$description,
						"location"=>$location,
						"lattitude"=>$lattitude,
						"longitude"=>$longitude,
						"points"=>$points,
						"created_date"=>$created_date,
						"approved_date"=>$approved_date,
						"expired_date"=>$expired_date,
						"is_expired"=>$is_expired
					);
			}
			$message="Boosted challenge list found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);
		}
		else
		{
			$error = "No any boosted challenge found.";
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