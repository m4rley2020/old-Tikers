<?php
	header("Content-type: application/json");
	include("connect.php");

	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '')
	{
		$userid = $_REQUEST['user_id'];
		$postid = $_REQUEST['post_id'];
		
		$get_post_query = "select * from post where id='".$postid."' and user_id='".$userid."' ";
		$get_post_res =   mysqli_query($db,$get_post_query)or die(mysqli_error($db));
		
		if(mysqli_num_rows($get_post_res)>0)
		{
			$delete_post_query = "delete from post where id='".$postid."' and user_id='".$userid."' ";
			
			if(mysqli_query($db,$delete_post_query)){
				
				$delete_post_comment_query = mysqli_query($db,"delete from post_comment where post_id='".$postid."' ");
				$delete_post_like_query = mysqli_query($db,"delete from post_like where post_id='".$postid."' ");
				
				$get_post_media_query = mysqli_query($db,"select * from post_media where post_id='".$postid."' ");
				if(mysqli_num_rows($get_post_media_query) > 0){
					while($post_media = mysqli_fetch_array($get_post_media_query)){
						$media_file = $post_media['file_name'];
						if($media_file != "")
						{
							if(file_exists("../post_media/".$media_file.""))
							{
								unlink("../post_media/".$media_file."");
							}
						}
					}
					$delete_post_media_query = mysqli_query($db,"delete from post_media where post_id='".$postid."' ");     
				}
				
				$error = "Post deleted successfully.";
				$result=array('message'=> $error, 'result'=>'1');
			}
			else{
				$error = "someting is wrong.";
				$result=array('message'=> $error, 'result'=>'0');
			}
		}
		else
		{
			$error = "Post not found.";
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