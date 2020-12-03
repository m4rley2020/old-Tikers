<?php 
include("connect.php");
include("admin.cookie.php");
$LeftLinkSection =3;
?>
<HTML>
<HEAD><title><?=Site_Title; ?></title>

<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link href="main.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<?php 
$id=$_GET['id'];
$qry="select * from staticpage where id=$id";
$rs=mysql_query($qry);
$arr=mysql_fetch_array($rs);
$pgnm=$arr["name"];
$pgdes=$arr["content"];
?>
<SCRIPT language=javascript src="body.js"></SCRIPT>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD height=60  colspan="2" bgColor=#333333><? include("top.php") ?></td>
  </TR>
  <tr>
   <td width="20%" valign="top" class="th-b" >
   	<? include("left.php"); ?>	</td>		
	<td width="80%" valign="top">

<table width="80%" align="center" cellpadding="0" cellspacing=0 class="t-a2">
  <tbody>
    <!--DWLayoutTable-->
    <tr>
      <td height="30" align="left" class="H2">Content Management <?=$pgnm;?> Page</td>
      <td align="left" class="H2">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="menu-a">Description</td>
      <td align="left" class="menu-a">Options</td>
      </tr>
    <tr>
      <td  align="left"><?=$pgdes;?></td>
      <td  align="left"><input name="button" type="button" class="bttn-s" onClick="window.location.href='editcontents.php?id=<?php echo $id; ?>'" value=" Edit "></td>
      </tr>
  </tbody>
</table>

</td></tr></TBODY></TABLE></BODY></HTML>


