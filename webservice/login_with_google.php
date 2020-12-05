<?php

/*	http://keshavinfotechdemo.com/KESHAV/KG2/CUN/webservices/google_login.php?google_id=3&email=test@gmail.com&%20first_name=test&last_name=lastname&profile_image=test&location=testlocation&dob=2017-05-20&current_datetime=2017-07-07%2005:03:23&current_country=test&google_token=1
*/

header('Content-type: application/json');
include('connect.php');
// require_once 'Twilio/autoload.php';
// use Twilio\Rest\Client;


$google_id=addslashes(trim($_REQUEST['google_id']));
$google_token_old = addslashes(trim($_REQUEST['google_token']));
$email = addslashes(trim($_REQUEST['email']));
$first_name=addslashes(trim($_REQUEST['first_name']));		
$last_name=addslashes(trim($_REQUEST['last_name']));
$profile_image = $_REQUEST['profile_image'];
$phone_number = $_REQUEST['phone_number'];
$register_type = $_REQUEST['register_type'];
$username = $_REQUEST['username'];



	if($google_token_old!="" && $email!="")
	{
		$google_id=GetValue("user","google_id","google_id",$google_token_old);		
		$email_id=GetValue("user","email","email",$email);
		$phone_number1=GetValue("user","phone_number","phone_number",$phone_number);
		
		if($google_id!="" || $email_id!="" || $phone_number1!="")
		{
			if($google_id!='') 
			{ 
				$iid=GetValue("user","id","google_id",$google_id); 
			}			
			else if($email_id!='') 
			{ 
				$iid=GetValue("user","id","email",$email_id); 
			}
			else if($phone_number1!=''){ 
				$iid=GetValue("user","id","phone_number",$phone_number); 
			}
			
			$google_response_in_json_url = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$google_id_old.'?alt=json');
			$d = json_decode($google_response_in_json_url);
			$friend_image = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
			if($friend_image!="")
			{	
				$friend_image=str_replace("s64-c","s140-c",$friend_image);
			}
	
			$update_query	=	"update user set 
			google_token = '$google_token_old',
			google_id = '$google_token_old',
			first_name = '".$first_name."',
			last_name = '".$last_name."',
			register_type = '".$register_type."',
			username = '".$username."',
			google_id = '$google_id', ";
			if($phone_number != "")
			{
				$update_query .= "phone_number='".$phone_number."', ";
			}
			$update_query .= " profile_image='".$profile_image."' 
						
			where id='".$iid."'";
			
			
			
			$update_result	= mysqli_query($db,$update_query) or die(mysqli_error($db));
			
			// $client = new Client($account_sid, $auth_token); 
			// $text = 'Your Mobile Number Verification Code is: '.$otp.'.';
			// $messages = $client->messages->create($phone, array( 
				// 'From' => '+14352362656',
				// 'Body' => $text
			// ));
			
			$select_user="select * from user where id=$iid";
			$result_user=mysqli_query($db,$select_user) or die(mysqli_error($db));
			$total_user=mysqli_num_rows($result_user);
			$row_user=mysqli_fetch_assoc($result_user);
			if($total_user>0)
			{
				
				$row['user_id']=$row_user['id'];
				$row['first_name']=$first_name;
				$row['last_name']=$last_name;
				$row['username']=$row_user['username'];
				$row['email']=$email;
				$row['is_verified']=$row_user['is_verified'];
				$row['google_id']=$google_id;
				$row['google_token']=$google_token;
				$row['phone_number']=$phone_number;
				$row['profile_image']=$profile_image;
				$row['user_type']=$row_user['user_type'];
				$row['is_private']=$row_user['is_private'];
				$row['is_verified']=$row_user['is_verified'];
				$row['store_id']=$row_user['store_id'];
				$row['country_code']=$row_user['country_code'];
				$row['register_type']=$row_user['register_type'];
				$row['add_date']=$row_iser['add_date'];
				
				$Message="Login Successfull";
				$result["result"]="1";
				$result["message"]=$Message;
				$result['responseData']=$row;
			}
			else
			{
				$result["result"]="0";
				$Message = "User Not Login";
				$result['message']=$Message;
			}
		}
		else
		{
			//echo "http://picasaweb.google.com/data/entry/api/user/$google_id_old?alt=json&sz=512";
			 $google_response_in_json_url = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$google_id_old.'?alt=json');
			$d = json_decode($google_response_in_json_url);
			 $friend_image = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
			if($friend_image!="")
			{
			$friend_image=str_replace("s64-c","s140-c",$friend_image);
			}
			$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
			$user_code = $randomString;
			$insert_query = "insert into user set 
								email='".$email."',
								google_id='".$google_id."',
								google_token = '$google_token_old',
								first_name = '".$first_name."',
								last_name = '".$last_name."',								
								phone_number='".$phone_number."', 								
								profile_image='".$profile_image."',
								user_type = 'User', 								 
								is_verified='0', 
								register_type = '".$register_type."',
								username = '".$username."',
								add_date=now()";
							
								$insert_result = mysqli_query($db,$insert_query) or die(mysqli_error($db));
								$last_inserted_id =	mysqli_insert_id();
								if($last_inserted_id > 0)
								{	
									// $client = new Client($account_sid, $auth_token); 
									// $text = 'Your Mobile Number Verification Code is: '.$otp.'.';
									// $messages = $client->messages->create($phone, array( 
										// 'From' => '+14352362656',
										// 'Body' => $text
									// ));
									
									$select_user="select * from user where id=$last_inserted_id";
									$result_user=mysqli_query($db,$select_user) or die(mysqli_error($db));
									$total_user=mysqli_num_rows($result_user);
									$row_user=mysqli_fetch_assoc($result_user);
									
									$row['user_id']=$row_user['id'];
									$row['first_name']=$fname;
									$row['last_name']=$last_name;
									$row['username']=$row_user['username'];
									$row['email']=$email;
									$row['is_verified']=$row_user['is_verified'];
									$row['google_id']=$google_id_old;
									$row['google_token']=$google_token_old;
									$row['phone_number']=$phone_number;
									$row['profile_image']=$profile_image;
									$row['user_type']=$row_user['user_type'];
									$row['is_private']=$row_user['is_private'];
									$row['is_verified']=$row_user['is_verified'];
									$row['store_id']=$row_user['store_id'];
									$row['country_code']=$row_user['country_code'];
									$row['register_type']=$row_user['register_type'];
									$row['add_date']=$row_iser['add_date'];
									
									$Message="User Registered Successfully";
									$result["result"]="1";
									$result["message"]=$Message;
									$result['responseData']=$row;
								}
								else
								{
									$result["result"]="0";
									$Message = "User Not Registor";
									$result['message']=$Message;
								}
		}
	}
	else
	{
		$result["result"]="0";
		$Message = "Please pass valid Google access token and valid Google id.";
		$result['message']=$Message;
	}
$result=json_encode($result);
echo $result;
?>
