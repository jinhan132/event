<?
header("Content-Type:text/html;charset=utf-8");



	$str = "<?\n";

		foreach ($_POST as $param_name => $param_val) {
			$str .= "$".$param_name." = '".$param_val."';\n";
		}

	$str .= "?>";

	$table_name = "member2.inc";

	$fp = fopen( "../db/$table_name", "w");
	fputs ($fp, $str);
	fclose($fp);
?>
<script>parent.location.reload();</script>