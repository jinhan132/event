<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}


include "/home/www/inc/db_connect.inc";
mysql_query("set names 'utf8'");



	$change1 = $_POST["change1"];
	$change2 = $_POST["change2"];
	
	$gubun = "timematch";
	
	$set_date = $_POST["set_date"];
	$set_time = $_POST["set_time"];

	$sql = "select * from tygem_eventlist_utf8 where eventnum='$gubun' and num1=$set_date and info='$set_time' order by data5, seq";

	$query = mysql_query($sql, $connect);

	while($data = mysql_fetch_array($query)){
		$seq = $data["seq"];
		$data5 = $data["data5"];

if($data5 == ""){
	$data5 = $seq;
}

		if($data5 == $change1){
			$sql_up = "update tygem_eventlist_utf8 set data5='$change2' where seq=$seq";
		}else if($data5 == $change2){
			$sql_up = "update tygem_eventlist_utf8 set data5='$change1' where seq=$seq";
		}else{
			$sql_up = "update tygem_eventlist_utf8 set data5='$data5' where seq=$seq";
		}

			$query_up = mysql_query($sql_up, $connect);

	}

	

	mysql_close($connect);
?>