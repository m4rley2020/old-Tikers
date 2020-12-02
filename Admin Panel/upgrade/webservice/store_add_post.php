<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['description'] != '' && $_REQUEST['address'] != '')
	{
		$user_id = GetValue("store","user_id","id",$_REQUEST['store_id']);
		
		$insert_query = "insert into post set 					
				user_id='".$user_id."',
				store_id='".$_REQUEST['store_id']."',
				description='".$_REQUEST['description']."',
				add_date = NOW(),
				address	= '".$_REQUEST['address']."',
				latitude = '".$_REQUEST['latitude']."',
				longitude = '".$_REQUEST['longitude']."'";
				mysql_query($insert_query)or die(mysql_error());
				$post_id = mysql_insert_id();
				
				
				$image_count = $_REQUEST['image_count'];		
				if($image_count>0)
				{
					for($i=1;$i<=$image_count;$i++)
					{ 
						if($_FILES['image_'.$i]['name']!="")
						{	
							$image_file_name = str_replace(" ","_",rand(1,999).trim($_FILES['image_'.$i]['name']));
							move_uploaded_file($_FILES["image_".$i]["tmp_name"],"../post_media/".$image_file_name);
		                 
							$query1 = "insert into post_media set post_id='".$post_id."', file_type = 'image', file_name='".$image_file_name."'";
							mysql_query($query1) or die(mysql_error());
						}
					}
				}
				
				$video_count = $_REQUEST['video_count'];		
				if($video_count>0)
				{
					for($i=1;$i<=$video_count;$i++)
					{ 
						if($_FILES['video_'.$i]['name']!="")
						{	
							$video_file_name = str_replace(" ","_",rand(1,999).trim($_FILES['video_'.$i]['name']));
							move_uploaded_file($_FILES["video_".$i]["tmp_name"],"../post_media/".$video_file_name);
		                 
							$query1 = "insert into post_media set post_id='".$post_id."', file_type = 'video', file_name='".$video_file_name."'";
							mysql_query($query1) or die(mysql_error());
						}
					}
				}
				
				$error = "Post Added Successfully";
				$result=array('message'=> $error, 'result'=>'1','post_id'=>$post_id);
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>