<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['username'] != '')
	{
		$check_customer_username = mysql_query("
		SELECT * FROM `user` WHERE username = '".$_REQUEST['username']."' and id != '".$_REQUEST['user_id'] ."'
		 ") or die(mysql_error());	
		 
		if(mysql_num_rows($check_customer_username) > 0)
		{
			$message = "User with the specified Username already exists.";
			$result=array('message'=> $message, 'result'=>'0');	
		}			
		else
		{
			$profile_image="";
			$gender = "";
			if(isset($_FILES["profile_image"]))
			{
				if ($_FILES["profile_image"]["error"] > 0)
				{
					//echo "Error: " . $_FILES["full"]["error"] . "<br />";
				}
				else
				{
					 $profile_image = rand(1,999).trim($_FILES["profile_image"]["name"]); 
					 move_uploaded_file($_FILES["profile_image"]["tmp_name"],"../User_image/".$profile_image);
				}
			}
			
			if($_REQUEST['gender'] == 0){
				$gender = "Male";
			}
			else if($_REQUEST['gender'] == 1){
				$gender = "Female";
			}
				
			
			
			$update_query = "update user set id = '".$_REQUEST['user_id']."' ";					
					if($_REQUEST['username'] != "")
					{
						$update_query .= " ,username='".$_REQUEST['username']."' ";	
					}
					if($_REQUEST['first_name'] != "")
					{
						$update_query .= " ,first_name='".$_REQUEST['first_name']."' ";	
					}
					if($_REQUEST['last_name'] != "")
					{
						$update_query .= " ,last_name='".$_REQUEST['last_name']."' ";	
					}
					if($_REQUEST['phone_number'] != "")
					{
						$update_query .= " ,phone_number='".$_REQUEST['phone_number']."' ";	
					}
					if($_REQUEST['gender'] != "")
					{
						$update_query .= " ,gender='".$gender."' "	;
					}
					if($_REQUEST['bio'] != "")
					{
						$update_query .= " ,bio='".$_REQUEST['bio']."' ";	
					}
					if($profile_image!="")
					{
						$update_query.=" , profile_image='$profile_image'";
					} 
					if($_REQUEST['country_code'] != "" && $_REQUEST['country_code'] > 0)
					{
						$update_query.=" , country_code='".$_REQUEST['country_code']."' ";
					} 
					$update_query .= "where id = '".$_REQUEST['user_id']."' ";
					
					
					
					mysql_query($update_query)or die(mysql_error());
					$user_id = $_REQUEST['user_id'];
			
					$get_user_detail_query = mysql_query("select * from user where id = '".$_REQUEST['user_id']."' ") or die(mysql_error());		

					if(mysql_num_rows($get_user_detail_query) > 0)
					{
						$row = mysql_fetch_array($get_user_detail_query);

							if($row['profile_image'] != "")
							{
								$profile_image = $SITE_URL."/User_image/".$row['profile_image'];
							}
							else
							{
								$profile_image = "";
							}

							if($row['user_type'] == "Store")
							{
								$store_id = GetValue("store","id","user_id",$row['id']);
							}
							else
							{
								$store_id = "";
							}
						
							$data = array(
								'user_id' => $row['id'],
								'email' => $row['email'],
								'phone_number' => $row['phone_number'],
								'first_name' => $row['first_name'],
								'last_name' => $row['last_name'],
								'username' => $row['username'],
								'password' => $row['password'],			
								'profile_image' => $profile_image,
								'is_verified' => $row['is_verified'],
								'user_type' => $row['user_type'],
								'store_id' => $store_id,
								'country_code' => $row['country_code'],
								'register_type' => $row['register_type'],
								'is_private' => $row['is_private'],
								'add_date' => $row['add_date'],

								); 
					}
					
					$error = "Account Updated Successfully";
					$result=array('message'=> $error, 'result'=>'1','responseData'=>$data);
		}
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>