<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['status'] != '')
	{
		$famous_user_id = $_REQUEST['user_id'];
		$challenge_id = $_REQUEST['challenge_id'];
		$status = $_REQUEST['status'];
		
		if($status == "accept"){
			$get_boost_amount = mysql_query("select challenge_id, amount from boost_store_challenges where famous_user_id = '".$famous_user_id."' and challenge_id = '".$challenge_id."' and is_accepted = 0 ");
			
			if(mysql_num_rows($get_boost_amount) > 0){
				$boost_amount_data = mysql_fetch_array($get_boost_amount);
				$boost_amount = $boost_amount_data['amount'];
				$challenge_id = $boost_amount_data['challenge_id'];
				
				$update_store_challenge = "update store_challenges set is_boost = 1 where id = '".$challenge_id."' and is_boost = 0";
				
				mysql_query($update_store_challenge);
				
				$update_boost_challenge = "update boost_store_challenges set is_accepted = 1 where famous_user_id = '".$famous_user_id."' and challenge_id = '".$challenge_id."' and is_accepted = 0 ";
				
				mysql_query($update_boost_challenge);
				
				$error = "Requested boost challenge is accepted and also boosted successfully.";
				$result=array('message'=> $error, 'result'=>'1');
			}
			else{
				$error = "Something is wrong with request.";
				$result=array('message'=> $error, 'result'=>'0');
			}
		}
		else if ($status == "dismiss"){
			$get_boost_amount = mysql_query("select store_id, amount from boost_store_challenges where famous_user_id = '".$famous_user_id."' and challenge_id = '".$challenge_id."' and is_accepted = 0 ");
			
			if(mysql_num_rows($get_boost_amount) > 0){
				$boost_amount_data = mysql_fetch_array($get_boost_amount);
				$boost_amount = $boost_amount_data['amount'];
				$store_id = $boost_amount_data['store_id'];
				
				$update_store = mysql_query("update store set current_credit = (current_credit + $boost_amount) where id = '".$store_id."' ");
				$remove_boost_challege = mysql_query("delete from boost_store_challenges where famous_user_id = '".$famous_user_id."' and challenge_id = '".$challenge_id."' and is_accepted = 0");
				
				$error = "Requested boost challenge is rejected.";
				$result=array('message'=> $error, 'result'=>'1');
			}
			else{
				$error = "Something is wrong with request.";
				$result=array('message'=> $error, 'result'=>'0');
			}
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