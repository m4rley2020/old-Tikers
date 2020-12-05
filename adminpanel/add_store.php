<?php									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="Store";

/* ---------------------- Declare Fields ---------------------- */

$user_id= "";
$name= "";
$store_type= "";
$location= "";
$latitude= "";
$longitude= "";
$phone_number= "";
$store_image= "";

/* ---------------------- Initialize Fields ---------------------- */

if(isset($_REQUEST["id"]) && $_REQUEST["id"] > 0)
{
	$id = $_REQUEST["id"];											
	$fetchquery = "select * from store where id=".$id;
	$result = mysqli_query($db,$fetchquery);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
				$user_id= stripslashes($row['user_id']);
				$name= stripslashes($row['name']);
				$store_type= stripslashes($row['store_type_id']);
				$location= stripslashes($row['location']);
				$latitude= stripslashes($row['latitude']);
				$longitude= stripslashes($row['longitude']);
				$phone_number= stripslashes($row['phone_number']);
				$store_image= stripslashes($row['store_image']);
				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit']))
{
	/* ------------- Change All Fck image permission to 777 -------------- */
	recurse_per_change($_SERVER["DOCUMENT_ROOT"]."/UserFiles");
		$user_id= addslashes($_REQUEST['user_id']);
		$name= addslashes($_REQUEST['name']);
		$store_type= addslashes($_REQUEST['store_type']);
		$location= addslashes($_REQUEST['location']);
		$latitude= addslashes($_REQUEST['latitude']);
		$longitude= addslashes($_REQUEST['longitude']);
		$phone_number= addslashes($_REQUEST['phone_number']);
		$store_image= addslashes($_REQUEST['store_image']);
		$store_image="";

		if ($_FILES["store_image"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $store_image = rand(1,999).trim($_FILES["store_image"]["name"]); 
			 move_uploaded_file($_FILES["store_image"]["tmp_name"],"../store_image/".$store_image);
			 
			 auto_change_file_permition("store_image",$store_image);
		}	if(isset($_REQUEST['mode']))
		{
			switch($_REQUEST['mode'])
			{
				case 'add' :
					
					$query = "insert into store 
					set store_type_id=$store_type,display_order='$display_order',user_id='$user_id',name='$name',location='$location',latitude='$latitude',longitude='$longitude',phone_number='$phone_number',store_image='$store_image'"; 
					mysqli_query($db,$query) or die(mysqli_error($db));
					
					$query2 = "update user set user_type = 'Store' where id=".$user_id;
					mysqli_query($db,$query2) or die(mysqli_error($db));
					
					location("manage_store.php?msg=1");
				break;
				
				case 'edit' :
					
					$query = "update store set store_type_id=$store_type,user_id='$user_id',name='$name',location='$location',latitude='$latitude',longitude='$longitude',phone_number='$phone_number'";
						
						if($store_image!="")
						{
							deletefull1($_REQUEST['id']);
							$query.=" , store_image='$store_image'";
						} 
					$query.=" where id=".$_REQUEST['id'];
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_store.php?msg=2");
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
$query = "delete from store where id=".$_REQUEST['id'];     
			mysqli_query($db,$query) or die(mysqli_error($db));
			location("manage_store.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select store_image from store where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['store_image'];
			if($dfile != "")
			{
				if(file_exists("../store_image/".$dfile.""))
				{
					unlink("../store_image/".$dfile."");
				}
			}
		}
		mysqli_free_result($dresult);
	}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><?php echo $pagetitle; ?> | </title>
    
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
                        
                        <li class="current">Store</li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Store</h3>
                        <span style="color:#CC6600;">
                        <?php 
                                        $msg = $_REQUEST['msg'];
                                        if($msg == 1)
                                                echo "<span style='color:#CC6600;'>Store Added Successfully.</span>";	 
                                        elseif($msg == 2)
                                                echo "<span style='color:#CC6600;'>Store Updated Successfully.</span>";	 
                                        elseif($msg == 3)
                                                echo "<span style='color:#CC6600;'>Store Deleted Successfully.</span>";	 
                                        elseif($msg == 4)
                                                echo "<span style='color:#CC6600;'>Store with this name is already exists.</span>";	 

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
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Store</div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="add_store.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>User
                             </label>     
                             <div class="col-md-9">
                        <select class="form-control required" name="user_id" id="user_id" ><option value="-" <?php if($user_id == '-'){ ?>selected="selected"<?php } ?>>Please Select</option><?php $tmp_cmb_array1 = explode(",",$user_id); ?><?										
											$add_result1 = mysqli_query($db,"select * from user") or die(mysqli_error($db));			
											while($add_row1 = mysqli_fetch_array($add_result1))
											{	
											?>
											<option value="<?=$add_row1['id']?>" <?php if($user_id!="" && in_array($add_row1['id'],$tmp_cmb_array1)){ echo 'selected="selected"'; } ?>><?=$add_row1['first_name']." ".$add_row1['last_name']." (".$add_row1['username'].")";?></option>
											<?
											}										
											?> </select>
								 
                             </div>
                        </div>
			 
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Store Name
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="name" type="text" id="name" value="<?=$name; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Type
                     </label>     
                     <div class="col-md-9">
                    <select class="form-control required" name="store_type" id="store_type" ><option value="-" <?php if($store_type == '-'){ ?>selected="selected"<?php } ?>>Please Select</option><?php $tmp_cmb_array1 = explode(",",$store_type); ?><?php                                        
                                            $add_result1 = mysqli_query($db,"select * from store_type") or die(mysqli_error($db));            
                                            while($add_row1 = mysqli_fetch_array($add_result1))
                                            {   
                                            ?>
                                            <option value="<?=$add_row1['id']?>" <?php if($store_type!="" && in_array($add_row1['id'],$tmp_cmb_array1)){ echo 'selected="selected"'; } ?>><?=$add_row1['store_type'];?></option>
                                            <?
                                            }                                       
                                            ?> </select>
                     <!-- <input class="form-control required" name="store_type" type="text" id="store_type" value="<?=$store_type; ?>" /> -->
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Location
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="location" type="text" id="location" value="<?=$location; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Latitude
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="latitude" type="text" id="latitude" value="<?=$latitude; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Longitude
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="longitude" type="text" id="longitude" value="<?=$longitude; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Phone Number
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="phone_number" type="text" id="phone_number" value="<?=$phone_number; ?>" />
                     </div>
                     </div>
				
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>image
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control  <?php if($store_type=="") { echo 'required'; }?>" type="file" name="store_image" id="store_image" />
                                                            <?php 
                                            if($store_image!="" && file_exists("../store_image/".$store_image))
                                            {
                                                    ?>
                                                    <br />
                                                    <img alt="image" src="../include/sample.php?nm=../store_image/<?=$store_image;?>&mwidth=88&mheight=88" border="0" />

                                                    <?											
                                            }
                                            ?>		
                                   </div>
                            </div>
			   
                                 
                                    <div class="form-actions">                                        
                                        <input type="hidden" value="<?=$_GET["id"]; ?>" name="id">
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
				/* -------------- User Validation --------------------- */
				if(document.getElementById("user_id").value.split(" ").join("") == "" || document.getElementById("user_id").value.split(" ").join("") == "0" || document.getElementById("user_id").value.split(" ").join("") == "-")
				{
					alert("Please Select User.");
					document.getElementById("user_id").focus();
					return false;
				}
				
				
			/* -------------- Store Name Validation --------------------- */
			if(document.getElementById("name").value.split(" ").join("") == "" || document.getElementById("name").value.split(" ").join("") == "0")
			{
				alert("Please enter Store Name.");
				document.getElementById("name").focus();
				return false;
			}
			
			
			/* -------------- Type Validation --------------------- */
			if(document.getElementById("store_type").value.split(" ").join("") == "" || document.getElementById("store_type").value.split(" ").join("") == "0")
			{
				alert("Please enter Type.");
				document.getElementById("store_type").focus();
				return false;
			}
			
			
			/* -------------- Location Validation --------------------- */
			if(document.getElementById("location").value.split(" ").join("") == "" || document.getElementById("location").value.split(" ").join("") == "0")
			{
				alert("Please enter Location.");
				document.getElementById("location").focus();
				return false;
			}
			
			
			/* -------------- Latitude Validation --------------------- */
			if(document.getElementById("latitude").value.split(" ").join("") == "" || document.getElementById("latitude").value.split(" ").join("") == "0")
			{
				alert("Please enter Latitude.");
				document.getElementById("latitude").focus();
				return false;
			}
			
			
			/* -------------- Longitude Validation --------------------- */
			if(document.getElementById("longitude").value.split(" ").join("") == "" || document.getElementById("longitude").value.split(" ").join("") == "0")
			{
				alert("Please enter Longitude.");
				document.getElementById("longitude").focus();
				return false;
			}
			
			
			/* -------------- Phone Number Validation --------------------- */
			if(document.getElementById("phone_number").value.split(" ").join("") == "" || document.getElementById("phone_number").value.split(" ").join("") == "0")
			{
				alert("Please enter Phone Number.");
				document.getElementById("phone_number").focus();
				return false;
			}
			
			/* -------------- image Validation --------------------- */
			if(document.frm.mode.value =="add" && document.frm.store_image.value.split(" ").join("")=="")										{
				alert("Please Select image.");
				document.frm.store_image.focus();
				return false
			}
            
}
</script>                             
</body>
</html>