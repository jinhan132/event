<?
header("Content-Type:text/html;charset=utf-8");

	include "../inc/db_con.inc";

	$nday	= 1;
	if ($year == "") {
		$year = date("Y");
		$mon = date("m");
	}
	else {
		if ($mon >= 13) {
			$year = $year + 1;
			$mon = 1;
		}
		else if ($mon <= 0) {
			$year = $year - 1;
			$mon = 12;
		}
		else {
			$year = $year;
			$mon = $mon;
		}
	}

	if ($mon < 10 && strlen($mon) > 1) {
		$mon = substr($mon, 1, 1);
	}

	strlen($mon) < 2 ? $mon_1	= "0".$mon : $mon_1	= $mon;

	$checkmon	= "$year-$mon_1";

	$mon_back = $mon - 1;
	$mon_next = $mon + 1;

	$tolday	=  0;

	$k=1;
	while (checkdate($mon, $k, $year)==1) {
		$tolday=$k;
		$k=$k+1;
	}

	$ta		= mktime(0,0,0,$mon, $nday, $year);
	$firday	= date(w,$ta);

	if (checkdate($mon, $nday, $year) != 0) {
			$x=(($tolday+$firday)/7);
			$ju=ceil($x);
	}

	
	$yy	= date("Y");
	$mm	= date("m");
	$dd	= date("d");	


	$size_date = "'".$year."-".$mon_1."-%'";

	$sql = "select date_format(user_basic.reg_time, '%Y-%m-%d') as reg_time, count(quiz_user.uid) from user_basic, quiz_user where user_basic.uid=quiz_user.uid and quiz_user.grade > 0 group by date_format(user_basic.reg_time, '%Y-%m-%d')";

	$query = mysql_query($sql, $con);
	$reg_member = 0;
	while($data = mysql_fetch_array($query)){
		$reg_time = $data[0];
		$reg_member += $data[1];
		
		$reg_day[$reg_time] = $data[1];
		$reg_total[$reg_time] = $reg_member;
		
	}

?>
<script language='JavaScript'>
	<!--
		function changeCal() {
			document.calForm.year.value = document.calForm.yy.value;
			document.calForm.mon.value = document.calForm.mm.value;
			document.calForm.action = "<?=$PHP_SELF?>";
			document.calForm.submit();
		}
		
		function sendCal(str) {
			document.calForm.year.value = <?=$year?>;
			if (str == "b") {
			document.calForm.mon.value = <?=$mon_back?>;
			}
			else {
			document.calForm.mon.value = <?=$mon_next?>;
			}
			document.calForm.action = "idct_total.html";
			document.calForm.submit();
		}
	//-->
	</script>
<form name='calForm' method='post' action=''>
	<input type='hidden' name='year'>
	<input type='hidden' name='mon' value="<?=$mon?>">
	<input type='hidden' name='mode' value='<?=$mode?>'>
	<input type="hidden" name="site_name" value="<?=$site_name?>">
</form>
<div class="cal_top">
                <a href="#" id="movePrevMonth" onClick="sendCal('b')"><span id="prevMonth" class="cal_tit">&lt;</span></a>
                <span id="cal_top_year" class="ico_record1"><?=$year?></span>
                <span id="cal_top_month"><?=$mon_1?></span>
                <a href="#" id="moveNextMonth" onClick="sendCal('n')"><span id="nextMonth" class="cal_tit">&gt;</span></a>
            </div>

<table class="calendar"><tbody><tr><th>일</th><th>월</th><th>화</th><th>수</th><th>목</th><th>금</th><th>토</th></tr>
<?

	for ($i=1; $i<=$ju; $i++) {
	echo"<tr height='100'>";
		for ($j=0; $j<=6; $j++) {
			echo"<td style='text-overflow:ellipsis;overflow:hidden;white-space:nowrap'>";
			if ($i==1 and $j<$firday) {
				echo"&nbsp;";
			}
			else {
				if ($nday <= $tolday) {
					if ($nday < 10 && strlen($nday) < 2) {
						$nday1 = "0".$nday;
					}
					else {
						$nday1 = $nday;
					}
					$t_day	= $year."-".$mon_1."-".$nday1;

				 // 오늘 날짜 처리
				 if (($year==$yy) && ($mon==$mm) && ($nday==$dd)) {
				    $ex="<b>$nday</b>";
				 }
				 else {
					$ex=$nday;
				 }

					if ($j==0) {
						echo"<div class='cal-day' style='color: rgb(231, 29, 55);'>$ex</div>";
					}
					else if ($j==6) {
						
							echo"<div class='cal-day' style='color: rgb(25, 160, 204);'>$ex</div>";
						
					}
					else {
							echo "<div class='cal-day'>$ex</div>";

					}

if($reg_day[$t_day] > 0){
					echo "<br><b>".$reg_total[$t_day]."</b> (".$reg_day[$t_day].")";
}
			}
				else {
					echo"&nbsp;";
				}
			$nday++;
			}
			echo"</td>";
		}
	echo"</tr>";
	}

?>	
</table>
<br><br><br><br>