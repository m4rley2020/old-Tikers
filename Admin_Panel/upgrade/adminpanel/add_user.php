<?									
include("connect.php");
include("FCKeditor/fckeditor.php") ;
$LeftLinkSection = 1;
$pagetitle="User";

/* ---------------------- Declare Fields ---------------------- */

$user_type= "";
$first_name= "";
$last_name= "";
$username= "";
$email= "";
$password= "";
$phone_number= "";
$profile_image= "";
$add_date= "";
$is_verified= "";
$country_code=0;

/* ---------------------- Initialize Fields ---------------------- */

if(isset($_REQUEST["id"]) && $_REQUEST["id"] > 0)
{
	$id = $_REQUEST["id"];											
	$fetchquery = "select * from user where id=".$id;
	$result = mysqli_query($db,$fetchquery);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
				$user_type= stripslashes($row['user_type']);
				$first_name= stripslashes($row['first_name']);
				$last_name= stripslashes($row['last_name']);
				$username= stripslashes($row['username']);
				$email= stripslashes($row['email']);
				$password= stripslashes($row['password']);
				$phone_number= stripslashes($row['phone_number']);
				$profile_image= stripslashes($row['profile_image']);
				$add_date= stripslashes($row['add_date']);
				$is_verified= stripslashes($row['is_verified']);
				$country_code= stripslashes($row['country_code']);
				
		}
	}
	
}

/* ---------------------- Inser / Update Code ---------------------- */

if(isset($_REQUEST['Submit']))
{
	/* ------------- Change All Fck image permission to 777 -------------- */
	recurse_per_change($_SERVER["DOCUMENT_ROOT"]."/UserFiles");
		$user_type= addslashes($_REQUEST['user_type']);
		$first_name= addslashes($_REQUEST['first_name']);
		$last_name= addslashes($_REQUEST['last_name']);
		$username= addslashes($_REQUEST['username']);
		$email= addslashes($_REQUEST['email']);
		$password= addslashes($_REQUEST['password']);
		$phone_number= addslashes($_REQUEST['phone_number']);
		$profile_image= addslashes($_REQUEST['profile_image']);
		$add_date= addslashes($_REQUEST['add_date']);
		$country_code= addslashes($_REQUEST['country_code']);
		
		if($_REQUEST["is_verified"]!="")
		{		
			$is_verified = mysqli_real_escape_string(implode(",",$_REQUEST["is_verified"])); 			
		}
		$profile_image="";

		if ($_FILES["profile_image"]["error"] > 0)
		{
			//echo "Error: " . $_FILES["full"]["error"] . "<br />";
		}
		else
		{
			 $profile_image = rand(1,999).trim($_FILES["profile_image"]["name"]); 
			 move_uploaded_file($_FILES["profile_image"]["tmp_name"],"../User_image/".$profile_image);
			 
			 auto_change_file_permition("profile_image",$profile_image);
		}	
		
		if(isset($_REQUEST['mode']))
		{
			switch($_REQUEST['mode'])
			{
				case 'add' :
					if(GTG_is_dup_add('user','email',$email))
					{
						unset($_REQUEST['Submit']);	
						location("add_user.php?mode=add&msg=4");
						return;
					}
					
					$display_order=sam_get_display_order("user","",$db);
					//echo $display_order;
					$query = "insert into user set user_type='$user_type', first_name='$first_name', last_name='$last_name',
								username='$username',  email='$email', password='$password', phone_number='$phone_number', profile_image='$profile_image',
								add_date='$add_date', is_verified='$is_verified', country_code = '$country_code'"; 
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_user.php?msg=1");
				break;
				
				case 'edit' :
					if(GTG_is_dup_edit('user','email',$email,$_REQUEST['id']))
					{
						unset($_REQUEST['Submit']);	
						location("add_user.php?mode=edit&id=".$_REQUEST['id']."&msg=4");	
						return;
					}
					$query = "update user set user_type='$user_type', first_name='$first_name', last_name='$last_name', username='$username', email='$email',
								password='$password', phone_number='$phone_number', add_date='$add_date', is_verified='$is_verified', 
								country_code='$country_code'";
									
						
						if($profile_image!="")
						{
							deletefull1($_REQUEST['id']);
							$query.=" , profile_image='$profile_image'";
						} 
					$query.=" where id=".$_REQUEST['id'];
					mysqli_query($db,$query) or die(mysqli_error($db));
					location("manage_user.php?msg=2");
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
$query = "delete from user where id=".$_REQUEST['id'];     
			mysqli_query($db,$query) or die(mysqli_error($db));
			location("manage_user.php?msg=3");
		break;
	}	
}	
	
	function deletefull1($iid)
	{
		$dquery = "select profile_image from user where id=".$iid;
		$dresult = mysqli_query($db,$dquery);
		while($drow = mysqli_fetch_array($dresult))
		{
			$dfile = $drow['profile_image'];
			if($dfile != "")
			{
				if(file_exists("../User_image/".$dfile.""))
				{
					unlink("../User_image/".$dfile."");
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
    <title><? echo $pagetitle; ?> | </title>
    
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

       <? include("top.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <? include("left.php"); ?>

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        
                        <li class="current">User</li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><? echo ($_GET["id"]>0)?"Edit ":"Add "; ?>User</h3>
                        <span style="color:#CC6600;">
                        <?php 
                                        $msg = $_REQUEST['msg'];
                                        if($msg == 1)
                                                echo "<span style='color:#CC6600;'>User Added Successfully.</span>";	 
                                        elseif($msg == 2)
                                                echo "<span style='color:#CC6600;'>User Updated Successfully.</span>";	 
                                        elseif($msg == 3)
                                                echo "<span style='color:#CC6600;'>User Deleted Successfully.</span>";	 
                                        elseif($msg == 4)
                                                echo "<span style='color:#CC6600;'>User with this name is already exists.</span>";	 

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
                                <div class="caption"><i class="fa fa-bars"></i><? echo ($_GET["id"]>0)?"Edit ":"Add "; ?>User</div>
                                
                            </div>
                            <div class="portlet-body">
                                        <form action="add_user.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1"  novalidate="novalidate">
                                        <input type="hidden" name="mode" id="mode" value="<?= $_REQUEST['mode']; ?>" >
                                         
                            <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>User Type
                             </label>     
                             <div class="col-md-9">
                             <select class="form-control required" name="user_type" id="user_type">
                             <option value="-" <? if($user_type == '-'){ ?>selected="selected"<? } ?>>Please Select</option>
                             <? $tmp_cmb_array1 = explode(",",$user_type); ?>
                             <option value="User" <? if($user_type!="" && in_array("User",$tmp_cmb_array1)){ echo 'selected="selected"'; } ?>>User</option>
                             <option value="Store" <? if($user_type!="" && in_array("Store",$tmp_cmb_array1)){ echo 'selected="selected"'; } ?>>Store</option>
                             <option value="Famous" <? if($user_type!="" && in_array("Famous",$tmp_cmb_array1)){ echo 'selected="selected"'; } ?>>Famous</option> </select>
                            </div>
                        </div>
			 
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>First Name
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="first_name" type="text" id="first_name" value="<?=$first_name; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Last Name
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="last_name" type="text" id="last_name" value="<?=$last_name; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Username
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="username" type="text" id="username" value="<?=$username; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Email
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="email" type="text" id="email" value="<?=$email; ?>" />
                     </div>
                     </div>
				
                    <div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Password
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="password" type="text" id="password" value="<?=$password; ?>" />
                     </div>
                     </div>
				
					<div class="form-group">
                    <label class="col-md-3 control-label">
                      <span class="required">*</span>Country Code
                     </label>     
                     <div class="col-md-9">
                     <input class="form-control required" name="country_code" type="text" id="country_code" value="<?=$country_code; ?>" />
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
                              <span class="required">*</span>Profile Image
                             </label>     
                             <div class="col-md-9">
                            <input class="form-control <?php if($_REQUEST['mode'] == 'add'){?> required <?php } ?>" type="file" name="profile_image" id="profile_image" />
                                                            <? 
                                            if($profile_image!="" && file_exists("../User_image/".$profile_image))
                                            {
                                                    ?>
                                                    <br />
                                                    <img alt="Profile Image" src="../User_image/<?=$profile_image;?>" width="125" border="0" />

                                                    <?											
                                            }
                                            ?>		
                                   </div>
                            </div>
			    <div class="form-group">
                            <label class="col-md-3 control-label">
                              <span class="required">*</span>Reg Date
                             </label>     
                             <div class="col-md-9">
                             <input class="form-control required" name="add_date" type="text" id="add_date" value="<?=$add_date; ?>" size="35" maxlength="50" readonly="true">&nbsp;<img src="calendar.jpg" width="24" height="24" align="absbottom"	onclick="displayCalendar(document.frm.add_date,'yyyy-mm-dd',this)" />
                                </div>
                            </div>
			   
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                              Is Verified
                             </label>     
                             <div class="col-md-9"><? $tmp_cmb_array10 = explode(",",$is_verified); ?>
                             <input class="" <? if($is_verified!="" && in_array("1",$tmp_cmb_array10)){ echo 'checked="checked"'; } ?> name="is_verified[]" type="checkbox" id="is_verified[]" value="1">
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
				/* -------------- User Type Validation --------------------- */
				if(document.getElementById("user_type").value.split(" ").join("") == "" || document.getElementById("user_type").value.split(" ").join("") == "0" || document.getElementById("user_type").value.split(" ").join("") == "-")
				{
					alert("Please Select User Type.");
					document.getElementById("user_type").focus();
					return false;
				}
				
				
			/* -------------- First Name Validation --------------------- */
			if(document.getElementById("first_name").value.split(" ").join("") == "" || document.getElementById("first_name").value.split(" ").join("") == "0")
			{
				alert("Please enter First Name.");
				document.getElementById("first_name").focus();
				return false;
			}
			
			
			/* -------------- Last Name Validation --------------------- */
			if(document.getElementById("last_name").value.split(" ").join("") == "" || document.getElementById("last_name").value.split(" ").join("") == "0")
			{
				alert("Please enter Last Name.");
				document.getElementById("last_name").focus();
				return false;
			}
			
			
			/* -------------- Username Validation --------------------- */
			if(document.getElementById("username").value.split(" ").join("") == "" || document.getElementById("username").value.split(" ").join("") == "0")
			{
				alert("Please enter Username.");
				document.getElementById("username").focus();
				return false;
			}
			
			
			/* -------------- Email Validation --------------------- */
			if(document.getElementById("email").value.split(" ").join("") == "" || document.getElementById("email").value.split(" ").join("") == "0")
			{
				alert("Please enter Email.");
				document.getElementById("email").focus();
				return false;
			}
			
			
			/* -------------- Password Validation --------------------- */
			if(document.getElementById("password").value.split(" ").join("") == "" || document.getElementById("password").value.split(" ").join("") == "0")
			{
				alert("Please enter Password.");
				document.getElementById("password").focus();
				return false;
			}
			
			/* -------------- Country Code Validation --------------------- */
			if(document.getElementById("country_code").value.split(" ").join("") == "" || document.getElementById("country_code").value.split(" ").join("") == "0")
			{
				alert("Please enter Country Code.");
				document.getElementById("country_code").focus();
				return false;
			}
	
			/* -------------- Phone Number Validation --------------------- */
			if(document.getElementById("phone_number").value.split(" ").join("") == "" || document.getElementById("phone_number").value.split(" ").join("") == "0")
			{
				alert("Please enter Phone Number.");
				document.getElementById("phone_number").focus();
				return false;
			}
			
			
			/* -------------- Profile Image Validation --------------------- */
			<?php
				if($_REQUEST['mode'] == 'add'){?>
					if(document.frm.mode.value =="add" && document.frm.profile_image.value.split(" ").join("")=="")										{
						alert("Please Select Profile Image.");
						document.frm.profile_image.focus();
						return false
					}
				<?php
				}?>
			
			
			/* -------------- Reg Date Validation --------------------- */
			if(document.getElementById("add_date").value.split(" ").join("") == "" || document.getElementById("add_date").value.split(" ").join("") == "0")
			{
				alert("Please enter Reg Date.");
				document.getElementById("add_date").focus();
				return false;
			}			
}
</script>                             
</body>
</html>