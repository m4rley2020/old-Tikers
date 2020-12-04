<?php 

    include ("../include/config.inc.php");
	// include_once ("../include/sendmail.php");
	//include ("../include/functions.php");
	//$pas;
  $ADMIN_MOUSEHOUR_COLOUR="#cccccc";
  $ADMIN_MOUSEOUT_COLOUR="#FFFFFF";
  $ADMIN_TOP_BGCOLOUR="#FFFFFF";
  
   $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
   mysql_select_db($DATABASENAME,$db);  
   $pas=$_GET["pas"];
   //$pas="";

?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Login | <?=$SITE_NAME?></title>

    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel='stylesheet' type='text/css' href="css/open-sans.css">
    
    <link rel='stylesheet' type='text/css' href="css/uniform.default.css">

    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">

</head>

<body class="login">
    
    <div class="logo"><!-- BEGIN LOGO -->
        <img src="images/logo.png" alt="logo" />
    </div>  <!-- END LOGO -->
    
    <div class="content">   <!-- BEGIN LOGIN -->
        
        <form class="form-vertical login-form" action="password.php">
            
            <h3 class="form-title">Login to your account</h3>
            
            <?php
                if($pas==1) // Access Denied
                {
            ?>
            <div class="alert alert-danger show">
                <button class="close" data-dismiss="alert"></button>
                <span>Access Denied</span>
            </div>
            <?php
                }
            ?>
             <?php
              if($_REQUEST['msg']==3)
                {
            ?>
            <div class="alert alert-danger show">
                <button class="close" data-dismiss="alert"></button>
                <span>Login details has been mailed to email address.</span>
            </div>
            <?php
                }
            ?>
            <?php
              if($_REQUEST['msg']==4)
                {
            ?>
            <div class="alert alert-danger show">
                <button class="close" data-dismiss="alert"></button>
                <span>Please enter Registered Email address.</span>
            </div>
            <?php
                }
            ?>
            <div class="control-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label">Username</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="fs-user-2"></i>
                        <input class="form-control" type="text" placeholder="Username" name="name" id="name"/>
                    </div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="fs-locked"></i>
                        <input class="form-control" type="password" placeholder="Password" name="pass" id="pass"/>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1"/> Remember me
                </label>
                <button type="submit" class="btn green pull-right">
                    <i class="fs-checkmark-2"></i> Login
                </button>            
            </div>
            
            <div class="forget-password">
                <a href="javascript:;" class="" id="forget-password">Forgot your password ?</a>
            </div>
            
        </form> <!-- END LOGIN FORM --> 
               
        
        <form class="form-vertical forget-form" action="forgot_pwd_process.php"> <!-- BEGIN FORGOT PASSWORD FORM -->
           
            <h3 class="">Forget Password ?</h3>
            <p>Enter your e-mail address below to reset your password.</p>
            
            <div class="control-group">
                <div class="controls">
                    <div class="input-icon left">
                        <i class="fa fa-envelope-o"></i>
                        <input class="form-control" type="text" placeholder="Email" name="forgot_email" id="forgot_email" />
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn">
                    <i class="fs-arrow-left"></i> Back
                </button>
                <button type="submit" class="btn green pull-right">
                    <i class="fs-checkmark-2"></i> Submit
                </button>            
            </div>
        </form> <!-- END FORGOT PASSWORD FORM -->
        
        
    </div>
    <!-- END LOGIN -->
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jquery.event.move.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.uniform.min.js"></script>

    <script type="text/javascript" src="js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.initLogin();
        });
    </script>
</body>
</html>