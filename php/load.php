 <?php
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
        include ".../php/config.php";
        include "../php/functions.php";
        include "../php/functionsTimeline.php";
        // global values

        $articleTextLength = 150;
        $articleLinkLength = 18;
        ?>

        <div id="timeline-articlelist" >

            <?php
            // TODO: get location filter
            $start_location = 1;

            // set default item if POST var is undefined
            // TODO: get default theme, including nav selection
            if (0 != 0) {
                //$start_theme = 1;
                // display nulled filter
                if ($count == 0)
                    echo '<div class="timeline-article-status"><p>BITTE WÄHLEN SIE EINE KATEGORIE</p></div>';
            }
            else {
                // set filter item

                $start_location = $_SESSION['start_location'];
                $start_theme = $_SESSION['start_theme'];
                // get query
                $last_art = $_SESSION['last_art'];

                
                
                if ($start_location == 1) {
    $sql1 = "SELECT  article.topic, article.article_id AS article_id,article.creator, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
                                        FROM article
                                        WHERE article.activation = true ";
} else {
   $sql1 = "SELECT DISTINCT article_locations_belongs_to.article, article.topic, article.article_id AS article_id,article.creator, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
                                        FROM article_locations_belongs_to 
                                        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
                                        INNER JOIN article_themes_belongs_to 
                                        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
                                        WHERE article.activation = true AND article_locations_belongs_to.location 
                                        IN (SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $start_location . " )) )
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $start_location . " ))
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location  WHERE location_id = " . $start_location . ")
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE location_id = " . $start_location . ")";
    
    
}

                //$sql1 = load_abo_sql_v2($start_location, $start_theme,$last_art);
              /*  $sql1 = "SELECT DISTINCT article_locations_belongs_to.article,article.creator, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
                                        FROM article_locations_belongs_to 
                                        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
                                        INNER JOIN article_themes_belongs_to 
                                        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
                                        WHERE article.activation = true AND article_locations_belongs_to.location 
                                        IN (SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $start_location . " )) )
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $start_location . " ))
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE super_location IN (SELECT location_id FROM location  WHERE location_id = " . $start_location . ")
                                        UNION
                                        SELECT location_id
                                        FROM location
                                        WHERE location_id = " . $start_location . ")";
                $i = 1;

*/

                $pagenummer = $_GET["page"];
      
                $limit = ($pagenummer * $varLoadLimit) - $varLoadLimit;



                /* if( $_SESSION['start_theme'] == 1)
                  {
                  $sql1 = "SELECT  article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event
                  FROM article
                  WHERE article.activation = true ";
                  } */


                $sql1 = $sql1 . " ORDER BY timestamp_creation DESC LIMIT " . $limit . "," . $varLoadLimit . ";";
       //$sql1 = $sql1 . " ORDER BY timestamp_event DESC LIMIT 5;";

                // TESTING
                //echo $sql1;
                //$result1 = mysql_query($sql1);
                //$row1 = mysql_fetch_object($result1);
                //$sql = "SELECT topic,article_text,source,timestamp_event FROM  `article` LIMIT 100;" ;
// log start			  
                $logdatei = fopen("../log/logfile.txt", "a");
                fputs($logdatei, "start - " . date("d.m.Y, H:i:s", time()) . "\n"
                );
                fclose($logdatei);

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
            }
            //log ende
            $logdatei = fopen("../log/logfile.txt", "a");
            fputs($logdatei, "ende - " . date("d.m.Y, H:i:s", time()) . "\n"
            );
            fclose($logdatei);
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
            $(function() {

                var $container = $('#timeline-articlelist');

                $container.imagesLoaded(function() {
                    $container.masonry({
                        itemSelector: '.timeline-article',
                        columnWidth: 100
                    });
                });

                $container.infinitescroll({
                    navSelector: '#page-nav', // selector for the paged navigation 
                    nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
                    itemSelector: '.box', // selector for all items you'll retrieve
                    donetext: null,
                    loadingText: null,
                    loadingImg: null
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





    </body>
</html>


<?php
$logdatei = fopen("../log/logfile.txt", "a");
fputs($logdatei, " \n"
);
fclose($logdatei);
?>