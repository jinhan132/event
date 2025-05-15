<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$gubun = "notice_delete";

$ukey = $_POST["ukey"];



if(!$ukey){
	exit;
}

	include "../inc/db_con.inc";

	$ip = $_SERVER['REMOTE_ADDR'];
	

	$pay_reason = "관리자 공지 삭제";
	//$pay_reason = iconv("euc-kr","utf-8",$pay_reason);

	$sql = "delete from notice where ukey=$ukey";
	$query = mysql_query($sql, $con);
	if($query){

		
		$uid = $s_unum;
		

		$sql_adminlog = "insert into admin_log_web(gubun, uid,  admin_id, ip, writeday, data1, txt1) values ('$gubun', $uid, '$s_uid', '$ip', now(), '$ukey', '$pay_reason')";
		$query_adminlog = mysql_query($sql_adminlog, $con);
	}

mysql_close($con);
?>
