<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['store_id'] != '' && $_REQUEST['status'] != '' && $_REQUEST['amount'] != '' && $_REQUEST['currency'] != '')
	{
		
		if($_FILES['challenge_image']['name']!="")
		{	
			$challenge_image = str_replace(" ","_",rand(1,999).trim($_FILES['challenge_image']['name']));
			move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../complete_challenge_image/".$challenge_image);
		}
		
		if($_FILES['bill_image']['name']!="")
		{	
			$bill_image = str_replace(" ","_",rand(1,999).trim($_FILES['bill_image']['name']));
			move_uploaded_file($_FILES["bill_image"]["tmp_name"],"../complete_challenge_image/".$bill_image);
		}
		
		if($_REQUEST['status'] == "public")
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}
		
		$insert_query = "insert into store_challenge_complete_by_user set 					
				user_id='".$_REQUEST['user_id']."',
				challenge_id='".$_REQUEST['challenge_id']."',
				store_id='".$_REQUEST['store_id']."',
				status='".$status."',
				amount='".$_REQUEST['amount']."',
				currency='".$_REQUEST['currency']."',
				bill_image='".$bill_image."',
				challenge_image='".$challenge_image."',				
				add_date = NOW()";
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				$post_id = mysqli_insert_id();
				
				$error = "Challenge Completed Successfully";
				$result=array('message'=> $error, 'result'=>'1');
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>