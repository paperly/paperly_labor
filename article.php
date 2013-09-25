<?php
session_start();
$user_id = $_SESSION["user_id"];
include "php/functions.php";
include "php/config.php";
$art_id = $_GET["artid"];





$abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
$ergebnis1 = mysql_query($abfrage1);
$row = mysql_fetch_object($ergebnis1);
$maxid = $row->maxid;

$maxid++;


$abfrage = "INSERT INTO log_db (id, action_id, user_id, data_1) VALUES ('$maxid',3,'$user_id','$art_id');";



mysql_query($abfrage);



$sql = "SELECT * FROM article WHERE article_id = " . $art_id;

$result = mysql_query($sql);
$row = mysql_fetch_object($result);
//$text = $row->article_text;
$topic = $row->topic;
$text = $row->article_text;
$image = $row->image;
$date = strtotime($row->timestamp_creation);
$creator = $row->creator;

$t = date('N', $date);
$wochentage = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag');
$wochentag = $wochentage[$t - 1];

$time = date('d.m.Y H:i', $date);
$time = $wochentag . ", " . $time . " Uhr";
//echo "<h1>".$topic."</h1>";

if ($creator == -1) {
    echo " <script type='text/javascript'> parent.$.fancybox.close(); </script>";
}


//echo '<div class="fb-like" data-href="http://prebeta.paperly.de/start.php?artid='.$art_id.'" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>';
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
    <!--<![endif]--><head>
        <base href="http://localhost">

        <meta charset="utf-8">
    </head>

    <link rel="stylesheet" href="css/style_article.css" media="screen,projection">
    <!-- social -->
    <script type="text/javascript" src="js/libs/timeline/like.js"></script>
    <script src="js/libs/profil/followClass.js"></script>
    <script src="js/libs/comment/commentClass.js"></script>
    <body>
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
        <script type="text/javascript">
            <!--
        if (self == top) {
                window.location.href = 'index.php';
            }


            //-->

        </script> 
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
        <script type = 'text/javascript'>
            if (typeof history.pushState !== "undefined") {
                parent.history.pushState(null, 'paperly Artikel', '<?php echo "http://localhost/article/" . $art_id . ""; ?>');
            }
        </script> 

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
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
                <?php
                $sql_bild = "SELECT * FROM `ersatzbilder` WHERE name = '" . substr($image, 0, -4) . "'";
                $result_bild = mysql_query($sql_bild);
                $quellen_bild = "";
                $bild_link = "http://localhost";
                $bild_fotograf = "paperly User";
                $bild_quelle = "paperly";
                $row_bild = mysql_fetch_object($result_bild);
                if (!empty($row_bild)) {

                    $bild_link = $row_bild->link;
                    $bild_fotograf = $row_bild->fotograf;
                    $bild_quelle = $row_bild->quelle;
                    $bild_name = "$bild_fotograf / $bild_quelle";
                    $quellen_bild = '</br>Bild: <a  href="' . $bild_link . '" title="Bildverweis" target="_new">' . $bild_name . '</a>';
                    echo $quellen_bild;
                }


                //$user_id = $_SESSION["user_id"];
                $like = load_likebox($user_id, $art_id);
                
                
                $sql = "SELECT * FROM `user` WHERE user_id = '" . $creator . "'";
                $result = mysql_query($sql);
               $row = mysql_fetch_object($result);

                  $creator_name = $row->nickname;
                
           
               
                
                
                ?>
<? /* <p><div class="fb-like" data-href="http://www.paperly.de/prebeta/?artid=<?php echo $art_id; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div> </p> */ ?>

                <div class="likebox" id="likebox_<?php echo $art_id; ?>"><?php echo $like; ?></div>
                <div class="article-post-time">
                    <a target="_parent" href="/<?php echo $creator_name; ?>"><?php echo $creator_name; ?></a> am <?php echo $time; ?>
                </div>
                <p><?php echo $text; ?></p>
                <p><a href="./promote_article.php?id=<?php echo $art_id; ?>"> </a></p>

                <?php
               
                
                
                if(isset($_SESSION["user_id"])) {
                ?>
                <textarea id="commentfield"  name="comment" placeholder="Schreibe ein Kommentar" value=""></textarea> 
                 <a id="commentsubmit" href="javascript:add_comment(<?php echo $art_id; ?>);"value="Absenden ">Absenden</a>
                 <div id="commentbox"><?php echo load_commentbox_html($art_id);?></div>
                     
                     <?php
                    
                }
                
                
                
                ?>
                
                
                
                
                
                
                
                
                
            </div>
        </div>
        <div class="article_r">

            <h3>Empfohlene Artikel:</h3>




            <?php
            $abfrage = "SELECT * FROM article WHERE not creator = -1 ORDER BY RAND() LIMIT 6;";
            $ergebnis = mysql_query($abfrage);
            while ($row = mysql_fetch_object($ergebnis)) {
                $topic = $row->topic;
                $artid = $row->article_id;
                //$topic = substr($topic, 0, 35).".."; class='fancybox fancybox.iframe
                echo "<p><a href='article.php?artid=" . $artid . "' target='_self'>" . $topic . "</a></p>";
            }
            ?>



        </div>









    </body>
</html>