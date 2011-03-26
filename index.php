<?php
include("dbconnect.php");
?>


<html>
<head>
<meta name = "viewport" content = "width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">		
<script src="http://code.google.com/apis/gears/gears_init.js" type="text/javascript" charset="utf-8"></script>
<script src="js/geo.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
function initialize_map()
{
    var myOptions = {
	      zoom: 4,
	      mapTypeControl: true,
	      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	      navigationControl: true,
	      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	      mapTypeId: google.maps.MapTypeId.ROADMAP      
	    }	
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}
function initialize()
{
	if(geo_position_js.init())
	{
		document.getElementById('current').innerHTML="Receiving...";
		geo_position_js.getCurrentPosition(show_position,function(){document.getElementById('current').innerHTML="Couldn't get location"},{enableHighAccuracy:true});
	}
	else
	{
		document.getElementById('current').innerHTML="Functionality not available";
	}
}

function show_position(p)
{
	document.getElementById('current').innerHTML="latitude="+p.coords.latitude+" longitude="+p.coords.longitude;
	
	document.getElementById('flat').value = p.coords.latitude;
	document.getElementById('flon').value = p.coords.longitude;
	
	
	
	var pos=new google.maps.LatLng(p.coords.latitude,p.coords.longitude);
	map.setCenter(pos);
	map.setZoom(13);

	var infowindow = new google.maps.InfoWindow({
	    content: "<strong>latitude="+p.coords.latitude+" longitude="+p.coords.longitude+"</strong>"
	});

	var marker = new google.maps.Marker({
	    position: pos,
	    map: map,
	    title:"You are here"
	});

	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});
	
	var polylineCoords = [
<?php
	$query = mysql_query("SELECT * FROM saved ORDER BY id");
	while($sqldata = mysql_fetch_array($query)){
		echo "new google.maps.LatLng(".$sqldata["lat"].", ".$sqldata["lon"]."),\n";
	}
	mysql_close($sql);
?>
];

	var pathPaint = new google.maps.Polyline({
		path: polylineCoords,
		strokeColor: "#FF0000",
		strokeOpacity: 1.0,
		strokeWeight: 2
	});
	pathPaint.setMap(map);
}

</script >
<style>
	body {font-family: Helvetica;font-size:11pt;padding:0px;margin:0px}
	#current {font-size:10pt;padding:5px;}	
</style>
</head>
<body onload="initialize_map();initialize()">
	<div id="current">Init...</div>
	<form name="saveForm" method="post" action="point_parser.php">
	Lat: <input type="text" name="lat" id="flat" /><br />
	Lon: <input type="text" name="lon" id="flon" /><br />
	<input type="submit" value="Save Point" />
	</form>
	<div id="map_canvas" style="width:320px; height:350px"></div>
</body>
</html>