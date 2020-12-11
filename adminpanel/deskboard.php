<?php 
include("connect.php"); 
	
$string="1";
$user_query = mysqli_query($db,"select * from user");
$post_query = mysqli_query($db,"select * from post");
$package_query = mysqli_query($db,"select * from package");
$challenge_type_query = mysqli_query($db,"select * from challenge_type");
$challenge_query = mysqli_query($db,"select * from store_challenges");
$store_query = mysqli_query($db,"select * from store");
$advertise_query = mysqli_query($db,"select * from advertise");
$promo_query = mysqli_query($db,"select * from promo_section");

echo "here";
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Dashboard | <?=$SITE_TITLE?></title>
    
    <!--[if lt IE 9]> <script src="js/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel='stylesheet' type='text/css' href="css/open-sans.css">
    
    <link rel='stylesheet' type='text/css' href="css/fullcalendar.css">
    <link rel='stylesheet' type='text/css' href="css/morris.css">
    
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    <link href="css/smart_wizard.css" rel="stylesheet" type="text/css"/>
    
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">

</head>

<body style="font-family:Arial, Helvetica, sans-serif;">

    <?php include("top.php"); ?>

    <div id="container">    <!-- Start : container -->

        <?php include("left.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li class="current">
                            <i class="fa fa-home"></i>Dashboard
                        </li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Dashboard</h3>
                        <span>statistics and more</span>
                    </div>
                </div>  <!-- End : Page Header -->
                
                <div class="row">
                    <div class="col-md-12">  <!-- For Dashboard Staters -->
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($user_query);?>
                                    </div>
                                    <div class="desc">									
                                        Users
                                    </div>
                                </div>
                                <a class="more" href="manage_user.php">
                                    View All <i class=" fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat green">
                                <div class="visual">
                                    <i class="fa fa-th-list"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($post_query);?>
                                    </div>
                                    <div class="desc">									
                                        Post
                                    </div>
                                </div>
                                <a class="more" href="manage_post.php">
                                    Check All <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($package_query);?>
                                    </div>
                                    <div class="desc">									
                                        Package
                                    </div>
                                </div>
                                <a class="more" href="manage_package.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($promo_query);?>
                                    </div>
                                    <div class="desc">									
                                        Promo
                                    </div>
                                </div>
                                <a class="more" href="manage_promo.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fs-banknote"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($challenge_type_query);?>
                                    </div>
                                    <div class="desc">									
                                        Challange Type
                                    </div>
                                </div>
                                <a class="more" href="manage_challenge_type.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
						<div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fs-banknote"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($challenge_query);?>
                                    </div>
                                    <div class="desc">									
                                        Challenges
                                    </div>
                                </div>
                                <a class="more" href="manage_store.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
						
						<div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat green">
                                <div class="visual">
                                    <i class="fs-banknote"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($store_query);?>
                                    </div>
                                    <div class="desc">									
                                        Store
                                    </div>
                                </div>
                                <a class="more" href="manage_store.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
						
						<div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fs-banknote"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <?php echo mysqli_num_rows($advertise_query);?>
                                    </div>
                                    <div class="desc">									
                                        Advertise
                                    </div>
                                </div>
                                <a class="more" href="manage_advertise.php">
                                    View more <i class="fs-arrow-right-2"></i>
                                </a>						
                            </div>
                        </div>
                        
                    </div>  <!-- END : Dashboard Staters -->
                    
                   
                </div>
                
                
                
               


            </div>  <!-- End : Inner Page container -->
            <a href="javascript:void(0);" class="scrollup">Scroll</a>
        </div>  <!-- End : Inner Page Content -->

    </div>  
    <p>
      <!-- End : container -->
      
      
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
      <script type="text/javascript" src="js/jquery.blockUI.js"></script>
      <script type="text/javascript" src="js/jquery.event.move.js"></script>
      <script type="text/javascript" src="js/lodash.compat.js"></script>
      <script type="text/javascript" src="js/respond.min.js"></script>
      <script type="text/javascript" src="js/excanvas.js"></script>
    </p>
    <p>&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp; </p>
<p>&nbsp;</p>
<p>
  <script type="text/javascript" src="js/breakpoints.js"></script>
  <script type="text/javascript" src="js/touch-punch.min.js"></script>
  
  <script type="text/javascript" src="js/jquery.flot.min.js"></script>
  <script type="text/javascript" src="js/jquery.flot.tooltip.js"></script>
  <script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
  <script type="text/javascript" src="js/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="js/jquery.sparkline.js"></script>
  <script type="text/javascript" src="js/fullcalendar.min.js"></script>
  
  
  <script type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/plugins.js"></script>
</p>
    <script>
        jQuery(document).ready(function() {
            App.init();
            Dashboard.init();
        });
    </script>
</body>
</html>
?>