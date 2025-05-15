<?
header("Content-Type:text/html;charset=utf-8");

	include "../inc/db_con.inc";

$log_total_key = 0;


	$fsdate = trim($_POST["fsdate"]);
	$fedate = trim($_POST["fedate"]);

	$today = date("Y-m-d");
	$start_date = date("Y-m-d");
	$end_date = date("Y-m-d");

	$today_start = date("Y-m-d 00:00:00");
	$today_end = date("Y-m-d 23:59:59");

	$date_query = " and reg_date>='$today_start'";

//$date_row = (strtotime($fedate) - strtotime($fsdate)) / 86400;

	


if($fsdate && $fedate){
	$fsdate_q = $fsdate." 00:00:00";
	$fedate_q = $fedate." 23:59:59";
	$date_query = " and (reg_date>='$fsdate_q' and reg_date<='$fedate_q')";
	$start_date = $fsdate;
	$end_date = $fedate;
}else if($fsdate){
	$fsdate_q = $fsdate." 00:00:00";
	$date_query = " and (reg_date>='$fsdate_q' )";
	$start_date = $fsdate;
}else if($fedate){
	$fedate_q = $fedate." 23:59:50";
	$date_query = " and (reg_date<='$fedate_q')";
}

//$date_row = ceil( $date_row / 7 );

?>

<div class="input-group" style="width:60%">
	<input type="text" class="form-control" onclick="Calendar(this);" id="fsdate" value="<?=$fsdate?>"> ~ 
	<input type="text" class="form-control" onclick="Calendar(this);" id="fedate" value="<?=$fedate?>">&nbsp;
	<button type="button" class="btn btn-danger" onclick="javascript:keyLog()">search</button>
</div>
<div style="margin-top:10px;text-align: left;"><input type="button" class="btn btn-danger" value="KEY LOG"></div>



<?



	$i =1;
	$sql = "select date_format(reg_date, '%Y-%m-%d') as reg_date, ktype, count(*) as kcount, sum(p_data) as psum, sum(m_data) as msum from key_history where seq>0 $date_query  group by date_format(reg_date, '%Y-%m-%d'), ktype";


	$query = mysql_query($sql);
	while($data = mysql_fetch_array($query)){

		$reg_date = $data["reg_date"];
		$ktype = $data["ktype"];
		$kcount = $data["kcount"];
		$psum = $data["psum"];
		$msum = $data["msum"];

		$var_cnt[$reg_date][$ktype] = $kcount;
		$var_psum[$reg_date][$ktype] = $psum;
		$var_msum[$reg_date][$ktype] = $msum;
	}


?>
<table>
	<tr>
<?
	$i = 0;
	while(date("Y-m-d",strtotime("$start_date +$i day"))){

		$view_date = date("Y-m-d",strtotime("$start_date +$i day"));

?>
		<td valign="top">
			<table border="1" cellpadding="3" cellspacing="3" bgcolor="dddddd" width="100">
				<tr bgcolor="ffffff">
					<td colspan="3"><span onclick="javascript:view_log('<?=$view_date?>')" style="cursor:pointer;"><b><?=$view_date?></b></span></td>
				</tr>
<? 		
				$ksum = 0;
				for($k=1;$k<=10;$k++){ 
				
				if($k == 10){
					$ktype = 0;
				}else{
					$ktype = $k;
				}

				$ksum = $ksum + $var_psum[$view_date][$ktype] - $var_msum[$view_date][$ktype];
?>
				<tr bgcolor="ffffff">
					<td>&nbsp;</td>
					<td><?=$var_cnt[$view_date][$ktype]?></td>
					<td><span onclick="javascript:view_log('<?=$view_date?>','<?=$k?>')" style="cursor:pointer;"><? if($var_psum[$view_date][$ktype] > 0){echo "<font color='blue'>".$var_psum[$view_date][$ktype]."</font>";}?><? if($var_msum[$view_date][$ktype] > 0){echo "<font color='red'>".$var_msum[$view_date][$ktype]."</font>";}?></span></td>
				</tr>
				
<?			}

	$ksumt[$i] = $ksum;
?>
				
			</table>
		</td>
<?
		
	if( date("Y-m-d",strtotime("$start_date +$i day")) == $end_date){
		break;
	}
	$i++;

}
?>
		<td valign="top">
			<table width="150" border="1" cellpadding="3" cellspacing="3" bgcolor="dddddd">
				<tr bgcolor="ffffff">
					<td>날짜</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>리워드 광고</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>출석체크(일반)</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>출석체크(추가)</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>우편 수령</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>문제 해제</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>해답도 보기</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>기력 테스트</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>운영자 지급</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>운영자 소진</td>
				</tr>
				<tr bgcolor="ffffff">
					<td>기타</td>
				</tr>
			</table>
		</td>

	</tr>

	<tr>
<? for($i=0; $i<sizeof($ksumt); $i++){?>		
		<td><?=$ksumt[$i]?></td>
<?
	$log_total_key = $log_total_key + $ksumt[$i];
}?>
		<td><b><?=$log_total_key?></b></td>
	</tr>
</table>


