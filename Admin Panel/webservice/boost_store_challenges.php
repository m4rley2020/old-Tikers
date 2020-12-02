<?php
	header("Content-type: application/json");
	include("connect.php");
	
	if($_REQUEST['store_id'] != '' && $_REQUEST['challange_id'] != '' && $_REQUEST['boost_type'] && $_REQUEST['payment_type'] != '' && $_REQUEST['amount'] != ''){
		$store_id = $_REQUEST['store_id'];
		$challange_id = $_REQUEST['challange_id'];
		$famous_user_id = $_REQUEST['famous_user_id'];
		$boost_type = $_REQUEST['boost_type'];
		$payment_type = $_REQUEST['payment_type'];
		$boost_code = $_REQUEST['boost_code'];
		$amount = $_REQUEST['amount'];
		
		
		if($payment_type == "online"){	
			$get_store_challenge_detail = mysql_query("select S.*,SC.* from store S INNER JOIN store_challenges SC on S.id = SC.store_id where S.id = '".$store_id."' and SC.id = '".$challange_id."' and SC.is_deleted = 0 and SC.is_approved = 1 ");
		}
		else if($payment_type == "boostcode"){
			"select S.*,SC.* from store S INNER JOIN store_challenges SC on S.id = SC.store_id where S.id = '".$store_id."' and SC.id = '".$challange_id."' and SC.is_deleted = 0 and SC.is_approved = 1 and S.boost_code = '".$boost_code."' ";
			$get_store_challenge_detail = mysql_query("select S.*,SC.* from store S INNER JOIN store_challenges SC on S.id = SC.store_id where S.id = '".$store_id."' and SC.id = '".$challange_id."' and SC.is_deleted = 0 and SC.is_approved = 1 and S.boost_code = '".$boost_code."' ");
		}

		if(mysql_num_rows($get_store_challenge_detail) > 0){
			$store_challenge_data = mysql_fetch_array($get_store_challenge_detail);
			
			if($store_challenge_data['expired_date'] > date("Y-m-d")){
				if($boost_type == "normal"){
					if($store_challenge_data['is_boost'] == 0){
						if($payment_type == "boostcode"){
							if($store_challenge_data['current_credit'] > $amount){
								$in_boost_challenge = "insert into boost_store_challenges set 
															store_id = '".$store_id."',
															challenge_id = '".$challange_id."',
															famous_user_id = '".$famous_user_id."',
															boost_type = '".$boost_type."',
															payment_type = '".$payment_type."',
															boost_code = '".$boost_code."',
															amount = '".$amount."',
															created_date = now() ";
															
								if(mysql_query($in_boost_challenge)){
									$updated_credit_amount = $store_challenge_data['current_credit'] - $amount;
									$update_store = "update store set current_credit = '".$updated_credit_amount."' where id = '".$store_id."' ";
									mysql_query($update_store);
									
									$update_store_challenge = "update store_challenges set is_boost = 1 where store_id = '".$store_id."' and id = '".$challange_id."' ";
									mysql_query($update_store_challenge);
									
									$error = "Challenge is boosted successfully.";
									$result=array('message'=> $error, 'result'=>'1');
								}
							}
							else{
								$error = "Current available balance is not sufficient.";
								$result=array('message'=> $error, 'result'=>'0');
							}
						}
						else{
							$in_boost_challenge = "insert into boost_store_challenges set 
															store_id = '".$store_id."',
															challenge_id = '".$challange_id."',
															famous_user_id = '".$famous_user_id."',
															boost_type = '".$boost_type."',
															payment_type = '".$payment_type."',
															boost_code = '".$boost_code."',
															amount = '".$amount."',
															created_date = now() ";
															
							if(mysql_query($in_boost_challenge)){
								$update_store_challenge = "update store_challenges set is_boost = 1 where store_id = '".$store_id."' and id = '".$challange_id."' ";
								mysql_query($update_store_challenge);
								
								$error = "Challenge is boosted successfully.";
								$result=array('message'=> $error, 'result'=>'1');
							}
						}
					}
					else{
						$error = "This challenge is already boosted as normal.";
						$result=array('message'=> $error, 'result'=>'0');
					}
				}
				else if($boost_type == "famous" && $famous_user_id > 0){
					$challenge = $_REQUEST['challange_id'];
					$check_famous_qury = mysql_query("select * from boost_store_challenges where challenge_id = '".$challenge."' and famous_user_id = '".$famous_user_id."' ");
					if(mysql_num_rows($check_famous_qury) > 0){
					
						$error = "This challenge is already found for this famous user.";
						$result=array('message'=> $error, 'result'=>'0');
					}
					else{
						if($payment_type == "boostcode"){
							if($store_challenge_data['current_credit'] > $amount){
								$in_boost_challenge = "insert into boost_store_challenges set 
															store_id = '".$store_id."',
															challenge_id = '".$challange_id."',
															famous_user_id = '".$famous_user_id."',
															boost_type = '".$boost_type."',
															payment_type = '".$payment_type."',
															boost_code = '".$boost_code."',
															amount = '".$amount."',
															created_date = now() ";
															
								if(mysql_query($in_boost_challenge)){
									$updated_credit_amount = $store_challenge_data['current_credit'] - $amount;
									$update_store = "update store set current_credit = '".$updated_credit_amount."' where id = '".$store_id."' ";
									mysql_query($update_store);
									
									$error = "Challenge is requested for boost successfully.";
									$result=array('message'=> $error, 'result'=>'1');
								}
							}
						}
						else{
							$in_boost_challenge = "insert into boost_store_challenges set 
															store_id = '".$store_id."',
															challenge_id = '".$challange_id."',
															famous_user_id = '".$famous_user_id."',
															boost_type = '".$boost_type."',
															payment_type = '".$payment_type."',
															boost_code = '".$boost_code."',
															amount = '".$amount."',
															created_date = now() ";
															
							if(mysql_query($in_boost_challenge)){								
								$error = "Challenge is requested for boost successfully.";
								$result=array('message'=> $error, 'result'=>'1');
							}
						}
					}
						
				}	
				else{
					$error = "Something is wrong with request.";
					$result=array('message'=> $error, 'result'=>'0');
				}
			}
			else{
				$error = "This challenge is already expired.";
				$result=array('message'=> $error, 'result'=>'0');
			}
		}
		else{
			$error = "Something is wrong with request.";
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

