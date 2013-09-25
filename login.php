<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbenanntes Dokument</title>
</head>

<body>
<?php

include "php/config.php";

		
$email = $_POST["EMail"];
$passwort = $_POST["Password"];

$abfrage = "SELECT user_id, password FROM user WHERE email = '$email' LIMIT 1";
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);
		
$passwort = md5($passwort);

//echo "user: " + md5($passwort);

if($row->password == $passwort) {
	$user_id = 	$row->user_id;
    $_SESSION["user_id"] = $user_id;
	//echo "Hallo Userer ".$user_id;
    
    // db

	$abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
    $ergebnis1 = mysql_query($abfrage1);
	$row = mysql_fetch_object($ergebnis1);
	$maxid = $row->maxid;
	
	$maxid++;
    
    $abfrage = "INSERT INTO log_db (id, action_id, user_id) VALUES ('$maxid',1,'$user_id');";

    mysql_query($abfrage,$verbindung);
        
    echo "<script language='javascript'>";
	echo "window.location.href='index.php'";
	echo "</script>";
} else {
    echo "Benutzername und/oder Passwort waren falsch. <a href=\"index.php\">Login</a>";
	echo "<script language='javascript'>";
	echo "window.location.href='index.php'";
	echo "</script>";
}

?>
</body>
</html>