<?php
include("dbconnect.php");

$lat = $_POST["lat"];
$lon = $_POST["lon"];


echo "Get data:<br />";
echo $lat;
echo "<br />";
echo $lon;

//echo "Updated!<br />Lat: "+$_POST["lat"]+"<br />Lon: "+$_POST["lon"]+"<br />";

mysql_query("INSERT INTO saved (lat,lon) VALUES (".$lat.",".$lon.")");


mysql_close($sql);
?>