<?php
	include("connect.php");
	
		if(isset($_REQUEST['id']))
		{			$id = checkNum($_REQUEST["id"]);
					$name = $_REQUEST['name'];
					deletefull1($id,$name);
					$query = "update staticpage set image_path='' where id=".$id;
					
					mysqli_query($db,$query);
					location("staticpage.php?id=$id&mode=edit&msg=1");			
		}	
		
function deletefull1($id,$name)
{
	$dquery = "select * from staticpage where id=".$id;
	
	$dresult = mysqli_query($db,$dquery);
	while($drow = mysqli_fetch_array($dresult))
	{
		$dfile = $drow[$name];
		if($dfile != "")
		{
			if(file_exists("../staticpage_images/".$dfile.""))
			{
				unlink("../staticpage_images/".$dfile."");
			}
		}
	}
	mysqli_free_result($dresult);
}	
?>