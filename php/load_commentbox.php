<?php
session_start();
include "config.php";
include "functions.php";

$article_id = $_GET["id"];

echo load_commentbox_html($article_id);
 



?>
