<?
header("Content-Type:text/html;charset=utf-8");
include "../inc/db_con.inc";

$user_txt = iconv("utf-8","euc-kr",$_POST["user_txt"]);
$user_txt = $_POST["user_txt"];
$user_info = $_POST["user_info"];

	$ncode = $_POST["ncode"];

	$ncode_arr = $_POST["ncode_arr"];

	

/*
if(count($user_info) > 0){
	$i=1;
	foreach ($user_info as $key => $value){
        if($i == 1){
			$arr_query = "'".$value."'";
		}else{
			$arr_query .= ", '".$value."'";
		}
		$i++;
	}
	$arr_query = " uid in ($arr_query)";
}
*/

	$user_info_var = explode(",",$user_info);
	for($i=0; $i<sizeof($user_info_var); $i++){
		 if($i == 0){
			$arr_query = "'".$user_info_var[$i]."'";
		}else{
			$arr_query .= ", '".$user_info_var[$i]."'";
		}
	}

	$arr_not_query = " uid not in ($arr_query)";

	$arr_query = " uid in ($arr_query)";

	$sql_arr = "select * from user_basic where $arr_query order by uid";
	$query_arr = mysql_query($sql_arr, $con);




$sub_query = "";
if($user_txt != ""){
	$sub_query = " and nick like '%$user_txt%' ";
}

	$sql = "select * from user_basic where $arr_not_query  $sub_query  order by uid";
	$query = mysql_query($sql, $con);
	
?>
<table class="table table-hover" width="100%">
<?
	while($data_arr = mysql_fetch_array($query_arr)){
		$uid = $data_arr["uid"];
		//$nick = iconv("euc-kr","utf-8",$data_arr["nick"]);
		$nick = $data_arr["nick"];
		$ukey = $data_arr["ukey"];
		$s_code = $data_arr["s_code"];


if($s_code == 1){
		$s_code_txt = "GOOGLE";
	}else if($s_code == 6){
		$s_code_txt = "APPLE";
	}else if($s_code == 11){
		$s_code_txt = "WEBGUEST";
	}else if($s_code == 12){
		$s_code_txt = "GUEST";
	}else{
		$s_code_txt = $s_code_txt;
	}

	$n_code = $data_arr["n_code"];

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
?>
		<tr>
			<td><input type="checkbox" name="uid[]" value="<?=$uid?>" checked onclick="checkbox_in()"></td>
			<td><?=$uid?></td>
			<td><?=$nick?></td>
			<td><?=$ukey?></td>
			<td><?=iconv("euc-kr","utf-8",$n_code_txt)?></td>
			<td><?=$s_code_txt?></td>
		</tr>
<?}?>

<?
	while($data = mysql_fetch_array($query)){
		$uid = $data["uid"];
//		$nick = iconv("euc-kr","utf-8",$data["nick"]);
		$nick = $data["nick"];
		$ukey = $data["ukey"];
		$s_code = $data["s_code"];

if($s_code == 1){
		$s_code_txt = "GOOGLE";
	}else if($s_code == 6){
		$s_code_txt = "APPLE";
	}else if($s_code == 11){
		$s_code_txt = "WEBGUEST";
	}else if($s_code == 12){
		$s_code_txt = "GUEST";
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
?>
		<tr>
			<td width="30"><input type="checkbox" name="uid[]" value="<?=$uid?>" onclick="checkbox_in()" <?if($n_code == $ncode){echo "checked";}?>></td>
			<td width="50"><?=$uid?></td>
			<td width="400"><?=$nick?></td>
			<td><?=$ukey?></td>
			<td><?=iconv("euc-kr","utf-8",$n_code_txt)?></td>
			<td><?=$s_code_txt?></td>
		</tr>
<?}?>
</table>