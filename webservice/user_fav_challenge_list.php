<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		$get_query1 = "select * from favourite where user_id = '".$_REQUEST['user_id']."' order by id desc";
		$get_query_res1 =   mysqli_query($db,$get_query1)or die(mysqli_error($db));
		if(mysqli_num_rows($get_query_res1)>0)
		{
			while($get_query_date1 = mysqli_fetch_array($get_query_res1))
			{
				$get_query2 = "select * from store_challenges where id = '".$get_query_date1['challenge_id']."' order by id desc";
				$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
				
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
						
						
						$get_query3 = "select name,rating from store where id = '".$store_id."'";		
						$get_query_res3 =   mysqli_query($db,$get_query3)or die(mysqli_error($db));
				
							if(mysqli_num_rows($get_query_res3)>0)
							{							
								while($get_query_data3 = mysqli_fetch_array($get_query_res3))
								{
									$store_name = $get_query_data3['name'];
									$store_rating = number_format($get_query_data3['rating'],2);
								}
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
					$message="Favorite Challenge found.";
					$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
				}
				
			}
		}
		else
		{
			$error = "No Favorite Challenge not found.";
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