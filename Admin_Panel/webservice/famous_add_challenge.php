<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_type_id'] != '' && $_REQUEST['name'] != '' && $_REQUEST['description'] != '' && $_REQUEST['location'] != '' && $_REQUEST['lattitude'] != '' && $_REQUEST['longitude'] != '' && $_REQUEST['gender'] != '' && $_REQUEST['points'] != '')
	{
		$famous_user_id = $_REQUEST['user_id'];
		$latitude = $_REQUEST['lattitude'];
		$longitude = $_REQUEST['longitude'];
		$challenge_points = $_REQUEST['points'];
		$challeng_image="";
		if(isset($_FILES["challeng_image"]))
		{
			if ($_FILES["challeng_image"]["error"] > 0)
			{
				//echo "Error: " . $_FILES["full"]["error"] . "<br />";
			}
			else
			{
				 $challeng_image = rand(1,999).trim($_FILES["challeng_image"]["name"]); 
				 move_uploaded_file($_FILES["challeng_image"]["tmp_name"],"../challenge_image/".$challeng_image);
			}
		}
		/*   gender  */
		/*	0 = Male /  1 = Female  /  2 = not specified  */
		$insert_query = "insert into store_challenges set 					
				famous_user_id='".$famous_user_id."',
				challenge_type_id='".$_REQUEST['challenge_type_id']."',
				name='".$_REQUEST['name']."',
				description='".$_REQUEST['description']."',
				location='".$_REQUEST['location']."',
				lattitude='".$_REQUEST['lattitude']."',
				longitude='".$_REQUEST['longitude']."',
				challenge_category='Paid',
				created_date=now(),
				gender = '".$_REQUEST['gender']."',
				points = '".$challenge_points."' ";
				if($challeng_image!="")
				{
					
					$insert_query.=" , challeng_image='$challeng_image'";
				} 
				mysql_query($insert_query)or die(mysql_error());
				$challenge_id = mysql_insert_id();
				
				
				/*$user_query = "select user.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(user.latitude ) ) * cos( radians( user.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(user.latitude ) ) ) ) AS range1 from user where user_type != 'Store' having range1 <= '60' ";
				$user_query_res =   mysql_query($user_query)or die(mysql_error());
				if(mysql_num_rows($user_query_res)>0)
				{
					while($user_data = mysql_fetch_array($user_query_res))
					{
						$reciver_id = $user_data['id'];						
						$sender_user_name =  GetValue('store','name','id',$_REQUEST['store_id']);
						$noti_type = 'add_challenge';
						$noti_message = $sender_user_name.' has posted new challenge.';
						send_notification($user_id,$reciver_id,$noti_type,$noti_message);
						android_notification_function($user_id,$reciver_id,$noti_type,$noti_message);				
						insert_notification2($user_id,$reciver_id,$noti_type,$noti_message,$post_id);
					}
				}*/
				
				
				$error = "Challenge Created Successfully";
				$result=array('message'=> $error, 'result'=>'1','store_id'=>$_REQUEST['store_id'],'challenge_id'=>$challenge_id);
		
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>