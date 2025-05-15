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


	$eventnum = "timematch_bethistory";

	include "/home/www/inc/db_connect.inc";
	mysql_query("set names 'utf8'");



	$sql = "delete from tygem_eventlist where eventnum='$eventnum' and seq=$seq";
	$query = mysql_query($sql, $connect);

	mysql_close($connect);
?>