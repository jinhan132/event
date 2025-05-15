<?
	error_reporting(0); 

	$db_server='10.10.10.197';
	$db_userid='admin';
	$db_userpasswd='TY_web_202#';
	
	$db_name='deadlive';


	$con = mysql_connect($db_server, $db_userid, $db_userpasswd) or die( "not MySQL Server");
	mysql_select_db($db_name, $con);

?>