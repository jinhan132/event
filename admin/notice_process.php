<?
header("Content-Type:text/html;charset=utf-8");

include "cookies.php";

	$gubun = "admin_notice";
	$ip = $_SERVER['REMOTE_ADDR'];

	$lang = $_POST["lang"];
	
	
	//$msg = iconv("euc-kr","utf-8",$_POST["form_msg"]);

	$msg = addslashes($_POST["form_msg"]);


	include "../inc/db_con.inc";


	$sql = "insert into notice(uid, ctime, lang, msg ) values ($s_unum, now(), $lang, '$msg')";
	$query = mysql_query($sql, $con);



mysql_close($con);
	

?>