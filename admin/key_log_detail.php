<?
header("Content-Type:text/html;charset=utf-8");

	include "../inc/db_con.inc";

	$reg_date = trim($_POST["reg_date"]);
	$ktype = trim($_POST["ktype"]);

	$start_date = $reg_date." 00:00:00";
	$end_date = $reg_date." 23:59:59";

if($ktype){

	if($ktype == 10){
		$ktype = 0;
	}

	$sql = "select * from key_history, user_basic where key_history.uid = user_basic.uid and key_history.ktype=$ktype and (key_history.reg_date >= '$start_date' and key_history.reg_date<='$end_date')";
	$query = mysql_query($sql);
?>
<table>
<?	
	$i = 1;
	while($data = mysql_fetch_array($query)){

		$info = $data["info"];
		$uid = $data["uid"];
		$reg_date = $data["reg_date"];
		$p_data = $data["p_data"];
		$m_data = $data["m_data"];

		$nick = $data["nick"];

?>
	<tr>
		<td width="50"><?=$i?></td>
		<td width="50"><?=$uid?></td>
		<td width="150"><?=$nick?></td>
		<td width="40"><?=$p_data?></td>
		<td width="40"><?=$m_data?></td>
		<td width="250"><?=$reg_date?></td>
	</tr>
<?
		$i++;
	}

?>
</table>
<?

}else{



	$sql = "select ktype, key_history.uid, nick, count(*), sum(p_data), sum(m_data) from key_history, user_basic where key_history.uid = user_basic.uid  and (key_history.reg_date >= '$start_date' and key_history.reg_date<='$end_date') group by ktype, key_history.uid";
	$query = mysql_query($sql);
?>
<table>
<?	
//	$i = 1;
	while($data = mysql_fetch_array($query)){

	$ktype = $data[0];
	
	if($ktype == 1){$ktype = "리워드 광고";
	}else if($ktype == 2){$ktype = "출석 체크 (일반)";
	}else if($ktype == 3){$ktype = "출석 체크 (추가)";
	}else if($ktype == 4){$ktype = "우편수령";
	}else if($ktype == 5){$ktype = "문제 해제";
	}else if($ktype == 6){$ktype = "해답도 보기";
	}else if($ktype == 7){$ktype = "기력 테스트";
	}else if($ktype == 8){$ktype = "운영자 지급";
	}else if($ktype == 9){$ktype = "운영자 소진";
	}else if($ktype == 10){$ktype = "기타";
	}else{$ktype="기타";}

	if($data[4] > 0){
		$pdata = "<font color='blue'>$data[4]</font>";
	}else{
		$pdata = $data[4];
	}

	if($data[5] > 0){
		$mdata = "<font color='red'>$data[5]</font>";
	}else{
		$mdata = $data[5];
	}

	if($old_ktype != $ktype){
		$i =1;
		echo "<tr><td colspan='7'>&nbsp;</td></tr>";
	}
?>
	<tr>
		<td width="50"><?=$i?></td>
		<td width="150"><?=$ktype?></td>
		<td width="50"><?=$data[1]?></td>
		<td width="150"><?=$data[2]?></td>
		<td width="40"><?=$data[3]?></td>
		<td width="40"><?=$pdata?></td>
		<td width="40"><?=$mdata?></td>
	</tr>
<?



		$old_ktype = $ktype;
		$i++;
	}

?>
</table>



<?}?>