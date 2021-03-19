<?php
include "connect.php";
include "FCKeditor/fckeditor.php";
$LeftLinkSection = 1;
$pagetitle = "Store Code";

/* ---------------------- Declare Fields ---------------------- */

$store_id = "";
$points = "";
$code = "";

/* ---------------------- Initialize Fields ---------------------- */

if (isset($_REQUEST["x"]) && $_REQUEST["id"] > 0) {
    $id = $_REQUEST["id"];
    $fetchquery = "select * from store_code where id=" . $id;
    $result = mysqli_query($db, $fetchquery);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $store_id = stripslashes($row['store_id']);
            $points = stripslashes($row['points']);
            $code = stripslashes($row['code']);
        }
    }
}

/* ---------------------- Inser / Update Code ---------------------- */

if (isset($_REQUEST['Submit'])) {
    /* ------------- Change All Fck image permission to 777 -------------- */
    recurse_per_change($_SERVER["DOCUMENT_ROOT"] . "/UserFiles");
    $store_id = addslashes($_REQUEST['store_id']);
    $points = addslashes($_REQUEST['points']);
    $code = addslashes($_REQUEST['code']);

    if (isset($_REQUEST['mode'])) {
        switch ($_REQUEST['mode']) {
            case 'add':

                $query = "insert into store_code
					set store_id='$store_id',code='$code',points='$points'";
                mysqli_query($db, $query) or die(mysqli_error($db));

                location("manage_store_code.php?msg=1");
                break;

            case 'edit':

                $query = "update store_code set store_id='$store_id',code='$code',points='$points'";

                $query .= " where id=" . $_REQUEST['id'];
                mysqli_query($db, $query) or die(mysqli_error($db));
                location("manage_store_code.php?msg=2");
                break;
        }
    }
}
if (isset($_REQUEST['mode'])) {
    switch ($_REQUEST['mode']) {
        case 'delete':
            deletefull1($_REQUEST['id']);
            $query = "delete from store_code where id=" . $_REQUEST['id'];
            mysqli_query($db, $query) or die(mysqli_error($db));
            location("manage_store_code.php?msg=3");
            break;
    }
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
    <title><?php echo $pagetitle; ?> | </title>

    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/open-sans.css">

    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="css/style_default.css" rel="stylesheet" type="text/css" />

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

        function top_GetXmlHttpObject() {
            var xmlHttp = null;
            try {
                // Firefox, Opera 8.0+, Safari
                xmlHttp = new XMLHttpRequest();
            } catch (e) {
                // Internet Explorer
                try {
                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            return xmlHttp;
        }

        function sam_GetSelectedItem(field_id) {
            var tmp = document.getElementById(field_id);
            var len = tmp.length
            var i = 0
            var chosen = ","

            for (i = 0; i < len; i++) {
                if (tmp[i].selected) {
                    chosen = chosen + tmp[i].value + ","
                }
            }

            return chosen
        }
    </script>

</head>

<body>



    <div id="container">
        <!-- Start : container -->

        <?php include "top.php";?>

        <div id="content">
            <!-- Start : Inner Page Content -->

            <?php include "left.php";?>

            <div class="container">
                <!-- Start : Inner Page container -->

                <div class="crumbs">
                    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>

                        <li class="current">Store Code</li>
                    </ul>

                </div> <!-- End : Breadcrumbs -->

                <div class="page-header">
                    <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3><?php echo ($_GET["id"] > 0) ? "Edit " : "Add "; ?>Store Code</h3>
                        <span style="color:#CC6600;">
                            <?php
$msg = $_REQUEST['msg'];
if ($msg == 1) {
    echo "<span style='color:#CC6600;'>Code Added Successfully.</span>";
} elseif ($msg == 2) {
    echo "<span style='color:#CC6600;'>Code Updated Successfully.</span>";
} elseif ($msg == 3) {
    echo "<span style='color:#CC6600;'>Code Deleted Successfully.</span>";
} elseif ($msg == 4) {
    echo "<span style='color:#CC6600;'>Code with this name is already exists.</span>";
}

if ($gmsg == 1) {
    echo "Please enter all the information.";
}

?>
                        </span>
                    </div>
                </div> <!-- End : Page Header -->

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-bars"></i><?php echo ($_GET["id"] > 0) ? "Edit " : "Add "; ?>Store Code</div>

                            </div>
                            <div class="portlet-body">
                                <form action="add_store_code.php" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return keshav_check();" class="form-horizontal row-border" id="validate-1" novalidate="novalidate">
                                    <input type="hidden" name="mode" id="mode" value="<?=$_REQUEST['mode'];?>">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <span class="required">*</span>Store
                                        </label>
                                        <div class="col-md-9">
                                            <select class="form-control required" name="store_id" id="store_id">
                                                <option value="-" <?php if ($store_id == '-') {?>selected="selected" <?php }?>>Please Select</option><?php $tmp_cmb_array1 = explode(",", $store_id);?><?php
$add_result1 = mysqli_query($db, "select * from store where store_type_id != 5") or die(mysqli_error($db));
while ($add_row1 = mysqli_fetch_array($add_result1)) {
    ?>
                                                <option value="<?=$add_row1['id']?>" <?php if ($store_id != "" && in_array($add_row1['id'], $tmp_cmb_array1)) {
        echo 'selected="selected"';
    }?>><?=$add_row1['name'] . " ";?></option>
                                            <?php
}
?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <span class="required">*</span>points
                                        </label>
                                        <div class="col-md-9">
                                            <input class="form-control required" name="points" type="int" id="points" value="<?=$points;?>" />
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <span class="required">*</span>code
                                        </label>
                                        <div class="col-md-9">
                                            <input class="form-control required" name="code" type="text" id="code" value="<?=$code;?>" />
                                        </div>
                                    </div>




                                    <div class="form-actions">
                                        <input type="hidden" value="<?=$_GET["id"];?>" name="id">
                                        <?php if ($_REQUEST['mode'] == 'add') {?>
                                            <input name="Submit" type="submit" value="Add" class="btn green pull-right" />
                                        <?php } else {?>
                                            <input name="Submit" type="submit" value="Edit" class="btn green pull-right" />
                                        <?php }?>
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
        function keshav_check() {
            /* -------------- Store Validation --------------------- */
            if (document.getElementById("store_id").value.split(" ").join("") == "" || document.getElementById("store_id").value.split(" ").join("") == "0" || document.getElementById("store_id").value.split(" ").join("") == "-") {
                alert("Please Select Store.");
                document.getElementById("store_id").focus();
                return false;
            }


            /* -------------- Points Name Validation --------------------- */
            if (document.getElementById("points").value.split(" ").join("") == "" || document.getElementById("points").value.split(" ").join("") == "0") {
                alert("Please enter Points.");
                document.getElementById("points").focus();
                return false;
            }





            /* -------------- Code Validation --------------------- */
            if (document.getElementById("code").value.split(" ").join("") == "" || document.getElementById("code").value.split(" ").join("") == "0") {
                alert("Please enter Code.");
                document.getElementById("code").focus();
                return false;
            }




        }
    </script>
</body>

</html>