<?php
	header("Content-type: application/json");
	include("connect.php");
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['store_id'] !='')
	{
		
		if($_FILES['challenge_image']['name']!="")
		{	
			$challenge_image = str_replace(" ","_",rand(1,999).trim($_FILES['challenge_image']['name']));
			move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../complete_challenge_image/".$challenge_image);
		}

		$get_query4 = "select points from user where id = '" . $_REQUEST['user_id'] . "'";
	$get_query_res4 =   mysqli_query($db, $get_query4) or die(mysqli_error($db));
	$get_q4 = mysqli_fetch_array($get_query_res4);
	$user_points = $get_q4['points'];

		$insert_query = "insert into store_challenge_complete_by_user set 					
				user_id='".$_REQUEST['user_id']."',
				challenge_id='".$_REQUEST['challenge_id']."',
				store_id='".$_REQUEST['store_id']."',
				challenge_image='".$challenge_image."',	
				points='".$user_points."',	
				add_date = NOW()";
				mysqli_query($db, $insert_query)or die(mysqli_error($db));
				$post_id = mysqli_insert_id($db);
				
				
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