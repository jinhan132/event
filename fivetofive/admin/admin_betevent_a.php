<?
header("Content-Type:text/html;charset=utf-8");

	$set_round = $_POST["set_round"];
	$set_game = $_POST["set_game"];

@include "./db/game_".$set_round."_".$set_game.".inc";

	include "/home/www/inc/db_connect.inc";


?>

<table cellpadding="1" cellspacing="1" border="0" bgcolor="dddddd">
<?
	$i = 1;
	$sql = "select * from tygem_eventlist where eventnum='fivetofive2024_admin' and data2='$set_round' and data3='$set_game' order by seq";
	$query = mysql_query($sql, $connect);
	while($data = mysql_fetch_array($query)){
		$user_num = $data["user_num"];
		$user_id = $data["user_id"];
		$num1 = $data["num1"];


?>
	<tr bgcolor="ffffff" height="20">
		<td width="30"><?=$i?></td>
		<td width="60"><?=$user_num?></td>
		<td width="90"><?=iconv("euc-kr","utf-8",$user_id)?></td>
		<td width="50"><?=$num1?></td>
	
	</tr>
<?
		$i++;
	}
?>
</table>