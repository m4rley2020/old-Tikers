<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from user where id = '".$_REQUEST['user_id']."' ";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			
			
			
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$user_id = $get_query_date2['id'];
				$email = $get_query_date2['email'];
				$phone_number = $get_query_date2['phone_number'];
				$username = $get_query_date2['username'];
				$first_name = $get_query_date2['first_name'];
				$last_name = $get_query_date2['last_name'];
				$gender = $get_query_date2['gender'];
				$bio = $get_query_date2['bio'];
				$email = $get_query_date2['email'];
				$profile_image = $get_query_date2['profile_image'];
				$is_private = $get_query_date2['is_private'];
				$country_code = $get_query_date2['country_code'];
				$register_type = $get_query_date2['register_type'];
				
				if($register_type != 'fb' && $register_type != 'google'){
					if(file_exists("../User_image/".$profile_image) && $profile_image!="")
					{
						$profile_image1 = $SITE_URL."../User_image/".$profile_image;
					}
					else
					{
						$profile_image1 = "";
					}
				}
				else{
					$profile_image1 = $profile_image;
				}
					
				
				$challengestot = 0;
				
				$follow_total = mysqli_num_rows(mysqli_query($db,"select id from friend where from_user = '".$user_id."' "));				
				$following_total = mysqli_num_rows(mysqli_query($db,"select id from friend where to_user = '".$user_id."' "));	
				$challengestot = mysqli_num_rows(mysqli_query($db,"select id from store_challenge_complete_by_user where user_id = '".$user_id."' "));	
				
									
				
				$data[]=array(
				"user_id"=>$user_id,
				"email"=>$email, 
				"phone_number"=>$phone_number,
				"username"=>$username,
				"first_name"=>$first_name,
				"last_name"=>$last_name,
				"gender"=>$gender,
				"bio"=>$bio,
				"email"=>$email,
				"profile_image"=>$profile_image1,
				"is_private"=>$is_private,
				"challengestot"=>$challengestot,
				"follow_total"=>$follow_total,
				"following_total"=>$following_total,
				"country_code" => $country_code
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