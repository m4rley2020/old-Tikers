<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '')
	{
		
		$get_query2 = "select * from package order by id desc";
		$get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_query_res2)>0)
		{
			
			
			
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{
				$package_id = $get_query_date2['id'];
				$name = $get_query_date2['name'];
				$package_image = $get_query_date2['package_image'];
				$description = $get_query_date2['description'];
				
				if(file_exists("../package_image/".$package_image) && $package_image!="")
				{
					$package_image1 = $SITE_URL."/package_image/".$package_image;
				}
				else
				{
					$package_image1 = "";
				}						
				
				$data[]=array(
				"package_id"=>$package_id,
				"name"=>$name, 
				"description"=>$description,
				"package_image"=>$package_image1				
				);
				
			}	
			$message="Package found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Package not found.";
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