<?php
session_start();
include "config.php";
include "functions.php";


$article = $_GET["article_id"];
$user_id = $_SESSION["user_id"];



$months = $_GET["months"];
$locations = $_GET["locations"];

$html = load_promotioncalcalation($months,$locations);
echo $html;




?>
