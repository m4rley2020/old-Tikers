<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from promo_section order by id desc";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$promo_id = $get_query_date2['id'];
				$name = $get_query_date2['name'];
				$promo_image = $get_query_date2['promo_image'];
				
				if(file_exists("../promo_image/".$promo_image) && $promo_image!="")
				{
					$promo_image1 = $SITE_URL."/promo_image/".$promo_image;
				}
				else
				{
					$promo_image1 = "";
				}						
				
				$data[]=array(
				"id"=>$promo_id,
				"name"=>$name,
				"promo_image"=>$promo_image1				
				);
				
			}	
			$message="Promo found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Promo not found.";
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