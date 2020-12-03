<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['challengid'] != '' && $_REQUEST['user_id'])
	{
		
		$get_query = "select * from store_challenges where id = '".$_REQUEST['challengid']."'";		
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{		
			
			while($get_query_date2 = mysql_fetch_array($get_query_res))
			{
				
				$name = $get_query_date2['name'];
				$description = $get_query_date2['description'];
				$challenge_image = $get_query_date2['challeng_image'];				
				$store_id = $get_query_date2['store_id'];
				$lattitude = $get_query_date2['lattitude'];
				$longitude = $get_query_date2['longitude'];
				$location = $get_query_date2['location'];
				$points = $get_query_date2['points'];
				$challenge_type_id = $get_query_date2['challenge_type_id'];		
				
				$check_fav = "select id from favourite where challange_id = '".$_REQUEST['challengid']."' and user_id = '".$_REQUEST['user_id']."' ";
				$check_fav_res = mysql_query($check_fav) or die(mysql_error());
				$is_fav = 0;
				if(mysql_num_rows($check_fav_res)>0)
				{
					$is_fav = 1;
				}		
				
				$get_query2 = "select name from challenge_type where id = '".$challenge_type_id."'";		
				$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
				
				if(mysql_num_rows($get_query_res2)>0)
				{							
					while($get_query_data = mysql_fetch_array($get_query_res2))
					{
						$challengtype = $get_query_data['name'];
					}
				}

				$get_query3 = "select name,rating from store where id = '".$store_id."'";		
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
					$challenge_image1 = "";
				}						
				
				$data[]=array(				
				"image"=>$challenge_image1,
				"challenge_type_id"=>$challenge_type_id,
				"challengtype"=>$challengtype,
				"challengename"=>$name, 
				"store_id"=>$store_id, 
				"storename"=>$store_name,
				"rating"=>$store_rating,				
				"description"=>$description,
				"favflag"=>'0',
				"storid"=>$store_id,
				"lattitude"=>$lattitude,
				"longitude"=>$longitude,
				"location"=>$location,
				"points"=>$points,
				"is_fav"=>$is_fav
				);
				
			}	
			$message="Challenge found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
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