<?php
session_start();
include "config.php";
include "functions.php";


$article = $_GET["article_id"];
$user_id = $_SESSION["user_id"];
$html = load_likebox($user_id, $article);
echo $html;


?>
