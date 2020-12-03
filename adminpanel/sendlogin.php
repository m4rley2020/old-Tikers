<? session_start();
	include ("../include/config.inc.php");
	include_once ("../include/sendmail.php");
	include ("../include/functions.php");
	
  $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
  mysql_select_db($DATABASENAME,$db);
 if(isset($_REQUEST['id']))
	{
		$id = $_REQUEST['id'];
		if($id > 0)
		{
			$id = $_REQUEST['id'];
			$fetchquery = "select username,password from user where id=".$id;
			$result = mysql_query($fetchquery);
			if(mysql_num_rows($result) > 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$username = stripslashes($row['username']); 
					$password = stripslashes($row['password']);
					
					
				}
			}
		}
	}
if($_REQUEST["Submit"])
{	
	
	$username=addslashes($_REQUEST["username"]);
	$password=addslashes($_REQUEST["password"]);
	$query = "update user set username='"."',username='".$username."',password='".$password."' where id=".$_REQUEST['id']; 
	mysql_query($query) or die(mysql_error());
	
	//$result=mysql_query("select * from user where username='".$username."' and username='".$password."' where id=".$_REQUEST['id']."");	
	  $que_mail="select * from user where id=".$_REQUEST['id'];
	
	
	$rs=mysql_query($que_mail);
	if(mysql_num_rows($rs) > 0)
	{	
		$row1=mysql_fetch_array($rs);
		//$to=$_REQUEST["email"];
		$to=$row1["emailcontact"];
		
		$from=$ADMIN_MAIL;
		$subject="Login Detail from AmiBet";
		$mailcontent='<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
				<td colspan="2">Here is your login information:</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" width="40%">Username :
				</td>
				<td>'.stripslashes($row1["username"]).'		
				</td>
			</tr>
			<tr>
				<td align="right" width="40%">Password :
				</td>
				<td>'.stripslashes($row1["password"]).'		
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
		</table>';
		SendHTMLMail1($to,$subject,$mailcontent,$from);
		echo '<script language="javascript">location.href="sendlogin.php?msg=2";</script>';
	}
	else
	{
		echo '<script language="javascript">location.href="sendlogin.php?msg=2";</script>';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Send Login Detail</title>
</head>
<body style="padding-bottom:10px;" >
<form name="frm" method="post" action="sendlogin.php" onsubmit="javascript: return sam_check();">
<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id'];?>" />
<table align="center" width="81%" border="0" cellpadding="2" height="138" cellspacing="2" style="border-color:#CCCCCC; border-width:1px; border-style:solid">
<tr>
			<td align="center" colspan="3">
				<font color="#FFFFFF"><strong>Send Login Detail</strong></font></td>
		</tr>
			<tr>
		      <td valign="top" align="center" class="subtitle" colspan="2" >
			  <font color="#FFFFFF">
			  <?
						if($_REQUEST["msg"]==2)
						{
							echo 'Login Detail Sent Sucessfully';
						}
						
					?></font>
			  </td>
			</tr>
			<tr>
			<td align="right" class="main_heading_small"  style="color:#FFFFFF" >User name : </td>
			<td> <input type="text" name="username" id="username" value="<?=$username; ?>"  /></td>
		</tr>
		<tr>
			<td align="right" class="main_heading_small"  style="color:#FFFFFF" >Password : </td>
			<td> <input type="password" name="password" id="password" value="<?=$password; ?>"  /></td>
		</tr>
		
		<tr>
			<td  class="main_heading_small" style="color:#FFFFFF"></td>
			<td class="main_heading_small" style="color:#FFFFFF" >
            <input name="Submit" type="submit" class="send_form" value="Send"  /> &nbsp;
        <input type="button" name="Close" value="Close" onclick="javascript:window.close();" class="send_form"  /></td>
		</tr>
		
		
</table>
</form>
<script language="javascript" type="text/javascript">
	function sam_check()
	{
		if(document.getElementById("username").value.split(" ").join("") == "")
		{
			alert("Please enter Usename.");
			document.getElementById("username").focus();
			return false;
		}
		if(document.getElementById("password").value.split(" ").join("") == "")
		{
			alert("Please enter Password.");
			document.getElementById("password").focus();
			return false;
		}
		
	}
</script>
</body>
</html>

