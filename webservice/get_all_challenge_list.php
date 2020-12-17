<?php
	header("Content-type: application/json");
	include("connect.php");

	
	if($_REQUEST['user_id'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '')
	{
		
		$latitude = $_REQUEST['latitude'];
		$longitude = $_REQUEST['longitude'];

		$get_query = "select * from store_challenges";
		
		/*if($_REQUEST['challenge_type_id'] != '')
		{
			$get_query .= " and challenge_type_id = ".$_REQUEST['challenge_type_id']." ";
		}*/
		
		
		
		
		
		
		
		$result = mysqli_query($db,$get_query);

		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$challenge_image = $row['challeng_image'];
				
				

				$get_query3 = "select name,rating from store where id = '".$row['store_id']."'";		
					$get_query_res3 =   mysqli_query($db,$get_query3)or die(mysqli_error($db));
					
					if(mysqli_num_rows($get_query_res3)>0)
					{							
						while($get_query_data3 = mysqli_fetch_array($get_query_res3))
						{
							$store_name = $get_query_data3['name'];
							$store_rating = number_format($get_query_data3['rating'],2);
						}
					}
					
					$get_query4 = "select name from challenge_type where id = '".$row['challenge_type_id']."'";		
					$get_query_res4 =   mysqli_query($db,$get_query4)or die(mysqli_error($db));
					if(mysqli_num_rows($get_query_res4)>0)
					{							
						while($get_query_data4 = mysqli_fetch_array($get_query_res4))
						{
							$challenge_type = $get_query_data4['name'];
						}
					}


				if(file_exists("../challenge_image/".$challenge_image) && $challenge_image!="")
				{
					$challenge_image1 = $SITE_URL."../challenge_image/".$challenge_image;
				}
				else
				{
					$challenge_image1 = "0";
				}

				$data[]=array(
							"challenge_id" => $row['id'], 
							"storename" => $store_name,
							"challengename" => $row['name'],
							"image" => $challenge_image1,
							"rating" => $row['rating'],						
							"storeid" => $row['store_id'],
							"lattitude" => $row['lattitude'],
							"longitude" => $row['longitude'],
							"location" => $row['location'],
							"points" => $row['points'],
							"description" => $row['description'],
							"rating" => $store_rating,
							"counter"=>$row['counter']
							);
			}

			$error = "Success";
			$result=array('message'=> $error, 'result'=>'1','responseData'=>$data);	
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