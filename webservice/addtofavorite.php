<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '')
	{
		
		$get_query = "select * from favourite where user_id = '".$_REQUEST['user_id']."' and challenge_id = '".$_REQUEST['challenge_id']."'";		
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			$error = "Challenge is alredy added.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		else
		{

			$get_query2 = "select store_id from store_challenges where id = '".$_REQUEST['challenge_id']."'";
			$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
			$get_q2 = mysqli_fetch_array($get_query_res2);

			$store_id = $get_q2['store_id'];

			$insert_query = "insert into favourite set 					
					user_id='".$_REQUEST['user_id']."',
					challenge_id='".$_REQUEST['challenge_id']."',
					add_date=NOW(),				
					store_id = '".$store_id."'";
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					$inserted_id = mysqli_insert_id();
					$add_date = GetValue("favourite","add_date","id",$inserted_id);				
						
					$error = "Post Added Successfully";
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
