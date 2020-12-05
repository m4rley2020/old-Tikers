<?PHP
/*--------------------------------------------Anroid coding------------------------*/
	include("../connect.php");
	
	 include_once './GCM.php';
	
 	//include_once('http://demo.keshavinfotech.com/webservices/Pushnotification_Android/GCM.php');
   
    $gcm = new GCM();
  	$message=addslashes($_REQUEST['message']);
    $message = array("price" => $message);
	
	$get_user_qry="select *from `gcm_users` where city_id='".$_REQUEST['sel_city']."'";
	$get_user_res=mysql_query($get_user_qry) or die(mysql_error());
	
	$total_user=mysql_num_rows($get_user_res);
	
	if($total_user > 0)
	{
		$registatoin_ids=array();
		while($data_row=mysql_fetch_array($get_user_res))
		{
			$registatoin_ids[]=$data_row['gcm_regid'];
 			if(count($registatoin_ids) > 0)
			{
				//$registration_string=implode(",",$registatoin_ids);
				$registration_string_json=json_encode($registatoin_ids);
			}
			else
			{
				$registatoin_ids="0";
				$registration_string_json=json_encode($registatoin_ids);
			}
		}
		$result = $gcm->send_notification($registration_string, $message);
	}
?>