<?php
session_start();

include ("../include/config.inc.php");
include_once ("../include/sendmail.php");
include ("../include/functions.php");
$pas;
$ADMIN_MOUSEHOUR_COLOUR="#cccccc";
$ADMIN_MOUSEOUT_COLOUR="#FFFFFF";
$ADMIN_TOP_BGCOLOUR="#FFFFFF";

$db=mysqli_connect($DBSERVER, $USERNAME, $PASSWORD);
mysqli_select_db($db,$DATABASENAME);  
$pas=$_GET["pas"];


$query="select * from admin where username='".$_REQUEST["name"]."' and password='".$_REQUEST["pass"]."'";
$result=mysqli_query($db,$query);
  //echo $result;
  $row=mysqli_fetch_array($result);
  
	 $ADMIN_USERNAME=$row["username"];

 	$ADMIN_PASSWORD=$row["password"];

 $name=$_REQUEST["name"];
 $pass=$_REQUEST["pass"];
 
  if($_REQUEST["name"]==$ADMIN_USERNAME && $_REQUEST["pass"]==$ADMIN_PASSWORD)
  {
  
  			if(isset($UsErOfAdMiN))
			{
			  setcookie("UsErOfAdMiN","");
			  $UsErOfAdMiN="";
			}

			$_SESSION["ADMIN_SESS_USERID"]=$row["id"];
			setcookie("UsErOfAdMiN",$name);
			$_SESSION["ADMIN_SESS_USERTYPE"]=$row["type"];
			header("Location:deskboard.php?menu_name=Default");
  }
  else
  {
   	 header("Location:index.php?pas=1");
  }
  
?>