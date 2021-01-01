<?php 
class FCM{
	function __construct() {
    }
 	public function send_notification($uniqueid, $message) {
	include_once 'config.php';
	require_once 'firebaselib/firebaseInterface.php';
	require_once 'firebaselib/firebaseLib.php';
	require_once 'firebaselib/firebaseStub.php';
	$firebase = new \Firebase\FirebaseLib(DEFAULT_URL,''); 
	return $firebase->push_noti($FCM_URL,$uniqueid, $message ,$GOOGLE_API_KEY);
	
	}
}
?>
