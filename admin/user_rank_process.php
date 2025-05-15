<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

$user_grade = array("","30급","29급","28급","27급","26급","25급","24급","23급","22급","21급","20급","19급","18급","17급","16급","15급","14급","13급","12급","11급","10급","9급","8급","7급","6급","5급","4급","3급","2급","1급","1단","2단","3단","4단","5단","6단","7단","8단","9단");

$uid = $_POST["uid"];
$grade = $_POST["grade"];


$gubun = "admin_rank";
$ip = $_SERVER['REMOTE_ADDR'];

include "../inc/db_con.inc";

	$sql = "select nick from user_basic where uid=$uid";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);
	$nick = $data["nick"];

	$sql_sel = "select * from quiz_user where uid=$uid";
	$query_sel = mysql_query($sql_sel, $con);
	$data_sel = mysql_fetch_array($query_sel);

	$old_grade = $data_sel["grade"];
	$data1 = $old_grade;
	
	$sql = "update quiz_user set grade = '$grade' where uid=$uid";
	$query = mysql_query($sql, $con);


//	$data2 = iconv("euc-kr","utf-8",$user_grade[$grade]);
	$data2 = $user_grade[$grade];
	

	$sql_adminlog = "insert into admin_log_web(gubun, uid, nick, admin_id, ip, writeday, data1, data2) values ('$gubun', $uid, '$nick', '$s_uid', '$ip', now(), '$data1', '$data2')";
	$query_adminlog = mysql_query($sql_adminlog, $con);

mysql_close($con);	

if($query){
?>
<script>alert("변경완료 되었습니다."); find_user()</script>
<?}?>