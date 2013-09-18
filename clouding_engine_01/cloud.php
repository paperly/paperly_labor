<?php

// import
include "config.php";
include "functions.php";  

ini_set('max_execution_time', 2000);






$sql = "SELECT url,theme_id,id FROM  `rss_feed` WHERE theme_id = 20 ORDER BY id ASC";
$result_f = mysql_query($sql);

$feedcnouter = 0;
$articelcounter = 0;
$fehlercounter = 0;


$feed_id = null;


// Arikel Atr
$text = null;
$titel = null;
$article_id = null;

// definitionen
 $arraywords = array();


echo "Anzahl Feeds:" . mysql_num_rows($result_f) . "</br>";


// FEED laden
while ($row = mysql_fetch_object($result_f)) {
    echo "------------------------------------------------------------------------------------</br>";
    $feedcnouter++;
    $ausgabe = $row->id;
    echo "Feed_id " . $ausgabe . "</br>";
    echo $feedcnouter . "</br>";
    $url = $row->url;
    $feed_id = $row->id;
    $feed_theme = $row->theme_id;
    echo "Thema: " . $feed_theme . "</br>";
    echo $url . "</br>";
    $feed = simplexml_load_file($url);

    // Artikel laden
    foreach ($feed->channel->item as $item) {
        $articelcounter++;
        $titel = $item->title;
        $text = $item->description;
        
        
        $text = $text.$titel;
        
        
       // Wörter aus text laden
        $arraywords = wordfromtext($text);
        
       //Wörter abspeichern
        
        savewordsionName($arraywords);
        
        
        //database import
        // cloud + theme_id
        // db -> current timestamp
        
        
        
        
   
    }
}



echo "-------------</br>-------------</br>";
echo "Fehler: " . $fehlercounter . "<br>";
echo "Artikel Gesamt: " . $articelcounter . "<br>";
?>


