<?php
	
	
	include ("../include/config.inc.php");
	include_once ("../include/sendmail.php");
	include ("../include/functions.php");
	
	  
	$db=mysqli_connect($DBSERVER, $USERNAME, $PASSWORD);
	mysqli_select_db($db,$DATABASENAME);
    
    
?>
