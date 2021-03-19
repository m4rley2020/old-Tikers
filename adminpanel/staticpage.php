<?php
include("connect.php");

include("FCKeditor/fckeditor.php");
$LeftLinkSection = 3;
$pagetitle = "Static Page Management";
?>
<?php
$content = "";
$name = "";
$mode = "";
$id = 0;
$query = "";
$redirect = "";

$id = checkNum(GTG_firewall($_GET['id']));
if ($id != 0) {

    if ($id > 0) {
        $fetchquery = "select * from staticpage where id=" . $id;
        $result = mysqli_query($db, $fetchquery);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $content1 = stripslashes($row['content']);
                $title = stripslashes($row['title']);
                $meta_keywords = stripslashes($row['meta_keywords']);
                $meta_discription = stripslashes($row['meta_discription']);
                $image_path = stripslashes($row['image_path']);
                $page_header = stripslashes($row['page_header']);
                $alt = stripslashes($row['alt']);
            }
        }
    }
}

if (isset($_POST['Submit'])) {

    $image_path = "";

    if ($_FILES["image_path"]["error"] > 0) {
        //echo "Error: " . $_FILES["full"]["error"] . "<br />";
    } else {
        $image_path = rand(1, 999) . trim($_FILES["image_path"]["name"]);
        move_uploaded_file($_FILES["image_path"]["tmp_name"], "../staticpage_images/" . $image_path);
    }

    $title = addslashes(GTG_firewall($_POST['title']));

    $page_header = addslashes(GTG_firewall($_POST['page_header']));
    $meta_keywords = addslashes(GTG_firewall($_POST['meta_keywords']));
    $meta_discription = addslashes(GTG_firewall($_POST['meta_discription']));
    $content = addslashes($_REQUEST['content1']);
    $alt = addslashes(GTG_firewall($_POST['alt']));




    $id = checkNum(GTG_firewall($_POST['id']));
    $query = "update staticpage set title='" . $title . "',content='" . $content . "',meta_keywords='" . $meta_keywords . "',meta_discription='" . $meta_discription . "',page_header='" . $page_header . "',alt='" . $alt . "'";
    if ($image_path != "") {
        deletefull($id);
        $query .= " , image_path='" . $image_path . "'";
    }
    $query .= " where id=" . $id;
    $redirect = "<script language='javascript'>location.href='staticpage.php?id=" . $id . "&msg=1'</script>";
    mysqli_query($db, $query) or die(mysqli_error($db));
    print $redirect;
}
function deletefull($iid)
{
    $dquery = "select image_path from staticpage where id=" . $iid;
    $dresult = mysqli_query($db, $dquery);
    while ($drow = mysqli_fetch_array($dresult)) {
        $dfile = $drow['image_path'];
        if ($dfile != "") {
            if (file_exists("../staticpage_images/" . $dfile . "")) {
                unlink("../staticpage_images/" . $dfile . "");
            }
        }
    }
    mysqli_free_result($dresult);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Static Page Management | <?= $SITE_NAME ?></title>

    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel='stylesheet' type='text/css' href="css/open-sans.css">

    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="css/style_default.css" rel="stylesheet" type="text/css" />

    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">

    <SCRIPT language=javascript src="body.js"></SCRIPT>
    <script>
        function valid() {
            if (document.addprod.name.value == "") {
                alert("Enter Password");
                document.addprod.name.select();
                return false;
            }
        }
    </script>
</head>

<body>



    <div id="container">
        <!-- Start : container -->
        <?php include("top.php"); ?>

        <div id="content">
            <!-- Start : Inner Page Content -->
            <?php include("left.php"); ?>

            <div class="container">
                <!-- Start : Inner Page container -->

                <div class="crumbs">
                    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        <li class="current">Static Page Management | <?= $pagetitle ?></li>
                    </ul>

                </div> <!-- End : Breadcrumbs -->

                <div class="page-header">
                    <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Static Page Management</h3>
                    </div>
                </div> <!-- End : Page Header -->
                <?php $msg = $_REQUEST['msg'];
                if ($msg == 1) { ?>
                    <div class="alert alert-danger show">
                        <button class="close" data-dismiss="alert"></button>
                        Page Updated Successfully
                    </div>
                <?php  } ?>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-bars"></i>Static Page Management</div>

                            </div>
                            <div class="portlet-body">

                                <form class="form-horizontal row-border" id="validate-1" novalidate="novalidate" action="staticpage.php" method="post" enctype="multipart/form-data" name="frm" onSubmit="return jbj_check();">
                                    <input type="hidden" name="mode" id="mode" value="<?= GTG_firewall($_GET['mode']); ?>">
                                    <input type="hidden" value="<?= checkNum(GTG_firewall($_GET['id'])) ?>" name="id">


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Page Header <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="page_header" id="page_header" size="50" value="<?= $page_header; ?>" class="form-control required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Browser Bar Title <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title" id="title" size="50" value="<?= $title ?>" class="form-control required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Meta Keywords <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="meta_keywords" cols="60" rows="5" class="form-control required"><?= $meta_keywords; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Meta Description <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="meta_discription" cols="60" rows="5" class="form-control required"><?= $meta_discription; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Manage Primary Image / Flash <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <?php
                                            if ($image_path != "" && file_exists("../staticpage_images/" . $image_path)) {
                                                if (substr($image_path, -4) == ".swf") {
                                            ?>
                                                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="400" height="131">
                                                        <param name="movie" value="../staticpage_images/<?= $image_path; ?>">
                                                        <param name="quality" value="high">
                                                        <embed src="../staticpage_images/<?= $image_path; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="88" height="131"></embed>
                                                    </object> <a href="delete_image.php?id=<?= $_REQUEST['id'] ?>&name=image_path" onClick="deleteconfirm('Are you sure you want to delete this Image')">Delete</a> <?php
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    ?>
                                                    <img alt="image" src="../include/sample.php?nm=../staticpage_images/<?= $image_path; ?>&mwidth=88&mheight=131" border="0"><a href="delete_image.php?id=<?= $_REQUEST['id'] ?>&name=<?= $image_path; ?>" onClick="deleteconfirm('Are you sure you want to delete this Image')">Delete</a>
                                            <?php
                                                                                                                                                                                                                }
                                                                                                                                                                                                            }
                                            ?>
                                            <input name="image_path" type="file" id="image_path">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            Page Content <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <?php
                                            $oFCKeditor = new FCKeditor('content1');
                                            $oFCKeditor->BasePath = 'FCKeditor/';
                                            $oFCKeditor->Value = $content1;
                                            $oFCKeditor->Height = 300;
                                            $oFCKeditor->Create();
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <input name="Submit" id="Submit" type="submit" value="Edit" class="btn green pull-right">
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>


                </div>

            </div> <!-- End : Inner Page container -->

        </div> <!-- End : Inner Page Content -->
        <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div> <!-- End : container -->

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
        $(document).ready(function() {
            App.init();
            FormValidation.init();
        });
    </script>

    <script language="javascript">
        function jbj_check() {
            if (document.getElementById("title").value.split(" ").join("") == "") {
                alert("Please Enter Title.");
                document.getElementById("title").focus();
                return false;
            }
            if (document.getElementById("page_header").value.split(" ").join("") == "") {
                alert("Please Enter Page Header.");
                document.getElementById("page_header").focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>