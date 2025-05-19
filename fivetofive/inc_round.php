<?

$set_round = 1;
$set_game = 1;

if( date("Y-m-d") < "2024-04-23"){
	$set_game = 1;
	$event_start = "2024-04-08";
	$event_end = "2024-04-22";
} else if(date("Y-m-d") >= "2024-04-23" && date("Y-m-d") <= "2024-04-29"){
	$set_game = 2;
	$event_start = "2024-04-23";
	$event_end = "2024-04-29";
} else if(date("Y-m-d") >= "2024-04-30" && date("Y-m-d") <= "2024-05-06"){
	$set_game = 3;
	$event_start = "2024-04-30";
	$event_end = "2024-05-06";
} else if(date("Y-m-d") >= "2024-05-07"){
	$set_game = 4;
	$event_start = "2024-05-07";
	//$event_end = "2024-05-13";
	$event_end = "2024-05-20";
}

?>