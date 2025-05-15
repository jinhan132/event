<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$uid = $_POST["uid"];
$key_type = $_POST["key_type"];
$key_cnt = $_POST["key_cnt"];
//$pay_reason = iconv("euc-kr","utf-8",$_POST["pay_reason"]);
$pay_reason = $_POST["pay_reason"];

if(!$uid || !$key_type || !$key_cnt || !$pay_reason){
	exit;
}



	include "../inc/db_con.inc";

	$sql = "select nick from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);
	$nick = $data["nick"];

	$ip = $_SERVER['REMOTE_ADDR'];


	if($key_type == "plus"){
		$key_txt = "지급";
		$data1 = $key_cnt;
		$sql = "update quiz_user set do_cnt = do_cnt + $key_cnt  where uid=$uid limit 1";
		$ktype = 8;
		$p_data = $key_cnt;
	}else if($key_type == "minus"){
		$key_txt = "소진";
		$data1 = "-".$key_cnt;
		$sql = "update quiz_user set do_cnt = do_cnt - $key_cnt  where uid=$uid limit 1";
		$ktype = 9;
		$m_data = $key_cnt;
	}

	$query = mysql_query($sql, $con);
	if(!$query){
?><script>alert("지급/소진 실패");</script><?
		exit;
	}

	$gubun = "admin_key";

	$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$pay_reason')";
	$query_adminlog = mysql_query($sql_adminlog, $con);
if(!$query_adminlog){
?><script>alert("관리자 지급/소진 LOG 저장 실패");</script><?
		exit;
	}

	$sql_sel = "select do_cnt from quiz_user where uid=$uid limit 1";
	$query_sel = mysql_query($sql_sel, $con);
	$data_sel = mysql_fetch_array($query_sel);

	$kcnt = $data_sel["do_cnt"];

	$info = "운영자 ". $key_cnt."개 ".$key_txt;
//	$info = iconv("euc-kr","utf-8",$info);


	if($key_type == "plus"){
		$sql_log = "insert into key_history(uid, ktype, p_data, kcnt, info, reg_date) values ($uid, $ktype, $p_data, $kcnt, '$info', now())";
	}else if($key_type == "minus"){
		$sql_log = "insert into key_history(uid, ktype, m_data, kcnt, info, reg_date) values ($uid, $ktype, $m_data, $kcnt, '$info', now())";
	}	
	$query_log = mysql_query($sql_log, $con);
if(!$query_log){
?><script>alert("key 지급/소진 LOG 저장 실패 <?=$sql_log?>");</script><?
		exit;
	}



mysql_close($con);
?>
<script>alert("<?=$key_txt?>완료 되었습니다."); find_user()</script>