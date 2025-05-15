<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$uid = $_POST["uid"];
$nick = iconv("utf-8","euc-kr",trim($_POST["nick"]));
$nick = $_POST["nick"];

$gubun = "admin_nick";
$ip = $_SERVER['REMOTE_ADDR'];


if(!$uid || !$nick){
	exit;
}

include "../inc/db_con.inc";


	$sql_sel = "select * from user_basic where uid=$uid";
	$query_sel = mysql_query($sql_sel, $con);
	$data_sel = mysql_fetch_array($query_sel);

	$old_nick = $data_sel["nick"];
	$data1 = $old_nick;

	$sql = "update user_basic set nick = '$nick' where uid=$uid";
	$query = mysql_query($sql, $con);

	$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$pay_reason')";
	$query_adminlog = mysql_query($sql_adminlog, $con);
	
	$sql_back = "insert into nick_backup(nick, uid, backup_time) values ('$data1', $uid, now())";
	$query_back = mysql_query($sql_back, $con);

mysql_close($con);

if($query){
?>
<script>alert("변경완료 되었습니다.");$("#uinfo option:eq(1)").prop("selected", true);$("#find_txt").val("<?=$uid?>"); find_user()</script>
<?}else{?>
<script>alert("닉네임 변경 실패!!!");</script>
<?}?>