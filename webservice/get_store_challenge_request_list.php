<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '')
	{ 
		$get_query1 = "select * from store_challenge_complete_by_user where store_id = '".$_REQUEST['store_id']."' and status = 0 order by add_date desc";
		$get_query_res1 =   mysqli_query($db,$get_query1)or die(mysqli_error($db));
		if(mysqli_num_rows($get_query_res1)>0)
		{
			while($get_query_date1 = mysqli_fetch_array($get_query_res1))
			{
				$challenge_image = $row['challeng_image'];
				if(file_exists("../complete_challenge_image/".$challenge_image) && $challenge_image!="")
				{
					$challenge_image1 = $SITE_URL."/complete_challenge_image/".$challenge_image;
				}
				else
				{
					$challenge_image1 = "0";
				}
				
				$bill_image = $row['bill_image'];
				if(file_exists("../complete_challenge_image/".$bill_image) && $bill_image!="")
				{
					$bill_image1 = $SITE_URL."/complete_challenge_image/".$bill_image;
				}
				else
				{
					$bill_image1 = "0";
				}
				
				$get_user = "select username,profile_image,first_name,last_name from user where id = '".$get_query_date1['user_id']."' ";
				$get_user_res = mysqli_query($db,$get_user) or die(mysqli_error($db));
				$get_user_row = mysqli_fetch_array($get_user_res);
				
				$profile_image = $get_user_row['profile_image'];
				if(file_exists("../User_image/".$profile_image) && $profile_image!="")
				{
					$profile_image1 = $SITE_URL."/User_image/".$profile_image;
				}
				else
				{
					$profile_image1 = "0";
				}
				
					
					$data[]=array(
						"id"=>$get_query_date1['id'],
						"user_id"=>$get_query_date1['user_id'],
						"username"=>$get_user_row['username'],
						"first_name"=>$get_user_row['first_name'],
						"last_name"=>$get_user_row['last_name'],
						"profile_image"=>$profile_image1,
						"store_id"=>$get_query_date1['store_id'],
						"challenge_id"=>$get_query_date1['challenge_id'],
						"challenge_image"=>$challenge_image1,
						"bill_image"=>$bill_image1,
						"amount"=>$get_query_date1['amount'], 
						"currency"=>$get_query_date1['currency'],
						"add_date"=>$get_query_date1['add_date']
						);	
					$message="Favorite Challenge found.";
					$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
				
				
			}
		}
		else
		{
			$error = "Challenge Request not found.";
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