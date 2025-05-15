<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";



include "/home/www/inc/db_connect_11.inc";
mysql_query("set names 'utf8'");

	$eventnum = "timematch_table";

	$yoil = array("일","월","화","수","목","금","토");
	$view_time = array("00:00","11:00","15:00","17:00","21:00");

$set_date = $_POST["set_date"];

echo "<b>[ ".date("Y-m-d", $set_date)." ] (".$yoil[date('w', $set_date)].")</b>";
?>

<table border="1">
	<tr>

<? for($j=1; $j<=4; $j++){?>
		<td>

<input type="button" value="<?=$view_time[$j]?>"  style="width:80px;height:30px;" >




<br><br>


<? for($i=1; $i<=2; $i++){

	$sql = "select * from tygem_eventlist where eventnum = '$eventnum' and user_num=$set_date and info='$j' and num1=$i";
	//echo $sql;
	$query = mysql_query($sql, $connect);
	$data = mysql_fetch_array($query);

	$data1 = $data["data1"];
	$data2 = $data["data2"];
	$data3 = $data["data3"];
	$data4 = $data["data4"];
	$data5 = $data["data5"];
	$data6 = $data["data6"];
	$data7 = $data["data7"];

	$data8 = $data["data8"];
?>

<form name="thisform<?=$j?><?=$i?>" method="post" action="admin_table_process.php" target="hiddenFrame">
<input type="hidden" name="set_date" value="<?=$set_date?>">
<input type="hidden" name="set_time" value="<?=$j?>">
<input type="hidden" name="num1" value="<?=$i?>">

<table>
	<tr>
		<td colspan="2"><?=$i?>조<input type="checkbox" name="data8" value="Y" style="width:30px;height:30px;" <? if($data8 == "Y"){echo "checked";}?>><td>
		<td align="right"><input type="button" value="저장" style="width:100px;height:30px;" onclick="javascript:document.thisform<?=$j?><?=$i?>.submit()"></td>
	</tr>

	<tr>
		<td colspan="4" align="center"><input type="text" name="data1" value="<?=$data1?>" style="width:100px;height:26px"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="text" name="data2" value="<?=$data2?>" style="width:100px;height:26px"></td>
		<td colspan="2" align="center"><input type="text" name="data3" value="<?=$data3?>" style="width:100px;height:26px"></td>
	</tr>
	<tr>
		<td align="center"><input type="text" name="data4" value="<?=$data4?>" style="width:100px;height:26px"></td>
		<td align="center"><input type="text" name="data5" value="<?=$data5?>" style="width:100px;height:26px"></td>
		<td align="center"><input type="text" name="data6" value="<?=$data6?>" style="width:100px;height:26px"></td>
		<td align="center"><input type="text" name="data7" value="<?=$data7?>" style="width:100px;height:26px"></td>
	</tr>
</table>
</form>
<br><br>
<?}?>


<?}?>
		</td>
	</tr>
</table>
<iframe name="hiddenFrame" style="display:none" title="hiddenFrame"></iframe>