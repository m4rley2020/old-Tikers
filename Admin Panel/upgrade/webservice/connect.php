<?php
	
	
	include ("../include/config.inc.php");
	include_once ("../include/sendmail.php");
	include ("../include/functions.php");
	
	  
	$db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
	mysql_select_db($DATABASENAME,$db);
    
    
?>
