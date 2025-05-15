<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$gubun = "post_delete";

$uid = $_POST["uid"];
$seq = $_POST["seq"];


if(!$seq){
	exit;
}

	include "../inc/db_con.inc";

	$sql = "select nick from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);
	$nick = $data["nick"];

	$ip = $_SERVER['REMOTE_ADDR'];
	
	$data1 = $seq;
	$pay_reason = "관리자 우편함 삭제";
	$pay_reason = iconv("euc-kr","utf-8",$pay_reason);

	$sql = "update postbox set b_del=2 where ukey=$seq";
	$query = mysql_query($sql, $con);
	if($query){
		$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$pay_reason')";
		$query_adminlog = mysql_query($sql_adminlog, $con);
	}

mysql_close($con);
?>
<script>alert("삭제 처리 되었습니다."); user_post_info()</script>