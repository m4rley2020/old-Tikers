<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '')
	{	
		$get_query2 = "select * from store where id = '".$_REQUEST['store_id']."' order by id desc";
		$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{	
			while($get_query_date2 = mysql_fetch_array($get_query_res2))
			{
				$store_id = $get_query_date2['id'];
				$store_name= $get_query_date2['name'];
				$store_image= $get_query_date2['store_image'];
				$user_id = $get_query_date2['user_id'];
				
				
				if(file_exists("../store_image/".$store_image) && $store_image!="")
				{
					$store_image1 = $SITE_URL."/store_image/".$store_image;
				}
				else
				{
					$store_image1 = "";
				}
				
				echo $get_store_cha_count = "select id as challenge_count from store_challenges where store_id = '".$_REQUEST['store_id']."' ";
				$get_store_cha_count_res = mysql_query($get_store_cha_count) or die(mysql_error());
					
				$challenge_count = mysql_num_rows($get_store_cha_count_res);
				
				
				$followers_count = mysql_num_rows(mysql_query("select id from friend where to_user = '".$user_id."' and status = 2 "));			
				
				$data[]=array(
				"store_id"=>$store_id,
				"store_name"=>$store_name,
				"store_image"=>$store_image1,
				"challenge_count"=>$challenge_count,
				"followers_count"=>$followers_count,		
				);				
			}	
			$message="Store found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Store not found.";
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