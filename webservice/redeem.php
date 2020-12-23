<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['item_id'] != ''  )
	{
        $get_query1 = "select points from user where id = '".$_REQUEST['user_id']."'";	
		$get_query_res1 =   mysqli_query($db,$get_query1)or die(mysqli_error($db));
		$get_q1 = mysqli_fetch_array($get_query_res1);
        $user_points = $get_q1['points'];

        
        $get_query2 = "select name,cost,code from in_app_store where id = '".$_REQUEST['item_id']."'";
        $get_query_res2 =   mysqli_query($db,$get_query2)or die(mysqli_error($db));
        $get_q2 = mysqli_fetch_array($get_query_res2);

        $cost = $get_q2['cost'];
        $code = $get_q2['code'];
        $name = $get_q2['name'];    
        
        
        if($user_points>=$cost)
        {
        $insert_query1 = "insert into store_purchased set
        name = '".$name."' ,
        item_id ='".$_REQUEST['item_id']."' ,
        user_id='".$_REQUEST['user_id']."'  ,
        code = '".$code."'" ;

        mysqli_query($db,$insert_query1)or die(mysqli_error($db));
        $post_id = mysqli_insert_id();
                 
        $user_points = $user_points - $cost;

        $data[]=array(
            "points"=>$user_points
            );

        $insert_query2 = "update user set points ='".$user_points."' where id='".$_REQUEST['user_id']."'";
        mysqli_query($db,$insert_query2)or die(mysqli_error($db));

            $error = "Challenge Completed Successfully";
            $result=array('message'=> $error, 'result'=>'1');


        }
        else
        {
        $error = "Not enough points";
        $result=array('message'=> $error,'result' =>'0');
        }
    }else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
    echo $result;
    
    ?>