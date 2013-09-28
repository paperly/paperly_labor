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
$paper_id = $_GET["paper_id"];
$_SESSION["paper_id"] = $paper_id;
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
        <script src="php/getTimelineNavigation.php" type="text/javascript"></script>
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
                            <div id="header-papercontrolbox">
                                <!--<div class="header-papercontrolbox-content">Speichere Deine aktuelle Auswahl als Paper: </div>-->
                            </div>
                        </div>
                        <!--<div id="header-navbox"></div>-->
                    </div>
                </div>
            </header>
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                    <div id="notificationbox">Bitte fülle folgendes Formular aus</div>
                    <div id="content-column">
                        <section>
                            <?php
                            // get paper title, default: paper id
                            $selectedPaperTitle = $paper_id;
                            try {
                                // get paper title
                                $stmtLabel = $pdoConnection->prepare('SELECT label FROM paper WHERE paper_id = :id');
                                $stmtLabel->setFetchMode(PDO::FETCH_OBJ);
                                $stmtLabel->execute(array(':id' => $paper_id));
                                while ($row = $stmtLabel->fetch()) {
                                    $selectedPaperTitle = $row->label;
                                }
                                // set controls
                            } catch (PDOException $e) {
                                // TODO: display error
                                //echo 'ERROR: ' . $e->getMessage();
                            }
                            ?>
                            <a href="filter.php"><h1>Paper: <?php echo $selectedPaperTitle; ?></h1></a>
                            <div id="submitFilter" style="display: none">
                                <form name="formArtikelFilter" enctype="multipart/form-data" class="submitfilter_form" action="<?php echo $target ?>" method="post">
                                    <input id="inputSelectedNavItem" type="hidden" name="selectedNavItem" value="">
                                    <!-- TODO: set add location filter -->
                                </form>
                            </div>
                            <div id="timeline-articlelist"><?php
                                // TODO: get location filter
                                // set default item if POST var is undefined
                                // TODO: get default theme, including nav selection
                                // get query
                                $sql1 = load_paper_sql_v2($paper_id);

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

                                    $title = $row->topic;
                                    $link = $row->source;
                                    $_SESSION['last_art'] = $row->article_id;
                                    $art_id = $row->article_id;
                                    // TODO: strip text, add 'weiterlesen' --> shadowbox
                                    //$text = substr($row->article_text, 0, 150);
                                    $text = stripArticleText($row->article_text, $articleTextLength, $art_id);

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
                                    $secs = $diff;
                                    $days = intval($secs / (60 * 60 * 24));
                                    $secs = $secs % (60 * 60 * 24);
                                    $hours = intval($secs / (60 * 60));
                                    $secs = $secs % (60 * 60);
                                    $mins = intval($secs / 60);
                                    $secs = $secs % 60;
                                    if (strlen($hours) == 1)
                                        $hours = "" . $hours;
                                    if (strlen($mins) == 1)
                                        $mins = "" . $mins;
                                    if (strlen($secs) == 1)
                                        $secs = "" . $secs;
                                    if ($hours == 0)
                                        $time = "vor " . $mins . " Minuten";
                                    else
                                        $time = "vor " . $hours . " Stunden ";


                                    if ($diff >= 86400) {
                                        $time = date('d.m.Y H:i', $btime);
                                    }
                                    
                                    // TESTING: get values by article query
                                    //$time = 'Vor 10 Minuten';
                                    //$time = dateDiff("now", "now +2 months");
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
                                <a href="php/load_paper.php?page=2"></a>
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
                        parent.history.pushState(null, 'paperly Artikel', 'http://prebeta.paperly.de/index.php');
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
