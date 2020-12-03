<?php
 
class DB_Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $fcm_regid,$device_id,$user_id,$user_type) {
	
		$select_user="SELECT * from fcm_users WHERE  fcm_regid='$fcm_regid'";
 		$res_user=mysql_query($select_user) or die(mysql_error());
		$total=mysql_num_rows($res_user);
		if($total > 0){
			$del_user="DELETE FROM fcm_users WHERE fcm_regid='$fcm_regid'";
			$res_user1=mysql_query($del_user) or die(mysql_error());
		}
		$select_user="SELECT * from fcm_users WHERE  user_id='$user_id'";
 		$res_user=mysql_query($select_user) or die(mysql_error());
		$total=mysql_num_rows($res_user);
		if($total > 0){
			$del_user="DELETE FROM fcm_users WHERE user_id='$user_id'";
			$res_user1=mysql_query($del_user) or die(mysql_error());
		}
        $result = mysql_query("INSERT INTO fcm_users(name, email, fcm_regid, push_notification_status, created_at,device_id,user_id,user_type) VALUES('$name', '$email', '$fcm_regid', 'on', NOW(),'$device_id','$user_id','$user_type')");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM fcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM fcm_users");
        return $result;
    }
 
}
 
?>