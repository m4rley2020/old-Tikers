<?php
	header('Content-type: application/json');
	include("connect.php");

	if($_REQUEST['type'] != '')
	{
		$type=trim($_REQUEST['type']);
		$id=0;
		if($type=='terms'){
			$id=1;
		}else if($type=='privacy'){
			$id=2;
		}

		$get_static_res = mysql_query("select * from staticpage where id=$id");
		$get_static_row=mysql_num_rows($get_static_res);
		if($get_static_row>0)
		{
			if($id==1){
				
				$get_static_data=mysql_fetch_array($get_static_res);

				$content=stripslashes(trim($get_static_data['content']));
				$static_array=array("page_header"=>stripslashes($get_static_data['page_header']), "content_text"=>$content);

			}else if($id==2){
				
				$get_static_data=mysql_fetch_array($get_static_res);

				$content=stripslashes(trim($get_static_data['content']));
				$static_array=array("page_header"=>stripslashes($get_static_data['page_header']), "content_text"=>$content);
			}

			$error = "success";
			$result["result"] = "1";
			$result["message"] = $error;
			$result["responseData"]=$static_array;
		}
		else
		{
			$error = "Data Not Found.";
			$result["result"] = "0";
			$result["message"] = $error;
		}
	}
	else
	{
		$error = "Please Enter All the required fields";
		$result["result"] = "0";
		$result["message"] = $error;
	}
	$result=json_encode($result);
	echo $result;
?>