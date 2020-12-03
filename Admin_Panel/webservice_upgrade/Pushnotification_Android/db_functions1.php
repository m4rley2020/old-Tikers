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
 		$res_user=mysqli_query($db,$select_user) or die(mysqli_error($db));
		$total=mysqli_num_rows($res_user);
		if($total > 0){
			$del_user="DELETE FROM fcm_users WHERE fcm_regid='$fcm_regid'";
			$res_user1=mysqli_query($db,$del_user) or die(mysqli_error($db));
		}
		$select_user="SELECT * from fcm_users WHERE  user_id='$user_id'";
 		$res_user=mysqli_query($db,$select_user) or die(mysqli_error($db));
		$total=mysqli_num_rows($res_user);
		if($total > 0){
			$del_user="DELETE FROM fcm_users WHERE user_id='$user_id'";
			$res_user1=mysqli_query($db,$del_user) or die(mysqli_error($db));
		}
        $result = mysqli_query($db,"INSERT INTO fcm_users(name, email, fcm_regid, push_notification_status, created_at,device_id,user_id,user_type) VALUES('$name', '$email', '$fcm_regid', 'on', NOW(),'$device_id','$user_id','$user_type')");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysqli_insert_id(); // last inserted id
            $result = mysqli_query($db,"SELECT * FROM fcm_users WHERE id = $id") or die(mysqli_error($db));
            // return user details
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_array($result);
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
        $result = mysqli_query($db,"select * FROM fcm_users");
        return $result;
    }
 
}
 
?>