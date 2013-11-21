<?php

// DB connect - all-inkl.de
//$verbindung = mysql_connect("paperly.de", "paperly_01_c", "f4s5S3dg3d") or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
$verbindung = mysql_connect("127.0.0.1", "root", "") or die("Verbindung zur Datenbank konnte nicht hergestellt werden");

// set utf 8
mysql_set_charset('utf8', $verbindung);
// choose db
mysql_select_db("paperly_01_c") or die("Datenbank konnte nicht ausgewählt werden");

// Wie viel Artikel werden geladen?
$varLoadLimit = 12;


//paperly base url
$basedir = "localhost";




// set PDO connection parameter
//$pdoHost = 'mysql:host=paperly.de;dbname=paperly_01_c';
//$pdoUsername = 'paperly_01_c';
//$pdoPassword = 'f4s5S3dg3d';
$pdoHost = 'mysql:host=localhost;dbname=paperly_01_c';
$pdoUsername = 'root';
$pdoPassword = '';
// set PDO db connection
try {
    $pdoConnection = new PDO($pdoHost, $pdoUsername, $pdoPassword);
    $pdoConnection->exec("SET NAMES 'utf8'");
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // TODO: display error
    //echo 'ERROR: ' . $e->getMessage();
}

?>