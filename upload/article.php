<?php
session_start();
$user_id = $_SESSION["user_id"];

include "php/config.php";
$art_id = $_GET["artid"];





 $abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
    $ergebnis1 = mysql_query($abfrage1);
	$row = mysql_fetch_object($ergebnis1);
	$maxid = $row->maxid;
	
	$maxid++;
    
	
    $abfrage = "INSERT INTO log_db (id, action_id, user_id, data_1) VALUES ('$maxid',3,'$user_id','$art_id');";
	
      
    
    mysql_query($abfrage);
    


$sql = "SELECT * FROM article WHERE article_id = ".$art_id;

		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		//$text = $row->article_text;
		$topic = $row->topic;
		$text = $row->article_text;
		$image = $row->image;
		$date = strtotime($row->timestamp_creation);
	
 		$t = date('N',$date);
		$wochentage = array('Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag','Sonntag');
		$wochentag = $wochentage[$t-1];  
		
		 $time = date('d.m.Y H:i', $date);
		 $time = $wochentag.", ".$time." Uhr";
		//echo "<h1>".$topic."</h1>";
		//echo "<p>".$text."</p>";
		
		//echo '<div class="fb-like" data-href="http://prebeta.paperly.de/start.php?artid='.$art_id.'" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>';
		?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
<!--<![endif]--><head>


<meta charset="utf-8">
</head>

<link rel="stylesheet" href="css/style_article.css" media="screen,projection">

<body>

<script type="text/javascript">
<!--
if (self == top) { window.location.href='index.php'; }


//-->

</script> 
<script src="js/libs/modernizr-2.0.6.min.js"></script>
<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
<script type = 'text/javascript'>
if (typeof history.pushState !== "undefined") {
     parent.history.pushState(null, 'paperly Artikel', '<?php echo "http://prebeta.paperly.de/index.php?artid=".$art_id."";?>');
}
</script> 

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1&appId=424820200939012";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="article_titel_box">
<div class="title_box_l"><h1><?php echo $topic; ?></h1></div>
<div class="title_box_r"><h4><?php echo $time; ?></h4></div>
</div>
<div class="article_l">
	<div class="article_text">
	<img class="bild" src="upload/article/<?php echo $image; ?>" >
    <p><div class="fb-like" data-href="http://prebeta.paperly.de/?artid=<?php echo $art_id; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div> </p>
    <p><?php echo $text; ?></p>
	</div>
</div>
<div class="article_r">

<h3>Empfohlene Artikel:</h3>

 


<?php
	$abfrage = "SELECT * FROM article WHERE not creator = -1 ORDER BY RAND() LIMIT 10;";
	$ergebnis = mysql_query($abfrage);
	while($row = mysql_fetch_object($ergebnis))
	{
		$topic = $row->topic;
		$artid = $row->article_id;
		//$topic = substr($topic, 0, 35).".."; class='fancybox fancybox.iframe
		echo "<p><a href='article.php?artid=".$artid."' target='_self'>".$topic."</a></p>";
		
		}


?>


</div>

 




    

  
</body>
</html>