<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['challenge_type_id'] != '' && $_REQUEST['name'] != '' && $_REQUEST['description'] != '' && $_REQUEST['location'] != '' && $_REQUEST['lattitude'] != '' && $_REQUEST['longitude'] != '')
	{
		
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
		
		$insert_query = "insert into store_challenges set 					
				store_id='".$_REQUEST['store_id']."',
				challenge_type_id='".$_REQUEST['challenge_type_id']."',
				name='".$_REQUEST['name']."',
				description='".$_REQUEST['description']."',
				location='".$_REQUEST['location']."',
				lattitude='".$_REQUEST['lattitude']."',
				longitude='".$_REQUEST['longitude']."',
				challenge_category='Paid',
				created_date=now()";
				if($challeng_image!="")
				{
					$insert_query.=" , challeng_image='$challeng_image'";
				} 
				mysql_query($insert_query)or die(mysql_error());
				$challenge_id = mysql_insert_id();
				
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