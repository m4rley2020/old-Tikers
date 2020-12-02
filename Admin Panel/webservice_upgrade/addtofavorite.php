<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challange_id'] != '')
	{
		
		$get_query = "select * from favourite where user_id = '".$_REQUEST['user_id']."' and challange_id = '".$_REQUEST['challange_id']."'";		
		$get_query_res =   mysqli_query($db,$get_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res)>0)
		{
			$error = "Challange is alredy added.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		else
		{
		
		$challange_id = $_REQUEST['challange_id'];
		
		$store_id = GetValue("store_challenges","store_id","id",$challange_id);

		$insert_query = "insert into favourite set 					
				user_id='".$_REQUEST['user_id']."',
				challange_id='".$_REQUEST['challange_id']."',
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
