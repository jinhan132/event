<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}

function rep_rankNum($rank_num) {
	if($rank_num == "0")        $rk_level = "18급";
	elseif($rank_num == "27")   $rk_level = "1단";
	elseif($rank_num == "28")   $rk_level = "2단";
	elseif($rank_num == "29")   $rk_level = "3단";
	elseif($rank_num == "30")   $rk_level = "4단"; 
	elseif($rank_num == "31")   $rk_level = "5단";
	elseif($rank_num == "32")   $rk_level = "6단";
	elseif($rank_num == "33")   $rk_level = "7단";
	elseif($rank_num == "34")   $rk_level = "8단";
	elseif($rank_num == "35")   $rk_level = "9단";

	return $rk_level;
}


	$user1 = rawurldecode(trim($_POST["user1"]));
	$user2 = rawurldecode(trim($_POST["user2"]));
	$game_time = trim($_POST["game_time"]);

//	$user1 = iconv("utf-8","euc-kr",$user1);
//	$user2 = iconv("utf-8","euc-kr",$user2);

	include "/home/www/inc/db_con_baduklevel.php";
	mysql_query("set names 'utf8'");

	$sql1 = "select * from baduk_people_dictionary_2022 where ko='$user1' limit 1";
	$query1 = mysql_query($sql1, $db_con_baduklevel);
	$data1 = mysql_fetch_array($query1);


	$user1_nick = $data1["user_nick"];

	$sql2 = "select * from baduk_people_dictionary_2022 where ko='$user2' limit 1";
	$query2 = mysql_query($sql2, $db_con_baduklevel);
	$data2 = mysql_fetch_array($query2);

	$user2_nick = $data2["user_nick"];


mysql_close($db_con_baduklevel);

	include "/home/www/inc/db_connect_11.inc";
	mysql_query("set names 'utf8'");


?>
<table cellpadding="1" cellspacing="1" border="0" bgcolor="dddddd">
	<tr align="center" bgcolor="ffffff" height="26">
		<td>종료시간</td>
		<td>배당</td>
		<td>베팅포인트</td>
		<td>흑대국자</td>
		<td>백대국자</td>
		<td>베팅포인트</td>
		<td>배당</td>
		<td>결과</td>
		<td></td>
		<td></td>
		<td>기전명</td>
		<td></td>
	</tr>
<?
	$sql = "select * from bet_game_9D where ((black_nick='$user1_nick' and white_nick='$user2_nick') or (white_nick='$user1_nick' and black_nick='$user2_nick')) and game_endtime like '$game_time%' order by game_seq";

	$query = mysql_query($sql, $connect);
	
	$i = 1;

	while($data = mysql_fetch_array($query)){
	
		$game_seq = $data["game_seq"];
		$black_id = $data["black_id"];
		$white_id = $data["white_id"];
		$black_nick = $data["black_nick"];
		$white_nick = $data["white_nick"];

		$black_totalbetmoney = $data["black_totalbetmoney"];
		$white_totalbetmoney = $data["white_totalbetmoney"];
		$game_result = $data["game_result"];
		$title = $data["title"];
		$titlenum = $data["titlenum"];

		$game_endtime = $data["game_endtime"];

		$black_ranknum = $data["black_ranknum"];
		$white_ranknum = $data["white_ranknum"];

		

		$sql_bet = "select bet_color, bet_ratio from bet_list_rank where game_seq=$game_seq and (bet_color='B' or bet_color='W') group by bet_color limit 2";
		$query_bet = mysql_query($sql_bet, $connect);
		while($data_bet = mysql_fetch_array($query_bet)){
			$bet_color = $data_bet["bet_color"];
			if($bet_color == "B"){
				$black_bet_ratio = $data_bet["bet_ratio"];
			}else if($bet_color == "W"){
				$white_bet_ratio = $data_bet["bet_ratio"];
			}
		}

		if($black_nick == $user1_nick){
			$black_id = $user1;
		}
		if($black_nick == $user2_nick){
			$black_id = $user2;
		}
		if($white_nick == $user1_nick){
			$white_id = $user1;
		}
		if($white_nick == $user2_nick){
			$white_id = $user2;
		}

		if($game_result == "B"){
			$game_result_txt = "흑승";
		}else if($game_result == "W"){
			$game_result_txt = "백승";
		}
?>
	<tr bgcolor="ffffff" height="22">
		<td><input type="text" id="game_endtime<?=$i?>" value="<?=$game_endtime?>" style="width:135px;"></td>
		<td><input type="text" id="black_bet_ratio<?=$i?>" value="<?=$black_bet_ratio?>" style="width:48">
		<td><input type="text" id="black_totalbetmoney<?=$i?>" value="<?=number_format($black_totalbetmoney)?>" style="width:110">
		<td><input type="text" id="black_id<?=$i?>" value="<?=$black_id?> <?=rep_rankNum($black_ranknum)?>" style="width:86">
		<td><input type="text" id="white_id<?=$i?>" value="<?=$white_id?> <?=rep_rankNum($white_ranknum)?>" style="width:86">
		<td><input type="text" id="white_totalbetmoney<?=$i?>" value="<?=number_format($white_totalbetmoney)?>" style="width:110">
		<td><input type="text" id="white_bet_ratio<?=$i?>" value="<?=$white_bet_ratio?>" style="width:46">
		<td><input type="text" id="game_result<?=$i?>" value="<?=$game_result_txt?>" style="width:60">
		<td width="230"><?=$title?></td>
		<td width="60"><?=$titlenum?></td>
		<td><input type="text" id="title_name<?=$i?>" placeholder="타임매치 준결승" style="width:120px;"></td>
		<td><input type="button" value="save" onclick="javascript:submit_data(<?=$i?>);"></td>
	</tr>
<?
		$i++;
	}

?>
