<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['liked_by'] != '')
	{
		$challenge_id = $_REQUEST['challenge_id'];
		$user_id = $_REQUEST['user_id'];
		$get_query = "select * from story_like where liked_by = '".$_REQUEST['liked_by']."' and story_id = '".$_REQUEST['challenge_id']."'";		
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			$error = "Story already liked.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		else
		{
			$likes = GetValue("store_challenge_complete_by_user","likes","id",$challenge_id,$db);
			$likes = $likes + 1;
			$points = GetValue("user","points","id",$user_id,$db);
			$points = $points +1;

			$insert_query = "insert into story_like set 					
					user_id='".$_REQUEST['user_id']."',
					liked_by='".$_REQUEST['liked_by']."',
					story_id='".$_REQUEST['challenge_id']."',
					add_date=NOW(),				
					story_id = '".$story_id."'";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					$inserted_id = mysqli_insert_id($db);

					$insert_query2 = "insert into store_challenge_complete_by_user set 					
					likes=$likes ";
					mysqli_query($db,$insert_query2)or die(mysqli_error($db));
					$inserted_id = mysqli_insert_id($db);	
					
					$insert_query3 = "insert into user set 					
					points=$points ";
					mysqli_query($db,$insert_query3)or die(mysqli_error($db));
					$inserted_id = mysqli_insert_id($db);
						
					$error = "Story liked Successfully";
					$result=array('message'=> $error, 'result'=>'1','id'=>$inserted_id,'add_date'=>$add_date);
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
