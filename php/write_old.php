<?php
session_start();
// get db connection
include "php/config.php";
include "php/functions.php";
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
        echo getHeaderConfig('Artikel schreiben');
        echo getMetaTags();
        ?>
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <!-- wysihtml5 parser -->
        <script src="js/libs/editor/parser_rules/advanced.js"></script>
        <!-- Library -->
        <script src="js/libs/editor/dist/wysihtml5-0.3.0.min.js"></script>
        <!-- theme lib --> 
        <script src="js/libs/theme/themeClass.js"></script>
        <!-- fancybox -->
        <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.4"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <link rel="stylesheet" type="text/css" href="js/libs/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        <script type="text/javascript" src="js/libs/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
        <style type="text/css">
            .fancybox-custom .fancybox-skin {
                box-shadow: 0 0 50px #222;
            }
        </style>
        <!-- search locations -->
        <script src="php/getFilterLocations.php" type="text/javascript"></script>
        <script src="js/libs/location/locationClass.js" type="text/javascript"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <!-- document ready functions --> 
        <script>
            $(document).ready(function() {

               

                $("#searchLocation").autocomplete({
                    autoFocus: true,
                    minLength: 3,
                    source: availableLocations,
                    select: function(event, ui) {
                        // get selected values
                        var selectedObj = ui.item;
                        var index = availableLocations.indexOf(selectedObj.value);
                        var locationID = availableLocationsByID[index][0];
                        var lacationName = availableLocationsByID[index][1];
                        // set properties
                        var linkContainer = 'location-box-result-links';
                        var infoContainer = 'location-box-result-info';
                        var infoContainerText = 'Weitere Städte einfach per Suchfunktion wählen';
                        var inputValues = 'location-box-result-input';
                        var valueSeparator = ';';
                        setLocationProperties(linkContainer, infoContainer, infoContainerText, inputValues, valueSeparator);
                        // append link element
                        addSelectedLocationLink(locationID, lacationName);
                        // append input value
                        addSelectedLocationInputValue(locationID);
                        // null input after select
                        $(this).val("");
                        return false;
                    }
                });

                $('.fancybox-themes').fancybox({
                    padding: 0,
                    margin: 0,
                    width: '80%',
                    height: '75%',
                    fitToView: false,
                    autoSize: false,
                    closeBtn: false,
                    type: 'iframe',
                    afterClose: function() {
                        // get themeflag / themeid
                        var themeFlag = document.getElementById(inputThemeFlag).value;
                        var selectedTheme = document.getElementById(inputSubThemeID).value;
                        // check methods
                        var openFancybox = '';
                        if (themeFlag == themeFlagOpenThemeBox)
                            openThemeSelect(false);
                        else if (themeFlag == themeFlagOpenSubThemeBox)
                            openSubThemeSelect(selectedTheme);
                        else {
                            var selectedThemes = getSelectedThemesInputValue();
                            updateThemeSelectInformation(selectedThemes);
                        }
                    }
                });

                $('.fancybox-subthemes').fancybox({
                    padding: 0,
                    margin: 0,
                    width: '600',
                    height: '215',
                    fitToView: false,
                    autoSize: false,
                    closeBtn: false,
                    type: 'iframe',
                    afterClose: function() {
                        // get themeflag / themeid
                        var themeFlag = document.getElementById(inputThemeFlag).value;
                        var selectedTheme = document.getElementById(inputSubThemeID).value;
                        // check methods
                        var openFancybox = '';
                        if (themeFlag == themeFlagOpenThemeBox)
                            openThemeSelect(false);
                        else if (themeFlag == themeFlagOpenSubThemeBox)
                            openSubThemeSelect(selectedTheme);
                        else {
                            // do nothing
                        }
                    }
                });
            });
        </script>
                   <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40911491-1', 'paperly.de');
  ga('send', 'pageview');

</script>
    </head>
    <body id="write">
        <?php /* set docuemnt header, check functions.php */ if (isset($_SESSION["user_id"])) echo getDocumentHeaderLoggedIn('write', $_SESSION["user_id"], $pdoConnection); ?>

        <!--        <div id="topbox" class="no-print">
                    <div class="wrapper">
                        <div id="topbox-column">
                            <nav role="navigation" id="nav-top">
                                <ul>
                                    <li class="first"><a href="index.php">Startseite</a></li>
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
                </div>-->
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"> <a href="index.php"><img src="images/design/logo.png" height="54" alt="paperly"></a> </div>
                            <div id="header-papercontrolbox"> </div>
                        </div>
                        <div id="header-navbox"> </div>
                    </div>
                </div>
            </header>
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                   
                    <div id="content-column">
                        <section>
                            <?php
                            $userid = $_SESSION["user_id"]; // Später durch session!
                            $check = false;
                            if (isset($_POST["check"])) {
                                $check = true;
                            }
                            if (!empty($_POST["tf_text"]) && !empty($_POST["tf_titel"]) && $check == true) {
                                $text = $_POST["tf_text"];
                                // böse zeichen entfernen
                                  $text = str_replace("'", "`", $text);
                                
                                
                                $topic = $_POST["tf_titel"];
                       
                                //GET Orte
                                $orte = array();
                                if (!empty($_POST["selectedLocations"])) {
                                    $selected_locations = $_POST["selectedLocations"];
                                    // get value separator @ 'var valueSeparator [61];'
                                    $orte = explode(';', $selected_locations);
                                }
                                // TODO: check nulled locations
                                else
                                    $orte[] = 1;
                                // id definieren
                                $result = mysql_query("SELECT MAX(article_id) AS 'id' FROM article ;");
                                $idmax = mysql_fetch_array($result);
                                $id = $idmax[id] + 1;
                                // Log_db Eintrag Thema Geschrieben (6)
                                $abfrage1 = "SELECT max(id) AS 'maxid' FROM log_db;";
                                $ergebnis1 = mysql_query($abfrage1);
                                $row = mysql_fetch_object($ergebnis1);
                                $maxid = $row->maxid;
                                $maxid++;
                                $user_id = $_SESSION["user_id"];
                                $abfrage2 = "INSERT INTO log_db (id, action_id, user_id, data_1, data_2) VALUES ('$maxid',6,'$user_id','$orte[0]','$themen[0]');";
                                mysql_query($abfrage);
                                // prüfen ob user rechte 1/2/3
                                $abfrage1 = "SELECT rights FROM user WHERE user_id = " . $user_id . ";";
                                $ergebnis1 = mysql_query($abfrage1);
                                $row = mysql_fetch_object($ergebnis1);
                                $rights = $row->rights;
                                // artikel activation setzen
                                if ($rights == 2 || $rights == 3) {
                                    $activation = true;
                                } else {
                                    $activation = false;
                                }
                                // article in db eintragen
                                
                                $sql = "INSERT INTO article (article_id, topic, article_text, creator, activation) VALUES ('$id','$topic','$text','$userid','$activation');";
                               echo $sql;
                                $eintragen = mysql_query($sql);
                                if ($eintragen == true) {
                                    //Ort+Thema
                                    save_article_themes($id, $themen);
                                    save_article_locations($id, $orte);
                                    echo "<div class='write_green'>Artikel wurde eingetragen.</div>";
                                    echo "<script language='javascript'>";
                                   // echo "window.location.href='index.php?artid=" . $id . "';";
                                    echo "</script>";
                                }
                                // Bild hochladen
                                if ($_FILES["datei"]["error"] != 0) {
                                    save_article_bild($id, $themen[0]);
                                }
                                if ($_FILES["datei"]["error"] != 0) {
                                    // Fals kein Bild mitgeschickt wurde soll er ein Standart Bild verwenden!!
                                    // Ende standartBild
                                } else {
                                    //$dateityp = GetImageSize($_FILES['datei']['tmp_name']);
                                    //if($dateityp[2] != 0)
                                    //{
                                    $dateityp = $_FILES['datei']['type'];
                                    if ($dateityp == "image/jpeg" || $dateityp == "image/png" || $dateityp == "image/png") {
                                        if ($_FILES['datei']['size'] < 20971520) {
                                            // jpeg abspeichern
                                            if ($_FILES['datei']['type'] == "image/jpeg") {
                                                $filename = "paperly_article_" . $id . ".jpg";
                                                move_uploaded_file($_FILES['datei']['tmp_name'], "upload/original/paperly_article_" . $id . ".jpg");
                                            }
                                            // ende jpeg
                                            // png abspeichern
                                            if ($_FILES['datei']['type'] == "image/png") {
                                                $filename = "paperly_article_" . $id . ".jpg";
                                                //move_uploaded_file($_FILES['datei']['tmp_name'], "upload/original/paperly_article_".$id.".jpg");
                                                $image = imagecreatefrompng($_FILES['datei']['tmp_name']);
                                                imagejpeg($image, "upload/original/paperly_article_" . $id . ".jpg", 100);
                                                imagedestroy($image);
                                            }
                                            // ende png
                                            // gif abspeichern
                                            if ($_FILES['datei']['type'] == "image/gif") {
                                                $filename = "paperly_article_" . $id . ".jpg";
                                                //move_uploaded_file($_FILES['datei']['tmp_name'], "upload/original/paperly_article_".$id.".jpg");
                                                $image = imagecreatefromgif($_FILES['datei']['tmp_name']);
                                                imagejpeg($image, "upload/original/paperly_article_" . $id . ".jpg", 100);
                                                imagedestroy($image);
                                            }
                                            // ende gif
                                            //resizeImage("images/upload/original/paperly_article_".$id.".jpg","images/upload/timeline/paperly_article_".$id.".jpg", 298,  -1);
                                            resizeImage("upload/original/paperly_article_" . $id . ".jpg", "upload/article/paperly_article_" . $id . ".jpg", 520, -1);
                                            //resizeImage("tut/".$savename.".jpg","tut/".$savename."2.jpg", 520,  0);
                                            // The file
                                            $filename = "upload/original/paperly_article_" . $id . ".jpg";
                                            // Set a maximum height and width
                                            $width = 298;
                                            // Content type
                                            // header('Content-Type: image/jpeg');
                                            // Get new dimensions
                                            list($width_orig, $height_orig) = getimagesize($filename);
                                            $ratio_orig = $width_orig / $height_orig;
                                            $height_big = $width / $ratio_orig;
                                            // Resample
                                            $image_1 = imagecreatetruecolor($width, $height_big);
                                            $image = imagecreatefromjpeg($filename);
                                            imagecopyresampled($image_1, $image, 0, 0, 0, 0, $width, $height_big, $width_orig, $height_orig);
                                            // nochaml setzen
                                            $width = 298;
                                            $height = 298;
                                            $ycord = ($height_big / 2) - $height;
                                            if ($ycord < 0) {
                                                $ycord = 0;
                                            }
                                            $image_p = imagecreatetruecolor($width, $height);
                                            imagecopyresized($image_p, $image_1, 0, 0, 0, $ycord, $width, $height, $width, $height);
                                            // Output
                                            //imagejpeg($image_p, null, 100);
                                            // my  tests
                                            // Das Bild als 'simpletext.jpg' speichern
                                            imagejpeg($image_p, "upload/timeline/paperly_article_" . $id . ".jpg");
                                            // Den Speicher freigeben
                                            imagedestroy($image_p);
                                            imagedestroy($image_1);
                                            $filename = "paperly_article_" . $id . ".jpg";
                                            $sql = "UPDATE article SET image = '$filename'  WHERE article_id = '$id';";
                                            $result = mysql_query($sql);
                                        }
                                    } else {
                                        save_article_bild($id, $themen[0]);
                                    }
                                }
                                // Mail mit Anhang
                                $abfrage1 = "SELECT image  FROM article WHERE article_id = " . $id . ";";
                                $ergebnis1 = mysql_query($abfrage1);
                                $row = mysql_fetch_object($ergebnis1);
                                $image = $row->image;
                               
                                
                                
                                
                                $empfaenger = "mario.keller@paperly.de;martin.uebelhoer@paperly.de;oliver.pajunk@paperly.de;mariokeller@me.com";
                                $betreff = $id . " - Neuer Artikel auf paperly: " . $topic;
                                $pfad = "upload/article/" . $image;
                                $mailtext = "<b>Es wurde ein neuer Artikel veröffentlicht </br> Artikelnummer:</b> " . $id . "</br> <b>Titel:</b> " . $topic . "</br> " . $text . "</br><b>Artikelbild:</b> </br> <img src='http://prebeta.paperly.de/" . $pfad . "' />";
                                $from = "From: Paperly Server <mail@paperly.de>\n";
                                //$from .= "Reply-To: mail@paperly.de\n";
                                $from .= "Content-Type: text/html\n";
                              //  mail($empfaenger, $betreff, $mailtext, $from);



                         

                                
                            }
                            ?>
                   
                         
                            <div class="write_left">
                                <form class="write-article-form" name="formWriteArticle" action="write_article.php" method="post" enctype="multipart/form-data">
                                    <div class="write_left_list_first">
                                        <h7>Titel:</h7><b style=" color:#F00"> *</b>
                                        <input name="tf_titel" type="text" size="50" autofocus maxlength="50" class="write" required>
                                    </div>
                                    <div class="write_left_list_ort">
                                        <!-- TODO: required location id -->
                                        <h7>Stadt:</h7><b style=" color:#F00"> *</b>
                                        <div id="location-box">
                                            <div id="location-box-search">
                                                <input id="searchLocation" class="write"  type="text" value="" name="Location" >
                                            </div>
                                            <div id="location-box-result">                                                
                                                <div id="location-box-result-links"><!--selectedLocations--></div>
                                                <div id="location-box-result-info"><!--infoContainer--></div>
                                                <input id="location-box-result-input"  type="hidden" name="selectedLocations" value="">                      
                                            </div>
                                        </div>                                        
                                    </div>
                                       <div class="write_left_list">
                                        <h7>Artikelbild:</h7> 
                                        <input type="file" name="datei" class="write" required>
                                    </div>
                                    <div class="write_left_list_textarea" style="">
                                        <h7 style="float:left; ">Artikeltext: <b style=" color:#F00"> *</b></h7>
                                        <textarea id="texteditor" name="tf_text" cols="50" rows="10" class="write"></textarea>
                                    </div>
                                 
                                    
                                    

                                    <div class="write_left_list">
                                        <div style="width:300px; float:left;">
                                            <p><input type="checkbox" name="check" checked="checked" > Mit der Veröffentlichung akzeptiere ich die Nutzungsbedingungen und Datenschutzerklärung</p>
                                        </div>
                                        <div style="width:200px; float:right;">
                                            <button type="submit" name="speichern" value="speichern"  class="css3button">Artikel veröffentlichen</button>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    var editor = new wysihtml5.Editor("texteditor", {// id of textarea element
                                        toolbar: "wysihtml5-toolbar", // id of toolbar element
                                        parserRules: wysihtml5ParserRules // defined in parser rules set 
                                    });
                                </script>
                            </div>
                            <!--! /#write_left -->
                            <div class="write_right">
                                <h2 id="title_schreiben">3 Schritte zu Deinem Artikel</h2>
                              
                                <div class="write_right_list" >
                                    <div class="write_right_list_bild"><img src="images/check.png" width="32" height="32"></div>
                                    <div class="write_right_list_text">
                                        <h4>Titel</h4>
                                        <p>Dein Artikel benötigt einen aussagekräftigen Titel, damit er gefunden wird</p>
                                    </div>
                                </div>
                                <!--! /#write_right_list -->
                                <div class="write_right_list" >
                                    <div class="write_right_list_bild"><img src="images/check.png" width="32" height="32"></div>
                                    <div class="write_right_list_text">
                                        <h4>Bild</h4>
                                        <p>Das Bild gibt Deinem Artikel ein Gesicht</p>
                                    </div>
                                </div>
                                <!--! /#write_right_list -->
                                <div class="write_right_list" >
                                    <div class="write_right_list_bild"><img src="images/check.png" width="32" height="32"></div>
                                    <div class="write_right_list_text">
                                        <h4>Stadt</h4>
                                        <p>Ohne eine Stadt taucht Dein Artikel nicht im Newsfeed auf</p>
                                    </div>
                                </div>
                                <!--! /#write_right_list --> 
                            </div>
                            <!--! /#write_right --> 
                        </section>
                    </div>
                    <!-- /#content-column --> 
                </div>
                <!--! /#wrapper --> 
            </div>
            <!-- /#main --> 
        </div>        
        <!--! /#container -->
        <footer class="no-print">
            <div class="wrapper clearfix">
                <div id="footer-column"><?php echo getDocumentFooter(); ?></div>
            </div>
        </footer>
    </body>
</html>