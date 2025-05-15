<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

	$gubun = "admin_post";
	$ip = $_SERVER['REMOTE_ADDR'];

	$i_expire = $_POST["i_expire"];
	$i_expire_hour = $_POST["i_expire_hour"];
	$i_expire_min = $_POST["i_expire_min"];
	
	$i_expire = $i_expire." ".$i_expire_hour.":".$i_expire_min.":00";
	
	//$form_msg = iconv("euc-kr","utf-8",$_POST["form_msg"]);
	$form_msg = $_POST["form_msg"];

	$user_uid = $_POST["user_uid"];

	$i_cnt = $_POST["i_cnt"];
	//$info = iconv("euc-kr","utf-8",$_POST["info"]);
	$info = $_POST["info"];

	include "../inc/db_con.inc";

	$users_var = explode(",", $user_uid);
	for($i=0; $i<sizeof($users_var); $i++){
		$uid = $users_var[$i];
		$sql = "insert into postbox(uid, sender, ptype, i_code, i_cnt, i_recv, i_expire, m_create, m_read, msg) values ($uid, 0, 0, 101, $i_cnt, 0, '$i_expire', now(), 0, '$form_msg')";
		mysql_query($sql, $con);
	}
	
	$sql = "select nick from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);
	$nick = $data["nick"];


	$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, answer, info, ip, writeday, data1, txt1) values ('$gubun', $uid, '$nick', '$s_uid', '$form_msg', '$info', '$ip', now(), '$i_cnt', '$user_uid')";
	$query_adminlog = mysql_query($sql_adminlog, $con);


mysql_close($con);
	

?><script>
	alert("발송 완료");
	parent.post_list();
</script>