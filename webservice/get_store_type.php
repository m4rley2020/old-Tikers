<?php
	header("Content-type: application/json");
	include("connect.php");
			 
		
		$get_query2 = "select * from store_type order by id desc";
		$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{	
			while($get_query_date2 = mysql_fetch_array($get_query_res2))
			{
				$ads_id = $get_query_date2['id'];
				$store_type = $get_query_date2['store_type'];				
				
				$data[]=array(
				"ads_id"=>$ads_id,
				"store_type"=>$store_type		
				);				
			}	
			$message="Store Type found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Store Type not found.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		
	$result=json_encode($result);
	echo $result;
?>