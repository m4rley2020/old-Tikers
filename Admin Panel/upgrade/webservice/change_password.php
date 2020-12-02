<?php
	header("Content-type: application/json");
	include("connect.php");
	
	
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['old_password'] != '' && $_REQUEST['new_password'] != '')
	{	
		$check_customer_mobile = mysql_query("select id,password from user where id='".$_REQUEST['user_id']."' ") or die(mysql_error());		
		
		if(mysql_num_rows($check_customer_mobile) > 0)
		{
			$row = mysql_fetch_array($check_customer_mobile);
			
				if($row['password'] == $_REQUEST['old_password'])
				{
					$update_password = "update user set password= '".$_REQUEST['new_password']."' where id='".$_REQUEST['user_id']."' ";
					mysql_query($update_password) or die(mysql_error());
					
					$message="Your Password has been changed successfully";
					$result=array('message'=> $message, 'result'=>'1');			
				}
				else
				{
					$message = "Your provided old password is wrong.";
					$result=array('message'=> $message, 'result'=>'0');
				}
		}		
		else
		{
			$message = "User not fond.";
			$result=array('message'=> $message, 'result'=>'0');
		}
	}
	else
	{	
		$error = "Please enter all required fields";
		$result=array('message'=> $message, 'result'=>'0');
	}	
	
	$result=json_encode($result);
	echo $result;
?>