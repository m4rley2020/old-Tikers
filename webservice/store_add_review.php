<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['store_id'] != '' && $_REQUEST['star'] != '' && $_REQUEST['comment'] != '')
	{	
		
		$check_customer_mobile = mysqli_query($db,"select id from store where id ='".$_REQUEST['store_id']."' ") or die(mysqli_error($db));
		if(mysqli_num_rows($check_customer_mobile) > 0)
		{
			$insert_query = "insert into store_comment set 					
					user_id='".$_REQUEST['user_id']."',
					store_id='".$_REQUEST['store_id']."',
					star='".$_REQUEST['star']."',
					comment='".$_REQUEST['comment']."',					
					add_date=NOW()";
					
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					$store_id = mysqli_insert_id();
					
					$get_average = "SELECT AVG(star) 'avg_rating' FROM store_comment where store_id = '".$_REQUEST['store_id']."' ";
					$get_average_res = mysqli_query($db,$get_average) or die(mysqli_error($db));
					$get_average_data = mysqli_fetch_array($get_average_res);
					$avg_rating = $get_average_data['avg_rating'];
					
					$update_store = "update store set rating = '".$avg_rating."' where id = '".$_REQUEST['store_id']."' ";
					$update_store_res = mysqli_query($db,$update_store) or die(mysqli_error($db));
					
					$error = "Store Review Added Successfully";
					$result=array('message'=> $error, 'result'=>'1');
		}				
		else
		{
			$message = "Store Not Found.";
			$result=array('message'=> $message, 'result'=>'0');
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