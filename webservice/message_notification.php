<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
	
	
function andriod_push_notification($sender_id,$receiver_id,$type,$message,$sendername,$senderimage)
{
	$regId=GetValue("fcm_users","fcm_regid","user_id",$receiver_id);
	
	if($regId!="")
	{
		$regId=trim($regId);
		$regId_new=explode(',',$regId);
		include_once './Pushnotification_Android/send.php';
		$fcm = new FCM();
		$registatoin_ids=$regId_new;
		
		if(!empty($registatoin_ids))
		{
			$message = array("message" => $message,"user_id" => $sender_id,"type"=>$type,'sendername'=>$sendername,'senderimage'=>$senderimage);
			
			//print_r($message);
			$result = $fcm->send_notification($registatoin_ids, $message);
		}
	}
	
}
function send_notification($sender_id,$reciver_id,$type,$message,$sendername,$senderimage)
{
	$apns_query="select devicetoken,user_id from apns_devices where push_notification_status=1";
	$apns_query.=" and user_id='".$reciver_id."'";
	
	$apns_result=mysqli_query($apns_query) or die(mysqli_query());
	$apns_total=mysqli_num_rows($apns_result);
	
	if($apns_total>0)
	{
		while($apns_row=mysqli_fetch_assoc($apns_result))
		{	
			$apns_user_id = $apns_row['user_id'];			
			$update_push_counter = "update push_counter set push_counter= push_counter + 1 where user_id='".$apns_user_id."'";
			
			mysqli_query($update_push_counter) or die (mysqli_error());
			
			$get_push_counter = mysqli_query("select push_counter from push_counter where user_id = '".$apns_user_id."'");
			
			$fetch_push_counter = mysqli_fetch_array($get_push_counter);
		
			$counter = intval($fetch_push_counter['push_counter']);
			
			$deviceToken=$apns_row['devicetoken'];
			$passphrase = 'keshav777';				
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			// Open a connection to the APNS server
			// Production / Distribution === ssl://gateway.push.apple.com:2195
			// Developemtn === ssl://gateway.sandbox.push.apple.com:2195
			$fp = stream_socket_client(
					'ssl://gateway.sandbox.push.apple.com:2195', $err,
					$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			if (!$fp)
					exit("Failed to connect: $err $errstr" . PHP_EOL);
			
			//$message1 = "You have received ".$points." kudos from ".$sender_name;
			
			$body['aps'] = array('sound'=>"default",'alert' => $message,'badge'=>$counter,'type'=>$type,'sendername'=>$sendername,'senderimage'=>$senderimage);
			
			
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
	
			 
if($_REQUEST['from_user_id'] != '' && $_REQUEST['from_user_type'] != '' && $_REQUEST['to_user_id'] != '')
{
		$from_user_id = $_REQUEST['from_user_id'];
		$to_user_id = $_REQUEST['to_user_id'];
		$from_user_type = $_REQUEST['from_user_type'];
		
		if($from_user_type == "User")
		{
			$sender_user_name =  GetValue('user','username','id',$from_user_id);
			$senderimage =  GetValue('user','profile_image','id',$from_user_id);			
			if(file_exists("../User_image/".$senderimage) && $senderimage!="")
			{
				$senderimage = $SITE_URL."/User_image/".$senderimage;
			}
			else
			{
				$senderimage = "";
			}
			
		}
		elseif($from_user_type == "Store")
		{
			$sender_user_name =  GetValue('store','name','user_id',$from_user_id);
			$senderimage =  GetValue('store','store_image','user_id',$from_user_id);
			if(file_exists("../store_image/".$senderimage) && $senderimage!="")
			{
				$senderimage = $SITE_URL."/store_image/".$senderimage;
			}
			else
			{
				$senderimage = "";
			}
		}
		
		
		$noti_type = 'message';
		echo $noti_message = $sender_user_name.' has sent new message.';
		send_notification($user_id,$to_user_id,$noti_type,$noti_message,$sender_user_name,$senderimage);
		andriod_push_notification($user_id,$to_user_id,$noti_type,$noti_message,$sender_user_name,$senderimage);
		
		//insert_notification($user_id,$reciver_id,$noti_type,$noti_message);
		
		
		$error = "Notification Sent Successfully";
		$result=array('message'=> $error, 'result'=>'1');
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>