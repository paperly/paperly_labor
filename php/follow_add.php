<?php

session_start();
include "config.php";
include "functions.php";
//$user_id = $_POST["user"];
$user_id = $_SESSION["user_id"];
$follow_user_id = $_POST["user"];
$follow_location_id = $_POST["location"];

if (!empty($follow_user_id)) {
//prüfen ob follow schon vorhanden ist
    $sql = "SELECT * FROM `user_follow` WHERE user_id_self = $user_id AND user_id_other = $follow_user_id";
    $data = mysql_query($sql);
    $row = mysql_fetch_object($data);
    if (empty($row)) {
        $sql = "INSERT INTO user_follow (user_id_self,user_id_other) VALUES ($user_id,'$follow_user_id');";
        $eintragen = mysql_query($sql);
    } else {
        $sql = "DELETE FROM user_follow WHERE user_id_self = $user_id AND user_id_other = $follow_user_id";
        $eintragen = mysql_query($sql);
    }
}

if (!empty($follow_location_id)) {
    $sql = "SELECT * FROM `location_follow` WHERE user_id_self = $user_id AND location_id = $follow_location_id";
    $data = mysql_query($sql);
    $row = mysql_fetch_object($data);
    if (empty($row)) {
        $sql = "INSERT INTO location_follow (user_id_self,location_id) VALUES ($user_id,'$follow_location_id');";
        $eintragen = mysql_query($sql);
    } else {
        $sql = "DELETE FROM location_follow WHERE user_id_self = $user_id AND location_id = $follow_location_id";
        $eintragen = mysql_query($sql);
    }
}



/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
