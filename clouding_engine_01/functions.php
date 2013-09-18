<?php

// import
include "config.php";

// wörter aus text in array laden
function wordfromtext($text) {

    $arraywords = explode(" ", $text);

    return $arraywords;
}

// wörter array in datenbanl speichern
function savewordsionName($words) {
    $theme_id = 20;

    for ($i = 0; $i < count($words); $i++) {
        $cloud = $words[$i];


           // Komma usw. ausmisten
        $replace = array('.', ',', ';',':','“', '"');
        $subject = '';
       $cloud= str_replace($replace,$subject, $cloud);
        
      
        
        // prüfen ob das word gross geschriben wird


        if (ctype_upper($cloud[0])) {

            $result = mysql_query("SELECT MAX(id) AS 'id' FROM cloud_count ;");
            $idmax = mysql_fetch_array($result);
            $id = $idmax[id] + 1;
            $sql = "INSERT INTO cloud_count (id,cloud,theme_id) VALUES ('$id','$cloud', '$theme_id');";
            mysql_query($sql);
        }
    }
}
?>






