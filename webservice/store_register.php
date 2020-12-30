<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['store_name'] != '' && $_REQUEST['store_type_id'] != '' && $_REQUEST['location'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '' && $_REQUEST['phone_number'] != '')
	{
		
		$check_customer_mobile = mysqli_query($db,"select id from store where user_id='".$_REQUEST['user_id']."' ") or die(mysqli_error($db));
		
		
		if(mysqli_num_rows($check_customer_email) > 0)
		{
			$message = "User has already created store.";
			$result=array('message'=> $message, 'result'=>'0');	
		}				
		else
		{
			
			$store_image="";
			if(isset($_FILES["store_image"]))
			{
				if ($_FILES["store_image"]["error"] > 0)
				{
					//echo "Error: " . $_FILES["full"]["error"] . "<br />";
				}
				else
				{
					 $store_image = rand(1,999).trim($_FILES["store_image"]["name"]); 
					 move_uploaded_file($_FILES["store_image"]["tmp_name"],"../store_image/".$store_image);
				}
			}
			
			$insert_query = "insert into store set 					
					user_id='".$_REQUEST['user_id']."',
					name='".$_REQUEST['store_name']."',
					store_type_id='".$_REQUEST['store_type_id']."',
					location='".$_REQUEST['location']."',
					latitude='".$_REQUEST['latitude']."',
					longitude='".$_REQUEST['longitude']."',
					phone_number='".$_REQUEST['phone_number']."',
					add_date=NOW()";
					if($profile_image!="")
					{	
						$insert_query.=" , profile_image='$profile_image'";
					} 
					mysqli_query($db,$insert_query)or die(mysqli_error($db));
					$store_id = mysqli_insert_id($db);
					
					$query2 = "update user set has_store = 'Yes' where id=".$_REQUEST['user_id'];
					mysqli_query($db,$query2) or die(mysqli_error($db));
					
					$store_challenge_query = "insert into store_challenges set store_id='$store_id', name='Visit the Store', points = '10', challenge_type_id = '5', created_date=now() "; 
			
					mysqli_query($db,$store_challenge_query) or die(mysqli_error($db));
			
					$error = "Store Registered Successfully";
					$result=array('message'=> $error, 'result'=>'1','user_id'=>$_REQUEST['user_id'],'store_id'=>$store_id);
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