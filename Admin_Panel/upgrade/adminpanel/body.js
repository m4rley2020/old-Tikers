function smsg(msgStr) { //v1.0
  status=msgStr;
  document.prs_return = true;
}
function nosmsg(msgStr) { //v1.0
  status=msgStr;
  document.prs_return = true;
}
function deleteconfirm(str,strurl)
{
	if (confirm(str)) 
	{
		this.location=strurl;
	}
}	