<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['storeid'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '')
	{
		$store_id = $_REQUEST['storeid'];
		$latitude = $_REQUEST['latitude'];
		$longitude = $_REQUEST['longitude'];
		
		$store_query = mysqli_query($db,"select * from store where id='".$store_id."' and latitude = '".$latitude."' and longitude = '".$longitude."' ");
		
		if(mysqli_num_rows($store_query) > 0 ){

			$user_query = "select user.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(user.latitude ) ) * cos( radians( user.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(user.latitude ) ) ) ) AS range1 from user where user_type = 'Famous' having range1 <= '60'  ";
			$user_query_res =   mysqli_query($db,$user_query)or die(mysqli_error($db));
			if(mysqli_num_rows($user_query_res)>0)
			{
				while($user_data = mysqli_fetch_array($user_query_res)){
					$user_id = $user_data['id']; 
					$firstname = $user_data['first_name']; 
					$lastname = $user_data['last_name']; 
					$username = $user_data['username'];
					$profile_image = $user_data['profile_image'];
					$register_type = $user_data['register_type'];
					
					if($register_type != 'fb' && $register_type != 'google'){
						if(file_exists("../User_image/".$profile_image) && $profile_image!="")
						{
							$profile_imagel = $SITE_URL."/User_image/".$profile_image;
						}
						else
						{
							$profile_imagel = "";
						}
					}
					else{
						$profile_image1 = $profile_image;
					}
				
					$userdata[]=array(
						"userid"=>$user_id,
						"fisrt_name"=>$firstname,
						"last_name"=>$lastname,
						"username"=>$username, 
						"profile_image"=>$profile_imagel,
					);	
				}
				
				$message="Famous User list.";
				$result=array('message'=> $message, 'result'=>'1','responseData'=>$userdata);
			}
			else{
				$message="Famous user not found.";
				$result=array('message'=> $message, 'result'=>'0','responseData'=>[]);
			}
		}
		else{
			$message="Store not found.";
			$result=array('message'=> $message, 'result'=>'0','responseData'=>[]);
		}
	}
	else
	{
		$message = "Please enter all required fields";
		$result=array('message'=> $message, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>