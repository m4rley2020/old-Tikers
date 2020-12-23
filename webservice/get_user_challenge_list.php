<?php
	header("Content-type: application/json");
	include("connect.php");

	
	if($_REQUEST['user_id'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '' && $_REQUEST['challenge_type_id'] != '')
	{
		
		$latitude = $_REQUEST['latitude'];
		$longitude = $_REQUEST['longitude'];

		$get_query = "select store_challenges.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(store_challenges.lattitude ) ) * cos( radians( store_challenges.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(store_challenges.lattitude ) ) ) ) AS range1  from store_challenges having range1<='60'";
		
		if($_REQUEST['challengename'] != '')
		{
			$get_query .= "and name like '%".$_REQUEST['challengename']."%' ";
		}
		
		if($_REQUEST['challenge_type_id'] != '')
		{
			$get_query .= " and challenge_type_id = ".$_REQUEST['challenge_type_id']." ";
		}
		
		if($_REQUEST['storename'] != '')
		{
			$storename = $_REQUEST['storename'].',';				
			$select_query = "select id from store where name like '%".$storename."%'";	
			$run_query = mysqli_query($db,$select_query) or die(mysqli_error($db));

			if(mysqli_num_rows($run_query) > 0)
			{
				while($fetch_data = mysqli_fetch_array($run_query))
				{
					$store_id .= $fetch_data['id'].",";
				}
			}
				
			$store_id=trim($store_id,",");
			if($store_id != "") 
			{
				$get_query .= " and store_id in (".$store_id.")";
			}		
			
		}
		
		$orderby= " order by range1 asc";
		
		$get_query .=$orderby;
		
		
		
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
							"rating" => $store_rating
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