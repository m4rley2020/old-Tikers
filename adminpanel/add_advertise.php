<?php									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="Advertise";

/* ---------------------- Declare Fields ---------------------- */

$title= "";
$ads_image= "";
$ads_video= "";
$message= "";

/* ---------------------- Initialize Fields ---------------------- */

if(isset($_REQUEST["id"]) && $_REQUEST["id"] > 0)
{
	$id = $_REQUEST["id"];											
	$fetchquery = "select * from advertise where id=".$id;
	$result = mysqli_query($db,$fetchquery);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
				$title= stripslashes($row['title']);
				$ads_image= stripslashes($row['ads_image']);
				$ads_video= stripslashes($row['ads_video']);
				$message= stripslashes($row['message']);
				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit']))
{
	/* ------------- Change All Fck image permission to 777 -------------- */
	recurse_per_change($_SERVER["DOCUMENT_ROOT"]."/UserFiles");
		$title= addslashes($_REQUEST['title']);
		$ads_image= addslashes($_REQUEST['ads_image']);
		$ads_video= addslashes($_REQUEST['ads_video']);
		$message= addslashes($_REQUEST['message']);
		$ads_image="";

		if ($_FILES["ads_image"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $ads_image = rand(1,999).trim($_FILES["ads_image"]["name"]); 
			 move_uploaded_file($_FILES["ads_image"]["tmp_name"],"../ads_images/".$ads_image);
			 
			 auto_change_file_permition("ads_images",$ads_image);
		}$ads_video="";

		if ($_FILES["ads_video"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $ads_video = rand(1,999).trim($_FILES["ads_video"]["name"]); 
			 move_uploaded_file($_FILES["ads_video"]["tmp_name"],"../ads_video/".$ads_video);
			 
			 auto_change_file_permition("ads_video",$ads_video);
		}	if(isset($_REQUEST['mode']))
		{
			switch($_REQUEST['mode'])
			{
				case 'add' :
					if(GTG_is_dup_add('advertise','title',$title))
					{
						unset($_REQUEST['Submit']);	
						location("add_advertise.php?mode=add&msg=4");
						return;
					}
					
					$display_order=sam_get_display_order("advertise","");
					
					$query = "insert into advertise 
					set display_order='$display_order',title='$title',ads_image='$ads_image',ads_video='$ads_video',message='$message'"; 
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_advertise.php?msg=1");
				break;
				
				case 'edit' :
					if(GTG_is_dup_edit('advertise','title',$title,$_REQUEST['id']))
					{
						unset($_REQUEST['Submit']);	
						location("add_advertise.php?mode=edit&id=".$_REQUEST['id']."&msg=4");	
						return;
					}
					$query = "update advertise set title='$title',message='$message'";
						
						if($ads_image!="")
						{
							deletefull1($_REQUEST['id']);
							$query.=" , ads_image='$ads_image'";
						}
						
						if($ads_video!="")
						{
							deletefull2($_REQUEST['id']);
							$query.=" , ads_video='$ads_video'";
						} 
					$query.=" where id=".$_REQUEST['id'];
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_advertise.php?msg=2");
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
			deletefull2($_REQUEST['id']);
$query = "delete from advertise where id=".$_REQUEST['id'];     
			mysqli_query($db,$query) or die(mysqli_error($db));
			location("manage_advertise.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select ads_image from advertise where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['ads_image'];
			if($dfile != "")
			{
				if(file_exists("../ads_images/".$dfile.""))
				{
					unlink("../ads_images/".$dfile."");
				}
			}
		}
		mysqli_free_result($dresult);
	}
	
	function deletefull2($iid)
	{
		$dquery = "select ads_video from advertise where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['ads_video'];
			if($dfile != "")
			{
				if(file_exists("../ads_video/".$dfile.""))
				{
					unlink("../ads_video/".$dfile."");
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
                        
                        <li class="current">Advertise</li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Advertise</h3>
                        <span style="color:#CC6600;">
                        <?php 
                                        $msg = $_REQUEST['msg'];
                                        if($msg == 1)
                                                echo "<span style='color:#CC6600;'>Advertise Added Successfully.</span>";	 
                                        elseif($msg == 2)
                                                echo "<span style='color:#CC6600;'>Advertise Updated Successfully.</span>";	 
                                        elseif($msg == 3)
                                                echo "<span style='color:#CC6600;'>Advertise Deleted Successfully.</span>";	 
                                        elseif($msg == 4)
                                                echo "<span style='color:#CC6600;'>Advertise with this name is already exists.</span>";	 

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
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"]>0)?"Edit ":"Add "; ?>Advertise</div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="add_advertise.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Title
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="title" type="text" id="title" value="<?=$title; ?>" />
                     </div>
                     </div>
											
					<div class="form-group">
						<label class="col-md-3 control-label">
						  <span class="required">*</span>Upload Type
						 </label>     
						 <div class="col-md-9">
						 	<input class=" required" name="upld_type" type="radio" id="upload_type_image" value="image" onClick="show_upload_type('i');" style="height: 20px; width: 20px;" /> Image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class=" required" name="upld_type" type="radio" id="upload_type_video" value="video" onClick="show_upload_type('v');" style="height: 20px; width: 20px;" /> Video
						 </div>
						<input type="hidden" name="upload_type" id="upload_type" value ="" />
                     </div>
				
					<?php 
						if($ads_image!="" && file_exists("../ads_images/".$ads_image))
						{?>
                        <div class="form-group" id="image_type">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Image
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control required" type="file" name="ads_image" id="ads_image" />
                                                            
                                                   
                                                    <br />
                                                    <img alt="Image" src="../include/sample.php?nm=../ads_images/<?=$ads_image;?>&mwidth=88&mheight=88" border="0" />

                                                   
                                   </div>
                            </div>
			   			 <?php											
							}
							?>	
											
						<?php 
						if($ads_video!="" && file_exists("../ads_video/".$ads_video))
						{
								?>
                        <div class="form-group" id="video_type" >
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Video
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control required" type="file" name="ads_video" id="ads_video" />
                                                            
                                                    <br />
                                                    <img alt="Video" src="../include/sample.php?nm=../ads_video/<?=$ads_video;?>&mwidth=88&mheight=88" border="0" />

                                                    
                                   </div>
                            </div>
			   			<?php											
						}
						?>		
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Message
                             </label>     
                             <div class="col-md-9">
                              <textarea class="form-control required" name="message" id="message" cols="50" rows="7"><?=$message?></textarea>
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
			/* -------------- Title Validation --------------------- */
			if(document.getElementById("title").value.split(" ").join("") == "" || document.getElementById("title").value.split(" ").join("") == "0")
			{
				alert("Please enter Title.");
				document.getElementById("title").focus();
				return false;
			}
			
			
			/* -------------- Image Validation --------------------- */
			if(document.frm.mode.value =="add" && document.frm.ads_image.value.split(" ").join("")=="" && document.getElementByID("upload_type").value == "image")										{
				alert("Please Select Image.");
				document.frm.ads_image.focus();
				return false
			}
			
			
			/* -------------- Video Validation --------------------- */
			if(document.frm.mode.value =="add" && document.frm.ads_video.value.split(" ").join("")=="" && document.getElementByID("upload_type").value == "video")										{
				alert("Please Select Video.");
				document.frm.ads_video.focus();
				return false
			}
			
			
			/* -------------- Message Validation --------------------- */
			if(document.getElementById("message").value.split(" ").join("") == "" || document.getElementById("message").value.split(" ").join("") == "0")
			{
				alert("Please enter Message.");
				document.getElementById("message").focus();
				return false;
			}
			
			
}
	
	function show_upload_type(u_type){
		if(u_type == 'i'){
		   	document.getElementById("image_type").style.display = 'block';
			document.getElementById("video_type").style.display = 'none';
			document.getElementByID("upload_type").value = "image";
		}
		else if(u_type == 'v'){
			document.getElementById("video_type").style.display = 'block';
			document.getElementById("image_type").style.display = 'none';
			document.getElementByID("upload_type").value = "video";
		}
		else{
			document.getElementById("image_type").style.display = 'none';
			document.getElementById("video_type").style.display = 'none';
			document.getElementByID("upload_type").value = "";
		}
		   
	}
</script>                             
</body>
</html>