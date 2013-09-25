<?php

session_start();
if (isset($_SESSION["user_id"])) {
    include "php/mypaperly.php";
} else {
    echo "<script language='javascript'>";
    echo "window.location.href='/'";
    echo "</script>";
    include "php/start.php";
}
?>