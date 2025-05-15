<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$gubun = "pay_cancel";

$uid = $_POST["uid"];
$order_id = $_POST["order_id"];


if(!$order_id){
	exit;
}

	include "../inc/db_con.inc";

	$sql = "select nick from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);
	$nick = $data["nick"];

	$ip = $_SERVER['REMOTE_ADDR'];

	$data1 = $order_id;
	$pay_reason = "관리자 환불로 취소";
	$pay_reason = iconv("utf-8","euc-kr",$pay_reason);

	$sql = "update mob_paylog set state='cancel' where order_id='$order_id'";
	$query = mysql_query($sql, $con);
	if($query){
		$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$pay_reason')";
		$query_adminlog = mysql_query($sql_adminlog, $con);
	}


mysql_close($con);
?>
<script>alert("환불 처리 되었습니다."); user_pay()</script>