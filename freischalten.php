<?php
session_start();
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
<!--<![endif]-->
<head>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>paperly</title>
<meta property="og:title" content="paperly.de - Meine Nachrichten" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://paperly.de" />
<meta property="og:image" content="http://prebeta.paperly.de/images/design/logo.png" />
<meta property="og:site_name" content="paperly" />
<meta property="fb:app_id" content="424820200939012" />
<meta name="description" content="">
<meta name="author" content="">
<!--<meta name="keywords" content=", , , , , , , , , ">-->
<meta name="robots" content="all">
<meta name="revisit-after" content="7 days">
<link rel="stylesheet" href="css/style.css" media="screen,projection">
<script src="js/libs/modernizr-2.0.6.min.js"></script>
<script src="js/libs/timeline/timelineClass.js"></script>
<script src="php/getTimelineNavigation.php" type="text/javascript"></script>
<script type="text/javascript">
function showdiv(id){

if(document.getElementById(id).style.visibility == "visible")
{
document.getElementById(id).style.visibility = "hidden";
}
else
{
document.getElementById(id).style.visibility = "visible";
}

//document.getElementById(id).style.display = "none";
}
</script>
</head>
<?
  // get db connection
  include "php/config.php";
  include "php/functions.php";
  include "php/functionsTimeline.php";
  // global values
  $target = 'index.php';
  $articleTextLength = 150;
  $articleLinkLength = 18;
  
  

	  
	  ?>
<body id="timeline" >
<div id="topbox" class="no-print">
  <div class="wrapper">
    <div id="topbox-column">
      <nav role="navigation" id="nav-top">
        <ul>
          <li class="first"><a href="#">Meine Papers</a></li>
          <li class="last"><a href="write_article.php">Artikel Veröffentlichen</a></li>
        </ul>
      </nav>
      <div id="topbox-profil"> <a onClick="showdiv('profilbox');" href="#"> Mein Profil <img src="images/design/profil.png" alt="Profil"> </a> </div>
    </div>
    <div id="profilbox" style="">
    <p><a href="profil.php">Einstellungen</a></p>
    <p><a href="logout.php">Abmelden</a></p>
    
	</div>
  </div>
</div>
<div id="container">
  <div id="header-designwrapper-left"></div>
  <div id="header-designwrapper-right"></div>
  <header class="no-print">
    <div class="wrapper clearfix">
      <div id="header-column">
        <div id="header-topbox">
          <div id="logo"><a href="index.php"><img src="images/design/logo.png" width="205" height="54" alt="paperly"></a></div>
          
          <div id="header-papercontrolbox">
            <!--<div class="header-papercontrolbox-content">Speichere Deine aktuelle Auswahl als Paper: </div>-->
          </div>
        </div>
        <div id="header-navbox"> </div>
      </div>
    </div>
  </header>
  <div id="main" role="main" class="clearfix">
    <div class="wrapper clearfix">
      <div id="notificationbox">Bitte fülle folgendes Formular aus</div>
      <div id="content-column">
        <section>
         
          <div id="timeline-articlelist"><?
		  
		  // TODO: get location filter
		  $start_location = 1;
		  
		 
	
	
   
    
 
			  
			 
			 // $varLoadLimit = 10;

			  $sql1 = " SELECT * FROM `article` WHERE activation = false ORDER BY `article`.`timestamp_creation` ASC";
			  // TESTING
			  //echo $sql1;
	  
			  //$result1 = mysql_query($sql1);
			  //$row1 = mysql_fetch_object($result1);
			  //$sql = "SELECT topic,article_text,source,timestamp_event FROM  `article` LIMIT 100;" ;
			  $result44 = mysql_query($sql1);
			  $count = 0;
			  
			  // format result
			  while($row = mysql_fetch_object($result44)) {
				  
				  $title = $row->topic;
				  $link =  $row->source;
				  $_SESSION['last_art'] = $row->article_id;
				  $art_id = $row->article_id;
				  // TODO: strip text, add 'weiterlesen' --> shadowbox
				  $text = $row->article_text;
				  //$text = stripArticleText($row->article_text, $articleTextLength,$art_id);
				  
				  // format link
				  
				  $bild = $row->image;
				  $strippedlink = stripArticleLink($link, -1);
				  $strippedlink_cropped = stripArticleLink($link, $articleLinkLength);
				  
				  // get timestamp
				  $date = strtotime($row->date);
				  $timestamp = $row->timestamp_event;
				 
				  //$atime = date("d.m.Y H:i");
				  $atime = strtotime("now");
				  $btime = strtotime($timestamp);
				  // $zeit = $date - $atime ; // in sekunden die verstrichen ist
				  $diff = $atime - $date;
				  $secs  =  $diff; 
				  $days  = intval($secs / (60 * 60 * 24)); 
				  $secs  = $secs % (60 * 60 * 24); 
				  $hours = intval($secs / (60 * 60)); 
				  $secs  = $secs % (60 * 60); 
				  $mins  = intval($secs / 60); 
				  $secs  = $secs % 60; 
				  if(strlen($hours)==1) $hours = "".$hours;
				  if(strlen($mins)==1) $mins = "".$mins; 
				  if(strlen($secs)==1) $secs = "".$secs; 
				  if($hours == 0) $time = "vor ".$mins." Minuten";
				  else $time = "vor ".$hours." Stunden ";
				  
				  
				 if($diff >= 86400)
				  {
					  $time = date('d.m.Y H:i', $btime);
				  }
				 
				  
				  // TESTING: get values by article query
				  //$time = 'Vor 10 Minuten';
				  //$time = dateDiff("now", "now +2 months");
				  
			
			// format output
			
			// TODO: get article by php function formatArticle($bild, $title, $link, $strippedlink, $strippedlink_cropped , $time);
			
			$article = '
			<article class="timeline-article">
			  <img src="upload/timeline/'.$bild.'" width="300" height="95" alt="paperly">
			  <h1>' . $title . '</h1>
			  <p>' . $text . '</p>
			    <p>Id: '. $art_id.'</p>
			  <div class="article-subbox">
				<div class="article-origin">
				  Edit: <a class="fancybox fancybox.iframe" href="article_edit.php?artid=' .$art_id. '" title="' . $strippedlink . '" target="_new">hier </a>
				</div>
				<div class="article-post-time">
				  ' . $time . '
				</div>
			  </div>
			</article>';
			echo $article;

				  //ads
				  if($count == 4) {
					  /*
					  $adv = '<div class="post" style="height:300px;">
						  <p  align="justify"  style="padding:10px;">WERBUNG </p>
						  <p><img src="bayern.jpg"/ height="200px" > </p>
						  </div>';
					  echo $adv;
					  */
					  $count = 0;
				  }
				  $count++;
				  //end ads
			  }
	  
			  // display nulled article list
			  if($count == 0) echo '<div class="timeline-article-status"><p>KEINE ARTIKEL VORHANDEN</p></div>';
		 
          ?></div>
          
          <!-- TODO: GET vars including lastArticelID -->
          <!-- TODO:  -->
		 <nav id="page-nav">
  <a href=""></a>
     
</nav>
          
        
          
        </section>
      </div>
      <!-- /#content-column --> 
    </div>
    <!--! /#wrapper --> 
  </div>
  <!-- /#main --> 
</div>
<!--! /#container -->
<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>
<script type="text/javascript" src="js/libs/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" >
	$(function(){
		
	  var $container = $('#timeline-articlelist');
  
	  $container.imagesLoaded(function(){
		$container.masonry({
		  itemSelector: '.timeline-article',
		  columnWidth: 300,
		  gutterWidth: 20
		});
	  });
	  
	  // begin infinity scroll, fixed code, loading per php --> GET Var
	  $container.infinitescroll({
		navSelector  : '#page-nav',    // selector for the paged navigation 
		nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
		itemSelector : '.timeline-article',     // selector for all items you'll retrieve
		
		loading: {
			finishedMsg: 'Keine weiteren Artikel.',
			img: 'http://i.imgur.com/6RMhx.gif'
		  }
		 
		},
		// trigger Masonry as a callback
		function( newElements ) {
		  // hide new items while they are loading
		  var $newElems = $( newElements ).css({ opacity: 0 });		  
		  // ensure that images load before adding to masonry layout
		  $newElems.imagesLoaded(function(){
			// show elems now they're ready
			$newElems.animate({ opacity: 1 });
			$container.masonry( 'appended', $newElems, true ); 
		  });
		}
	  );
		
	});
</script>
<script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
<link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.2" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		//  Simple image gallery. Uses default settings
		$('.fancybox').fancybox({
			'padding'	:	0,
			'margin'	:	0,
			'width' : 875,
			'height' : '90%',
			fitToView : false,
   			autoSize : false,
			beforeClose: function() {window.location.href='freischalten.php';}
			
			});
	});
</script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>
<footer class="no-print">
  <div class="wrapper clearfix">
    <div id="footer-column"></div>
  </div>
</footer>
</body>
</html>
