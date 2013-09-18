<?php
// import
include "config.php";
include "functions.php";  




// ini_set('max_execution_time', 2000);








$result = mysql_query("SELECT count(cloud) as count, cloud FROM `cloud_count` group by cloud order by count DESC");
while($row = mysql_fetch_object($result))
{
echo $row->count; 
echo " "; 
echo $row->cloud;
echo "</br>";


}






?>