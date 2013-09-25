<?
session_start();

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  
  <title>Infinite Scroll &middot; jQuery Masonry</title>
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  
  <link rel="stylesheet" href="../css/style.css" />
  
  
  <!-- scripts at bottom of page -->

</head>
<body class="demos ">
  
<?php
  // get db connection
  include "../php/config.php";
  include "../php/functions.php";
  include "../php/functionsTimeline.php";
  // global values

  $articleTextLength = 150;
  $articleLinkLength = 18;
?>

<div id="timeline-articlelist" >

	<?
		  
		  // TODO: get location filter
		  $start_location = 1;
		  
		  // set default item if POST var is undefined
		  // TODO: get default theme, including nav selection
		  if(0 != 0) { 
			  //$start_theme = 1;
			  // display nulled filter
			  if($count == 0) echo '<div class="timeline-article-status"><p>BITTE WÄHLEN SIE EINE KATEGORIE</p></div>';
		  }
		  else {
			  // set filter item
		
			   $paper_id = $_SESSION['paper_id'];
			  // get query
			  $last_art = $_SESSION['last_art']; 
			  $sql1 = load_paper_sql_v2($paper_id);
			  $i = 1;
			  while($i < count($artikel_array)) {
				  $art_id = $artikel_array[$i];
				  $sql1 = $sql1 . "," . $art_id . " ";	
				  $i++;
			  }
			  
			  
			$pagenummer =	$_GET["page"];
			$limit = ($pagenummer*$varLoadLimit)-$varLoadLimit;
			  $sql1 = $sql1." ORDER BY timestamp_event DESC LIMIT " . $limit . "," . $varLoadLimit . ";";
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
				 	  $_SESSION['last_art'] = $row->article_id; 
					   $art_id = $row->article_id;
				  // TODO: strip text, add 'weiterlesen' --> shadowbox
				  //$text = substr($row->article_text, 0, 150);
				  $text = stripArticleText($row->article_text, $articleTextLength, $row->article);
				  
				  // format link
				  $link =  $row->source;
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
					  $time = date('d.m.Y H:i', $date);
				  }
				  
				  // TESTING: get values by article query
				  //$time = 'Vor 10 Minuten';
				  //$time = dateDiff("now", "now +2 months");
				  //$time = date('m.d.Y', $date);
			
			// format output
			
			// TODO: get article by php function formatArticle($bild, $title, $link, $strippedlink, $strippedlink_cropped , $time);
			
		//Bild quelle
                                    // $bild_name = substr($bild, 0, -4);
                                    $sql_bild = "SELECT * FROM `ersatzbilder` WHERE name = '" . substr($bild, 0, -4) . "'";
                                    $result_bild = mysql_query($sql_bild);
                                    $quellen_bild = "";
                                    $bild_link = "http://www.paperly.de";
                                    $bild_fotograf = "paperly User";
                                    $bild_quelle = "paperly";
                                    $row_bild = mysql_fetch_object($result_bild);
                                    if (!empty($row_bild)) {

                                        $bild_link = $row_bild->link;
                                        $bild_fotograf = $row_bild->fotograf;
                                        $bild_quelle = $row_bild->quelle;
                                        $bild_name = "$bild_fotograf / $bild_quelle";
                                        $quellen_bild = '</br>Bild: <a  href="' . $bild_link . '" title="Bildverweis" target="_new">' . $bild_name . '</a>';
                                    }


                                    $quellen_text = "";
                                    if (!empty($strippedlink_cropped)) {
                                        $quellen_text = 'Quelle: <a  href="redirect.php?id=' . $art_id . '" title="' . $strippedlink . '" target="_new">' . $strippedlink_cropped . '</a>';
                                    }





                                    $article = '
                                    <article class="timeline-article">
                                      <img src="upload/timeline/' . $bild . '" width="300" height="95" alt="paperly">
                                      <h1>' . $title . '</h1>
                                      <p>' . $text . '</p>
                                       
                                      <div class="article-subbox">
                                            <div class="article-origin">
                                           ' . $quellen_text . '
                                             ' . $quellen_bild . '
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
		  }
	
          ?>
         

</div> <!-- #container -->

<nav id="page-nav">
  <a href="pages/2.php"></a>
</nav>

<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
<!--<script src="js/libs/jquery-1.7.1.min.js"></script>-->
<script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
<!-- <script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>-->
<script type="text/javascript" src="js/libs/jquery.infinitescroll.min.js"></script>
<script>
  $(function(){
    
    var $container = $('#timeline-articlelist');
    
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.timeline-article',
        columnWidth: 100
      });
    });
    
    $container.infinitescroll({
      navSelector  : '#page-nav',    // selector for the paged navigation 
      nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
      itemSelector : '.box',     // selector for all items you'll retrieve
      loading: {
          finishedMsg: 'No more pages to load.',
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
    
   
    


</body>
</html>