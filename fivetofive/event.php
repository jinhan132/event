<?
	include "/home/www/inc/define.h";
	include "$docPath/inc/session.inc";

	$eventnum = "fivetofive2024_bet";

if($_POST["round"]){
	$set_round = $_POST["round"];
}
if($_POST["game"]){
	$set_game = $_POST["game"];
}





if($set_game == ""){

if( date("Y-m-d") < "2024-04-23"){
	$set_game = 1;
	$event_week_date = "2024-04-01";
} else if(date("Y-m-d") >= "2024-04-23" && date("Y-m-d") <= "2024-04-29"){
	$set_game = 2;
	$event_week_date = "2024-04-23";
} else if(date("Y-m-d") >= "2024-04-30" && date("Y-m-d") <= "2024-05-06"){
	$set_game = 3;
	$event_week_date = "2024-04-30";
} else if(date("Y-m-d") >= "2024-05-07"){
	$set_game = 4;
	$event_week_date = "2024-05-07";
}


}

include "./db/member.inc";
include "./db/member2.inc";
@include "./db/game_".$set_round."_".$set_game.".inc";

$game_date_var = explode("-",$game_date);

function rep_rankNum($rank_num) {
	if($rank_num == "35")        $rk_level = "9단";
	elseif($rank_num == "34")    $rk_level = "8단";
	elseif($rank_num == "33")    $rk_level = "7단";
	elseif($rank_num == "32")    $rk_level = "6단";
	elseif($rank_num == "31")    $rk_level = "5단";
	elseif($rank_num == "30")    $rk_level = "4단";
	elseif($rank_num == "29")    $rk_level = "3단";
	elseif($rank_num == "28")    $rk_level = "2단";
	elseif($rank_num == "27")    $rk_level = "1단";

return $rk_level;
}



if($s_uid != ""){
		include "/home/www/inc/db_connect.inc";
		
		$sql = "select * from tygem_eventlist where eventnum='$eventnum' and user_num=$s_unum and data2='$set_round' and data3 ='$set_game'";

		$query = mysql_query($sql, $connect);
		$data = mysql_fetch_array($query);

		$myselect = $data["data1"];
}


$event_end = $game_date." 21:00:00";

?>	

<form name="thisform" method="post" action="bigmatch01_process.html" target="hiddenFrame">
<input type="hidden" name="set_round" value="<?=$set_round?>">
<input type="hidden" name="set_game" value="<?=$set_game?>">
<input type="text" id="myselect" name="myselect" value="">
</form>
<iframe name="hiddenFrame" style="display:none" title="hiddenFrame"></iframe>
<script>
	function select_user(player, play_step){

<? if(date("Y-m-d H:i:s") > $event_end){ ?>			
			alert("이벤트가 종료되었습니다.");
			return;
<?}?>

<?if($s_uid == ""){?>
		document.location.href = "https://www.tygem.com/login.php?gotourl="+ document.location.href 
		return;
<?}?>
		
			$("#player1_"+play_step).attr("class", "match_player");
			$("#player2_"+play_step).attr("class", "match_player");
		
			if($("#player"+player+"_"+play_step).hasClass("player_select")){
				$("#player"+player+"_"+play_step).attr("class","match_player");
			}else{
				$("#player"+player+"_"+play_step).attr("class","match_player  player_select");
			}
		
		if($("#player1_0").hasClass("player_select")){myselect = "A";}else if($("#player2_0").hasClass("player_select")){myselect = "B";}else{myselect="";}
		if($("#player1_1").hasClass("player_select")){myselect = myselect+"A";}else if($("#player2_1").hasClass("player_select")){myselect = myselect+"B";}
		if($("#player1_2").hasClass("player_select")){myselect = myselect+"A";}else if($("#player2_2").hasClass("player_select")){myselect = myselect+"B";}
		if($("#player1_3").hasClass("player_select")){myselect = myselect+"A";}else if($("#player2_3").hasClass("player_select")){myselect = myselect+"B";}
		if($("#player1_4").hasClass("player_select")){myselect = myselect+"A";}else if($("#player2_4").hasClass("player_select")){myselect = myselect+"B";}
		if($("#player1_5").hasClass("player_select")){myselect = myselect+"A";}else if($("#player2_5").hasClass("player_select")){myselect = myselect+"B";}


		$("#myselect").val(myselect);

		if(myselect.length == 6){
			$("#event_btn").html("<button  class='btn_bet' onclick=\"javascript:if(confirm('제출하시겠습니까?\\n(※제출 후에는 수정할 수 없습니다.)')){document.thisform.submit()}\"><span>승부예측 제출하기</span></button>");
		}else{
			$("#event_btn").html("<button class='btn_bet' onclick=\"javascript:alert('승리 예측팀/선수를 선택해 주시기 바랍니다.');\"><span>승부예측 제출하기</span></button>");
		}
	}
</script>



			<div class="bigm_con">
                <div class="bet_tab">
                    <button type="button" class="tab_day<? if($set_game==1){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 1)">4월 22일<br /><span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==2){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 2)">4월 29일<br /><span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==3){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 3)">5월 6일<br /><span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==4){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 4)">5월 20일<br /><span>월요일</span></button>
                </div>
                <div class="bet_top">
                    <p class="bet_title">한&#183;중 5&#58;5 빅매치 <span><?=$set_game?>라운드</span></p>
                    <p class="bet_date"><?=intval($game_date_var[1])?>월 <?=intval($game_date_var[2])?>일(월) 오후 9시</p>
                    <div class="bet_notice">
                        <p class="img_logo_team01"></p>
                        <p class="img_logo_team02"></p>
                        <p class="txt_notice"><span>아래에서 승리 예측팀/선수를 선택해주세요.</span></p>
                        <!-- 대진표 없을 때
                        <p class="txt_notice" style="display:none"><span>대진표 준비중입니다.</span></p>
                        -->
                    </div>
                </div>
                <div class="bet_matcharea">
                    <div class="match_list">
                        <div class="match_team_left">
                            <div class="match_player<? if(substr($myselect, 0,1) == 'A'){echo ' player_select';}?>" onclick="javascript:select_user(1,0)" id="player1_0">
                                <span class="player_mtscore">적중점수 50점</span>
                                <span class="player_name">상록수 연구실</span>
                            </div>
<? if($winA == "A"){?><p class="match_result img_win"><span>승리</span></p>
<?}else if($winB == "B"){?><p class="match_result img_lose"><span>패배</span></p>
<?}?>
                        </div>
                        <div class="match_team_right">
                            <div class="match_player<? if(substr($myselect, 0,1) == 'B'){echo ' player_select';}?>" onclick="javascript:select_user(2,0)" id="player2_0">
                                <span class="player_name">멍타이링 도장</span>
                                <span class="player_mtscore">적중점수 50점</span>
                            </div>
<? if($winB == "B"){?><p class="match_result img_win"><span>승리</span></p>
<?}else if($winA == "A"){?><p class="match_result img_lose"><span>패배</span></p>
<?}?>
                        </div>
                        <p class="match_line"></p>
                        <p class="match_team_vs">vs</p>
                    </div>
<? 
if($name_1_1 != ""){


	for($i=1; $i<=5; $i++){ 
		$player_1 = "name_1_".$i;
		$player_2 = "name_2_".$i;
		$img_1 = "img_1_".$i;
		$img_2 = "img_2_".$i;

		$winA = "winA_1_".$i;
		$winB = "winB_2_".$i;
		$pointA = "pointA_1_".$i;
		$pointB = "pointB_2_".$i;
		
		$checkword = substr($myselect, $i,1);		
?>
					<div class="match_list">
                        <div class="match_team_left">
                            <div class="match_player<? if($checkword=='A'){echo ' player_select';}?>" onclick="javascript:select_user(1,<?=$i?>)" id="player1_<?=$i?>">
                                <span class="player_mtscore"><?=$$pointA?>점</span>
                                <span class="player_name"><?=$$player_1?></span>
                                <span class="player_img"><img src="//img.tygem.com/images/event/20240403/img/<?=$$img_1?>"></span>
                            </div>
<? if($$winA == "A"){?><p class="match_result img_win"><span>승리</span></p>
<?}else if($$winB == "B"){?><p class="match_result img_lose"><span>패배</span></p>
<?}?>
                        </div>
                        <div class="match_team_right">
                            <div class="match_player<? if($checkword=='B'){echo ' player_select';}?>" onclick="javascript:select_user(2,<?=$i?>)" id="player2_<?=$i?>">
                                <span class="player_img"><img src="//img.tygem.com/images/event/20240403/img/<?=$$img_2?>"></span>
                                <span class="player_name"><?=$$player_2?></span>
                                <span class="player_mtscore"><?=$$pointB?>점</span>
                            </div>
<? if($$winB == "B"){?><p class="match_result img_win"><span>승리</span></p>
<?}else if($$winA == "A"){?><p class="match_result img_lose"><span>패배</span></p>
<?}?>
                        </div>
                        <p class="match_line"></p>
                        <p class="match_team_vs">vs</p>
                    </div>
<?}?>

<? 
	$game_date = $game_date." 20:00:00";
if($game_date >= date("Y-m-d H:i:s") ){

?>
                    <div id="event_btn"><button type="button" class="btn_bet" id="btn_bet" onclick="javascript:alert('승리 예측팀/선수를 선택해 주시기 바랍니다.');"><span>승부예측 제출하기</span></button></div>
<?}else{?>
					<button type="button" class="btn_bet state_close"><span>승부예측 마감</span></button>
<?}?>
					<!-- 미제출 시 
                    <button type="button" class="btn_bet state_close"><span>승부예측 마감</span></button> -->
                    <!-- 제출 완료 시 
                    <button type="button" class="btn_bet state_ok"><span>승부예측 완료</span></button> -->
                </div>
            </div>

<?}?>

<? if($myselect!=""){?>
<script>
	$("#event_btn").html("<button type='button' class='btn_bet state_ok' onclick=''><span>승부예측 완료</span></button>");
</script>
<?}?>