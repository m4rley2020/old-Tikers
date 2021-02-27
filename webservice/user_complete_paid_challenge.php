<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['store_id'] != '' && $_REQUEST['code'] != '' )
	{
		if($_FILES['challenge_image']['name']!="")
		{	
			$challenge_image = str_replace(" ","_",rand(1,999).trim($_FILES['challenge_image']['name']));
			move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../complete_challenge_image/".$challenge_image);
		}
		
		$code_query= "select * from store_code where code ='".$_REQUEST['code']."' AND is_used = 'No' & store_id ='".$_REQUEST['store_id']."'";
		$get_code= mysqli_query($db,$code_query)or die(mysqli_error($db));

		/* ---------------------- check code and get user points ---------------------- */
		if(mysqli_num_rows($get_code)>0){

			$get_code_fetch = mysqli_fetch_array($get_code);
			$challenge_points= $get_code_fetch['points'];

			$points_query="select points from user where id='".$_REQUEST['user_id']."'";
			$get_points= mysqli_query($db,$points_query)or die(mysqli_error($db));
			$get_points_fetch = mysqli_fetch_array($get_points);
			$user_points= $get_points_fetch['points'];

			$new_points= $challenge_points + $user_points;

			$update_user="update user set points ='".$new_points."' where id='".$_REQUEST['user_id']."'";
			mysqli_query($db,$update_user)or die(mysqli_error($db));

					

			/* ---------------------- counter ---------------------- */
			$counter;
			$q1 = "select counter from store_challenges where id='".$_REQUEST['challenge_id']."'";
			$get_query_res2 = mysqli_query($db,$q1)or die(mysqli_error($db));

			if(mysqli_num_rows($get_query_res2)>0)
			{
				$get_query_date2 = mysqli_fetch_array($get_query_res2);
				$counter = $get_query_date2['counter'];
				$counter++;
			}
			$insert_query1 = "update store_challenges  set counter ='".$counter."' where id='".$_REQUEST['challenge_id']."'";
			mysqli_query($db,$insert_query1)or die(mysqli_error($db));

					
			
			/* ---------------------- insert Fields ---------------------- */
			$insert_query = "insert into store_challenge_complete_by_user set 					
					user_id='".$_REQUEST['user_id']."',
					challenge_id='".$_REQUEST['challenge_id']."',
					store_id='".$_REQUEST['store_id']."',
					challenge_image='".$challenge_image."',
					points='".$challenge_points."',			
					add_date = NOW()";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					$post_id = mysqli_insert_id($db);
					
					$error = "Challenge Completed Successfully";
					$result=array('message'=> $error, 'result'=>'1');

					$insert_query2 = "update store_code set user_id = '".$_REQUEST['user_id']."' ,
					challenge_id = '".$_REQUEST['challenge_id']."', is_used = 'Yes', date=NOW() where code = '".$_REQUEST['code']."' ";
					
					mysqli_query($db,$insert_query2)or die(mysqli_error($db));
					$post_id = mysqli_insert_id($db);

		}
		else
		{
			$error = "your code is incorrect or used";
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