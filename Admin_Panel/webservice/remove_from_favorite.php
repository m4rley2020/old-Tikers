<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challange_id'] != '')
	{
		
		$get_query = "select * from favourite where user_id = '".$_REQUEST['user_id']."' and challange_id = '".$_REQUEST['challange_id']."'";		
		$get_query_res =   mysql_query($get_query)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res)>0)
		{
			$challange_id = $_REQUEST['challange_id'];	
			
			$get_query = "delete from favourite where user_id = '".$_REQUEST['user_id']."' and challange_id = '".$_REQUEST['challange_id']."'";		
			$get_query_res =   mysql_query($get_query)or die(mysql_error());				

							
			$error = "Challange removed from your favourite.";
			$result=array('message'=> $error, 'result'=>'1');
		}
		else
		{
			$error = "This Challange is not in your favourite.";
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
