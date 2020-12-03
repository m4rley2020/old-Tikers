<?									
include("connect.php");


include("function_pushnotification.php");

if(isset($_REQUEST['chid']) && isset($_REQUEST['mode']))
{	
	$sel_ch = mysql_query("select * from store_challenges where id='".$_REQUEST['chid']."' ");
	
	if(mysql_num_rows($sel_ch) > 0)
	{
		if($_REQUEST['mode'] == 1) 
		{
			$get_challenge = "select * from store_challenges where id='".$_REQUEST['chid']."' ";
			$get_challenge_res = mysql_query($get_challenge) or die(mysql_error());
			$get_challenge_row = mysql_fetch_array($get_challenge_res);
			
			$latitude = $get_challenge_row['lattitude'];
			$longitude = $get_challenge_row['longitude'];
			$store_id = $get_challenge_row['store_id'];
			$user_id = GetValue("store","user_id","id",$store_id);
			
			//==================================================================
			$user_query = "select user.*,( 3959 * acos( cos( radians($latitude) ) * cos( radians(user.latitude ) ) * cos( radians( user.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(user.latitude ) ) ) ) AS range1 from user where user_type != 'Store' having range1 <= '60' ";
			$user_query_res =   mysql_query($user_query)or die(mysql_error());
			if(mysql_num_rows($user_query_res)>0)
			{
				while($user_data = mysql_fetch_array($user_query_res))
				{
					$reciver_id = $user_data['id'];						
					$sender_user_name =  GetValue('store','name','id',$store_id);
					$noti_type = 'add_challenge';
					$noti_message = $sender_user_name.' has posted new challenge.';
					send_notification($user_id,$reciver_id,$noti_type,$noti_message);
					android_notification_function($user_id,$reciver_id,$noti_type,$noti_message);				
					insert_notification2($user_id,$reciver_id,$noti_type,$noti_message,$post_id);
				}
			}
			//==================================================================
			
			$current_date = date("Y-m-d");
			$expired_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($current_date)) . " +1 month"));
			
			$approve_ch = "update store_challenges set is_approved = 1, approved_date = now(), expired_date = '".$expired_date."' where id='".$_REQUEST['chid']."' ";
			
			if(mysql_query($approve_ch))
			{
				location("manage_store.php?msg=6");
			}
			else
			{
				echo mysql_error();
			}
			
		}
		else if($_REQUEST['mode'] == 0)
		{
			$reject_ch = "delete from store_challenges where id='".$_REQUEST['chid']."' ";
			
			if(mysql_query($reject_ch))
			{
				location("manage_store.php?msg=7");
			}
			else
			{
				echo mysql_error();
			}
		}
	}
}

$LeftLinkSection = 1;
$pagetitle="Pending Challenge";
$sel= "select * from store_challenges where store_id='".$_REQUEST['id']."' and is_approved = 0 and is_deleted = 0 and challenge_category = 'Paid' order by name" ;
$result=$prs_pageing->number_pageing($sel,20000,10,'N','Y');

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><? echo $pagetitle; ?> | <?=$SITE_NAME?></title>
    
    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/open-sans.css">
    
    <link rel="stylesheet" type="text/css" href="css/select2.css" />
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css" />
    
    
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">
    
<SCRIPT language=javascript src="body.js"></SCRIPT>

</head>

<body>

   <? include("top.php"); ?>

    <div id="container">    <!-- Start : container -->

    <? include("left.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        
                        <li class="current"><? echo $pagetitle; ?></li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Manage <? echo $pagetitle; ?></h3>
                        
                    </div>
                </div>  <!-- End : Page Header -->
                <? if($_GET["msg"]) { ?>
                <div class="alert alert-danger show">
                        <button class="close" data-dismiss="alert"></button>
                        
                          <span style="color:#CC6600;">
                          <?
                                    if($_GET["msg"]==1)
                                            echo "Challenge Added Successfully.";
                                    elseif($_GET["msg"]==2)
                                            echo "Challenge Updated Successfully.";
                                    elseif($_GET["msg"]==3)
                                            echo "Challenge Deleted Successfully.";
                                    elseif($_GET["msg"]==4)
                                            echo "Challenge with this name is already Exist.";	
                                    elseif($_GET["msg"]==5)
                                            echo "This Challenge is in use. You can not delete this Challenge.";	

                             ?>
                           </span>
                         
                 </div>
                 <? } 					  
                        ?> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i><? echo $pagetitle; ?></div>
                                                                
                                
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                <form name="frmNewsList" method="post" action="">
                                    <table class="table table-bordered table-hover DynamicTable">
                                        <thead>                                            
                                        <tr>
											<!--
											<th width="25px">
												<input type="checkbox" name="chkAll" id="chkAll" value="chkAll" onclick="chkSelectAll();" />
											</th>
											-->
											<th width="25px">No.</th>
											<th>Image</th>
											<th>challenge Type</th>
											<th>Name</th>										
											<th>Created Date</th>
                                             <th>Actions</th>                                               
                                        </tr>
                                        </thead>
                                        <tbody>
                                            
						  <? $count=0; 
							 while($get=mysql_fetch_object($result[0])) 
							 {  
								$count++;
						 ?>	 
							 <tr>
							  <!--<td>
							  <input type="hidden" name="pid<?=$count;?>" id="pid<?=$count;?>" value="<?=$get->id;?>" />
							  <input type="checkbox" name="chk<?=$count;?>" id="chk<?=$count;?>" value="<?=$count;?>" /></td>-->
							 <td><?=$count;?>.</td>
						 		<td class="photo">
								<?php if($get->challeng_image!="" && file_exists('../challenge_image/'.$get->challeng_image)) { ?>
									<img  src="<? echo '../challenge_image/'.$get->challeng_image; ?>" width="125" border="0" hspace="8" />
									<?php } ?>&nbsp;	
								 </td>
							  <td > <strong> <? echo stripslashes(GetValue('challenge_type','name','id',$get->challenge_type_id)); ?></strong></td>
								<td > <strong> <? echo stripslashes($get->name); ?></strong></td>
							
							<td class="photo"><strong> <? echo stripslashes($get->created_date); ?></strong></td>
								 <td nowrap>				 
		<a class="btn mini green" href="javascript:void(0);" onClick="window.location.href='store_pending_challenge.php?chid=<?php echo ($get->id); ?>&mode=1'"><i class="fa fa-check"></i>Approve</a> 
                <a class="btn mini red" href="javascript:void(0);" onClick="window.location.href='store_pending_challenge.php?chid=<?php echo ($get->id); ?>&mode=0'"><i class="fa fa-times"></i>Reject</a>                  
</td>
			</tr>	  
                <? } ?>	
                             </tbody>
                       </table>
			  
					<!--
                                 <div class="row"><div class="col-md-6">
				 <input type="hidden" name="count" id="count" value="<?=$count;?>" />   
				 <input style="margin-right:7px;" type="submit" name="btnDelete" id="btnDelete" value="Delete"  onclick="return chkDelete();" class="btn red pull-left" />&nbsp;
				 <input style="margin-right:7px;" type="button" name="button2" id="button2" value="ADD NEW"  onclick="location.href='add_challenge.php?mode=add'" class="btn green pull-left" />
					-->
                                    &nbsp; 
                                 
                                  <? // $result[1] ?> 								
                                   
                                    </div></div>
                                    </form>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>  <!-- End : Inner Page container -->
            <a href="javascript:void(0);" class="scrollup">Scroll</a>
        </div>  <!-- End : Inner Page Content -->

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
    
    <script type="text/javascript" src="js/select2.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/DT_bootstrap.js"></script>
    
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    
    <script>
        $(document).ready(function(){
            App.init();
            DataTabels.init();
        });        
    </script>
    
<script>
    function chkSelectAll()
    {
            totchk=document.getElementById("count").value;
            if(document.getElementById("chkAll").checked==true)
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=true;
                    }
            }
            else
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=false;
                    }
            }
    }
    function chkDelete()
    {
            return confirm("Are you sure that you want to delete the selected Challenge Type.");
    }
</script>    

</body>
</html>