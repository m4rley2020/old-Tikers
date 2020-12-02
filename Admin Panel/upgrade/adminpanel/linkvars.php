<? 
$page_arr1=array(
array("Manage User","manage_user.php",0),
array("Add User","add_user.php?mode=add",0),);


$page_arr2=array(
array("Manage Post","manage_post.php",0),
array("Add Post","add_post.php?mode=add",0),);

$page_arr3=array(
array("Manage Package","manage_package.php",0),
array("Add Package","add_package.php?mode=add",0),);


$page_arr4=array(
array("Manage Challenge Type","manage_challenge_type.php",0),
array("Add Challenge Type","add_challenge_type.php?mode=add",0),);

$page_arr5=array(
array("Manage Store","manage_store.php",0),
array("Add Store","add_store.php?mode=add",0),);

$page_arr6=array(
array("Manage Advertise","manage_advertise.php",0),
array("Add Advertise","add_advertise.php?mode=add",0),);

$page_arr7=array(
array("Manage Challenge","manage_challenge.php",0),
array("Add Challenge","add_challenge.php?mode=add",0),);

$section_arr1=array (
array ("Manage User","manage_user.php",count($page_arr1),$page_arr1,"category.png"),
);

$section_arr2=array (
array ("Manage Post","manage_post.php",count($page_arr2),$page_arr2,"category.png"),
);
	
$section_arr3=array (
array ("Manage Package","manage_package.php",count($page_arr3),$page_arr3,"category.png"),
);
	
$section_arr4=array (
array ("Manage Challenge Type","manage_challenge_type.php",count($page_arr4),$page_arr4,"category.png"),
);
	
$section_arr5=array (
array ("Manage Store","manage_store.php",count($page_arr5),$page_arr5,"category.png"),
);
	
$section_arr6=array (
array ("Manage Advertise","manage_advertise.php",count($page_arr6),$page_arr6,"category.png"),
);

$section_arr7=array (
array ("Manage Challenge","manage_challenge.php",count($page_arr7),$page_arr7,"category.png"),
);
	
$HeadLinksArray = array (
array("User",count($section_arr1),$section_arr1),
array("Post",count($section_arr2),$section_arr2),
array("Package",count($section_arr3),$section_arr3),
array("Challenge Type",count($section_arr4),$section_arr4),
array("Challenge",count($section_arr7),$section_arr7),
array("Store",count($section_arr5),$section_arr5),
array("Advertise",count($section_arr6),$section_arr6),
);
 ?>
<script language="javascript" type="text/javascript">	
	
	var NoOffFirstLineMenus=<? echo count($HeadLinksArray).";"; ?>	//Total No. Of Main Sections Specify Here Too
	var LowBgColor='#FFFFFF';		
	var LowSubBgColor='#FFFFFF';		
	var HighBgColor='#7B9045';		
	var HighSubBgColor='#666666';	
	var FontLowColor='#333333';		
	var FontSubLowColor='#333333';	
	var FontHighColor='White';		
	var FontSubHighColor='White';	
	var BorderColor='#333333';		
	var BorderSubColor='#333333';	
	var BorderWidth=1;				
	var BorderBtwnElmnts=1;			
	var FontFamily="Verdana,Arial"	
	var FontSize=9;					
	var FontBold=1;					
	var FontItalic=0;				
	var MenuTextCentered='center';	
	var MenuCentered='center';		
	var MenuVerticalCentered='top';	
	var ChildOverlap=.0;			
	var ChildVerticalOverlap=.0;	
	var StartTop=94;				
	var StartLeft=0;				
	var VerCorrect=0;				
	var HorCorrect=0;				
	var LeftPaddng=3;				
	var TopPaddng=3;				
	var FirstLineHorizontal=1;		
	var MenuFramesVertical=0;		
	var DissapearDelay=75;			
	var TakeOverBgColor=0;			
	var FirstLineFrame='navig';		
	var SecLineFrame='navig';		
	var DocTargetFrame='navig';		
	var TargetLoc='';				
	var HideTop=0;					
	var MenuWrap=0;					
	var RightToLeft=0;				
	var UnfoldsOnClick=0;			
	var WebMasterCheck=0;			
	var ShowArrow=0;				
	var KeepHilite=1;				
	var Arrws=['../images/tri.gif',3,10,'../images/tridown.gif',6,4,'../images/trileft.gif',5,10];	// Arrow source, width and height
	
function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}

<?
	for($LinkCount=1;$LinkCount<=count($HeadLinksArray);$LinkCount++)
	{
		////////// FOR MAIN MENU (IE) 1ST LEVEL OF MENU (HEADING)/////////////////////
		/*echo 'Menu'.$LinkCount.' = new Array("'.$HeadLinksArray[$LinkCount-1][0].'","'.$HeadLinksArray[$LinkCount-1][5].'","",'.$HeadLinksArray[$LinkCount-1][1].','.$HeadLinksArray[$LinkCount-1][2].','.$HeadLinksArray[$LinkCount-1][3].');';*/
			
			$TempChildAry = $HeadLinksArray[$LinkCount-1][4];
			if(is_array($TempChildAry))
			{
				for($LinkCount2=1;$LinkCount2<=count($TempChildAry);$LinkCount2++)
				{
					////////// FOR SUB OF THE MENU (IE) 2ND LEVEL OF MENU/////////////////////
					/*echo "\n Menu".$LinkCount."_".$LinkCount2." = new Array('".$TempChildAry[$LinkCount2-1][0]."','".$TempChildAry[$LinkCount2-1][1]."','".$TempChildAry[$LinkCount2-1][2]."',".$TempChildAry[$LinkCount2-1][3].",".$TempChildAry[$LinkCount2-1][4].",".$TempChildAry[$LinkCount2-1][5].");";*/
					
							
							$TempChildAry2 = $TempChildAry[$LinkCount2-1][6];
							
							if(is_array($TempChildAry2))
							{
								////////// FOR SUB - SUB OF THE MENU (IE) 3RD LEVEL OF MENU///////////////////// 							
								for($LinkCount3=1;$LinkCount3<=count($TempChildAry2);$LinkCount3++)
								{
										/*echo "\n Menu".$LinkCount."_".$LinkCount2."_".$LinkCount3." = new Array('".$TempChildAry2[$LinkCount3-1][0]."','".$TempChildAry2[$LinkCount3-1][1]."','".$TempChildAry2[$LinkCount3-1][2]."',".$TempChildAry2[$LinkCount3-1][3].",".$TempChildAry2[$LinkCount3-1][4].",".$TempChildAry2[$LinkCount3-1][5].");";*/
										
								}
							}
					
				}
			}
		
	}
?>
</script>