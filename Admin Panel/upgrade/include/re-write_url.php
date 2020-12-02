<?php
function blog_home_url($bid)
{
	global $SITE_URL;

	$BUSql=mysqli_query($db,"SELECT blog_title FROM blog WHERE id=".$bid);
	$BURes=mysqli_fetch_object($BUSql);
	$BTName=rms($BURes->blog_title);
	
	$BTName1=getModifiedUrlNamechange($BTName);
	
	// Online Url
	$BLUrl=$SITE_URL."/blog/".$BTName1."/".$bid;
	
	// Local Url
	//$BLUrl=$SITE_URL."/scuba-blog.php?bid=".$bid;
	
	return $BLUrl;
}

function blog_reply_url($bid)
{
	global $SITE_URL;

	$BUSql=mysqli_query($db,"SELECT blog_title FROM blog WHERE id=".$bid);
	$BURes=mysqli_fetch_object($BUSql);
	$BTName=$BURes->blog_title;
	$BTName1=getModifiedUrlNamechange($BTName);
	
	// Online Url
	//$BLUrl=$SITE_URL."/blog-view/".$BTName1."/".$bid;
	
	// Local Url
	$BLUrl=$SITE_URL."/scuba-blog-comment.php?bid=".$bid;
	
	return $BLUrl;
}



function getModifiedUrlNamechange($TmpName)
{
	$TmpName=ereg_replace(" & ","-",$TmpName);
	$TmpName=ereg_replace(" / ","-",$TmpName);
	$TmpName=ereg_replace("--","-",$TmpName);
	$TmpName=ereg_replace(" ","-",$TmpName);
	$TmpName=ereg_replace("--","-",$TmpName);
	$TmpName=ereg_replace("/","-",$TmpName);
	$TmpName=ereg_replace("--","-",$TmpName);
	$TmpName=ereg_replace(":","-",$TmpName);
	$TmpName=ereg_replace("/","-",$TmpName);
	$TmpName=ereg_replace("[^A-Za-z0-9]","-",$TmpName);
	$TmpName=ereg_replace("--","-",$TmpName);
	$TmpName=ereg_replace("--","-",$TmpName);
	
	return $TmpName;
}
?>