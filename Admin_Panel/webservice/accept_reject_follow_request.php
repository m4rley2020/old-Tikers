<?php
	header("Content-type: application/json");
	include "connect.php";
	include "function_pushnotification.php";

	if($_REQUEST['user_id']!="" && $_REQUEST['followerid']!="" && $_REQUEST['flag']!=""){
		$from_user_id 	= intval($_REQUEST['followerid']);
		$to_user_id 	= intval($_REQUEST['user_id']);
		$request_status = $_REQUEST['flag'];
		
		$follow_request_quesy = mysql_query("select * from friend where from_user='".$from_user_id."' and to_user='".$to_user_id."' and status = 1");
		$follow_request_rows = mysql_num_rows($follow_request_quesy);
		
		if($follow_request_rows > 0){
			if($request_status == 'accept'){
				$accept_rquest_query = "update friend set status='2' where from_user='".$from_user_id."' and to_user='".$to_user_id."' ";
				
				if(mysql_query($accept_rquest_query)){
					$sender_user_name =  GetValue('user','username','id',$to_user_id);
					$result["status"]="1";
					$error = "Follow request accepted successfully";
					$result["message"]=$error;
					$noti_type = 'follow_request_accepted';
					$noti_message = 'Your follow request accepted by '.$sender_user_name;
					send_notification($to_user_id,$from_user_id,$noti_type,$noti_message);
					android_notification_function($to_user_id,$from_user_id,$noti_type,$noti_message);
					insert_notification($to_user_id,$from_user_id,$noti_type,$noti_message);
				}
				else{
					die(mysql_error());
				}
			}
			else if($request_status == 'reject'){
				$reject_rquest_query = "delete from friend where from_user='".$from_user_id."' and to_user='".$to_user_id."' ";
				
				if(mysql_query($reject_rquest_query)){
					$result["status"]="1";
					$error = "Follow request rejected successfully";
					$result["message"]=$error;
				}
				else{
					die(mysql_error());
				}
			}
			else{
				$result["status"]="0";
				$error = "Something went wrong.";
				$result["message"]=$error;
			}
		}
		else{
			$result["status"]="0";
			$error = "No follow request found.";
			$result["message"]=$error;
		}
	}
	else{
		$result["status"]="0";
		$error = "Please enter all required field";
		$result["message"]=$error;
	}

	$result=json_encode($result);
	echo $result;
	
?>
