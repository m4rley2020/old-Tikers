<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from advertise order by id desc";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			
			
			
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$ads_id = $get_query_date2['id'];
				$title = $get_query_date2['title'];
				$message = $get_query_date2['message'];
				
				$ads_image = $get_query_date2['ads_image'];				
				if(file_exists("../ads_images/".$ads_image) && $ads_image!="")
				{
					$ads_image1 = $SITE_URL."/ads_images/".$ads_image;
				}
				else
				{
					$ads_image1 = "";
				}						
				
				$ads_video = $get_query_date2['ads_video'];				
				if(file_exists("../ads_video/".$ads_video) && $ads_video!="")
				{
					$ads_video1 = $SITE_URL."/ads_video/".$ads_video;
				}
				else
				{
					$ads_video1 = "";
				}
				
				$data[]=array(
				"ads_id"=>$ads_id,
				"title"=>$title, 
				"message"=>$message, 
				"ads_image"=>$ads_image1, 
				"ads_video1"=>$ads_video1			
				);
				
			}	
			$message="Ads found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Ads not found.";
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