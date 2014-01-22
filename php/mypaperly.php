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
$user_id = $_SESSION["user_id"];
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
        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <script src="js/libs/timeline/timelineClass.js"></script>
        <script src="php/getTimelineNavigation.php" type="text/javascript"></script>
        <!-- fancybox -->
        <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.4"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-40911491-1', 'paperly.de');
            ga('send', 'pageview');

        </script>
    </head>
        <?php $art_id = $_GET["artid"]; ?>
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
                             <!-- <div id="header-papercontrolbox">
                                <div class="header-papercontrolbox-content">Speichere Deine aktuelle Auswahl als Paper: </div>
                            </div>-->

                            <?php
// set docuemnt header, check functions.php
                            if (!isset($_SESSION["user_id"])){
                                echo getDocumentLogin();
                            }
                                else{
                                    
                                    //
                                    // my paperly INFOBOX START
                                    // 
                                    $sql = "SELECT nickname FROM user WHERE user_id = '$user_id';";
                                    $ergebnis = mysql_query($sql);
                                    $row = mysql_fetch_object($ergebnis);
                                    $username = $row->nickname;
                                    ?>
                                    <div id="header-infobox">
                                        Hallo <a href="/<?php echo $username; ?>"><?php echo $username; ?></a>,</br>
                                du hast  <a href="mypaperly">24 ungelesene Artikel</a></br>in 
                                    deinem Garten
                                    </div>
                                    <?php
                                    //
                                    // my paperly INFOBOX ENDE
                                    // 
                                }
                            ?>
                        </div>
                        <!--<div id="header-navbox"></div>-->
                        
                         <div id="header-navigation-box">
                            <nav role="navigation" id="nav-filter">

                                <p sytle="width:400px;">my paperly - dein persönlicher nachrichtengarten</p>

                                 
                                <div class="location-box">
                                    <div id="location-box-search">
                                      

                                        
                                        <a class="fancybox fancybox.iframe" href="php/mypaperly_following.php" target="_new"><input  id="button_a_mypaperlysetting" type="submit" name="" value="My paperly bearbeiten"/></a>
                                            <a href='/<?php echo $username; ?>'><input  id="button_a_profil" type="submit" name="" value="Profil"/></a>
                                            <a href='/abmelden'><input  id="button_a_logout" type="submit" name="" value="Logout"/></a>
                                   
                                    </div>
                                   
                                    <div id="location-box-result">
                                        <div id="location-box-result-info">
                                            <!--infoContainer-->
                                        </div>
                                    </div>
                                </div>  
                            </nav>                            
                        </div>
                        
                        
                        
                    </div>
                </div>
            </header>
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                    <div id="notificationbox">Bitte fülle folgendes Formular aus</div>
                    <div id="content-column">
                      
                        <section>


                            <h1></h1>
                            <div id="timeline-articlelist">
                      

                                <?php
                                // TODO: get location filter
                                // set default item if POST var is undefined
                                // TODO: get default theme, including nav selection
                                // get query
                                //  $sql1 = "SELECT article_text, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_creation,creator  FROM article WHERE activation = 1 AND creator In (SELECT user_id_other FROM user_follow WHERE user_id_self = $user_id) OR  article_id in In (SELECT user_id_other FROM user_follow WHERE user_id_self = $user_id)";

                                $sql1 = "SELECT article_text, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_creation,creator  FROM article WHERE activation = 1 AND creator In (SELECT user_id_other FROM user_follow WHERE user_id_self = $user_id) OR article_id IN (SELECT article FROM article_locations_belongs_to WHERE location IN (SELECT location_id FROM location_follow WHERE user_id_self = $user_id))";


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

                                    echo load_article_html($row->topic, $row->article_text, $row->article_id, $row->source, $row->creator, $row->image, $row->date);


                                    //beginn social ads
                                    if ($count == 5) {

                                        echo get_socialad();
                                        $count = 0;
                                    }
                                    $count++;
                                    //end ads
                                }

                                // display nulled article list
                                if ($count == 0)
                                    echo '<div class="timeline-article-status"><p>KEINE ARTIKEL VORHANDEN</p></div>';
                                ?>

                          


                            </div>

                            <!-- TODO: GET vars including lastArticelID -->
                            <!-- TODO:  -->
                            <nav id="page-nav">
                                <a href="php/load_mypaperly.php?page=2"></a>
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
                    itemSelector: '.timeline-article' // selector for all items you'll retrieve

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
                        parent.history.pushState(null, 'paperly Artikel', 'http://<?php echo $basedir; ?>/mypaperly');
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
