<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}

	$user_id = iconv("euc-kr","utf-8",$s_uid);

	include "/home/www/inc/db_connect.inc";
	mysql_query("set names 'utf8'");

	$eventnum = "timematch_table";

	$set_date = $_POST["set_date"];
	$set_time = $_POST["set_time"];
	$num1 = $_POST["num1"];
	
	$data8 = $_POST["data8"];

	$data1 = $_POST["data1"];
	$data2 = $_POST["data2"];
	$data3 = $_POST["data3"];
	$data4 = $_POST["data4"];
	$data5 = $_POST["data5"];
	$data6 = $_POST["data6"];
	$data7 = $_POST["data7"];

	
	$sql = "select seq from tygem_eventlist where eventnum='$eventnum' and user_num=$set_date and info='$set_time' and num1=$num1";
	$query = mysql_query($sql, $connect);
	$data = mysql_fetch_array($query);

	$seq = $data[0];
	if($seq > 0){
		$sql_up = "update tygem_eventlist set data1='$data1', data2='$data2', data3='$data3', data4='$data4', data5='$data5', data6='$data6', data7='$data7', data8='$data8' where eventnum='$eventnum' and seq=$seq";
//		echo $sql_up;
		mysql_query($sql_up, $connect);

	}else{
		
		$ip = $_SERVER["REMOTE_ADDR"];
		$sql_in = "insert into tygem_eventlist(eventnum, user_num, user_id, info, ip, writeday, data1, data2, data3, data4, data5, data6, data7, data8, num1) values ('$eventnum', $set_date, '$user_id', '$set_time', '$ip', now(), '$data1', '$data2', '$data3', '$data4', '$data5', '$data6', '$data7', '$data8', $num1)";
//		echo $sql_in;
		mysql_query($sql_in);
	}

mysql_close($connect, $connect);
?>
<script>
alert("저장완료");
parent.location.reload();
</script>