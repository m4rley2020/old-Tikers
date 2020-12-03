<?php
	header("Content-type: application/json");
	include("connect.php");
	
	if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != ''){
		$famous_user_id = $_REQUEST['user_id'];
		
		$get_boost_challege_list = mysql_query("select challenge_id from boost_store_challenges where famous_user_id = '".$famous_user_id."' and is_accepted = 0");
		
		if(mysql_num_rows($get_boost_challege_list) > 0){
			while($boost_challenge_data = mysql_fetch_array($get_boost_challege_list)){
				$challege_id = $boost_challenge_data['challenge_id'];
				
				$get_challege_list = mysql_query("select * from store_challenges where id = '".$challege_id."' and is_boost = 0 order by id desc");
				if(mysql_num_rows($get_challege_list) > 0){
					$challenge_data = mysql_fetch_array($get_challege_list);
					$challenge_id = $challenge_data['id'];
					$challenge_type_id = $challenge_data['challenge_type_id'];
					$challenge_type_name = GetValue("challenge_type","name","id",$challenge_type_id);
					$challenge_name = $challenge_data['name'];
					$challeng_image = $challenge_data['challeng_image'];
					$description = $challenge_data['description'];
					$location = $challenge_data['location'];
					$lattitude = $challenge_data['lattitude'];
					$longitude = $challenge_data['longitude'];
					$points = $challenge_data['points'];
					$created_date = $challenge_data['created_date'];
					$approved_date = $challenge_data['approved_date'];
					$expired_date = $challenge_data['expired_date'];
					$is_boost = $challenge_data['is_boost'];
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
						"id"=>$challenge_data['id'],
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
			}
			$message="Requested Challenges for boost found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else{
			$error = "No boost request found";
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