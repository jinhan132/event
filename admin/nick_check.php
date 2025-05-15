<?
header("Content-Type:text/html;charset=utf-8");



$uid = $_POST["uid"];
$nick = iconv("utf-8","euc-kr",trim($_POST["nick"]));

if(!$uid || !$nick){
	exit;
}

include "../inc/db_con.inc";


	if(strlen($nick) > 11){
?><script>$("#nick_div").val("no");$("#nick_text").html("길이 제한을 초과하였습니다.");</script><?
exit;
	}

	$sql = "select count(*) from user_basic where nick='$nick'";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);

	if($data[0] > 0){
?><script>$("#nick_div").val("no");$("#nick_text").html("이미 있는 닉네임입니다.");</script><?
exit;
	}

	$day_3ago = date("Y-m-d H:i:s", strtotime("-3 Day"));

	$sql_nick = "select count(*) from nick_backup where nick='$nick' and backup_time >= '$day_3ago'";
	$query_nick = mysql_query($sql_nick, $con);
	$data_nick = mysql_fetch_array($query_nick);
	if($data_nick[0] > 0){
?><script>$("#nick_div").val("no");$("#nick_text").html("일정기간 사용 불가능한 닉네임입니다.");</script><?
exit;		
	}


	$sql_admin = "select count(*) from admin_log_web where gubun='admin_nick' and writeday >='$day_3ago' and data1='$nick'";
	$query_admin = mysql_query($sql_admin, $con);
	$data_admin = mysql_fetch_array($query_admin);
	if($data_admin[0] > 0){
?><script>$("#nick_div").val("no");$("#nick_text").html("일정기간 사용 불가능한 닉네임입니다.");</script><?
exit;	
	}


?>
<script>$("#nick_div").val("yes");$("#nick_text").attr("class","text-success"); $("#nick_text").html("사용 가능한 닉네임입니다.");</script>

