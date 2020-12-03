<?php
// response json
header("Content-type: application/json");
$json = array();
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_REQUEST["regId"])) {
	
    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $fcm_regid = $_REQUEST["regId"];
	$oldregid = $_REQUEST["oldregid"];
	$user_id = $_REQUEST["user_id"]; // fcm Registration ID
	$device_id = $_REQUEST["device_id"];
	$user_type = $_REQUEST["user_type"];
	
    // Store user details in db
    include_once './db_functions1.php';
    include_once './send.php';
    $db = new DB_Functions();
    $fcm = new FCM();
	if($device_id!='')
	{
		$select_device="SELECT * from fcm_users WHERE device_id='$device_id'";
		$res_device=mysql_query($select_device) or die(mysql_error());
		$total_device=mysql_num_rows($res_device);
		if($total_device > 0)
		{
			$del_device="DELETE FROM fcm_users WHERE device_id='$device_id'";
			$res_device1=mysql_query($del_device) or die(mysql_error());
		}	
	}
 	$select_user="SELECT * from fcm_users WHERE  fcm_regid='$oldregid'";
 	$res_user=mysql_query($select_user) or die(mysql_error());
	$total=mysql_num_rows($res_user);
	if($total > 0)
	{
		$del_user="DELETE FROM fcm_users WHERE fcm_regid='$oldregid'";
		$res_user1=mysql_query($del_user) or die(mysql_error());
	}
	if($device_id=='')
	{
		$device_id="";
	}

    $res = $db->storeUser($name, $email, $fcm_regid,$device_id,$user_id,$user_type);
    $registatoin_ids = array($fcm_regid);
    
    if($res!=false)
    {
		
		$message = "Regestartion Successfully.";
		$result['responseData']=array('result'=>'success','message'=>$message,'reg_id'=>$registatoin_ids);	
	}
	else
	{
		$message = "Regestartion Unsuccessful";
		$result['responseData']=array('result'=>'failed','message'=>$message);	
	}
	
} else {
    // user details missing
}
$result=json_encode($result);
echo $result;
?>