<?php
session_start();
$user_id = $_SESSION["user_id"];

include "php/config.php";
$art_id = $_GET["artid"];








 


$sql = "SELECT * FROM article WHERE article_id = ".$art_id;

		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		//$text = $row->article_text;
		$topic = $row->topic;
		$text = $row->article_text;
		$image = $row->image;
		$date = strtotime($row->timestamp_creation);
	
 		$t = date('N',$date);
		$wochentage = array('Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag');
		$wochentag = $wochentage[$t-1];  
		
		 $time = date('d.m.Y H:i', $date);
		 $time = $wochentag.", ".$time." Uhr";
		//echo "<h1>".$topic."</h1>";
		//echo "<p>".$text."</p>";
		
		//echo '<div class="fb-like" data-href="http://prebeta.paperly.de/start.php?artid='.$art_id.'" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>';
		?>
<html class="no-js" lang="de">

<meta charset="utf-8">
<link rel="stylesheet" href="css/style_article.css" media="screen,projection">

<body>
<script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>

<script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>
<script type="text/javascript">
<!--
if (self == top) { window.location.href='index.php'; }
//-->
</script>  


<div class="article_titel_box">
<div class="title_box_l"><h1><?php echo $topic; ?></h1></div>
<div class="title_box_r"><h4><?php echo $time; ?></h4></div>
</div>
<div class="article_l">
	<div class="article_text">
	<img class="bild" src="upload/article/<?php echo $image; ?>" >
   
    <p><?php echo $text; ?></p>
	</div>
</div>

<?php
// speichern // löschern
$action_save = $_POST["action_save"];
$action_delete = $_POST["action_delete"];


// artikel freischlten
if(!empty($action_save))
{
	
	$sql = "UPDATE article SET activation = true  WHERE article_id = ".$art_id.";" ;
 	$result = mysql_query($sql);
	echo "öffentlich gespeichert";
	echo "<script type='text/javascript'>
	$(document).ready(function(){
		parent.jQuery.fancybox.close();
 	
	 })
	  window.location.href='index.php';
	 
	 </script>";
	
	}
	
	if(!empty($action_delete))
{
	$sql = "DELETE FROM article WHERE article_id = ".$art_id.";" ;
 	$result = mysql_query($sql);
	echo "löschen";
	echo "<script type='text/javascript'>
	$(document).ready(function(){
		parent.jQuery.fancybox.close();
 	
	 })
	  window.location.href='index.php';
	 
	 </script>";
	
	}





?>
 
 <form class="profil-form" method="post" action="article_edit.php?artid=<?php echo $art_id;?>" enctype="multipart/form-data">
      <fieldset class="profil-fieldset">
        <legend class="profil-legend">Formulardaten</legend>
        <div class="profil-fieldwrap">
        
          
        </div>
        
        <div class="profil-fieldwrap">
          <input class="profil-submit profil_css3button" type="submit" name="action_save" value="freischalten / speichern" >
        </div>
        <div class="profil-fieldwrap">
          <input class="profil-submit profil_css3button" type="submit" name="action_delete" value="löschen" >
        </div>
      </fieldset>
    </form>



    

  
</body>
</html>