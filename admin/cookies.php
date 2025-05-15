<?
function Decode($sText, $sCode){
	$arrCode = array();
	$arrData = explode(chr(44),$sText);

	$cntData = count($arrData) - 1;
	$cntCode = strlen($sCode)-1;
	
	for($i=0; $i <= $cntCode; $i++){
		$arrCode[$i] = substr($sCode, $i, 1);
	}
	
	$flag = 0;
	$strResult = "";
	
	for ($i=0; $i < $cntData; $i++) {
		$strResult .= chr((intval($arrData[$i]) ^ (ord($arrCode[$flag]))));
		$flag == $cntCode ? $flag = 0 : $flag = $flag + 1;
	}
	
	return $strResult;	
}


function getOriCookie() {
	$tempRemoteAddr = $_SERVER['REMOTE_ADDR'];

	if($tempRemoteAddr == '222.107.33.198' or $tempRemoteAddr == '222.107.33.199')
		$tempRemoteAddr = '222.107.33.198';

	$real_val = explode("|",$_COOKIE['TestC']);
	$tmp_val = $real_val[$i];
	$tmp_val = Decode($real_val[$i],$tempRemoteAddr);
	$tmp_val = urldecode($tmp_val);
	return $real_val;
}

function getTcookies() {
	$tempRemoteAddr = $_SERVER['REMOTE_ADDR'];

	if($tempRemoteAddr == '222.107.33.198' or $tempRemoteAddr == '222.107.33.199')
		$tempRemoteAddr = '222.107.33.198';

	$tmp = getOriCookie();
	$t_tmp = $tmp[count($tmp)-1];
	$t_tmp = Decode($t_tmp,$tempRemoteAddr);
	$t_tmp = urldecode($t_tmp);
	return $t_tmp;
}



	$tempRemoteAddr = $_SERVER['REMOTE_ADDR'];
/*
	if($tempRemoteAddr == "172.16.100.34"){
		$tempRemoteAddr = "1.209.147.114";
	}else if(substr($tempRemoteAddr,0,10) == '172.16.100' || substr($tempRemoteAddr,0,10) == '172.16.101' ){
		$tempRemoteAddr = "222.107.33.198";
	}
*/
if($tempRemoteAddr == '222.107.33.198' or $tempRemoteAddr == '222.107.33.199')
		$tempRemoteAddr = '222.107.33.198';

	$i = 0;
	$real_val = explode("|",$_COOKIE['TestC']);
	$tmp_val = $real_val[$i];
		$tmp_val = Decode($real_val[$i],$tempRemoteAddr);
	$tmp_val = urldecode($tmp_val);


	$cookies_info = explode(",", $tmp_val);

	$s_uid = $cookies_info[0];
	$login_time = $cookies_info[1];

//	echo $s_uid."<br>";
//	echo $login_time;


$TCookies = getTcookies();

	$cookie	= explode("/", $TCookies);
	$s_unum = $cookie[0];


//echo $s_unum;

?>