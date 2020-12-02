<?php
	header("Content-type: application/json");
	include("connect.php");

	
	if($_REQUEST['user_id'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '' && $_REQUEST['start'] != '' && $_REQUEST['start'] >= 0)
	{
		
		$latitude = $_REQUEST['latitude'];
		$longitude = $_REQUEST['longitude'];
		$store_name = "";
		$store_rating = 0;
		$post_start_limit = $_REQUEST['start'];
		
		$get_query = "select store_challenges.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(store_challenges.lattitude ) ) * cos( radians( store_challenges.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(store_challenges.lattitude ) ) ) ) AS range1  from store_challenges having range1<='60'";
		
		if($_REQUEST['challengename'] != '')
		{
			$get_query .= "and name like '%".$_REQUEST['challengename']."%' ";
		}
		
		if($_REQUEST['challenge_type_id'] != '')
		{
			$get_query .= " and challenge_type_id = ".$_REQUEST['challenge_type_id']." ";
		}
		
		if($_REQUEST['gender'] != '' && ($_REQUEST['gender'] == 0 || $_REQUEST['gender'] == 1))
		{
			$get_query .= " and gender = ".$_REQUEST['gender']." ";
		}
		
		if($_REQUEST['storename'] != '')
		{
			$storename = $_REQUEST['storename'].',';				
			$select_query = "select id from store where name like '%".$storename."%'";	
			$run_query = mysql_query($select_query) or die(mysql_error(	));

			if(mysql_num_rows($run_query) > 0)
			{
				while($fetch_data = mysql_fetch_array($run_query))
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
		
		$orderby= " order by range1 asc limit $post_start_limit,10";
		
		$get_query .=$orderby;
		
		
		$result = mysql_query($get_query);

		if(mysql_num_rows($result) > 0)
		{
			while($row = mysql_fetch_array($result))
			{
				$challenge_image = $row['challeng_image'];
				$challenge_is_favourite = 0;
				$is_completed = 0;				

				$get_query3 = "select name,rating from store where id = '".$row['store_id']."'";		
					$get_query_res3 =   mysql_query($get_query3)or die(mysql_error());
					
					if(mysql_num_rows($get_query_res3)>0)
					{							
						while($get_query_data3 = mysql_fetch_array($get_query_res3))
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
					$get_ch_type_res3 =   mysql_query($get_ch_type_query)or die(mysql_error());
					
					if(mysql_num_rows($get_ch_type_res3)>0)
					{							
						while($get_ch_type_data3 = mysql_fetch_array($get_ch_type_res3))
						{
							$challenge_type = $get_ch_type_data3['challenge_type_name'];
							
						}
					}
				
				$get_ch_favourite_query = "select id as favourite_id from favourite where challange_id = '".$row['id']."' and user_id = '".$_REQUEST['user_id']."' ";		
					$get_ch_favourite_res3 =   mysql_query($get_ch_favourite_query)or die(mysql_error());
					
					if(mysql_num_rows($get_ch_favourite_res3)>0)
					{							
						$challenge_is_favourite = 1;
					}
					
				$get_ch_completed_query = "select id as completed_chelange_id from store_challenge_complete_by_user where challenge_id = '".$row['id']."' and user_id = '".$_REQUEST['user_id']."' and is_approve = '1' ";		
					$get_ch_completed_res3 =   mysql_query($get_ch_completed_query)or die(mysql_error());
					
					if(mysql_num_rows($get_ch_completed_res3)>0)
					{							
						$is_completed = 1;
					}

				$data[]=array(
							"challenge_id" => $row['id'], 
							"storename" => $store_name,
							"challengename" => $row['name'],
							"challenge_type" => $challenge_type,
							"challenge_is_favourite" => $challenge_is_favourite,
							"is_completed"=>$is_completed,
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