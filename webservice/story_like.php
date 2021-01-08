<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '')
	{
		
		$get_query = "select * from story_like where user_id = '".$_REQUEST['user_id']."' and completed_challenge_id = '".$_REQUEST['challenge_id']."'";		
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			$error = "Story already liked.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		else
		{

			$insert_query = "insert into story_like set 					
					user_id='".$_REQUEST['user_id']."',
					completed_challenge_id='".$_REQUEST['challenge_id']."',
					add_date=NOW()";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
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
