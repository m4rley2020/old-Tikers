<?
	include ("../include/config.inc.php");
	include_once ("../include/sendmail.php");
	include ("../include/functions.php");
  
	$db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
	mysql_select_db($DATABASENAME,$db);  
	$pas=$_GET["pas"];


	
	$result=mysql_query("SELECT * FROM  `admin` WHERE  `email` = '".$_REQUEST["forgot_email"]."'");	
	$row=mysql_fetch_array($result);
        
	if($row["email"]==$_REQUEST["forgot_email"])
	{	
		
		//$to=$_REQUEST["email"];
		$to=$_REQUEST["forgot_email"];
		//$from="info@unpacktrack.com";
		$from=$ADMIN_MAIL;
		$subject="Your login details for adminpanel";
		$mailcontent='<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
				<td colspan="2"> Hi </td>
			</tr>
			<tr>
				<td colspan="2"> Here are your login details: </td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" width="40%">Username :
				</td>
				<td>'.stripslashes($row["username"]).'		
				</td>
			</tr>
			<tr>
				<td align="right" width="40%">Password :
				</td>
				<td>'.stripslashes($row["password"]).'		
				</td>
			</tr>
			<tr>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
		</table>';
		/*echo $mailcontent;
		exit;*/
		//SendHTMLMail1($to,$subject,$mailcontent,$from);
		echo '<script language="javascript">location.href="index.php?value=fgp&msg=3"</script>';
	}
	else
	{
		echo '<script language="javascript">location.href="index.php?value=fgp&type=forgot&msg=4"</script>';
	}

?>
