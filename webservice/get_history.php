<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from store_challenge_complete_by_user where user_id = '".$_REQUEST['user_id']."'";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$date = $get_query_date2['add_date'];
				$points = $get_query_date2['points'];
				$store_id =$get_query_date2['store_id'];
				
		$get_query4 = "select name from store where id = '".$store_id."'";
        $get_query_res4 =   mysqli_query($db,$get_query4)or die(mysqli_error($db));
		$get_q4 = mysqli_fetch_array($get_query_res4);
		$store_name = $get_q4['name'];					
				
				$data[]=array(
				"store_name"=>$store_name,
				"points"=>$points, 
				"date"=>$date			
				);
				
			}	
			$message="History found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "History not found.";
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