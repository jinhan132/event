<?
header("Content-Type:text/html;charset=utf-8");

$user_grade = array("","30급","29급","28급","27급","26급","25급","24급","23급","22급","21급","20급","19급","18급","17급","16급","15급","14급","13급","12급","11급","10급","9급","8급","7급","6급","5급","4급","3급","2급","1급","1단","2단","3단","4단","5단","6단","7단","8단","9단");


	$uinfo = $_POST["uinfo"];
	$find_txt = trim($_POST["find_txt"]);

	
	include "../inc/db_con.inc";


//	$find_txt = iconv("utf-8","euc-kr",$find_txt);


	$sql = "select * from user_basic, quiz_user where user_basic.uid = quiz_user.uid and user_basic.$uinfo = '$find_txt' ";
	$query = mysql_query($sql, $con);
	$data = mysql_fetch_array($query);

if($data["ukey"] == ""){
	$exampleModalLabel = "not find";
	$modal_body = "사용자를 찾을수 없습니다.";
}else{

	$uid = $data["uid"];
	$do_cnt = $data["do_cnt"];


	$s_code = $data["s_code"];
	if($s_code == 1){
		$s_code_txt = "GOOGLE";
	}else if($s_code == 6){
		$s_code_txt = "APPLE";
	}else if($s_code == 11){
		$s_code_txt = "WEBGUEST";
	}else if($s_code == 12){
		$s_code_txt = "APPGUEST";
	}else{
		$s_code_txt = $s_code_txt;
	}

	$n_code = $data["n_code"];

	if($n_code == 1){
		$n_code_txt = "일본";
	}else if($n_code == 2){
		$n_code_txt = "중국";
	}else if($n_code == 3){
		$n_code_txt = "영어";
	}else if($n_code == 4){
		$n_code_txt = "대만";
	}else{
		$n_code_txt = "한국";
	}

	$grade = $data["grade"];

	$reg_time = $data["reg_time"];

		$sql_hist = "select * from quiz_hist where uid=$uid";
		$query_hist = mysql_query($sql_hist, $con);
		while($data_hist = mysql_fetch_array($query_hist)){
			$suc = $data_hist["suc"];
			$fail = $data_hist["fail"];
			$work = $data_hist["work"];
			$buy = $data_hist["buy"];
			$level = $data_hist["level"];

			$suc_total = $suc_total + $suc;
			$fail_total = $fail_total + $fail;
			$work_total = $work_total + $work;
			$buy_total = $buy_total + $buy;

			$level_cnt[$level]++;

			if($suc > 0){$suc_cnt++; }
			if($fail > 0){$fail_cnt++;}
			if($work > 0){$work_cnt++;}
			if($buy > 0){$buy_cnt++;}
		}
mysql_close($con);
?>
<div class="container my-2">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
      <li class="breadcrumb-item" style="font-weight: 900;">계정 정보</li>
      <li class="breadcrumb-item" ><a href="javascript:key_info(<?=$uid?>)" style="text-decoration: none!important;">열쇠 정보</a></li>
      <li class="breadcrumb-item"><a href="javascript:user_post_info(<?=$uid?>)" style="text-decoration: none!important;">우편 로그</a></li>
	  <li class="breadcrumb-item"><a href="javascript:user_pay(<?=$uid?>)" style="text-decoration: none!important;">결제 정보</a></li>
    </ol>
  </nav>
</div>

<table class="table">
	<tr>
		<th scope="row">uid</th>
		<td><?=$uid?></td>
	</tr>
	<tr>
		<th scope="row">ukey</th>
		<td><?=$data["ukey"]?></td>
	</tr>
	<tr>
		<th scope="row">nick</th>
		<td><?=$data["nick"]?><!--<?=iconv("euc-kr","utf-8",$data["nick"])?>--></td>
	</tr>
	<tr>
		<th scope="row">가입 일자</th>
		<td><?=$reg_time?></td>
	</tr>
	<tr>
		<th scope="row">최종 로그인</th>
		<td><?=$data["last_time"]?></td>
	</tr>
	<tr>
		<th scope="row">계정유형</th>
		<td><?=$s_code_txt?></td>
	</tr>
	<tr>
		<th scope="row">국가</th>
		<td><?=$n_code_txt?></td>
	</tr>
	<tr>
		<th scope="row">기력</th>
		<td><?=$user_grade[$grade]?> </td>
	</tr>
	<tr>
		<th scope="row">보유 열쇠</th>
		<td><?=number_format($do_cnt)?>&nbsp;( <?=number_format($buy_total)?> / <?=number_format($buy_cnt)?> )</td>
	</tr>
	<tr>
		<th scope="row">풀이 시도</th>
		<td><?=number_format($work_total)?> / <?=number_format($work_cnt)?></td>
	</tr>
	<tr>
		<th scope="row">풀이 성공</th>
		<td><?=number_format($suc_total)?> / <?=number_format($suc_cnt)?></td>
	</tr>
	<tr>
		<th scope="row">풀이 실패</th>
		<td><?=number_format($fail_total)?> / <?=number_format($fail_cnt)?></td>
	</tr>
	<tr>
		<th scope="row">난이도</th>
		<td>
<?
	for($i=1; $i<=20; $i++){
		if($i == 1){
			echo number_format($level_cnt[$i]);
		}else{
			echo " | ".number_format($level_cnt[$i]);
		}
	}
?>		
		</td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td><button type="button" class="btn btn-danger" onclick="javascript:adminLeave(<?=$uid?>)"> &nbsp;탈퇴&nbsp; </button></td>
		<td align="right">
		<button type="button" class="btn btn-secondary" onclick="adminNick(<?=$uid?>)">닉 변경</button>&nbsp;
		<button type="button" class="btn btn-secondary" onclick="javascript:adminRank(<?=$uid?>, <?=$grade?>)">기력 변경</button>&nbsp;
		<button type="button" class="btn btn-primary" onclick="adminGiveKey(<?=$uid?>,<?=$do_cnt?>,'plus')">열쇠 지급</button>&nbsp;
		<button type="button" class="btn btn-primary" onclick="adminGiveKey(<?=$uid?>,<?=$do_cnt?>,'minus')">열쇠 소진</button>
		</td>
	</tr>
<?
	exit;
}

?>

<script>
$("#exampleModalLabel").text("<?=$exampleModalLabel?>");
$("#modal_body").text("<?=$modal_body?>")
$('#exampleModal').modal("show");
</script>