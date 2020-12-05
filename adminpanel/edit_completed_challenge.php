<?php									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="Approve Completed Challenge";

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
	$fetchquery = "select SCC.*, U.username as username, S.name as store_name, SC.name as challenge_name from store_challenge_complete_by_user SCC left join user U on SCC.user_id = U.id left join store S on SCC.store_id = S.id left join store_challenges SC on SCC.challenge_id = SC.id where SCC.id=".$id;
	$result = mysql_query($fetchquery);
	if(mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_array($result))
		{
				$user_id= stripslashes($row['user_id']);
				$username= stripslashes($row['username']);
				$store_name= stripslashes($row['store_name']);
				$challenge_name= stripslashes($row['challenge_name']);
				$challenge_image= stripslashes($row['challenge_image']);
				$bill_image= stripslashes($row['bill_image']);
				$amount= stripslashes($row['amount']);
				$currency= stripslashes($row['currency']);
				$add_date= stripslashes($row['add_date']);
				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit_approve']) || isset($_REQUEST['Submit_reject']))
{
	$completed_challenge_id= addslashes($_REQUEST['id']);
			
	if(isset($_REQUEST['mode']))
	{
		switch($_REQUEST['mode'])
		{
			case 'edit' :
				if(isset($_REQUEST['Submit_approve'])){
					$query = "update store_challenge_complete_by_user set is_approve = 1, approved_by = 'Admin', approve_date = now() where id = '".$_REQUEST["id"]."' ";
					mysql_query($query) or die(mysql_error());
					location("manage_completed_challenge.php?msg=1");
				}
				
				if(isset($_REQUEST['Submit_reject'])){
					$query = "update store_challenge_complete_by_user set is_approve = 2, approved_by = 'Admin', approve_date = now() where id = '".$_REQUEST["id"]."' ";
					mysql_query($query) or die(mysql_error());
					location("manage_completed_challenge.php?msg=2");
				}
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
			mysql_query($query) or die(mysql_error());
			location("manage_store.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select store_image from store where id=".$iid;
		$dresult = mysql_query($dquery);
		while($drow = mysql_fetch_array($dresult))
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
		mysql_free_result($dresult);
	}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><?php echo $pagetitle; ?> | <?=$pagetitle?></title>
    
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
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?><?=$pagetitle?></div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="edit_completed_challenge.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                              User Name
                             </label>     
                             <div class="col-md-9">
                        		<?php echo $username; ?>
                             </div>
                        </div>
											
					<div class="form-group">
                            <label class="col-md-3 control-label">
                              Challenge Name
                             </label>     
                             <div class="col-md-9">
                        		<?php echo $challenge_name; ?>
                             </div>
                        </div>
			 
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      		Store Name
                     </label>     
                     <div class="col-md-9">
                    	<?php echo $store_name; ?>
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      Challenge Image
                     </label>     
                     <div class="col-md-9">
                     <?php
						 if($challenge_image!="" && file_exists("../complete_challenge_image/".$challenge_image))
						{
								?>
								<br />
								<img alt="Challenge Image" src="../complete_challenge_image/<?=$challenge_image;?>" width="125" border="0" />

								<?											
						}
						 ?>
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Bill Amount
                     </label>     
                     <div class="col-md-9">
                     <?php echo $amount; ?>
                     </div>
                     </div>
				
                    
                                 
                                    <div class="form-actions">                                        
                                        <input type="hidden" value="<?=$_GET["id"]; ?>" name="id">
                                         <?php if($_REQUEST['mode'] == 'add') { ?>
                                            <input name="Submit" type="submit" value="Add" class="btn green pull-right"  />
                                            <?php } else { ?>
                                            <input name="Submit_approve" type="submit" value="Approve" class="btn green pull-right" />
											<input name="Submit_reject" type="submit" value="Reject" class="btn red pull-right" />
                                        <?php } ?>
                                    </div>

                                    

                                </form>
                            </div>
                        </div>
                        
                        
                    </div>
                    
					<div class="col-md-6 col-sm-6">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-bars"></i>Completed Challenge Bill Image</div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                 
											
					
			 
                   
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Bill Image
                     </label>     
                     <div class="col-md-9">
                     <?php
						 if($bill_image!="" && file_exists("../complete_challenge_image/".$bill_image))
						{
								?>
								<br />
								<img alt="Challenge Image" src="../complete_challenge_image/<?=$bill_image;?>" style="width: 100%;" border="0" />

								<?											
						}
						 ?>
                     </div>
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