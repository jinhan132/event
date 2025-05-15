<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}

$seq = $_POST["seq"];
if($seq>0){
}else{
	exit;
}

	$user_id = iconv("euc-kr","utf-8",$s_uid);

	$eventnum = "timematch_bethistory";

	include "/home/www/inc/db_connect.inc";
	mysql_query("set names 'utf8'");

	

	$game_time = $_POST["game_time"];
	$game_endtime = $_POST["game_endtime"];
	$black_bet_ratio = $_POST["black_bet_ratio"];
	$black_totalbetmoney = $_POST["black_totalbetmoney"];
	$black_id = $_POST["black_id"];
	$white_id = $_POST["white_id"];
	$white_totalbetmoney = $_POST["white_totalbetmoney"];
	$white_bet_ratio = $_POST["white_bet_ratio"];
	$game_result = $_POST["game_result"];
	$title_name = $_POST["title_name"];

	
	$user_num = date("Ymd", strtotime($game_time));
	
	$data1 = $game_time;
	$data2 = $game_endtime;
	$data3 = $black_bet_ratio;
	$data4 = $black_totalbetmoney;
	$data5 = $black_id;
	$data6 = $white_id;
	$data7 = $white_totalbetmoney;
	$data8 = $white_bet_ratio;
	$data9 = $game_result;
	$data10 = $title_name;

	$ip = $_SERVER["REMOTE_ADDR"];

	$sql = "update tygem_eventlist set data2='$data2', data3='$data3', data4='$data4', data5='$data5', data6='$data6', data7='$data7', data8='$data8', data9='$data9', data10='$data10' where eventnum='$eventnum' and seq=$seq";
	$query = mysql_query($sql, $connect);

mysql_close($connect);
?>