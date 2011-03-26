<?php

$sql = mysql_connect('localhost','root','*****');
if(!$sql){
	die("SQL Connection ERROR!");
}

if(!mysql_select_db('mappaint',$sql)){
	die("Database ERROR!");
}


?>