<?php									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="Challenge Type";

/* ---------------------- Declare Fields ---------------------- */

$name= "";
$challenge_image= "";
$is_hot= "";

/* ---------------------- Initialize Fields ---------------------- */

if(isset($_REQUEST["id"]) && $_REQUEST["id"] > 0)
{
	$id = $_REQUEST["id"];											
	$fetchquery = "select * from challenge_type where id=".$id;
	$result = mysqli_query($db,$fetchquery);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
				$name= stripslashes($row['name']);
				$challenge_image= stripslashes($row['challenge_image']);
				$is_hot= stripslashes($row['is_hot']);
				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit']))
{
	/* ------------- Change All Fck image permission to 777 -------------- */
	recurse_per_change($_SERVER["DOCUMENT_ROOT"]."/UserFiles");
		$name= addslashes($_REQUEST['name']);
		$challenge_image= addslashes($_REQUEST['challenge_image']);
		$is_hot = addslashes($_REQUEST['is_hot']);
				
		$challenge_image="";
		if ($_FILES["challenge_image"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $challenge_image = rand(1,999).trim($_FILES["challenge_image"]["name"]); 
			 move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../challenge_image/".$challenge_image);
			 
			 
		}	
		
		if(isset($_REQUEST['mode']))
		{
			switch($_REQUEST['mode'])
			{
				case 'add' :
					if(GTG_is_dup_add('challenge_type','name',$name))
					{
						unset($_REQUEST['Submit']);	
						location("add_challenge_type.php?mode=add&msg=4");
						return;
					}
					
					$display_order=sam_get_display_order("challenge_type","");
					
					$query = "insert into challenge_type 
					set display_order='$display_order',name='$name',challenge_image='$challenge_image',is_hot='$is_hot'"; 
					mysqli_query($db,$query) or die(mysqli_error());
					location("manage_challenge_type.php?msg=1");
				break;
				
				case 'edit' :
					if(GTG_is_dup_edit('challenge_type','name',$name,$_REQUEST['id']))
					{
						unset($_REQUEST['Submit']);	
						location("add_challenge_type.php?mode=edit&id=".$_REQUEST['id']."&msg=4");	
						return;
					}
					$query = "update challenge_type set name='$name',is_hot='$is_hot'";
						
						if($challenge_image!="")
						{
							deletefull1($_REQUEST['id']);
							$query.=" , challenge_image='$challenge_image'";
						} 
					$query.=" where id=".$_REQUEST['id'];
					
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_challenge_type.php?msg=2");
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
$query = "delete from challenge_type where id=".$_REQUEST['id'];     
			mysqli_query($db,$query) or die(mysqli_error($db));
			location("manage_challenge_type.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select challenge_image from challenge_type where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['challenge_image'];
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
                        
                        <li class="current">Challenge Type</li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Challenge Type</h3>
                        <span style="color:#CC6600;">
                        <?php 
                                        $msg = $_REQUEST['msg'];
                                        if($msg == 1)
                                                echo "<span style='color:#CC6600;'>Challenge Type Added Successfully.</span>";	 
                                        elseif($msg == 2)
                                                echo "<span style='color:#CC6600;'>Challenge Type Updated Successfully.</span>";	 
                                        elseif($msg == 3)
                                                echo "<span style='color:#CC6600;'>Challenge Type Deleted Successfully.</span>";	 
                                        elseif($msg == 4)
                                                echo "<span style='color:#CC6600;'>Challenge Type with this name is already exists.</span>";	 

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
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Challenge Type</div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="add_challenge_type.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Name
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="name" type="text" id="name" value="<?=$name; ?>" />
                     </div>
                     </div>
				
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Image
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control" type="file" name="challenge_image" id="challenge_image" />
                                                            <?php 
                                            if($challenge_image!="" && file_exists("../challenge_image/".$challenge_image))
                                            {
                                                    ?>
                                                    <br />
                                                    <img alt="Image" src="../include/sample.php?nm=../challenge_image/<?=$challenge_image;?>&mwidth=88&mheight=88" border="0" />

                                                    <?php											
                                            }
                                            ?>		
                                   </div>
                            </div>
			   
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                              Is Hot?
                             </label>     
                             <div class="col-md-9">
                             
                             <input  <?php if($is_hot!="" && $is_hot=="Yes" ){ echo 'checked="checked"'; } ?> name="is_hot" type="checkbox" id="is_hot" value="Yes">Yes
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
			/* -------------- Name Validation --------------------- */
			if(document.getElementById("name").value.split(" ").join("") == "" || document.getElementById("name").value.split(" ").join("") == "0")
			{
				alert("Please enter Name.");
				document.getElementById("name").focus();
				return false;
			}
			
			
			/* -------------- Image Validation --------------------- */
			if(document.frm.mode.value =="add" && document.frm.challenge_image.value.split(" ").join("")=="")										{
				alert("Please Select Image.");
				document.frm.challenge_image.focus();
				return false
			}
			
			
			
			
			
}
</script>                             
</body>
</html>