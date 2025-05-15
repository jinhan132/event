<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$uid = $_POST["uid"];
$leave_info = iconv("euc-kr","utf-8",trim($_POST["leave_info"]));
$leave_info = $_POST["leave_info"];

$gubun = "admin_leave";
$ip = $_SERVER['REMOTE_ADDR'];


if(!$uid || !$leave_info){
	exit;
}

include "../inc/db_con.inc";


	$sql_sel = "select * from user_basic where uid=$uid";
	$query_sel = mysql_query($sql_sel, $con);
	$data_sel = mysql_fetch_array($query_sel);

	$nick = $data_sel["nick"];
	$uid = $data_sel["uid"];
	$data1 = $data_sel["ukey"];
	$data2 = $data_sel["s_code"];

	$sql_sns = "select * from sns_user where uid=$uid";
	$query_sns = mysql_query($sql_sns);
	$data_sns = mysql_fetch_array($query_sns);
	if($data_sns[idx] > 0){
		$data3 = $data_sns["snsid"];
		
		$sns_del = "delete from sns_user where uid=$uid";
		$query_del = mysql_query($sns_del, $con);
	}

	
	$sql = "delete from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);

	$sql = "delete from user_member where uid=$uid";
	$query = mysql_query($sql, $con);

	$sql = "delete from quiz_user where uid=$uid";
	$query = mysql_query($sql, $con);

	$sql = "delete from quiz_favorites where uid=$uid";
	$query = mysql_query($sql, $con);


	$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, data2, data3, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$data2', '$data3', '$leave_info')";
	$query_adminlog = mysql_query($sql_adminlog, $con);

mysql_close($con);
?>OK