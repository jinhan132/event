<?
header("Content-Type:text/html;charset=utf-8");

	$gubun = "timematch";
	
	$set_date = $_POST["set_date"];
	$kind = $set_date;
	$set_time = $_POST["set_time"];

	$userid = rawurldecode(trim($_POST["userid"]));

	$uid = iconv("utf-8","euc-kr",$userid);

	include "/home/www/inc/db_con_baduklevel.php";
	mysql_query("set names 'utf8'");

	$sql = "select * from baduk_people_dictionary_2022 where ko='$userid' limit 1";
	$query = mysql_query($sql, $db_con_baduklevel);
	$data = mysql_fetch_array($query);

	$user_num = $data["user_num"];
	$country_code = $data["country_code"];
	$ch = $data["ch"];



	include "/home/www/inc/db_con2.inc";

	$sql_user = "select user.my_photo, user.rank_num, user_info.country_code from user, user_info where user.user_id=user_info.user_id and user.user_num=$user_num";
	$query_user = mysql_query($sql_user, $con2);
	$data_user = mysql_fetch_array($query_user);

	$rank_num = $data_user[1];
	$my_photo = $data_user[0];

	$country_code = $data_user[2];

	mysql_close($con2);



	if($user_num > 0){
	
			include "/home/www/inc/db_connect.inc";
			mysql_query("set names 'utf8'");
			

//			$sql = "insert into event_data(gubun, kind, user_num, user_id, mvalue1, mvalue2, writeday, event_id) values ('$gubun', '$kind', $user_num, '$userid', $set_time, $country_code, now(), '$ch')";


/*
	num1 : 날짜정보 timestamp
	info : 회차(11:00 , )
	data1 : 중국명
	data2 : country_code
	data3 : rank_num
	data4 : avata
*/

			$ip = $_SERVER["REMOTE_ADDR"];

			$sql_sel = "select ifnull(count(*),0) from tygem_eventlist_utf8 where eventnum='$gubun' and num1=$set_date and user_num=$user_num";
			$query_sel = mysql_query($sql_sel, $connect);
			$data_sel = mysql_fetch_array($query_sel);

			$rsv_no = $data_sel[0];
			$rsv_no++;

			$sql = "insert into tygem_eventlist_utf8(eventnum, user_num, user_id, info,ip, data1, data2, data3, data4, num1, writeday, data6) values ('$gubun', $user_num, '$userid', '$set_time', '$ip', '$ch', '$country_code', '$rank_num', '$my_photo', $set_date, now(), $rsv_no)";

//echo $sql;

			$query = mysql_query($sql, $connect);

			if($query){
?><script>window.location.reload()</script><?
			}

			mysql_close($connect);
	}else{
		echo "no";
	}

	mysql_close($db_con_baduklevel);
?>