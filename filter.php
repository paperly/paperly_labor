<?php
// Filter
session_start();
if (isset($_SESSION["user_id"])) {
    include "php/filter.php";
} else {
    echo "<script language='javascript'>";
    echo "window.location.href='index.php'";
    echo "</script>";
    include "php/start.php";
}
?>