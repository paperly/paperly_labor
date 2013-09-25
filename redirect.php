<?php
include "php/config.php";
$art_id = $_GET["id"];
session_start();
$user_id = $_SESSION["user_id"];


$sql = "SELECT * FROM article WHERE article_id = ".$art_id;

		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		//$text = $row->article_text;
		$link = $row->source;
		 $abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
    $ergebnis1 = mysql_query($abfrage1);
	$row = mysql_fetch_object($ergebnis1);
	$maxid = $row->maxid;
	
	$maxid++;
    
	
    $abfrage = "INSERT INTO log_db (id, action_id, user_id, data_1) VALUES ('$maxid',4,'$user_id','$art_id');";
	
      
    
    mysql_query($abfrage);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML> 
<HEAD> 


 <meta http-equiv="refresh" content="0; url=<?php echo $link?>"> 
</HEAD> 
</HTML>


