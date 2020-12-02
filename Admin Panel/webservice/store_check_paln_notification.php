<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
	
	
			 
	if($_REQUEST['store_id'] != '' )
	{
		$today = date("Y-m-d"); 
		$expire_date =  GetValue('store','expire_date','id',$_REQUEST['store_id']);
		
		if ($expire_date > $today)
		{
			$error = "Current Plan is active.";
			$result=array('message'=> $error, 'result'=>'1');
		} 
		else
		{
			$error = "Plan is expired. Please renew your plan.";
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