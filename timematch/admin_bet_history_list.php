<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}


	$thisinfo = $_POST["thisinfo"];
	
	$eventnum = "timematch_bethistory";

	include "/home/www/inc/db_connect_11.inc";
	mysql_query("set names 'utf8'");

?>
<table cellpadding="1" cellspacing="1" border="0" bgcolor="dddddd">
	<tr align="center" bgcolor="ffffff" height="26">
		<td>종료시간</td>
		<td>기전명</td>
		<td>배당</td>
		<td>베팅포인트</td>
		
		<td>흑대국자</td>
		<td>백대국자</td>
		<td>베팅포인트</td>
		<td>배당</td>
		<td>결과</td>
		<td colspan="2"></td>
	</tr>
<?

	$i =1;
	$sql = "select * from tygem_eventlist where eventnum='$eventnum' and user_num=$thisinfo";
	$query = mysql_query($sql, $connect);
	while($data = mysql_fetch_array($query)){

		$seq = $data["seq"];

		$data1 = $data["data1"];
		$data2 = $data["data2"];
		$data3 = $data["data3"];
		$data4 = $data["data4"];
		$data5 = $data["data5"];
		$data6 = $data["data6"];
		$data7 = $data["data7"];
		$data8 = $data["data8"];
		$data9 = $data["data9"];
		$data10 = $data["data10"];
?>
	<tr bgcolor="ffffff" height="22">
		<td><input type="text" id="game_endtime<?=$i?>" value="<?=$data2?>" style="width:135px;"></td>
		<td><input type="text" id="title_name<?=$i?>" value="<?=$data10?>" style="width:120px;"></td>
		<td><input type="text" id="black_bet_ratio<?=$i?>" value="<?=$data3?>" style="width:48px;">
		<td><input type="text" id="black_totalbetmoney<?=$i?>" value="<?=$data4?>" style="width:110px;">
		<td><input type="text" id="black_id<?=$i?>" value="<?=$data5?>" style="width:86px;">
		<td><input type="text" id="white_id<?=$i?>" value="<?=$data6?>" style="width:86px">
		<td><input type="text" id="white_totalbetmoney<?=$i?>" value="<?=$data7?>" style="width:110px;">
		<td><input type="text" id="white_bet_ratio<?=$i?>" value="<?=$data8?>" style="width:46px;">
		<td><input type="text" id="game_result<?=$i?>" value="<?=$data9?>" style="width:60px;">
		
		<td><input type="button" value="update" onclick="javascript:update_data(<?=$i?>,<?=$seq?>);"></td>
		<td><input type="button" value="delete" onclick="javascript:delete_data(<?=$seq?>);"></td>
	</tr>
<?
		$i++;
	}

?>
	<tr bgcolor="ffffff" height="22">
		<td><input type="text" id="game_endtime0" style="width:135px;"></td>
		<td><input type="text" id="title_name0" style="width:120px;"></td>
		<td><input type="text" id="black_bet_ratio0" style="width:48">
		<td><input type="text" id="black_totalbetmoney0" style="width:110">
		<td><input type="text" id="black_id0" style="width:86">
		<td><input type="text" id="white_id0" style="width:86">
		<td><input type="text" id="white_totalbetmoney0" style="width:110">
		<td><input type="text" id="white_bet_ratio0" style="width:46">
		<td><input type="text" id="game_result0" style="width:60">

		
		<td colspan="2"><input type="button" value="insert" onclick="javascript:submit_data(0);"></td>
	</tr>
	