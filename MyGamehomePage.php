<!DOCTYPE html>
<html>
<head>
<title>My Games</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>MY GAMES</h1>
<p style="font-size:30px">
<a href="sellerSubmitInfo.php">Post Your Game</a><br />
<a href="buyerSubmitInfo.php">Submit Interest</a><br />

</p>
<?php
if (isset($_GET['action'])) {
	if ((file_exists("GamesDirectory.txt")) && (filesize("GamesDirectory.txt") != 0)) {
      if($_GET['action']=="DeleteMessage"){
        if(isset($_GET['message'])){
        $detailArray = file("GamesDirectory.txt");
        $singleGameRecord = explode("~", $detailArray[$_GET['message']]);
        echo "<h3>the game serial is ".$singleGameRecord[3].".</h3>";
        echo "<h3>the release year is ".$singleGameRecord[6].".</h3>";
        echo "<h3>the original package is ".$singleGameRecord[7].".</h3>";       
         
       }
      }
   }
}

#if there is no game record
if ((!file_exists("GamesDirectory.txt")) || (filesize("GamesDirectory.txt")== 0))
	echo "<p>There are no messages posted.</p>\n";
else {
    #parse the file to array
	$gameArray = file("GamesDirectory.txt");
	echo "<table style=\"background-color:lightgray\" border=\"1\" width=\"100%\">\n";
	$count = count($gameArray);
	for ($i = 0; $i < $count; ++$i) {
		$singleGameRecord = explode("~", $gameArray[$i]);
		#set serial number as the key
		$KeyArray[] = $singleGameRecord[3];
		$ValueArray[] = $singleGameRecord[4] . "~" . $singleGameRecord[5];
		
	}
	//get a new array, the key is serial number,the value is release year and orginal package
	$detailArray = array_combine($KeyArray, $ValueArray);
	//$detailArray[$singleGameRecord[3]] = $singleGameRecord[6] . "~" . $singleGameRecord[7];
	$Index = 1;
	#display records
	foreach($detailArray as $detail) {
		$detailValue = explode("~", $detail);
		echo "<tr>\n";
		echo "<td width=\"10%\"><span>Game " . $Index . "</span></td>\n";
		echo "<td width=\"80%\"><span> Serial number:</span> " . htmlentities(key($detailArray)) ."<br />";
		echo "<span> type:</span> " . htmlentities($detailValue[0]) . "<br />";
		echo "<span>short description</span><br />\n" . htmlentities($detailValue[1]) ."</td>\n";
		echo "<td width=\"10%\"><span> get more details:</span><br />\nSerial number: " . "<a href='homePage.php?" . "action=DeleteMessage&" . "message=" . ($Index -1 ). "'>". htmlentities(key($detailArray))."</a></td>\n";

		echo "</tr>\n"; 
		++$Index;
		next($detailArray);
	}
}

?>

</body>
</html>
