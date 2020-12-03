<?php

if (isset($_GET["regId"]) && isset($_GET["message"])) {
    $regId = $_GET["regId"];
    
	//print_r($regId); die;
	//echo $_GET["regId"]; die;
	$regId_new=explode(',',$regId);
	
	//print_r($regId_new); die;
	//echo count($regId_new); die;
    $message = $_GET["message"];
     
    include_once './send.php';
     
    $fcm = new FCM();
 	/*for($i=0;$i<count($regId_new);$i++)
	{
		echo "<br>".$regId_new[$i];
		continue; */
		$registatoin_ids = $regId_new;
		//array($regId_new);
		//print_r($registatoin_ids); 
		//(array)
		//continue;
		$message = array("message" => $message,"game_id" => "1","type"=>"start");
		$result = $fcm->send_notification($registatoin_ids, $message);
		
		echo $result;
	
	/*}*/
}

?>
