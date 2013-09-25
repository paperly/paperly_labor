<?php

session_start();
include "config.php";
include "functions.php";
//$user_id = $_POST["user"];
$user_id = $_SESSION["user_id"];
$article = $_POST["article"];

//prüfen ob like schon vorhanden ist
$sql = "SELECT * FROM `likes` WHERE user_id = $user_id AND article_id = $article AND typ = 2";
$data = mysql_query($sql);
$row = mysql_fetch_object($data);
if (empty($row)) {
    $sql = "INSERT INTO likes (user_id,article_id,typ) VALUES ($user_id,'$article','2');";
    $eintragen = mysql_query($sql);
    $sql = "DELETE FROM likes WHERE user_id = $user_id AND article_id = $article ANd typ = 1";
    $eintragen = mysql_query($sql);
}
else{
   $sql = "DELETE FROM likes WHERE user_id = $user_id AND article_id = $article ANd typ = 2";
    $eintragen = mysql_query($sql);
}






/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
