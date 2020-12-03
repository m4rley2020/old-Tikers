<? 
	include("connect.php");
	$emp_id=$_REQUEST["emp_id"];
	$result=mysql_query("select * from employee where id=".$emp_id);
	$row=mysql_fetch_array($result);
	$join_date=stripslashes($row["joining_date1"]);
	$join_date_arr=split("-",$join_date);
	$leave_renew_date=date("Y-m-d",mktime(0,0,0,$join_date_arr[1],$join_date_arr[2],date("Y")));
	$last_renew_date=date("Y-m-d",mktime(0,0,0,$join_date_arr[1],$join_date_arr[2],date("Y")-1));
	if(date('Y-m-d') > $leave_renew_date)
	{
		$leave_renew_date=date("Y-m-d",mktime(0,0,0,$join_date_arr[1],$join_date_arr[2],date("Y")+1));
		$last_renew_date=date("Y-m-d",mktime(0,0,0,$join_date_arr[1],$join_date_arr[2],date("Y")));
	}

	
	$taken_leave_result=mysql_query("select * from employee_leave where eid=".$emp_id." and leave_type=0 and date1 <='".$leave_renew_date."' and date1 >= '".$last_renew_date."'");
	$total_full_leave_taken=mysql_num_rows($taken_leave_result);
	
	$taken_leave_result1=mysql_query("select * from employee_leave where eid=".$emp_id." and leave_type=1 and date1 <='".$leave_renew_date."' and date1 >= '".$last_renew_date."'");
	$total_half_leave_taken=mysql_num_rows($taken_leave_result1);
	
	$taken_leave_result2=mysql_query("select * from employee_leave where eid=".$emp_id." and leave_type=2 and date1 <='".$leave_renew_date."' and date1 >= '".$last_renew_date."'");
	$total_partial_leave_taken=mysql_num_rows($taken_leave_result2);
	
?>
    <table cellpadding="2" cellspacing="2">
		<? /*<tr>
			<td><strong>Join Date :</strong></td> 
			<td><?=$join_date?></td>
		</tr>
		*/ ?>
		<tr>
			<td><strong> Renew Date :</strong></td> 
			<td><?=$last_renew_date."&nbsp;&nbsp;&nbsp;###&nbsp;&nbsp;&nbsp;".$leave_renew_date?></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td><strong> Total Full Leave:</strong></td> 
			<td><?=$total_full_leave_taken;	?> </td>
			<td><strong> Total Partial Leave:</strong></td> 
			<td><?=$total_partial_leave_taken;	?> </td>
		</tr>
		<tr>
			<td><strong> Total Half Leave:</strong></td> 
			<td><?=$total_half_leave_taken;	?> </td>
			<td><strong style="color:#FF0000">Final Total :</strong></td>
			<td><strong style="color:#FF0000"><?=$total_full_leave_taken+$total_half_leave_taken;	?></strong></td>
		</tr>
		<tr>
			
		</tr>
	</table>
<?
	function sam_date_diff($start,$end,$return)
	{
		$diff = abs(strtotime($end) - strtotime($start));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		
		//printf("%d years, %d months, %d days\n", $years, $months, $days);	
			
		if($return=="d")
		{
			return $days;
		}
		if($return=="y")
		{
			return $years;
		}
		if($return=="m")
		{
			return $months;
		}
	}
 ?>