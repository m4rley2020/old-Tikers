<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'])
	{
		$get_chalange = "select * from store_challenges where famous_user_id = '".$_REQUEST['user_id']."' and id = '".$_REQUEST['challenge_id']."' ";
		$get_chalange_res = mysql_query($get_chalange) or die(mysql_error());
		$get_chalange_row = mysql_fetch_array($get_chalange_res);
		
		$expired_date = $get_chalange_row['expired_date'];		
		
		
		if($expired_date < date("Y-m-d"))
		{	
			$update_che = "update store_challenges set expired_date = DATE_ADD(expired_date, INTERVAL +1 MONTH), is_renewed = 1 where famous_user_id = '".$_REQUEST['user_id']."' and id = '".$_REQUEST['challenge_id']."' ";
			
			mysql_query($update_che) or die(mysql_error());
			
			$error = "Challenge Re-Post Successfully";
			$result=array('message'=> $error, 'result'=>'1','user_id'=>$_REQUEST['user_id'],'challenge_id'=>$_REQUEST['challenge_id']);
			
		}
		else
		{
			$error = "Challenge is currently active so you can not Re-post it.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		
	}
	
	$result=json_encode($result);
	echo $result;
		
?>