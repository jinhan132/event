<?
header("Content-Type:text/html;charset=utf-8"); 

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	 if( mb_substr(iconv("euc-kr","utf-8",$s_uid), 0 , 3, 'utf-8') != "운영자" ){
		exit;
	}


	function userDir2($unum, $ccode) {
		$incnum = 1000;
		if($ccode == 2){
			$user_info_path = "//images.eweiqi.com/wuser/";
		}else{
			$user_info_path = "//service.tygem.com/wuser/";
		}
		// depth1 디렉토리
		$dir1 = $user_info_path . (int)( ($unum/$incnum) / $incnum ) . "/";

		// depth2 디렉토리
		$dir2 = $dir1 . (int)( ($unum/$incnum) % $incnum ) . "/";

		// depth3 디렉토리
		$dir3 = $dir2 . (int)( $unum%$incnum );

		return $dir3;
	}

$rank_view = array("1단","2단","3단","4단","5단","6단","7단","8단","9단");


$gubun = "timematch";

$yoil = array("일","월","화","수","목","금","토");
$view_time = array("00:00","11:00","15:00","17:00","21:00");




include "/home/www/inc/db_connect_11.inc";
mysql_query("set names 'utf8'");


$set_date = $_POST["set_date"];

echo "<b>[ ".date("Y-m-d", $set_date)." ] (".$yoil[date('w', $set_date)].")</b>";

?>

<? for($i=1; $i<=4; $i++){?>
<br><br><input type="button" value="<?=$view_time[$i]?>" style="color:red; width:80px;height:22px;"> 
<br>

<table>
	<tr>
<?
	//$sql = "select * from event_data where gubun='$gubun' and kind='$set_date' and mvalue1=$i";

	$sql = "select * from tygem_eventlist_utf8 where eventnum='$gubun' and num1=$set_date and info='$i' order by data5,seq";
	$query = mysql_query($sql, $connect);
	while($data = mysql_fetch_array($query)){
		$seq = $data["seq"];
		$user_num = $data["user_num"];
		$data3 = $data["data3"];
		$data4 = $data["data4"];

		$data2 = $data["data2"];
		$country_code = $data2;

		$user_id = $data["user_id"];



$data5 = $data["data5"];
if($data5 == ""){
	$data5 = $seq;
}


		$ava_exp	= explode(".", $data4);
			if(strlen($ava_exp[0]) < 7){
				if($ava_exp[0] == "Mouse" || $ava_exp[0] == "Cow" || $ava_exp[0] == "Tiger" || $ava_exp[0] == "Rabbit" || $ava_exp[0] == "Dragon" || $ava_exp[0] == "Snake" || $ava_exp[0] == "Horse" || $ava_exp[0] == "Sheep" || $ava_exp[0] == "Monkey" || $ava_exp[0] == "Rooster" || $ava_exp[0] == "Dog" || $ava_exp[0] == "Pig" ){
					$ava_path = "//service.tygem.com/member/img/".$data4;
				}else{
					$ava_path = "//service.tygem.com/avataimg/".$data4;
				}
			
			}else{
				$u_udir	= userDir2($user_num,$country_code);
				$ava_path	= "$u_udir/photo/thumbs/$data4";
			}
?>
		<td width="130"><?=$user_id?> <?=$rank_view[$data3-27]?>(<?=$data["data1"]?>)<br><div id="D<?=$data5?>" ><img src='<?=$ava_path?>' width='118' height='89'  id="<?=$data5?>"></div></td>
<?		
		
		//echo $data["user_id"]."(".$data["data1"].") <br><img src='$ava_path' width='118' height='89' >";
	}
?>
	</tr>
</table>
<?}?>