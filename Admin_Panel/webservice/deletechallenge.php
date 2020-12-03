<?php
	header("Content-type: application/json");
	include "connect.php";
	
	if($_REQUEST['userid']!="" && $_REQUEST['challengeid']!="")
	{
		$store_id 	= intval($_REQUEST['userid']);
		$challengeid = intval($_REQUEST['challengeid']);
		
		$sel_challenge = mysql_query("select * from store_challenges where id='".$challengeid."' and store_id='".$store_id."'");
		$sel_challenge_rows = mysql_num_rows($sel_challenge);
		
		if($sel_challenge_rows>0)
		{
			$delete_challenge = mysql_query("update store_challenges set is_deleted =1 where id='".$challengeid."' and store_id='".$store_id."' ");
			$result["status"]="1";
			$error = "Challenge deleted successfully";
			$result["message"]=$error;
		}
		else
		{
			$result["status"]="0";
			$error = "No challenge found.";
			$result["message"]=$error; 
		}
	}
	else
	{
		$result["status"]="0";
		$error = "Please enter all required field";
		$result["message"]=$error;
	}

	$result=json_encode($result);
	echo $result;
	
?>
