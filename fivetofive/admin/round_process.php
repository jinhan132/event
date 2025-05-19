<?
header("Content-Type:text/html;charset=utf-8");

	$str = "<?\n";
	foreach ($_POST as $param_name => $param_val) {
		$str .= "$".$param_name." = '".$param_val."';\n";
	}
	$str .= "?>";

	$table_name = "game_".$set_round."_".$set_game.".inc";

	$fp = fopen( "../db/$table_name", "w");
	fputs ($fp, $str);
	fclose($fp);


$eventnum_bet = "fivetofive2024_bet";
$eventnum_admin = "fivetofive2024_admin";
$eventnum_live = "fivetofive2024_live";

$ip = $_SERVER["REMOTE_ADDR"];


	include "/home/www/inc/db_connect.inc";

if($winA == "A" || $winB == "B"){

	$sql = "select * from tygem_eventlist where eventnum='$eventnum_bet' and data2='$set_round' and data3='$set_game' order by seq";
	$query = mysql_query($sql, $connect);
	while($data = mysql_fetch_array($query)){
		$win_cnt = 0;
		$num1 = 0;
		$myselect = $data["data1"];
		$user_num = $data["user_num"];
		$user_id = $data["user_id"];
		$writeday = $data["writeday"];

		if(substr($myselect, 0,1) == $winA){
			$num1 += $pointA;
			$win_cnt++;
		}else if(substr($myselect, 0,1) == $winB){
			$num1 += $pointB;
			$win_cnt++;
		}

		if(substr($myselect, 1,1) == $winA_1_1){
			$num1 += $pointA_1_1;
			$win_cnt++;
		}else if(substr($myselect, 1,1) == $winB_2_1){
			$num1 += $pointB_2_1;
			$win_cnt++;
		}

		if(substr($myselect, 2,1) == $winA_1_2){
			$num1 += $pointA_1_2;
			$win_cnt++;
		}else if(substr($myselect, 2,1) == $winB_2_2){
			$num1 += $pointB_2_2;
			$win_cnt++;
		}
		if(substr($myselect, 3,1) == $winA_1_3){
			$num1 += $pointA_1_3;
			$win_cnt++;
		}else if(substr($myselect, 3,1) == $winB_2_3){
			$num1 += $pointB_2_3;
			$win_cnt++;
		}
		if(substr($myselect, 4,1) == $winA_1_4){
			$num1 += $pointA_1_4;
			$win_cnt++;
		}else if(substr($myselect, 4,1) == $winB_2_4){
			$num1 += $pointB_2_4;
			$win_cnt++;
		}
		if(substr($myselect, 5,1) == $winA_1_5){
			$num1 += $pointA_1_5;
			$win_cnt++;
		}else if(substr($myselect, 5,1) == $winB_2_5){
			$num1 += $pointB_2_5;
			$win_cnt++;
		}

			if($win_cnt == 5){
//				$num1 = $num1 + 200;
			}

			$sql_sel = "select seq from tygem_eventlist where eventnum='$eventnum_admin' and data2='$set_round' and data3='$set_game' and user_num=$user_num";
			$query_sel = mysql_query($sql_sel, $connect);
			$data_sel = mysql_fetch_array($query_sel);
			$seq = $data_sel["seq"];
			if($seq > 0){
				$sql_up = "update tygem_eventlist set num1=$num1, data4=$win_cnt where seq=$seq";
				$query_up = mysql_query($sql_up, $connect);
			}else{
				$sql_in = "insert into tygem_eventlist(eventnum, user_num, user_id, ip, writeday, data1, data2, data3, num1) values ('$eventnum_admin', $user_num, '$user_id', '$ip', '$writeday', '$myselect', '$set_round', '$set_game', $num1)";
				$query_in = mysql_query($sql_in, $connect);
			}
	}

}


/******************************************************************************************************************/

		$sql_set = "delete from tygem_eventlist where eventnum='$eventnum_live' and data2='$set_round' and data3='$set_game'";
		$query_set = mysql_query($sql_set, $connect);

/******************************************************************************************************************/


if($winA_1_1 == "A" or $winA_1_2 == "A" or $winA_1_3 == "A" or $winA_1_4 == "A" or $winA_1_5 == "A" or $winB_2_1 == "B" or $winB_2_2 == "B" or $winB_2_3 == "B" or $winB_2_4 == "B" or $winB_2_5 == "B"){


	$set_date = $game_date;

	$set_date_var = explode("-",$set_date);
	$betgame_kind = "betgame".$set_date_var[0].$set_date_var[1].$set_date_var[2];
	$game_time_start = $set_date." 18:00:00";
	$game_time_end = $set_date." 23:59:59";

	$data_msg1 = "5억";
	$data_msg2 = "5억";
	$data_msg3 = "100만";
	$data_msg4 = "100만";
	$data_msg5 = "장미";


	$select_id = "";

for($i=1; $i<=5;$i++){

	$nick1 = "nick_1_".$i;
	$nick2 = "nick_2_".$i;

	if($$nick1 != ""){
		$nick1 = $$nick1;
		if($select_id!=""){
			$select_id.=",'$nick1'";
		}else{
			$select_id.="'$nick1'";
		}
	}
	if($$nick2 != ""){
		$nick2 = $$nick2;
		if($select_id!=""){
			$select_id.=",'$nick2'";
		}else{
			$select_id.="'$nick2'";
		}
	}
}

	$log_txt = "";


if($set_date == date("Y-m-d")){
	$bet_game = "bet_game";
	$bet_list = "bet_list";
}else{
	$bet_game = "bet_game_9D";
	$bet_list = "bet_list_rank";
}

	


	$sql = "select * from $bet_game, $bet_list where $bet_game.game_seq = $bet_list.game_seq and $bet_game.black_nick in ($select_id) and $bet_game.white_nick in ($select_id) and $bet_game.kind='$betgame_kind' and ($bet_game.game_time>='$game_time_start' and $bet_game.game_time<='$game_time_end') and $bet_list.ccode = 0 ";
	$query = mysql_query($sql, $connect);



	while($data = mysql_fetch_array($query)){
		
		$game_result = $data["game_result"];
		$user_num = $data["user_num"];
		$user_id = $data["user_id"];
		$bet_color = $data["bet_color"];
		$bet_money = $data["bet_money"];
		$rose_cnt = $data["rose_cnt"];

		$bet_time = $data["bet_time"];
		
		$idx = $data["idx"];



		$sql_in = "";
		if($bet_money >= 500000000){
			if($game_result == "B" || $game_result == "W"){
			if($game_result == $bet_color){
				$field_value = "data11";
				$data_num = 200;
				$data_msg .= iconv("euc-kr","utf-8",$user_id).",".$data_msg1.",".$data_num.",".$bet_time.",".$user_num."<br>";
			}else{
				$field_value = "data12";
				$data_num = 100;
				$data_msg .= iconv("euc-kr","utf-8",$user_id).",".$data_msg2 .",".$data_num.",".$bet_time.",".$user_num."<br>";
			}
			
			if($user_num > 0){
				$sql_in = "insert into tygem_eventlist(eventnum, user_num, user_id, ip, writeday, data1, data2, data3, $field_value, num1) values ('$eventnum_live', $user_num, '$user_id', '$ip', '$game_time_end', '$idx','$set_round', '$set_game', '1', $data_num)";
				mysql_query($sql_in, $connect);
			}
			}
		}else if($bet_money >= 10000000 && $bet_money < 500000000){
			if($game_result == "B" || $game_result == "W"){
			if($game_result == $bet_color){
				$field_value = "data13";
				$data_num = 40;
				$data_msg .= iconv("euc-kr","utf-8",$user_id).",".$data_msg3 .",".$data_num.",".$bet_time.",".$user_num."<br>";
			}else{
				$field_value = "data14";
				$data_num = 20;
				$data_msg .= iconv("euc-kr","utf-8",$user_id).",".$data_msg4.",".$data_num.",".$bet_time.",".$user_num."<br>";
			}
			if($user_num > 0){
				$sql_in = "insert into tygem_eventlist(eventnum, user_num, user_id, ip, writeday, data1, data2, data3, $field_value, num1) values ('$eventnum_live', $user_num, '$user_id', '$ip', '$game_time_end', '$idx', '$set_round', '$set_game', '1', $data_num)";
				mysql_query($sql_in, $connect);
			}
			}
		}


		if($rose_cnt >= 90){
			$data_msg .= iconv("euc-kr","utf-8",$user_id).",".$data_msg5.",10,".$bet_time.",".$user_num."<br>";
			$sql_in = "insert into tygem_eventlist(eventnum, user_num, user_id, ip, writeday, data1, data2, data3, data15, num1) values ('$eventnum_live', $user_num, '$user_id', '$ip', '$game_time_end', '$idx', '$set_round', '$set_game', '1', 10)";
			mysql_query($sql_in, $connect);

		}

	}

mysql_close($connect);

?>
<!--
<form name="log_form" method="post" accept-charset="utf-8">
<input type="hidden" name="log_txt" value="<?=$data_msg?>">
</form>
<script>//var winOpen = window.open('','live_log','');document.log_form.target='live_log';document.log_form.action='log_page.html';document.log_form.submit();</script>
-->
<?
}

?>
<script>alert("적용완료");//parent.location.href="round.html?round=<?=$set_round?>&game=<?=$set_game?>";</script>