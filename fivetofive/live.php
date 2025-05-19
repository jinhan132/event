<?

include "inc_round.php";

if($_POST["round"]){
	$set_round = $_POST["round"];
}
if($_POST["game"]){
	$set_game = $_POST["game"];
}
if($set_game == ""){
	$set_game = 1;
}


if($set_game == 1){
	$step1_point = "100";
	$step2_point = "50";
	$step3_point = "50";
	$step4_point = "20";
	
	$step3_money = 1000000;
	$step3_txt = "100만 PT 이상<br />5억 PT 미만";


}else{
	$step1_point = "200";
	$step2_point = "100";
	$step3_point = "40";
	$step4_point = "20";
	
	$step3_money = 10000000;
	$step3_txt = "1,000만PT이상<br />5억 PT 미만";
}


include "./db/game_".$set_round."_".$set_game.".inc";

	$set_date = $game_date;

	$set_date_var = explode("-",$set_date);
	$betgame_kind = "betgame".$set_date_var[0].$set_date_var[1].$set_date_var[2];
	$game_time_start = $set_date." 00:00:00";
	$game_time_end = $set_date." 23:59:59";


	$data_cnt1 = 0;
	$data_cnt2 = 0;
	$data_cnt3 = 0;
	$data_cnt4 = 0;
	$data_cnt5 = 0;

	$data_total = 0;

for($i=1; $i<=5;$i++){

	$nick1 = "nick_1_".$i;
	$nick2 = "nick_2_".$i;

	if($$nick1 != ""){
		$nick1 = $$nick1;
		if($select_id!=""){
			$select_id.=",'$nick1'";
		}else{
			$select_id.="'$nick1'";
		}
	}
	if($$nick2 != ""){
		$nick2 = $$nick2;
		if($select_id!=""){
			$select_id.=",'$nick2'";
		}else{
			$select_id.="'$nick2'";
		}
	}
}



include "/home/www/inc/db_connect_11.inc";

if($set_date == date("Y-m-d")){
	$bet_game = "bet_game";
	$bet_list = "bet_list";
}else{
	$bet_game = "bet_game_9D";
	$bet_list = "bet_list_rank";
}

if($_POST["user_num"] > 0){
	$s_unum = $_POST["user_num"];
}
	$sql = "select * from $bet_game, $bet_list where $bet_game.game_seq = $bet_list.game_seq and $bet_list.user_num=$s_unum and $bet_game.black_nick in ($select_id) and $bet_game.white_nick in ($select_id) and $bet_game.kind='$betgame_kind' and ($bet_game.game_time>='$game_time_start' and $bet_game.game_time<='$game_time_end') and $bet_list.ccode = 0 ";

if($s_unum == 6333638){
//echo $sql;
}

	$query = mysql_query($sql, $connect);



	while($data = mysql_fetch_array($query)){
		
		$game_result = $data["game_result"];
		$user_num = $data["user_num"];
		$user_id = $data["user_id"];
		$bet_color = $data["bet_color"];
		$bet_money = $data["bet_money"];
		$rose_cnt = $data["rose_cnt"];

		$bet_time = $data["bet_time"];
	
		if($bet_money >= 500000000){
			if($game_result == "B" || $game_result == "W"){
				if($game_result == $bet_color){
					$data_cnt1++;
					$data_total = $data_total + $step1_point;
				}else{
					$data_cnt2++;
					$data_total = $data_total + $step2_point;
				}
			}

		}else if($bet_money >= $step3_money && $bet_money < 500000000){
			if($game_result == "B" || $game_result == "W"){
				if($game_result == $bet_color){
					$data_cnt3++;
					$data_total = $data_total + $step3_point;
				}else{
					$data_cnt4++;
					$data_total = $data_total + $step4_point;
				}
			}

		}



		if($rose_cnt >= 90){
			$data_cnt5++;
			$data_total = $data_total + 10;
		}

	}

?>
			<div class="bigm_con">
                <div class="cheer_top">
                    <p class="top_txt">매주 월요일 밤 9시! <span>실시간</span>응원 미션</p>
                    <p class="top_box"><span><strong>실시간</strong>만 해당!<br /><span>= 사전베팅방 제외</span></span></p>
                </div>
                <div class="cheer_tab">
                    <button type="button" class="tab_day<? if($set_game==1){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 1)">4월 22일 <span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==2){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 2)">4월 29일 <span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==3){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 3)">5월 6일 <span>월요일</span></button>
                    <button type="button" class="tab_day<? if($set_game==4){?> day_on<?}?>" onclick="javascript:eventArea(<?=$set_round?>, 4)">5월 20일 <span>월요일</span></button>
                </div>
                <ul class="cheer_box">
                    <li class="box_mission01">
                        <p class="mission_type">베팅 적중</p>
                        <p class="mission_title">5억 PT 이상</p>
                        <div class="mission_imgbox">
                            <p class="mission_img"><img src="//img.tygem.com/images/event/20240403/img/img_cheer_mission01.png"></p>
                        </div>
                        <p class="mission_score"><span class="score_num"><?=$step1_point?></span>점<span class="score_unit">/회</span></p>
                        <p class="mission_num"><?=$data_cnt1?>회</p>
                    </li>
                    <li class="box_mission02">
                        <p class="mission_type">베팅 미적중</p>
                        <p class="mission_title">5억 PT 이상</p>
                        <div class="mission_imgbox">
                            <p class="mission_img"><img src="//img.tygem.com/images/event/20240403/img/img_cheer_mission02.png"></p>
                        </div>
                        <p class="mission_score"><span class="score_num"><?=$step2_point?></span>점<span class="score_unit">/회</span></p>
                        <p class="mission_num"><?=$data_cnt2?>회</p>
                    </li>
                    <li class="box_mission03">
                        <p class="mission_type">베팅 적중</p>
                        <p class="mission_title"><?=$step3_txt?></p>
                        <div class="mission_imgbox">
                            <p class="mission_img"><img src="//img.tygem.com/images/event/20240403/img/img_cheer_mission03.png"></p>
                        </div>
                        <p class="mission_score"><span class="score_num"><?=$step3_point?></span>점<span class="score_unit">/회</span></p>
                        <p class="mission_num"><?=$data_cnt3?>회</p>
                    </li>
                    <li class="box_mission04">
                        <p class="mission_type">베팅 미적중</p>
                        <p class="mission_title"><?=$step3_txt?></p>
                        <div class="mission_imgbox">
                            <p class="mission_img"><img src="//img.tygem.com/images/event/20240403/img/img_cheer_mission04.png"></p>
                        </div>
                        <p class="mission_score"><span class="score_num"><?=$step4_point?></span>점<span class="score_unit">/회</span></p>
                        <p class="mission_num"><?=$data_cnt4?>회</p>
                    </li>
                    <li class="box_mission05">
                        <p class="mission_type">장미 응원</p>
                        <p class="mission_title">장미 90개 응원</p>
                        <div class="mission_imgbox">
                            <p class="mission_img"><img src="//img.tygem.com/images/event/20240403/img/img_cheer_mission05.png"></p>
                        </div>
                        <!--<p class="mission_txt">프리미엄<br />서버만<br />집계</p>-->
                        <p class="mission_score"><span class="score_num">10</span>점<span class="score_unit">/회</span></p>
                        <p class="mission_num"><?=$data_cnt5?>회</p>
                    </li>
                </ul>
                <p class="mission_notice">5개 미션 모두 구간별 미션으로, 한 대국당 1구간부터 최대 4구간까지 자유롭게 중복 도전 가능합니다.</p>
            </div>
<script>
	$("#score_num").html("<?=number_format($data_total)?>점");
</script>