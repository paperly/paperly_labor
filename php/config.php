<?php

// DB connect - all-inkl.de
$verbindung = mysql_connect(".de", "", "") or die("Verbindung zur Datenbank konnte nicht hergestellt werden");

// set utf 8
mysql_set_charset('utf8', $verbindung);
// choose db
mysql_select_db("") or die("Datenbank konnte nicht ausgewählt werden");

// Wie viel Artikel werden geladen?
$varLoadLimit = 12;


//paperly base url
$basedir = "localhost";




// set PDO connection parameter
$pdoHost = 'mysql:host=paperly.de;dbname=paperly_01_c';
$pdoUsername = '';
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
