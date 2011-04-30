<?php

if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	
	include("dbconnect.php");
	 if($mode == "insert"){
		$lat = $_POST["lat"];
		$lon = $_POST["lon"];

		/*
		echo "Get data:<br />";
		echo $lat;
		echo "<br />";
		echo $lon;
		*/
		//echo "Updated!<br />Lat: "+$_POST["lat"]+"<br />Lon: "+$_POST["lon"]+"<br />";
		mysql_query("INSERT INTO saved (lat,lon) VALUES (".$lat.",".$lon.")");
		echo $lat."|".$lon.";";
		
	}elseif($mode == "get"){
		$query = mysql_query("SELECT * FROM saved ORDER BY id");
		while($sqldata = mysql_fetch_array($query)){
			//echo "new google.maps.LatLng(".$sqldata["lat"].", ".$sqldata["lon"]."),\n";
			echo $sqldata["lat"]."|".$sqldata["lon"].";";
		}
	}

	mysql_close($sql);

}else{
	print "ERROR";
}
?>