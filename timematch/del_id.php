<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";

	$gubun = "timematch";

	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}

	$seq = $_POST["seq"];

	if($seq > 0){
		include "/home/www/inc/db_connect.inc";


			$sql_sel = "select * from tygem_eventlist_utf8 where eventnum='$gubun' and seq=$seq";
			$query_sel = mysql_query($sql_sel, $connect);
			$data_sel = mysql_fetch_array($query_sel);

		
			$data6 = $data_sel["data6"];
			$num1 = $data_sel["num1"];
			$user_num = $data_sel["user_num"];


			$sql = "delete from tygem_eventlist_utf8 where eventnum='$gubun' and seq=$seq";
			$query = mysql_query($sql, $connect);

			$sql_up = "update tygem_eventlist_utf8 set data6 = data6 - 1 where eventnum='$gubun' and user_num=$user_num and num1=$num1 and data6 > $data6";
			$query_up = mysql_query($sql_up, $connect);

		if($query){
			echo "delete_ok";
		}
	}

mysql_close($connect);

?>
