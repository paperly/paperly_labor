<?php

$verbindung = mysql_connect("paperly.de", "d016d8cb" , "yyzZxYmVvppKZeL4") 
or die("Verbindung zur Datenbank konnte nicht hergestellt werden"); 
// set utf 8
	mysql_set_charset('utf8', $verbindung);

mysql_select_db("d015c94d") or die ("Datenbank konnte nicht ausgewählt werden"); 
	
?>