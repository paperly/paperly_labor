<?php
session_start();
// get db connection
include "php/config.php";
include "php/functions.php";
include "php/functionsTimeline.php";
$user_id = $_SESSION["user_id"];
// global values
$target = 'search';
$articleTextLength = 160;
$articleLinkLength = 18;
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
        echo getHeaderConfig('Timeline');
        echo getMetaTags();
        ?>        
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <script src="js/libs/timeline/timelineClass.js"></script>

        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
        <!--  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <!-- search locations -->
        <script src="php/getFilterLocations.php" type="text/javascript"></script>
        <script src="js/libs/location/locationClass.js" type="text/javascript"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <!-- fancybox -->
        <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.4"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
        <!-- masonry -->
        <script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
        <script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>
        <script type="text/javascript" src="js/libs/jquery.infinitescroll.min.js"></script>
        <!-- social -->
        <script type="text/javascript" src="js/libs/timeline/like.js"></script>
        <script src="js/libs/profil/followClass.js"></script>
        <!-- document ready functions --> 
        <script>
            $(document).ready(function() {
                $("#selectedKeyword").autocomplete({
                    autoFocus: true,
                    minLength: 3,
                    source: availableLocations,
                    select: function(event, ui) {
                        // get selected values
                        var selectedObj = ui.item;
                        var index = availableLocations.indexOf(selectedObj.value);
                        var locationID = availableLocationsByID[index][0];
                        var locationName = availableLocationsByID[index][1];
                        // set properties
                        var linkContainer = 'location-box-result-links';
                        var infoContainer = 'location-box-result-info';
                        var infoContainerText = 'Weitere Gemeinden einfach per Suchfunktion wählen';
                        var inputValues = 'inputSelectedNavItemLocation';
                        var valueSeparator = ';';
                        setLocationProperties(linkContainer, infoContainer, infoContainerText, inputValues, valueSeparator);
                        // append link element
                        //addSelectedLocationLinkSingle(locationID, lacationName);
                        // append input value
                        addSelectedLocationInputValueSingle(locationID);
                        // null input after select
                        //submit location select
                        selectNavigationItemLocation(locationID);
                        $(this).val("");
                        return false;
                    }
                });

                $('.fancybox').fancybox({
                    'padding': 0,
                    'margin': 0,
                    'width': 875,
                    'height': '90%',
                    fitToView: false,
                    autoSize: false,
                    beforeClose: function() {
                        parent.history.pushState(null, 'paperly Artikel', 'http://<?php echo $basedir; ?>/search');
                    }
                });
            });

            $(document).ready(function() {
                //  Simple image gallery. Uses default settings
                $('.fancybox2').fancybox({
                    'padding': 0,
                    'margin': 0,
                    'width': 875,
                    'height': '90%',
                    fitToView: false,
                    autoSize: false,
                    beforeClose: function() {
                        parent.history.pushState(null, 'paperly Artikel', 'http://<?php echo $basedir; ?>/search');
                    }
                });
            });
        </script>
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
    <?php
    $art_id = $_GET["artid"];
    if (!empty($art_id)) {
        echo "<a class='fancybox2 fancybox.iframe' href='article.php?artid=" . $art_id . "' target='_new' ></a>";
    }
    ?>
    <body id="timeline" onLoad="<?php
    if (!empty($art_id)) {
        echo "javascript: $('.fancybox2').trigger('click');";
    }
    ?>">
<?php /* set docuemnt header, check functions.php */ if (isset($_SESSION["user_id"])) echo getDocumentHeaderLoggedIn('timeline', $_SESSION["user_id"], $pdoConnection); ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"><a href="index.php"><img src="images/design/logo.png" height="54" alt="paperly"></a></div>
                            <div id="header-papercontrolbox">
                                <!--<div class="header-papercontrolbox-content">Speichere Deine aktuelle Auswahl als Paper: </div>-->
                            </div>
                        </div>
                        <div id="header-location-box">
                            <nav role="navigation" id="nav-filter">

                                <h2>Durchsuche paperly:</h2>

                                <?php
                                if (empty($_POST["searchkeyword"])) {
                                    $searchkeyword = "Suchbegriff hier eintragen";
                                } else {
                                    $searchkeyword = $_POST["searchkeyword"];
                                }
                                $sql = "SELECT name FROM location WHERE location_id = $start_location;";
                                $ergebnis = mysql_query($sql);
                                $row = mysql_fetch_object($ergebnis);
                                $location_name = $row->name;

                                $sql = "SELECT * FROM  `location_follow` WHERE user_id_self = $user_id AND location_id = $start_location;";
                                $data = mysql_query($sql);
                                $row = mysql_fetch_object($data);
                                ?>

                                <div class="location-box">
                                    <div id="location-box-search">
                                        <form action="<?php echo $target ?>"method="post">

                                            <input id="searchLocation" class="field" type="text" value="" autofocus placeholder="<?php echo $searchkeyword; ?>" name="searchkeyword">
                                            <input id="submit" class="follow_button_location" type="submit" name="" value="Suchen"/>
                                        </form>

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
                            <div id="submitFilter" style="display: none">
                                <form name="formArtikelFilter" enctype="multipart/form-data" class="submitfilter_form" action="<?php echo $target ?>" method="post">

                                    <input id="selectedKeyword" type="hidden" name="selectedKeyword" value="<?php echo $_POST["selectedNavItemLocation"]; ?>">

                                    <!-- TODO: set add location filter -->
                                </form>
                            </div>


                            <div id="timeline-articlelist">

                        




                                <?php
// TODO: get location filter
// set default item if POST var is undefined
// TODO: get default theme, including nav selection
//$start_theme = 1;
// display nulled filter
//if($count == 0) echo '<div class="timeline-article-status"><p>BITTE WÄHLEN SIE EINE KATEGORIE</p></div>';
//$start_location = 1;
// set filter item
                                $start_theme = 0;


// get query
// prüfen ob location deutschland ist -> performance
                                if (!empty($_POST["searchkeyword"])) {
                                    $sql1 = "SELECT  article.topic, article.creator,article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
                                        FROM article
                                        WHERE article.topic like '%$searchkeyword%' OR article.article_text like '%$searchkeyword%' AND article.activation = true ";
                                }


                                $sql1 = $sql1 . " ORDER BY timestamp_creation DESC, article_id ASC  LIMIT " . $varLoadLimit . ";";
                                $abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
                                $ergebnis1 = mysql_query($abfrage1);
                                $row = mysql_fetch_object($ergebnis1);
                                $maxid = $row->maxid;
                                $maxid++;
                                $user_id = $_SESSION["user_id"];
                                $abfrage2 = "INSERT INTO log_db (id, action_id, user_id, data_1, data_2) VALUES ('$maxid',5,'$user_id','$start_location','$start_theme');";
                                mysql_query($abfrage2);
//$sql1 = load_abo_sql($start_location, $start_theme,$last_art);
                                $_SESSION['search'] = $searchkeyword;

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
//echo $sql1;
                                $result44 = mysql_query($sql1);
                                $count = 0;
// format result

                                while ($row = mysql_fetch_object($result44)) {
                                    echo load_article_html($row->topic, $row->article_text, $row->article_id, $row->source, $row->creator, $row->image, $row->date);

while ($row = mysql_fetch_object($result44)) {
          echo load_article_html($row->topic,$row->article_text,$row->article_id,$row->source,$row->creator,$row->image,$row->date);

    
    //ads
    if ($count == 2) {
        /*
          $adv = '<div class="post" style="height:300px;">
          <p  align="justify"  style="padding:10px;">WERBUNG </p>
          <p><img src="bayern.jpg"/ height="200px" > </p>
          </div>';
          echo $adv;
         */
        echo get_socialad();
        $count = 0;
    }
    $count++;
    //end ads
}
// display nulled article list




                                
                        //beginn social ads
                                if ($count == 5) {

                                    echo get_socialad();
                                    $count = 0;
                                }
                                $count++;
                                //end ads 
                            

                                }
// display nulled article list
                          ?>


                            </div>
                            <!-- TODO: GET vars including lastArticelID -->
                            <!-- TODO:  -->
                            <nav id="page-nav">
                                <a href="php/load_search.php?page=2"></a>
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
        <!--<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>-->

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
                    donetext: null,
                    loadingText: null,
                    loadingImg: null,
                    bufferPx: 500
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
                        //alert("jetzt ordnen");
                    });
                }
                );
            });
        </script>
        <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.2" media="screen" />
        <style type="text/css">
            .fancybox-custom .fancybox-skin {
                box-shadow: 0 0 50px #222;
            }
        </style>
        <footer class="no-print">
            <div class="wrapper clearfix">
                <div id="footer-column"><?php echo getDocumentFooter(); ?></div>
            </div>
        </footer>
    </body>
</html>
