<?
header("Content-Type:text/html;charset=utf-8");

	$set_round = $_POST["set_round"];
	$set_game = $_POST["set_game"];

@include "../db/game_".$set_round."_".$set_game.".inc";

	include "/home/www/inc/db_connect.inc";
?>

<table cellpadding="1" cellspacing="1" border="0" bgcolor="dddddd">
<?
	$i = 1;
	$sql = "select * from tygem_eventlist where eventnum='fivetofive2024_bet' and data2='$set_round' and data3='$set_game' order by seq";
	$query = mysql_query($sql, $connect);
	while($data = mysql_fetch_array($query)){
		$user_num = $data["user_num"];
		$user_id = $data["user_id"];
		$ip = $data["ip"];
		$writeday = $data["writeday"];
		$data1 = $data["data1"];

		$checkword1 = substr($data1, 0, 1);
		$checkword2 = substr($data1, 1, 1);
		$checkword3 = substr($data1, 2, 1);
		$checkword4 = substr($data1, 3, 1);
		$checkword5 = substr($data1, 4, 1);
		$checkword6 = substr($data1, 5, 1);

?>
	<tr bgcolor="ffffff" height="20">
		<td width="30"><?=$i?></td>
		<td width="60"><?=$user_num?></td>
		<td width="90"><?=iconv("euc-kr","utf-8",$user_id)?></td>
		<td width="100"><?=$ip?></td>
		<td width="150"><?=$writeday?></td>
		<td width="50">
<?
		if( ($winA=="A" && $checkword1==$winA) || ($winB=="B" && $checkword1==$winB) ){
			echo "<font color='red'>$checkword1</font>";
		}else{
			echo $checkword1;
		}
		if( ($winA_1_1=="A" && $checkword2==$winA_1_1) || ($winB_2_1=="B" && $checkword2==$winB_2_1) ){
			echo "<font color='red'>$checkword2</font>";
		}else{
			echo $checkword2;
		}
		if( ($winA_1_2=="A" && $checkword3==$winA_1_2) || ($winB_2_2=="B" && $checkword3==$winB_2_2) ){
			echo "<font color='red'>$checkword3</font>";
		}else{
			echo $checkword3;
		}
		if( ($winA_1_3=="A" && $checkword4==$winA_1_3) || ($winB_2_3=="B" && $checkword4==$winB_2_3) ){
			echo "<font color='red'>$checkword4</font>";
		}else{
			echo $checkword4;
		}
		if( ($winA_1_4=="A" && $checkword5==$winA_1_4) || ($winB_2_4=="B" && $checkword5==$winB_2_4) ){
			echo "<font color='red'>$checkword5</font>";
		}else{
			echo $checkword5;
		}
		if( ($winA_1_5=="A" && $checkword6==$winA_1_5) || ($winB_2_5=="B" && $checkword6==$winB_2_5) ){
			echo "<font color='red'>$checkword6</font>";
		}else{
			echo $checkword6;
		}
		
?>
		</td>
	</tr>
<?
		$i++;
	}
?>
</table>