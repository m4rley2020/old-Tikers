<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['challenge_type_id'] != '' && $_REQUEST['name'] != '' && $_REQUEST['description'] != '' )
	{
		
		$challenge_image="";
		if(isset($_FILES["challenge_image"]))
		{
			if ($_FILES["challenge_image"]["error"] > 0)
			{
				//echo "Error: " . $_FILES["full"]["error"] . "<br />";
			}
			else
			{
				 $challenge_image = rand(1,999).trim($_FILES["challenge_image"]["name"]); 
				 move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../challenge_image/".$challenge_image);
			}
		}
		
		$insert_query = "insert into store_challenges set 					
				store_id='".$_REQUEST['store_id']."',
				challenge_type_id='".$_REQUEST['challenge_type_id']."',
				name='".$_REQUEST['name']."',
				description='".$_REQUEST['description']."',
				location='".$_REQUEST['location']."',
				lattitude='".$_REQUEST['lattitude']."',
				longitude='".$_REQUEST['longitude']."',
				created_date=now()";
				if($challenge_image!="")
				{
					$insert_query.=" , challeng_image='$challenge_image'";
				} 
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				$challenge_id = mysqli_insert_id($db);
				
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