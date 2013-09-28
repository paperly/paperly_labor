<?php
session_start();
// get db connection
include "php/config.php";
include "php/functions.php";
include "php/functionsTimeline.php";
// global values
$target = 'index.php';
$articleTextLength = 160;
$articleLinkLength = 18;
// set current paper id
$profil_name = $_GET["id"];

 $sql = "SELECT * FROM  user WHERE nickname = '$profil_name';";
 $result = mysql_query($sql);
 $row = mysql_fetch_object($result);
$nickname = $row->nickname;

if(Strtolower($nickname) != Strtolower($profil_name)){

   
   echo "<script language='javascript'>";
	echo "window.location.href='/'";
	echo "</script>";
   die();
  
    
    
}
    
  



$user_id =  $_SESSION["user_id"];






?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
    <!--<![endif]-->
    <head>
        <?php
        echo getHeaderConfig('Profil');
        echo getMetaTags();
        ?>
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <script src="js/libs/timeline/timelineClass.js"></script>
        
          <!-- social functions -->
        <script src="js/libs/profil/followClass.js"></script>
        
        <script src="php/getTimelineNavigation.php" type="text/javascript"></script>
                   <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40911491-1', 'paperly.de');
  ga('send', 'pageview');

</script>
    </head>

    <body id="timeline" onLoad="">
        <?php
        // set docuemnt header, check functions.php
        if (isset($_SESSION["user_id"]))
            echo getDocumentHeaderLoggedIn('paper', $_SESSION["user_id"], $pdoConnection);
        else
            echo getDocumentHeaderLoggedOff();
        ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"><a href="index.php"><img src="images/design/logo.png"  height="54" alt="paperly"></a></div>
                            <div id="header-papercontrolbox">
                                <!--<div class="header-papercontrolbox-content">Speichere Deine aktuelle Auswahl als Paper: </div>-->
                            </div>
                            
                                                        <?php
        // set docuemnt header, check functions.php
        if (!isset($_SESSION["user_id"]))
            echo getDocumentLogin();
        ?>
                            
                            
                        </div>
                        <!--<div id="header-navbox"></div>-->
                    </div>
                </div>
            </header>
            
            
         
              
            
            
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                    
                    
                 
                    
                    
                    
                     <?php
                            // get paper title, default: paper id
                            $selectedProfilTitle = $profil_id;
                            $sql = "SELECT * FROM  `user` WHERE nickname = '$profil_name';";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_object($result);
                            //$nickname = $profil_id;
                            $profil_id = $row->user_id;
                            $_SESSION["profil_id"] = $profil_id;
                            $nickname = $row->nickname;
                            $picture = $row->picture;
                            $hometown = $row->home_town;
                            $description = $row->description;
                            $sql = "SELECT name  FROM  `location` WHERE location_id = $hometown";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_object($result);
                            $hometown = $row->name;
                            $sql = "SELECT COUNT(creator) as count FROM  `article` WHERE creator = $profil_id And activation = true";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_object($result);
                            $anzahlArtikel = $row->count;
                             $sql = "SELECT COUNT(user_id_other) as count FROM  `user_follow` WHERE user_id_other = $profil_id";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_object($result);
                            $anzahlFollower = $row->count;
                             $sql = "SELECT COUNT(user_id_self) as count FROM  `user_follow` WHERE user_id_self = $profil_id";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_object($result);
                            $anzahlFollowing = $row->count;
                              $followtext = "no sql";
                            $sql = "SELECT * FROM  `user_follow` WHERE user_id_self = $user_id AND user_id_other = $profil_id;";
                            $data = mysql_query($sql);
                             $row = mysql_fetch_object($data);
                            if (empty($row)) {
                                $followtext = "Folgen";
                            } else {
                                $followtext = "Entfolgen";
                            }
                             $sql = "SELECT count(DISTINCT data_1) AS count FROM  `log_db` WHERE user_id = $profil_id AND action_id = 3;";
                            $data = mysql_query($sql);
                             $row = mysql_fetch_object($data);
                           
                          $read = $row->count;
                         
                            
                            
                    if($user_id == $profil_id )
                    {
                       
                        ?>
                    
                    
                      <section> <div id="mypaperly_edit"> <a href="/einstellungen" t><input id="mypaperly_edit_button" type="submit" name="" value="Einstellungen"/></a>
                           
                            </div>
                          <div id="mypaperly_edit"> <a  href="/abmelden" ><input id="mypaperly_edit_button" type="submit" name="" value="Abmelden"/></a>
                           
                            </div>
                           
                       </section>
                    
                    
                    <?php  }?>
                    <section>
                       <div class="content-info">
                           <div id="profilicon"></div>
                            <div id="profilname"><h1><?php echo $nickname; ?></h1>
                            </div>
                             <hr>
                                 <div class="userprofil_left">
                                     <img id="profilbild" src="<?php echo $picture; ?>" height="250" width="250"/>
                                      <a href='javascript:follow_add(<?php echo $profil_id; ?>);'><input  id="follow_button" type="submit" name="" value="<?php echo $followtext; ?>"/></a>

                            </div>
                               <div class="userprofil_right">
                                   
                                   <div id="user_badges">
                                       <h2></h2>
                                     
                                   </div>
                                   <div id="user_linelist_left">
                                     <div id="user_line"><div id="user_count_left">Follower:</div><div id="user_count_right"><?php echo $anzahlFollower; ?></div></div> 
                                     <div id="user_line"><div id="user_count_left">Following:</div><div id="user_count_right"><?php echo $anzahlFollowing; ?></div></div> 
                                        
                                  
                                   </div>
                                   <div id="user_linelist_right">
                                      <div id="user_line"><div id="user_count_left">Verfasste Artikel:</div><div id="user_count_right"><?php echo $anzahlArtikel; ?></div></div> 
                                     <div id="user_line"><div id="user_count_left">Gelesene Artikel:</div><div id="user_count_right"><?php echo $read; ?></div></div> 
                                       
                                   </div>
                                   <div id="user_description">
                                       <p><?php echo $description; ?></p>
                                   </div>
                               </div>
                           <h1>Nachrichten von <?php echo $nickname; ?></h1>
                             <hr>
                            
                       
                       </div>
                                </section>                

                    <div id="notificationbox">Bitte fülle folgendes Formular aus</div>
                    <div id="content-column">
                        <section>
                           
                           
                        
                            
                     
                                        <div id="timeline-articlelist">
                                           <?php
                            // TODO: get location filter
                            // set default item if POST var is undefined
                            // TODO: get default theme, including nav selection
                            // get query
                            $sql1 = "SELECT article.topic, article.article_id AS article_id,article.creator, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event  FROM article where creator = $profil_id  And activation = 1";

                            //$i = 1;
                            /* while($i < count($artikel_array)) {
                              $art_id = $artikel_array[$i];
                              $sql1 = $sql1 . "," . $art_id . " ";
                              $i++;
                              } */

                            // $varLoadLimit = 10;

                            $sql1 = $sql1 . " ORDER BY timestamp_creation DESC, article_id ASC  LIMIT " . $varLoadLimit . ";";

                            //$sql1 = load_abo_sql($start_location, $start_theme,$last_art);

                            $i = 1;
                            /* while($i < count($artikel_array)) {
                              $art_id = $artikel_array[$i];
                              $sql1 = $sql1 . "," . $art_id . " ";
                              $i++;
                              } */

                            // $varLoadLimit = 10;
                            //$sql1 = $sql1." ORDER BY timestamp_creation DESC, article_id ASC  LIMIT " . $varLoadLimit . ";";
                            // TESTING
                            //echo $sql1;
                            //$result1 = mysql_query($sql1);
                            //$row1 = mysql_fetch_object($result1);
                            //$sql = "SELECT topic,article_text,source,timestamp_event FROM  `article` LIMIT 100;" ;
                            $result44 = mysql_query($sql1);
                            $count = 0;

                            // format result
                            while ($row = mysql_fetch_object($result44)) {

                                   echo load_article_html($row->topic,$row->article_text,$row->article_id,$row->source,$row->creator,$row->image,$row->date);


                                //ads
                                if ($count == 4) {
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
                            if ($count == 0)
                                echo '<div class="timeline-article-status"><p>KEINE ARTIKEL VORHANDEN</p></div>';
                            ?></div>

                                        <!-- TODO: GET vars including lastArticelID -->
                                        <!-- TODO:  -->
                                        <nav id="page-nav">
                                            <a href="php/load_profil.php?page=2"></a>
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
                                            $(function() {

                                                var $container = $('#timeline-articlelist');

                                                $container.imagesLoaded(function() {
                                                    $container.masonry({
                                                        itemSelector: '.timeline-article',
                                                        columnWidth: 300,
                                                       
                                                        gutterWidth: 20
                                                    });
                                                });

                                                // begin infinity scroll, fixed code, loading per php --> GET Var
                                                $container.infinitescroll({
                                                    navSelector: '#page-nav', // selector for the paged navigation 
                                                    nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
                                                    itemSelector: '.timeline-article', // selector for all items you'll retrieve
                                                    loading: {
                                                        finishedMsg: 'Keine weiteren Artikel.',
                                                        img: 'http://i.imgur.com/6RMhx.gif'
                                                    }
                                                },
                                                // trigger Masonry as a callback
                                                function(newElements) {
                                                    // hide new items while they are loading
                                                    var $newElems = $(newElements).css({opacity: 0});
                                                    // ensure that images load before adding to masonry layout
                                                    $newElems.imagesLoaded(function() {
                                                        // show elems now they're ready
                                                        $newElems.animate({opacity: 1});
                                                        $container.masonry('appended', $newElems, true);
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
                                                    'padding': 0,
                                                    'margin': 0,
                                                    'width': 875,
                                                    'height': '90%',
                                                    fitToView: false,
                                                    autoSize: false,
                                                    beforeClose: function() {
                                                        parent.history.pushState(null, 'paperly', 'http://localhost/<?php echo $nickname; ?>');
                                                    }
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
                                                <div id="footer-column">
<?php echo getDocumentFooter(); ?>
                                                </div>
                                            </div>
                                        </footer>
                                        </body>
                                        </html>
