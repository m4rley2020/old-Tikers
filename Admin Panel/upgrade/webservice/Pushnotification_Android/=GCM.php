<?php
 
class GCM {
	
    //put your code here
    // constructor
    function __construct() {
        
    }
 
    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) {
		
	 //$google_api="AIzaSyCo0pWOcv89ExBfa-NooHQCJUBeSXbERfk";
        // include config
       // include_once 'config.php';
       define( 'API_ACCESS_KEY', 'AIzaSyAF_E3JtjTeDVTtWSLlPZWPirjvD1gnoeA' );
		//print_r($registatoin_ids); 
		//print_r($message); 
		//die;
        // Set POST variables
		//print_r($message); die;
       
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'notification' => $message,
        );
 		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		echo $result; die;
		
    }
}
?>
