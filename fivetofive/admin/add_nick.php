<?
header("Content-Type:text/html;charset=utf-8");


	$userno = $_POST["userno"];
	$usernick = trim($_POST["usernick"]);

	include "/home/www/inc/db_con_baduklevel.php";
	mysql_query("set names 'utf8'");

	$sql = "select * from baduk_people_dictionary_2022 where user_nick='$usernick' limit 1";
	$query = mysql_query($sql, $db_con_baduklevel);
	$data = mysql_fetch_array($query);

	$user_num = $data["user_num"];
	$country_code = $data["country_code"];
	$ch = $data["ch"];

	$user_nick = $data["user_nick"];
	$ko = $data["ko"];


//echo $user_nick;

	include "/home/www/inc/db_con2.inc";

	$sql_user = "select user.my_photo, user.rank_num, user_info.country_code from user, user_info where user.user_id=user_info.user_id and user.user_num=$user_num";
	$query_user = mysql_query($sql_user, $con2);
	$data_user = mysql_fetch_array($query_user);

	$rank_num = $data_user[1];
	$my_photo = $data_user[0];

	$country_code = $data_user[2];

	mysql_close($con2);


//echo " ".$rank_num;

?>
<script>
	$("#cuser_nick<?=$userno?>").val("<?=$usernick?>");
	$("#cuser_id<?=$userno?>").val("<?=$ko?>");
	$("#cuser_rank<?=$userno?>").val("<?=$rank_num?>");
</script>