<?php									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="Challenge";

/* ---------------------- Declare Fields ---------------------- */

$package = "";
$challenge_type= "";
$challenge_name= "";
$challenge_image= "";
$challgnge_description= "";
$challenge_points=0;
$add_date= "";

/* ---------------------- Initialize Fields ---------------------- */

if(isset($_REQUEST["id"]) && $_REQUEST["id"] > 0)
{
	$id = $_REQUEST["id"];											
	$fetchquery = "select * from store_challenges where id=".$id;
	$result = mysqli_query($db,$fetchquery);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
			$package_arr = explode("@@",$row['package']);
			$challenge_type= stripslashes($row['challenge_type_id']);
			$challenge_name= stripslashes($row['name']);
			$challenge_image= stripslashes($row['challeng_image']);
			$challgnge_description= stripslashes($row['description']);
			$challenge_points = stripslashes($row['points']);
			$add_date = stripslashes($row['created_date']);				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit']))
{
	/* ------------- Change All Fck image permission to 777 -------------- */
		$package = implode("@@",$_REQUEST['package']);
		$challenge_type= addslashes($_REQUEST['challenge_type']);
		$challenge_name= addslashes($_REQUEST['challenge_name']);
		$challenge_image= addslashes($_REQUEST['challenge_image']);
		$challenge_description= addslashes($_REQUEST['challenge_description']);
		$challenge_points = addslashes($_REQUEST['challenge_points']);
		
		if ($_FILES["challenge_image"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $challenge_image = rand(1,999).trim($_FILES["challenge_image"]["name"]); 
			 move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../challenge_image/".$challenge_image);
			 
			 auto_change_file_permition("challenge_image",$challenge_image);
		}

		$myip = get_client_ip();
		if($myip == 'UNKNOWN'){
			$json     = file_get_contents("http://ipinfo.io/$myip/geo");
			$json     = json_decode($json, true);
			$location = $json['city'];
			$lat_long = $json['loc'];
			$lat_long_arr = explode(",",$lat_long);
			$latitude = $lat_long_arr[0];
			$longitude = $lat_long_arr[1];
		}
		if(isset($_REQUEST['mode']))
		{
			switch($_REQUEST['mode'])
			{
				case 'add' :
					if(GTG_is_dup_add('store_challenges','name',$challenge_name))
					{
						unset($_REQUEST['Submit']);	
						location("add_challenge.php?mode=add&msg=4");
						return;
					}
					
					$query = "insert into store_challenges set package='$package', challenge_type_id='$challenge_type', name='$challenge_name', challeng_image='$challenge_image', description = '$challenge_description', location='$location', lattitude='$latitude', longitude='$longitude', points = '$challenge_points', challenge_category = 'Free', created_date=now() "; 
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_challenge.php?msg=1");
				break;
				
				case 'edit' :
					if(GTG_is_dup_edit('store_challenges','name',$challenge_name,$_REQUEST['id']))
					{
						unset($_REQUEST['Submit']);	
						location("add_challenge.php?mode=edit&id=".$_REQUEST['id']."&msg=4");	
						return;
					}
					$query = "update store_challenges set package='$package', challenge_type_id='$challenge_type', name='$challenge_name', description = '$challenge_description', points = '$challenge_points' ";								
						
						if($challenge_image!="")
						{
							deletefull1($_REQUEST['id']);
							$query.=" , challeng_image='$challenge_image'";
						} 
					$query.=" where id=".$_REQUEST['id'];
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_challenge.php?msg=2");
				break;
				
			}	
		}
		
}	
if(isset($_REQUEST['mode']))
{
	switch($_REQUEST['mode'])
	{
		case 'delete' :
			deletefull1($_REQUEST['id']);
$query = "delete from store_challenges where id=".$_REQUEST['id'];     
			mysqli_query($db,$query) or die(mysqli_error($db));
			location("manage_challenge.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select challeng_image from store_challenges where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['challeng_image'];
			if($dfile != "")
			{
				if(file_exists("../challenge_image/".$dfile.""))
				{
					unlink("../challenge_image/".$dfile."");
				}
			}
		}
		mysqli_free_result($dresult);
	}

function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}

$challenge_type_query = "select * from challenge_type";
$challenge_type_result = mysqli_query($db,$challenge_type_query);

$package_query = "select * from package";
$package_result = mysqli_query($db,$package_query);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><?php echo $pagetitle; ?> | <?=$SITE_NAME?></title>
    
    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/open-sans.css">
    
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">

<SCRIPT language=javascript src="body.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen" />
<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

<script language="JavaScript" type="text/javascript">
var xmlHttp
function top_GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
	{
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
  catch (e)
	{
	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  }
return xmlHttp;
}

function sam_GetSelectedItem(field_id)
{
var tmp=document.getElementById(field_id);
var len = tmp.length
var i = 0
var chosen = ","

for (i = 0; i < len; i++) {
if (tmp[i].selected) {
chosen = chosen +  tmp[i].value + ","
} 
}

return chosen
}
</script>
	
	
</head>
<body>

   

    <div id="container">    <!-- Start : container -->

       <?php include("top.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <?php include("left.php"); ?>

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        
                        <li class="current"><?=$pagetitle?></li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?><?=$pagetitle?></h3>
                        <span style="color:#CC6600;">
                        <?php 
                                        $msg = $_REQUEST['msg'];
                                        if($msg == 1)
                                                echo "<span style='color:#CC6600;'>Challenge Added Successfully.</span>";	 
                                        elseif($msg == 2)
                                                echo "<span style='color:#CC6600;'>Challenge Updated Successfully.</span>";	 
                                        elseif($msg == 3)
                                                echo "<span style='color:#CC6600;'>Challenge Deleted Successfully.</span>";	 
                                        elseif($msg == 4)
                                                echo "<span style='color:#CC6600;'>Challenge with this name is already exists.</span>";	 

                                        if($gmsg == 1)
                                                echo "Please enter all the information."; 
                                ?>
                        </span>
                    </div>
                </div>  <!-- End : Page Header -->

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?><?=$pagetitle?></div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="add_challenge.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
											<?php
											


											?>
                            <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Package
                             </label>     
                             <div class="col-md-9">
                             <select class="form-control required" name="package[]" id="package" multiple size="10">
                             	<option value="" <?php if($package_arr == ''){ ?>selected="selected"<?php } ?>>Please Select</option>
								<?php
								 	if(mysqli_num_rows($package_result) > 0){
										while($package_data = mysqli_fetch_array($package_result)){?>
								 			<option value="<?php echo $package_data['id']; ?>" <?php if(in_array($package_data['id'],$package_arr)) {?> selected <?php } ?> ><?php echo $package_data['name']; ?></option>
								 		<?php
										}
									}
								?>	
                             </select>
                            </div>
                        </div>					
			 
											
                            <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Challenge Type
                             </label>     
                             <div class="col-md-9">
                             <select class="form-control required" name="challenge_type" id="challenge_type">
                             	<option value="" <?php if($challenge_type == ''){ ?>selected="selected"<?php } ?>>Please Select</option>
								<?php
								 	if(mysqli_num_rows($challenge_type_result) > 0){
										while($challenge_type_data = mysqli_fetch_array($challenge_type_result)){?>
								 			<option value="<?php echo $challenge_type_data['id']; ?>" <?php if($challenge_type == $challenge_type_data['id']) {?> selected <?php } ?> ><?php echo $challenge_type_data['name']; ?></option>
								 		<?php
										}
									}
								?>	
                             </select>
                            </div>
                        </div>
											
						
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Challenge Name
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="challenge_name" type="text" id="challenge_name" value="<?=$challenge_name; ?>" />
                     </div>
                     </div>
											
					<div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Challenge Points
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="challenge_points" type="text" id="challenge_points" value="<?=$challenge_points; ?>" />
                     </div>
                     </div>
				
                     <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Challenge Image
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control <?php if($_REQUEST['mode'] == 'add'){?> required <?php } ?>" type="file" name="challenge_image" id="challenge_image" />
                                                            <?php 
                                            if($challenge_image!="" && file_exists("../challenge_image/".$challenge_image))
                                            {
                                                    ?>
                                                    <br />
                                                    <img alt="Challenge Image" src="../challenge_image/<?=$challenge_image;?>" width="125" border="0" />

                                                    <?											
                                            }
                                            ?>		
                                   </div>
                            </div>
											
					 <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Description
                     </label>     
                     <div class="col-md-9">
                     <textarea class="form-control required" name="challenge_description" id="challenge_description" rows="10"> <?=$challgnge_description; ?></textarea>
                     </div>
                     </div>
											
						<?php if($_REQUEST['mode'] == 'edit'){?>
			    			<div class="form-group">
								<label class="col-md-3 control-label">
								  <span class="required">*</span>Created Date
								 </label>     
								 <div class="col-md-9">
								 <input class="form-control required" name="add_date" type="text" id="add_date" value="<?=$add_date; ?>" size="35" maxlength="50" readonly="true">
									</div>
                            </div>
						<?php } ?>
			   
			 
                                 
                                    <div class="form-actions">                                        
                                        <input type="hidden" value="<?=$_GET["id"]; ?>" name="id">
										<input type="hidden" name="latitude" id="latitude" value="" />
										<input type="hidden" name="longitude" id="longitude" value="" />
                                         <?php if($_REQUEST['mode'] == 'add') { ?>
                                            <input name="Submit" type="submit" value="Add" class="btn green pull-right"  />
                                            <?php } else { ?>
                                            <input name="Submit" type="submit" value="Edit" class="btn green pull-right" />
                                        <?php } ?>
                                    </div>

                                    

                                </form>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>

            </div>  <!-- End : Inner Page container -->

        </div>  <!-- End : Inner Page Content -->
        <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>  <!-- End : container -->
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jquery.event.move.js"></script>
    <script type="text/javascript" src="js/lodash.compat.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script type="text/javascript" src="js/excanvas.js"></script>
    <script type="text/javascript" src="js/breakpoints.js"></script>
    <script type="text/javascript" src="js/touch-punch.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    
    <script>
        $(document).ready(function(){
            App.init();
            FormValidation.init();
        });        
		
    </script>
<script language="javascript">
function keshav_check()
{
			/* -------------- Challenge Type Validation --------------------- */
			if(document.getElementById("challenge_type").value.split(" ").join("") == "" || document.getElementById("challenge_type").value.split(" ").join("") == "0" || document.getElementById("challenge_type").value.split(" ").join("") == "-")
			{
				alert("Please Select Challenge Type.");
				document.getElementById("challenge_type").focus();
				return false;
			}
				
				
			/* -------------- Challenge Name Validation --------------------- */
			if(document.getElementById("challenge_name").value.split(" ").join("") == "" || document.getElementById("challenge_name").value.split(" ").join("") == "0")
			{
				alert("Please enter Challenge Name.");
				document.getElementById("challenge_name").focus();
				return false;
			}
	
			/* -------------- Challenge Points Validation --------------------- */
			if(document.frm.mode.value =="add" && (document.getElementById("challenge_points").value.split(" ").join("") == "" || document.getElementById("challenge_points").value.split(" ").join("") == "0"))
			{
				alert("Please enter Challenge Points.");
				document.getElementById("challenge_points").focus();
				return false;
			}
			
			
			/* -------------- Challenge Image Validation --------------------- */
			if(document.frm.mode.value =="add" && document.frm.challenge_image.value.split(" ").join("")==""){
				alert("Please Select Challenge Image.");
				document.frm.challenge_image.focus();
				return false
			}	
	
	
}
</script>                             
</body>
</html>