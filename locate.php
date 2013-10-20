<?php

$info = geoip_record_by_name($_SERVER['REMOTE_ADDR']);
$city = $info['city'];
if($city == "Munich"){
    $city = "München";
}


//echo "<p>Deine Stadt: ".$city."</p>";


?>