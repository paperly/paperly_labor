<?php

session_start();
include "config.php";
include "functions.php";
//$user_id = $_POST["user"];
$user_id = $_SESSION["user_id"];
$text = $_POST["text"];
$article_id = $_POST["id"];
   if(!empty($user_id)){
             
 $sql = "INSERT INTO article_comment (user_id,text,article_id) VALUES ($user_id,'$text',$article_id);";
        $eintragen = mysql_query($sql);

}


?>