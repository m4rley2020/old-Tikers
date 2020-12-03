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
//======================
$add_date=date("Y-m-d H:i:s");
if($user_id != "" && $devicetoken!="" && $deviceuid!="" && $devicename!="" && $devicemodel!="" && $deviceversion!="" && $push_notification_status!="")
{
	$check_pid="select pid from apns_devices where user_id='".$user_id."'";
	$run_check_pid=mysqli_query($db,$check_pid) or die (mysqli_error($db));
	if(mysqli_num_rows($run_check_pid)>0)
	{
		$update_device_token="update apns_devices set devicetoken='".$devicetoken."',
													deviceuid='".$deviceuid."',
													devicename='".$devicename."',
													devicemodel='".$devicemodel."',
													deviceversion='".$deviceversion."',
													push_notification_status='".$push_notification_status."',modified='".$add_date."'  where user_id='".$user_id."'";
													
		$run_update=mysqli_query($db,$update_device_token) or die (mysqli_error($db));
		
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
													user_id='".$user_id."'";
													
		$run_ins=mysqli_query($db,$inser_query) or die (mysqli_error($db));
		
		$check_user = mysqli_query($db,"select user_id from push_counter where user_id='".$user_id."'");
		if(mysqli_num_rows($check_user) > 0)
		{
			$insert_push_counter = "update push_counter set push_counter = '0' where user_id='".$user_id."'";
			mysqli_query($db,$insert_push_counter) or die (mysqli_error($db));
		}
		else
		{
			$insert_push_counter = "insert into push_counter set user_id='".$user_id."', push_counter='0'";
			mysqli_query($db,$insert_push_counter) or die (mysqli_error($db));
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
