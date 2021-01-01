<?php
	header("Content-type: application/json");
	include("connect.php");

	
	if($_REQUEST['store_id'] != '')
	{
		$get_ch_ids = "select challenge_id from store_challenge_complete_by_user where store_id = '".$_REQUEST['store_id']."' ";
		$get_ch_ids_res = mysqli_query($get_ch_ids) or die(mysqli_error());
		if(mysqli_num_rows($get_ch_ids_res) > 0)
		{
			$completed_che_ids = "";
			while($get_ch_ids_row = mysqli_fetch_array($get_ch_ids_res))
			{
				$completed_che_ids = $completed_che_ids.",".$get_ch_ids_row['challenge_id'];
			}
			$completed_che_ids = trim($completed_che_ids,",");
			
			
			$store_name = "";
			$store_rating = 0;
			
			$get_query = "select * from store_challenges where id in (".$completed_che_ids.") ";
			
			$result = mysqli_query($get_query);

			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_array($result))
				{
					$challenge_image = $row['challeng_image'];
					$challenge_is_favourite = 0;
					$is_completed = 0;				

					$get_query3 = "select name,rating from store where id = '".$row['store_id']."'";		
						$get_query_res3 =   mysqli_query($get_query3)or die(mysqli_error());
						
						if(mysqli_num_rows($get_query_res3)>0)
						{							
							while($get_query_data3 = mysqli_fetch_array($get_query_res3))
							{
								$store_name = $get_query_data3['name'];
								$store_rating = number_format($get_query_data3['rating'],2);
							}
						}

					if(file_exists("../challenge_image/".$challenge_image) && $challenge_image!="")
					{
						$challenge_image1 = $SITE_URL."/challenge_image/".$challenge_image;
					}
					else
					{
						$challenge_image1 = "0";
					}
					
					$get_ch_type_query = "select name as challenge_type_name from challenge_type where id = '".$row['challenge_type_id']."'";		
						$get_ch_type_res3 =   mysqli_query($get_ch_type_query)or die(mysqli_error());
						
						if(mysqli_num_rows($get_ch_type_res3)>0)
						{							
							while($get_ch_type_data3 = mysqli_fetch_array($get_ch_type_res3))
							{
								$challenge_type = $get_ch_type_data3['challenge_type_name'];
								
							}
						}
					
					
						
					

					$data[]=array(
								"challenge_id" => $row['id'], 
								"storename" => $store_name,
								"challengename" => $row['name'],
								"challenge_type" => $challenge_type,
								"image" => $challenge_image1,
								"rating" => $row['rating'],						
								"storeid" => $row['store_id'],
								"lattitude" => $row['lattitude'],
								"longitude" => $row['longitude'],
								"location" => $row['location'],
								"points" => $row['points'],
								"description" => $row['description'],
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