<?
header("Content-Type:text/html;charset=euc-kr");

include_once "/home/www/inc/define.h";
include_once "$docPath/inc/session.inc";


	$avata_name[968] = "판다";
	$avata_name[969] = "백호";
	$avata_name[970] = "5대5";


	$fsdate = $_POST["fsdate"];
	$fedate = $_POST["fedate"]." 23:59:59";

	$user_id = trim($_POST["user_id"]);
	$user_id = iconv("utf-8","euc-kr",$user_id);

	include "$docPath/inc/db_con2.inc";
?>
<br>
<table cellpadding="1" cellspacing="1" border="0" bgcolor="dddddd">
<?
	$sub_query = "";
	if($user_id){
		$sub_query = " and user_id='$user_id'";
	}

	$total_num = 0;
?>
	<tr height="23" bgcolor="f1f1f1" align="center">

		<td></td>
		<td>아이디</td>
		<td>회원번호</td>
		<td>상품명</td>
		<td>구매날짜</td>
		<td>금액</td>
	</tr>
<?
	$sql = "select * from order_account where order_time>='$fsdate' and order_time<='$fedate' $sub_query and account_result='결제완료' and (goods_item like '%968%' or goods_item like '%969%' or goods_item like '%970%' )";
	$query = mysql_query($sql, $con2);
	$total_i = 1;
	$i = 1;
	while($data = mysql_fetch_array($query)){

		$user_id = $data["user_id"];
		$goods_name = $data["goods_name"];
		$total_price = $data["total_price"];
		$order_time = $data["order_time"];
		$goods_item = $data["goods_item"];

		$goods_item_var = explode(",",$goods_item);

		
?>
	<tr bgcolor="ffffff" height="20">
		<td width="80" align="center"><?=$i?></td>
		<td width="80"><?=$user_id?></td>
		<td width="80"><?=$data[user_num]?></td>
		<td width="190"><?=$goods_name?></td>
		<td width="120"><?=$order_time?></td>
		<td width="70" align="right"><?=number_format($total_price)?></td>

	</tr>
<?
			
		

		$i++;
	}
?>
	
</table>
<? mysql_close($con2); ?>