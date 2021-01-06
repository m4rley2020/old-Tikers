<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from user where id = '".$_REQUEST['user_id']."' and has_store = 'Yes'";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$store_id = GetValue("store","id","user_id",$_REQUEST['user_id'],$db);
				$store_name = GetValue("store","name","id",$store_id,$db);
				
							
				
				$data[]=array(
				"store_name"=>$store_name,
				"store_id"=>$store_id			
				);
				
			}	
			$error="store found.";
			$result=array('message'=> $error, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "store not found.";
			$result=array('message'=> $error, 'result'=>'0');
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