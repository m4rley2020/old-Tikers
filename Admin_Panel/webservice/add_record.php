<?php 
header('Content-type: application/json');
include("connect.php");


$user_id=addslashes(trim($_REQUEST['user_id']));
$devicetoken=addslashes(trim($_REQUEST['devicetoken']));
$deviceuid=addslashes(trim($_REQUEST['deviceuid']));
$devicename=addslashes(trim($_REQUEST['devicename']));
$devicemodel=addslashes(trim($_REQUEST['devicemodel']));
$deviceversion=addslashes(trim($_REQUEST['deviceversion']));
$push_notification_status=addslashes(trim($_REQUEST['push_notification_status']));
$usertype=addslashes(trim($_REQUEST['user_type']));
//======================
$add_date=date("Y-m-d H:i:s");
if($user_id != "" && $devicetoken!="" && $deviceuid!="" && $devicename!="" && $devicemodel!="" && $deviceversion!="" && $push_notification_status!="" && $usertype != "")
{
	$check_pid="select pid from apns_devices where user_id='".$user_id."'";
	$run_check_pid=mysql_query($check_pid) or die (mysql_error());
	if(mysql_num_rows($run_check_pid)>0)
	{
		$update_device_token="update apns_devices set devicetoken='".$devicetoken."',
													deviceuid='".$deviceuid."',
													devicename='".$devicename."',
													devicemodel='".$devicemodel."',
													deviceversion='".$deviceversion."',
													user_type = '".$usertype."',
													push_notification_status='".$push_notification_status."',modified='".$add_date."'  where user_id='".$user_id."'";
													
		$run_update=mysql_query($update_device_token) or die (mysql_error());
		
		$error="Device token updated successfully";
		$result['responseData']=array('result'=>'success','message'=>$error);
	}
	else
	{
		$inser_query="insert into apns_devices set devicetoken='".$devicetoken."',
													deviceuid='".$deviceuid."',
													devicename='".$devicename."',
													devicemodel='".$devicemodel."',
													deviceversion='".$deviceversion."',
													push_notification_status='".$push_notification_status."',
													modified='".$add_date."',
													created='".$add_date."',
													user_type = '".$usertype."',
													user_id='".$user_id."'";
													
		$run_ins=mysql_query($inser_query) or die (mysql_error());
		
		$check_user = mysql_query("select user_id from push_counter where user_id='".$user_id."'");
		if(mysql_num_rows($check_user) > 0)
		{
			$insert_push_counter = "update push_counter set push_counter = '0' where user_id='".$user_id."'";
			mysql_query($insert_push_counter) or die (mysql_error());
		}
		else
		{
			$insert_push_counter = "insert into push_counter set user_id='".$user_id."', push_counter='0'";
			mysql_query($insert_push_counter) or die (mysql_error());
		}
		
		
		$error="Device token added successfully";
		$result['responseData']=array('result'=>'success','message'=>$error);
	}
}
else
{
	$error="Please enter all the required fields";
	$result['responseData']=array('result'=>'failed','message'=>$error);
}
$result=json_encode($result);
echo $result;
exit;
?>
