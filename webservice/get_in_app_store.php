<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from in_app_store order by id desc";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			
			
			
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$store_id = $get_query_date2['id'];
				$name = $get_query_date2['name'];
				$store_image = $get_query_date2['store_image'];
				$cost = $get_query_date2['cost'];
				
				if(file_exists("../app_store_image/".$store_image) && $store_image!="")
				{
					$store_image1 = $SITE_URL."../app_store_image/".$store_image;
				}
				else
				{
					$store_image1 = "";
				}						
				
				$data[]=array(
				"id"=>$store_id,
				"name"=>$name,
				"store_image"=>$store_image1,
				"cost"=>$cost				
				);
				
			}	
			$message="app store found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "app store not found.";
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