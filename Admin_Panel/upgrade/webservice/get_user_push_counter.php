<?php
	header('Content-type: application/json');
	include("connect.php");
	
	$user_id = addslashes($_REQUEST['user_id']);
	
	if($user_id != "")
	{
		$search = mysql_query("select * from push_counter where user_id='".$user_id."'");
		$count = mysql_num_rows($search);
		if($count > 0)
		{
			$fetch = mysql_fetch_array($search);
			$error="Data found successfully.";
			$result["responseData"]=array('result'=>'success',
			'message'=>$error,
			'push_counter'=>$fetch["push_counter"]			
			);
		}
		else
		{
			$error="Data not found";
			$result["responseData"]=array('result'=>'failed','message'=>$error);
			$result=json_encode($result);
			echo $result;
			exit;
		}
	}
	else
	{
		$error="Please enter all the required fields";
		$result['responseData']=array('result'=>'failed','message'=>$error);
	}
$result=json_encode($result);
print_r($result);
?>
