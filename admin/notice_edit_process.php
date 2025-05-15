<?
header("Content-Type:text/html;charset=utf-8");

	include "../inc/db_con.inc";


	$ukey = $_POST["ukey"];
	$msg = $_POST["msg"];


if($ukey && $msg){
	$sql = "update notice set msg='$msg' where ukey=$ukey limit 1";
	$query = mysql_query($sql, $con);
}
?>