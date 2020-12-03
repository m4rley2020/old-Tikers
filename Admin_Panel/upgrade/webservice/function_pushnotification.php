<?php
function send_notification($sender_id,$reciver_id,$type,$message)
{
	$apns_query="select devicetoken,user_id from apns_devices where push_notification_status=1";
	$apns_query.=" and user_id='".$reciver_id."'";
	
	$apns_result=mysql_query($apns_query) or die(mysql_query());
	$apns_total=mysql_num_rows($apns_result);
	
	if($apns_total>0)
	{
		while($apns_row=mysql_fetch_assoc($apns_result))
		{	
			$apns_user_id = $apns_row['user_id'];			
			$update_push_counter = "update push_counter set push_counter= push_counter + 1 where user_id='".$apns_user_id."'";
			
			mysql_query($update_push_counter) or die (mysql_error());
			
			$get_push_counter = mysql_query("select push_counter from push_counter where user_id = '".$apns_user_id."'");
			
			$fetch_push_counter = mysql_fetch_array($get_push_counter);
		
			$counter = intval($fetch_push_counter['push_counter']);
			
			$deviceToken=$apns_row['devicetoken'];
			$passphrase = 'keshav777';				
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			// Open a connection to the APNS server
			$fp = stream_socket_client(
					'ssl://gateway.push.apple.com:2195', $err,
					$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			if (!$fp)
					exit("Failed to connect: $err $errstr" . PHP_EOL);
			
			//$message1 = "You have received ".$points." kudos from ".$sender_name;
			
			$body['aps'] = array('sound'=>"default",'alert' => $message,'badge'=>$counter,'type'=>$type);
			
			$payload = json_encode($body);
			
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			
			$result11 = fwrite($fp, $msg, strlen($msg));
			
			/*if(!$result)
				echo 'Message not delivered' . PHP_EOL;
			else
				echo 'Message successfully delivered' . PHP_EOL;
			// Close the connection to the server
			fclose($fp);*/
		}
	}
}
 
 function android_notification_function($sender_id,$reciver_id,$type,$message)
 {

	$sender_name = GetValue($sender_id);
	include_once './Pushnotification_Android/send.php';
	$fcm = new FCM();
	$registatoin_ids = array();
	
	$sel_reg_ids="select fcm_regid,user_id from fcm_users where 1=1";
	
	$sel_reg_ids.=" and user_id='".$reciver_id."' ";
	
	$res_reg_ids=mysql_query($sel_reg_ids);
	$res_reg_ids_total=mysql_num_rows($res_reg_ids);

	if($res_reg_ids_total > 0)
	{
		$count=0;
		while($row_reg_ids=mysql_fetch_array($res_reg_ids))
		{
			$count++;
			$gcm_regid=$row_reg_ids['fcm_regid'];
			array_push($registatoin_ids,$gcm_regid);
		}
		
		$add_noti = "insert into notification set sender_id = '".$sender_id."', receiver_id = '".$reciver_id."', type = '".$type."', 
						message = '".$message."', is_read = 0, created_date = now() ";
		
		if(mysql_query($add_noti)){
			$message = array('message' => $message,
						 'type'=>$type,
						 'from_id'=>$sender_id,
						 'from_name'=>$sender_name);
		
			$result = $fcm->send_notification($registatoin_ids, $message);
		}
	}
 }

?>


