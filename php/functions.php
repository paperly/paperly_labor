<?php

include "config.php";
// = $_SESSION["user_id"];



function load_commentbox_html($article_id){
    $abfrage = "SELECT * FROM article_comment,user WHERE article_comment.user_id = user.user_id AND article_id = $article_id ORDER by timestamp DESC ;";
 $ergebnis = mysql_query($abfrage);
     while ($row = mysql_fetch_object($ergebnis)) {
                $text = $row->text;
                $user_name = $row->nickname;
                $date = strtotime($row->timestamp);
                $t = date('N', $date);
$wochentage = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag');
$wochentag = $wochentage[$t - 1];

$time = date('d.m.Y H:i', $date);
$time = $wochentag . ", " . $time . " Uhr";
              
             
                $html .= "<p><b><a target='_parent' href='/$user_name'>$user_name</a> am $time</b></br>";
                $html .= "$text</p>";
            }
            
            return $html;
}



function load_promotioncalcalation($months, $locations) {
    $html = "";

    $locations_array = str_getcsv($locations, ";");
    $count_locations = count($locations_array);

    // locations sortieren
    $locations_nation = array();
    $locations_state = array();
    $locations_distct = array();
    $locations_city = array();



    foreach ($locations_array as $location) {
        $sql = "Select location_id,name,location_level FROM location WHERE location_id = " . $location . ";";
        $result = mysql_query($sql);


       $row = mysql_fetch_object($result);



            $location_object = (object) array('id' => $row->location_id, 'location_level' => $row->location_level, 'location_name' => $row->name);
            if ($location_object->location_level == 3) {
                $locations_nation[] = $location_object;
            }

            if ($location_object->location_level == 4) {
                $locations_state[] = $location_object;
            }
            if ($location_object->location_level == 5) {
                $locations_distct[] = $location_object;
            }
            if ($location_object->location_level == 6) {
                $locations_city[] = $location_object;
            }
        


    }



        $count = 1;
        $sum = 0;
        
        // City
        foreach ($locations_city as $location) {
            if ($count == 1) {
                // first
                $betrag = 50;
            } else {
                //more
                $betrag = 30;
            }
            $html .= "<p>".$location->location_name." (Stadt): " . $betrag . "€</p>";
            $sum += $betrag;

            $count++;
        }
        // District
          foreach ($locations_distct as $location) {
           
                $betrag = 100;
            
            $html .= "<p>".$location->location_name." (Bezirk) :" . $betrag . "€</p>";
            $sum += $betrag;

        }
        // State
          foreach ($locations_state as $location) {
           
                $betrag = 250;
            
            $html .= "<p>".$location->location_name." (Bundesland) :" . $betrag . "€</p>";
            $sum += $betrag;

        }
        // Nation
          foreach ($locations_nation as $location) {
           
                $betrag = 500;
            
            $html .= "<p>".$location->location_name." (Nation) : " . $betrag . "€</p>";
            $sum += $betrag;

        }
        
        

        $sum_ges = $sum * $months;

        $date_start = date("d.m.Y", time());
        $date_end = date("d.m.Y", strtotime('+ ' . $months . ' months'));
        $html .= "<p>Zeitraum vom " . $date_start . " bis " . $date_end . "</p>";
        $html .= "<p>Monate: " . $months . "</p>";
        $html .= "<p>Kosten pro Monat: " . $sum . "€</p>";
        $html .= "<p>Kosten Gesamt: " . $sum_ges . "€</p>";








        return $html;
    }

    function create_article_html($title, $link, $art_id, $text, $bild, $date, $timestamp, $creator, $user_id) {



        $strippedlink = stripArticleLink($link, -1);
        $strippedlink_cropped = stripArticleLink($link, $articleLinkLength);
        // get timestamp
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

        //bild html
        $bild_html = "";
        if (empty($link)) {
            $bild_html = "<a class='fancybox fancybox.iframe' href='article.php?artid=" . $art_id . "' target='_new' ><img src='upload/timeline/$bild' width='300' height='95' alt='paperly'></a>";
        } else {
            $bild_html = "<a href='redirect.php?id=" . $art_id . "' target='_new' ><img src='upload/timeline/$bild' width='300' height='95' alt='paperly'></a>";
        }




        $like = load_likebox($user_id, $art_id);

        $html = '
                                    <article class="timeline-article">
                                     ' . $bild_html . '
                                      <h1>' . $title . '</h1>
                                      <p>' . $text . '</p>
                                          <div class="likebox" id="likebox_' . $art_id . '">' . $like . '</div>
                                       
                                      <div class="article-subbox">
                                            <div class="article-origin">
                                           ' . $quellen_text . '
                                             ' . $quellen_bild . '
                                            </div>
                                            
                                            <div class="article-post-time">
                                              ' . $time . '</br> ' . $creator . '
                                            </div>

                                      </div>
                                    </article>';
        
        
       
        return $html;
    }

    function load_likebox($user_id, $article) {
        $sql = "SELECT COUNT( article_id ) AS count  FROM  `likes` WHERE article_id = $article AND typ = 1;";
        $data = mysql_query($sql);
        $row = mysql_fetch_object($data);
        $anzahl = $row->count;
        $html = "<a href='javascript:like_add($user_id,$article);'> <div id='likebox_up' ></div></a><div id='likebox_count'>$anzahl</div>";
        $sql = "SELECT COUNT( article_id ) AS count  FROM  `likes` WHERE article_id = $article AND typ = 2;";
        $data = mysql_query($sql);
        $row = mysql_fetch_object($data);
        $anzahl = $row->count;
        $html .= "<a href='javascript:unlike_add($user_id,$article);'> <div id='likebox_down' ></div></a><div id='likebox_count'>$anzahl</div>";
        $sql = "SELECT COUNT( article_id ) AS count  FROM  `article_comment` WHERE article_id = $article;";
        $data = mysql_query($sql);
        $row = mysql_fetch_object($data);
        $anzahl = $row->count;   
        $html .= "<div id='likebox_comment' ></div><div id='likebox_count' name='Comments'>$anzahl</div>";
         
        return $html;
    }

    function get_socialad() {
        $ads_array = array();
        
        
      if (isset($_SESSION["user_id"])) {
   $ads_array[] = '<article class="timeline-article">
          <div id="socialad">
          <h1>Werde paperly!</h1>
          <p>Das Artikel schreiben hilft dir um alles in der richtigen ordnung Pflumen mit Äpfeln zu werden.</p>
       <button id="socialadsbutton" onclick="location.href='."'schreiben'".'">Artikel Schreiben</button>
          </div>
          </article>';
} 
        else
        {
               $ads_array[] = '<article class="timeline-article">
          <div id="socialad">
          <h1>Registriere Doch!</h1>
          <p>Hallo Waldtanne34 wir haben bei der registragtion...</p>
       <button id="socialadsbutton" onclick="location.href='."'start'".'">Jetzt Resigistrieren</button>
          </div>
          </article>';
         
            
        }
        
         
      
        
         



        return $ads_array[rand(0, count($ads_array) - 1)];
    }

    function save_article_bild($aid, $th) {
        $id_thema = $th;
        $art_id = $aid;

        //$result = mysql_query("SELECT name FROM ersatzbilder WHERE theme_id = $id_thema LIMIT 1;");
        //$row = mysql_fetch_object($result);
        //$bild_name = $row -> name;
        //echo "Themaid: ".$id_thema."</br>";
        $reply = mysql_query("SELECT bild_id FROM ersatzbilder WHERE theme_id = $id_thema;");

        $array = array();
        if (!empty($reply)) {
            while ($row = mysql_fetch_object($reply)) {
                $array[] = $row->bild_id;
            }
        }

        $zufallsid = $array[rand(0, count($array) - 1)];
        $sql = "SELECT name FROM ersatzbilder WHERE bild_id =" . $zufallsid;
        $reply = mysql_query($sql);
        if (!empty($reply)) {
            $row = mysql_fetch_object($reply);
        }

        $bild_name = $row->name;

        //echo "Bildname: ".$bild_name."</br>";

        if (empty($bild_name)) {
            $bild_name = "paperly_std_article_000";
        }
        $filename = $bild_name . ".jpg";

        echo "Bild: " . $filename . "</br>";

        $sql = "UPDATE article SET image = '$filename'  WHERE article_id = '$art_id';";
        $result = mysql_query($sql);
    }

    function checkmail($email) {
        if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) {
            $i = 1;
        } else {
            $i = 0;
        }
        return $i;
    }

    function load_paper_sql_v2($paper_id) {
        $sql1 = "SELECT DISTINCT article_locations_belongs_to.article, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
        FROM article_locations_belongs_to 
        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
        INNER JOIN article_themes_belongs_to 
        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
        WHERE article.activation = true ";

        $sqldb = "SELECT location, theme 
        FROM subscription 
        WHERE paper_id = '$paper_id'";
        $result = mysql_query($sqldb);

        // TESTING
        // reduce max location / theme selection
        // filter by max amount of selection
        $arrayLocation = array();
        $arrayThemes = array();
        $maxThemeCountOfLocation = 10;
        while ($row = mysql_fetch_object($result)) {
            $location = $row->location;
            $theme = $row->theme;
            // check exisiting theme count of location
            $currentThemeCountOfLocation = 0;
            for ($i = 0; $i < sizeof($arrayLocation); $i++) {
                if ($location == $arrayLocation[$i])
                    $currentThemeCountOfLocation++;
            }
            // add if count < maxThemeCount
            if ($currentThemeCountOfLocation <= $maxThemeCountOfLocation) {
                array_push($arrayLocation, $row->location);
                array_push($arrayThemes, $row->theme);
            }
        }

        for ($i = 0; $i < sizeof($arrayLocation); $i++) {
            if ($i == 0) {
                $op = "AND (";
            } else {
                $op = "OR";
            }
            $loc = $arrayLocation[$i];
            $theme = $arrayThemes[$i];
            $sql1 = $sql1 . " " . $op . " article_locations_belongs_to.location 
        IN (SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $loc . " )) )
        UNION
        SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $loc . " ))
        UNION
        SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location  WHERE location_id = " . $loc . ")
        UNION
        SELECT location_id
        FROM location
        WHERE location_id = " . $loc . ") AND article_themes_belongs_to.theme IN (SELECT theme_id
        FROM theme
        WHERE super_theme IN (SELECT theme_id FROM theme WHERE super_theme IN (SELECT theme_id FROM theme WHERE theme_id = " . $theme . " ))
        UNION
        SELECT theme_id
        FROM theme
        WHERE super_theme IN (SELECT theme_id FROM theme  WHERE theme_id = " . $theme . ")
        UNION
        SELECT theme_id
        FROM theme
        WHERE theme_id = " . $theme . ")";
            $i++;
        }

        $sql = $sql1 . ")";
        return $sql;
    }

    function load_paper_sql($pid) {
        $paperid = $pid;
        $sql = "SELECT DISTINCT article_locations_belongs_to.article, article.topic, DATE_FORMAT(article.timestamp_event, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.source, article.timestamp_event 
        FROM article_locations_belongs_to 
        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
        INNER JOIN article_themes_belongs_to 
        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
        WHERE ";

        $sql55 = "SELECT location, theme 
        FROM paper_subscriptions_has 
        INNER JOIN subscription ON subscription.subscription_id = paper_subscriptions_has.subscription_id 
        WHERE paper_subscriptions_has.paper_id = '$paperid'";
        $result55 = mysql_query($sql55);
        $e = 0;
        while ($row55 = mysql_fetch_object($result55)) {
            if ($e == 0) {
                $sql = $sql . "(";
            } else {
                $sql = $sql . "OR (";
            }

            $loc_a = $row55->location;
            $the_a = $row55->theme;
            $locations = load_location_ids($loc_a);
            $themes = load_theme_ids($the_a);

            $sql = $sql . "article_locations_belongs_to.location IN (" . $loc_a . " ";
            $i = 0;
            //TESTING: echo $locations;
            while ($i < count($locations)) {
                //TESTING: echo $id_array[$i]."<br>";
                $i++;
                $location_id = $locations[$i];
                //TESTING: echo $locations[$i];

                if (!empty($location_id)) {
                    $sql = $sql . ", $location_id ";
                }
            }

            $sql = $sql . ") AND article_themes_belongs_to.theme IN (" . $the_a . " ";
            //TODO: hier jetzt noch thema
            $i = 0;
            while ($i < count($themes)) {
                //TESTING: echo $id_array[$i]."<br>";
                $i++;
                $theme_id = $themes[$i];
                //TESTING: echo $locations[$i];
                if (!empty($theme_id)) {
                    $sql = $sql . ", $theme_id ";
                }
            }

            $sql = $sql . ")) ";
            $e++;
        }

        //TESTING: echo $sql;
        return $sql;
    }

    function load_abo_sql($startloc, $startthe, $last_art) {
        $loc = $startloc;
        $theme = $startthe;
        //$locations = load_location_ids($loc);
        $locations = array();
        $locations[] = 1;

        $themes = load_theme_ids($theme);
        $sql = "SELECT DISTINCT article_locations_belongs_to.article, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
        FROM article_locations_belongs_to 
        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
        INNER JOIN article_themes_belongs_to 
        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
        WHERE article.activation = true AND article_locations_belongs_to.location 
        IN (" . $loc . " ";
        //article.article_id > ".$last_art." AND
        $i = 0;
        //TESTING: echo $locations;
        while ($i < count($locations)) {
            //TESTING: echo $id_array[$i]."<br>";
            $i++;
            $location_id = $locations[$i];
            //TESTING: echo  $locations[$i];
            if (!empty($location_id)) {
                $sql = $sql . ", $location_id ";
            }
        }

        $sql = $sql . ") 
        AND article_themes_belongs_to.theme 
        IN (" . $theme . " ";
        //TODO: hier jetzt noch thema
        $i = 0;
        //TESTING: echo $locations;
        while ($i < count($themes)) {
            //TESTING: echo $id_array[$i]."<br>";
            $i++;
            $theme_id = $themes[$i];
            //TESTING: echo  $locations[$i];
            if (!empty($theme_id)) {
                $sql = $sql . ", $theme_id ";
            }
        }

        $sql = $sql . ")";

        //TESTING: echo $sql;
        return $sql;
    }

    function load_abo_sql_v2($startloc, $startthe, $last_art) {
        $loc = $startloc;
        $theme = $startthe;

        $sql = "SELECT DISTINCT article_locations_belongs_to.article, article.topic, article.article_id AS article_id, DATE_FORMAT(article.timestamp_creation, '%d.%m.%Y %H:%i') AS 'date', article.article_text, article.image, article.source, article.timestamp_event 
        FROM article_locations_belongs_to 
        INNER JOIN article ON article_locations_belongs_to.article = article.article_id 
        INNER JOIN article_themes_belongs_to 
        ON article_locations_belongs_to.article = article_themes_belongs_to.article 
        WHERE article.activation = true AND article_locations_belongs_to.location 
        IN (SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $loc . " )) )
        UNION
        SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location WHERE super_location IN (SELECT location_id FROM location WHERE location_id = " . $loc . " ))
        UNION
        SELECT location_id
        FROM location
        WHERE super_location IN (SELECT location_id FROM location  WHERE location_id = " . $loc . ")
        UNION
        SELECT location_id
        FROM location
        WHERE location_id = " . $loc . ") AND article_themes_belongs_to.theme IN (SELECT theme_id
        FROM theme
        WHERE super_theme IN (SELECT theme_id FROM theme WHERE super_theme IN (SELECT theme_id FROM theme WHERE theme_id = " . $theme . " ))
        UNION
        SELECT theme_id
        FROM theme
        WHERE super_theme IN (SELECT theme_id FROM theme  WHERE theme_id = " . $theme . ")
        UNION
        SELECT theme_id
        FROM theme
        WHERE theme_id = " . $theme . ")";

        //TESTING: echo $sql;
        return $sql;
    }

    function load_location_ids($start) {
        $start_id = $start;
        $id_array = array();
        $id_array[] = $start_id;
        $sql1 = "SELECT location_id, location_level 
        FROM `location` 
        WHERE location.super_location = '$start_id'";
        $result1 = mysql_query($sql1);
        while ($row1 = mysql_fetch_object($result1)) {
            $loc_id1 = $row1->location_id;
            $level1 = $row1->location_level;
            $id_array[] = $loc_id1;

            //TESTING: echo " > ".$loc_id1."<br>";
            $sql2 = "SELECT location_id, location_level 
            FROM `location` 
            WHERE location.super_location = '$loc_id1'";
            $result2 = mysql_query($sql2);
            while ($row2 = mysql_fetch_object($result2)) {
                $loc_id2 = $row2->location_id;
                $level2 = $row2->location_level;
                $id_array[] = $loc_id2;

                //TESTING: echo " >> ".$loc_id2."<br>";
                $sql3 = "SELECT location_id, location_level 
                FROM `location` 
                WHERE location.super_location = '$loc_id2'";
                $result3 = mysql_query($sql3);
                while ($row3 = mysql_fetch_object($result3)) {
                    $loc_id3 = $row3->location_id;
                    $level3 = $row3->location_level;
                    $id_array[] = $loc_id3;

                    //TESTING: echo " >>> ".$loc_id3."<br>";
                    $sql4 = "SELECT location_id, location_level 
                    FROM `location` 
                    WHERE location.super_location = '$loc_id3'";
                    $result4 = mysql_query($sql4);
                    while ($row4 = mysql_fetch_object($result4)) {
                        $loc_id4 = $row4->location_id;
                        $level4 = $row4->location_level;
                        $id_array[] = $loc_id4;
                        //TESTING: echo " >>>> ".$loc_id4."<br>";
                    }
                }
            }
        }

        // array ausgeben
        /*
          $i = 0;
          while($i < count($id_array))
          {
          echo $id_array[$i]."<br>";
          $i++;
          }
         */

        return $id_array;
    }

    function load_theme_ids($start) {
        $start_id = $start;
        $id_array = array();
        $id_array[] = $start_id;
        $sql1 = "SELECT theme_id, theme_level 
        FROM `theme` 
        WHERE theme.super_theme = '$start_id'";
        $result1 = mysql_query($sql1);
        while ($row1 = mysql_fetch_object($result1)) {
            $loc_id1 = $row1->theme_id;
            $level1 = $row1->theme_level;
            $id_array[] = $loc_id1;

            //TESTING: echo " > ".$loc_id1."<br>";
            $sql2 = "SELECT theme_id, theme_level 
            FROM `theme` 
            WHERE theme.super_theme = '$loc_id1'";
            $result2 = mysql_query($sql2);
            while ($row2 = mysql_fetch_object($result2)) {
                $loc_id2 = $row2->theme_id;
                $level2 = $row2->theme_level;
                $id_array[] = $loc_id2;

                //TESTING: echo " >> ".$loc_id2."<br>";
                $sql3 = "SELECT theme_id, theme_level 
                FROM `theme` 
                WHERE theme.super_theme = '$loc_id2'";
                $result3 = mysql_query($sql3);
                while ($row3 = mysql_fetch_object($result3)) {
                    $loc_id3 = $row3->theme_id;
                    $level3 = $row3->theme_level;
                    $id_array[] = $loc_id3;

                    //TESTING: echo " >>> ".$loc_id3."<br>";
                    $sql4 = "SELECT theme_id, theme_level 
                    FROM `theme` 
                    WHERE theme.super_theme = '$loc_id3'";
                    $result4 = mysql_query($sql4);
                    while ($row4 = mysql_fetch_object($result4)) {
                        $loc_id4 = $row4->theme_id;
                        $level4 = $row4->theme_level;
                        $id_array[] = $loc_id4;
                        //TESTING: echo " >>>> ".$loc_id4."<br>";
                    }
                }
            }
        }

        // array ausgeben
        /*
          $i = 0;
          while($i < count($id_array))
          {
          echo $id_array[$i]."<br>";
          $i++;
          }
         */

        return $id_array;
    }

    function get_artikelperabo_loc_theme($l_s, $t_s) {
        $start = $l_s;
        $theme = $t_s;
        $sql = "SELECT article_locations_belongs_to.article AS 'id' 
        FROM article_locations_belongs_to 
        WHERE (article_locations_belongs_to.location = '$start' ";
        $locations = array();
        $locations = load_location_ids($start);
        $i = 0;
        //TESTING: echo $locations;
        while ($i < count($locations)) {
            //TESTING: echo $id_array[$i]."<br>";
            $i++;
            $location_id = $locations[$i];
            //TESTING: echo  $locations[$i];
            if (!empty($location_id)) {
                $sql = $sql . "OR article_locations_belongs_to.location =  $location_id ";
            }
        }
        $sql = $sql . ")";

        //TESTING: echo $sql;
        $result = mysql_query($sql);
        $artikel_array = array();
        while ($row = mysql_fetch_object($result)) {
            $art_id = $row->id;
            //TESTING: echo $art_id."<br>";
            if (!in_array($art_id, $artikel_array, true)) {
                $artikel_array[] = $art_id;
            }
        }

        return $artikel_array;
    }

    function load_abo_articles($pstart, $ptheme) {
        $start = $pstart;
        $theme = $ptheme;
        if ($theme == 0) {
            $sql = "SELECT article_locations_belongs_to.article AS 'id' 
            FROM article_locations_belongs_to 
            WHERE article_locations_belongs_to.location 
            IN ($start ";
            $locations = array();
            $locations = load_location_ids($start);
            $i = 0;
            //TESTING: echo $locations;
            while ($i < count($locations)) {
                //TESTING: echo $id_array[$i]."<br>";
                $i++;
                $location_id = $locations[$i];
                //TESTING: echo $locations[$i];
                if (!empty($location_id)) {
                    $sql = $sql . ", article_locations_belongs_to.location =  $location_id ";
                }
            }
            $sql = $sql . ")";

            //TESTING: echo $sql;
            $result = mysql_query($sql);
            $artikel_array = array();
            while ($row = mysql_fetch_object($result)) {
                $art_id = $row->id;
                //TESTING: echo $art_id."<br>";
                if (!in_array($art_id, $artikel_array, true)) {
                    $artikel_array[] = $art_id;
                }
            }
        } else {
            $sql = "SELECT article_locations_belongs_to.article AS 'id' 
            FROM article_locations_belongs_to, article_themes_belongs_to 
            WHERE article_locations_belongs_to.article = article_themes_belongs_to.article AND article_locations_belongs_to.location 
            IN( $start ";
            $locations = array();
            $locations = load_location_ids($start);
            $i = 0;
            //TESTING: echo $locations;
            while ($i < count($locations)) {
                //TESTING: echo $id_array[$i]."<br>";
                $i++;
                $location_id = $locations[$i];
                //TESTING: echo  $locations[$i];
                if (!empty($location_id)) {
                    $sql = $sql . ", $location_id   ";
                }
            }

            $sql = $sql . " ) AND article_themes_belongs_to.theme IN ( $theme ";
            $themes = array();
            $themes = load_theme_ids($theme);
            $i = 0;
            //TESTING: echo $locations;
            while ($i < count($themes)) {
                //TESTING: echo $id_array[$i]."<br>";
                $i++;
                $theme_id = $themes[$i];
                //TESTING: echo $themes[$i];
                if (!empty($theme_id)) {
                    $sql = $sql . ", $theme_id   ";
                }
            }
            $sql = $sql . ") ";

            //TESTING: echo $sql;
            $result = mysql_query($sql);
            $artikel_array = array();
            while ($row = mysql_fetch_object($result)) {
                $art_id = $row->id;
                //TESTING: echo $art_id."<br>";
                if (!in_array($art_id, $artikel_array, true)) {
                    $artikel_array[] = $art_id;
                }
            }
        }

        return $artikel_array;
    }

    function get_paper_article_array($ppaper_id) {
        $paper_id = $ppaper_id;
        $artikel_array = array();
        $sql55 = "SELECT subscription_id 
        FROM `paper_subscriptions_has` 
        WHERE paper_id = '$paper_id'";
        $result55 = mysql_query($sql55);
        $subsription_array = array();
        while ($row55 = mysql_fetch_object($result55)) {
            $sub_id = $row55->subscription_id;
            $subsription_array[] = $sub_id;
        }

        $i = 0;
        while ($i < count($subsription_array)) {
            //TESTING: echo $subsription_array[$i]."<br>";
            $sub = $subsription_array[$i];
            $sql12 = "SELECT location, theme 
            FROM `subscription` 
            WHERE subscription_id = '$sub'";
            $result12 = mysql_query($sql12);
            while ($row12 = mysql_fetch_object($result12)) {
                $loc = $row12->location;
                $theme = $row12->theme;
                //TESTING: echo $theme." - thema ";
                //TESTING: echo $loc." - loc ";
            }

            $array = load_abo_articles($loc, $theme);
            $i++;
            //TESTING: $artikel_array= $array;
            $artikel_array = array_merge_recursive($artikel_array, $array);
            $artikel_array = array_unique($artikel_array);
        }

        $artikel_array_new = array();
        $i = 0;
        while ($i < count($artikel_array)) {
            if (empty($artikel_array[$i])) {
                
            } else {
                $artikel_array_new[] = $artikel_array[$i];
            }
            $i++;
        }
        $artikel_array = $artikel_array_new;

        /* $i = 0;
          while($i < count($artikel_array))
          {
          echo $artikel_array[$i]."<br>";
          $i++;
          }
         */

        return $artikel_array;
    }

    function resizeImage($filepath_old, $filepath_new, $image_dimension, $scale_mode = 0) {
        if (!(file_exists($filepath_old)) || file_exists($filepath_new))
            return false;

        $image_attributes = getimagesize($filepath_old);
        $image_width_old = $image_attributes[0];
        $image_height_old = $image_attributes[1];
        $image_filetype = $image_attributes[2];

        if ($image_width_old <= 0 || $image_height_old <= 0)
            return false;

        $image_aspectratio = $image_width_old / $image_height_old;

        if ($scale_mode == 0) {
            $scale_mode = ($image_aspectratio > 1 ? -1 : -2);
        } elseif ($scale_mode == 1) {
            $scale_mode = ($image_aspectratio > 1 ? -2 : -1);
        }

        if ($scale_mode == -1) {
            $image_width_new = $image_dimension;
            $image_height_new = round($image_dimension / $image_aspectratio);
        } elseif ($scale_mode == -2) {
            $image_height_new = $image_dimension;
            $image_width_new = round($image_dimension * $image_aspectratio);
        } else {
            return false;
        }

        switch ($image_filetype) {
            case 1:
                $image_old = imagecreatefromgif($filepath_old);
                $image_new = imagecreate($image_width_new, $image_height_new);
                imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
                imagegif($image_new, $filepath_new);
                break;
            case 2:
                $image_old = imagecreatefromjpeg($filepath_old);
                $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
                imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
                imagejpeg($image_new, $filepath_new);
                break;
            case 3:
                $image_old = imagecreatefrompng($filepath_old);
                $image_colordepth = imagecolorstotal($image_old);

                if ($image_colordepth == 0 || $image_colordepth > 255) {
                    $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
                } else {
                    $image_new = imagecreate($image_width_new, $image_height_new);
                }

                imagealphablending($image_new, false);
                imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
                imagesavealpha($image_new, true);
                imagepng($image_new, $filepath_new);
                break;
            default:
                return false;
        }

        imagedestroy($image_old);
        imagedestroy($image_new);
        return true;
    }

    function save_article_themes($art_id, $themen_a) {
        //echo "hallo";
        $themen = array();
        $themen = $themen_a;
        echo "tuta";
        echo count($themen);

        //if(empty($themen))
        //{
        //	$themen[] = 0;
        //	}
        $article_id = $art_id;
        echo "tra: " . $article_id;

        $i = 0;
        //echo "ANzahl Then: ".count($themen);

        while ($i < count($themen)) {
            $theme_id = $themen[$i];
            //echo "###".$theme_id." - theaID<br>";
            //echo "###".$article_id." - ARTICLE<br>";

            $sql = "INSERT INTO article_themes_belongs_to (article,theme) VALUES ($article_id , $theme_id);";
            $eintragen = mysql_query($sql);
            $i++;
        }
    }

    function save_article_locations($art_id, $orte_a) {

        $orte = array();
        $orte = $orte_a;
        if (empty($orte)) {
            $orte[] = 0;
            $orte[] = 1;
        }
        $article_id = $art_id;

        $i = 0;
        while ($i < count($orte)) {
            $loc_id = $orte[$i];
            //echo $loc_id." - ID<br>";
            //echo $article_id." - ARTICLE<br>";
            $sql = "INSERT INTO article_locations_belongs_to (article,location) VALUES ($article_id , $loc_id);";
            $eintragen = mysql_query($sql);
            $i++;
        }
    }

// template functions
    function formatHTMLLineBreak($html, $spaceCountBefore) {
        $space = '';
        for ($i = 0; $i < $spaceCountBefore; $i++) {
            $space .= ' ';
        }
        return $space . $html . "\n";
    }

    function getHeaderConfig($headerid) {
    
         
            $basedir = "localhost";
        $html .= formatHTMLLineBreak('<base href="http://'.$basedir.'">', 0);
   $html .= formatHTMLLineBreak('<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon; charset=binary">');
      $html .= formatHTMLLineBreak('<link rel="icon" href="images/favicon.ico" type="image/x-icon; charset=binary">');
//    $html .= formatHTMLLineBreak('<title>' . $headerid . ': paperly</title>');
        $html .= formatHTMLLineBreak('<title>paperly - Dein lokales Nachrichtennetzwerk</title>', 8);
        return $html;
    }

    function getMetaTags() {
        // parsing line breaks on output:  . "\n"
        $html = formatHTMLLineBreak('<meta charset="utf-8">', 8);
        $html .= formatHTMLLineBreak('<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">', 8);
        $html .= formatHTMLLineBreak('<meta property="og:title" content="paperly - Dein lokales Nachrichtennetzwerk" />', 8);
        $html .= formatHTMLLineBreak('<meta property="og:type" content="website"/>', 8);
        $html .= formatHTMLLineBreak('<meta property="og:url"  content="http://www.paperly.de" />', 8);
        $html .= formatHTMLLineBreak('<meta property="og:image" content="http://prebeta.paperly.de/images/design/logo.png" />', 8);
        $html .= formatHTMLLineBreak('<meta property="og:site_name" content="paperly" />', 8);
        $html .= formatHTMLLineBreak('<meta property="fb:app_id" content="424820200939012" />', 8);
        $html .= formatHTMLLineBreak('<meta name="description" content="Lies Artikel aus Deiner Stadt. Schreibe Artikel und bewege Menschen. Werde Teil des lokalen Nachrichtennetzwerks. Sei paperly!">', 8);
        $html .= formatHTMLLineBreak('<meta name="author" content="paperly">', 8);
        $html .= formatHTMLLineBreak('<meta name="keywords"content="individuell, lokal, zeitung, interessieren, gezielt, filter, news,erstelle, themen, orte">', 8);
        $html .= formatHTMLLineBreak('<meta name="robots" content="all">', 8);
        $html .= formatHTMLLineBreak('<meta name="revisit-after" content="7 days">', 8);

        // TODO: mario
        /*
          <link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" />
          <meta name="apple-mobile-web-app-status-bar-style" content="black" />
          <meta name="author" content="paperly UG"/>
          <meta name="robots" content="all">
          <meta name="revisit-after" content="7 days">
          <meta property="og:title" content="<?php
          $art_id = $_GET["artid"];
          $abfrage1 = "SELECT topic  FROM article WHERE article_id = " . $art_id . ";";
          $ergebnis1 = mysql_query($abfrage1);
          $row = mysql_fetch_object($ergebnis1);
          $topic = $row->topic;
          if (!empty($art_id)) {
          echo $topic;
          }
          ?>"/>
          <meta property="og:type" content="article" />
          <meta property="og:image" content="http://prebeta.paperly.de/images/design/logo2.png" />
          <meta property="og:site_name" content="paperly.de" />
          <meta property="og:description" content="Deine individuelle Lokalzeitung. Jetzt kostenlosen Account erstellen" />
          <meta property="fb:app_id" content="424820200939012" />
          <meta property="og:url" content="http://prebeta.paperly.de/index.php?artid=<?php echo $art_id; ?>" />
         */

        return $html;
    }

    function getDocumentHeaderLoggedIn($headerid, $userid, $connection) {
        // TODO: check implemented javascript class: templateClass.js [showContentBox]
        if ($headerid == 'bodyid') {
            // do something
        }
        $sql = "SELECT * FROM  `user` WHERE user_id = '$userid';";
        $result = mysql_query($sql);
        $row = mysql_fetch_object($result);

        $username = $row->nickname;
        // format header
        $html = formatHTMLLineBreak('<div id="topbox" class="no-print">', 0);
        $html .= formatHTMLLineBreak('  <div class="wrapper">', 8);
        $html .= formatHTMLLineBreak('    <div id="topbox-column">', 8);
        $html .= formatHTMLLineBreak('      <nav role="navigation" id="nav-top">', 8);
        $html .= formatHTMLLineBreak('        <ul>', 8);
        $html .= formatHTMLLineBreak('          <li class="first"><a href="">paperly Towns</a></li>', 8);
        $html .= formatHTMLLineBreak('          <li><a href="/suchen">Suche</a></li>', 8);
        $html .= formatHTMLLineBreak('          <li><a href="/schreiben">Artikel Schreiben</a></li>', 8);
        $html .= formatHTMLLineBreak('          <li><a href="/mypaperly">my paperly</a></li>', 8);

        //  $html .= formatHTMLLineBreak('          <li class="last">  ', 8);
        //$html .= formatHTMLLineBreak('            <span style="float: left; margin-right: 8px;">Meine Paper:</span>', 8);
        //$html .= formatHTMLLineBreak('            <span style="float: left">', 8);
        // get paper options
        // if ($headerid == 'paper') {
        // get selected paper
        //   if (isset($_SESSION["paper_id"]))
        //     $selectedPaperID = $_SESSION["paper_id"];
        // $html .= getPapersOfUser($userid, $connection, $selectedPaperID);
        // }
        //else {
        // null selected paper id, except for filter.php
        // if ($headerid != 'filter')
        //       $_SESSION["paper_id"] = -1;
        //     $html .= getPapersOfUser($userid, $connection, -1);
        //   }
        // $html .= formatHTMLLineBreak('            </span>', 8);
        // $html .= formatHTMLLineBreak('          </li>', 8);
        // hide control on filter.php
        if ($headerid != 'filter') {
            // change control on selected paper
            if ($headerid == 'paper') {
                // $html .= formatHTMLLineBreak('          <li><a href="filter.php">Paper bearbeiten</a></li>', 8);
            } else {
                // $html .= formatHTMLLineBreak('          <li><a href="filter.php">Paper erstellen</a></li>', 8);
            }
        }
        $html .= formatHTMLLineBreak('        </ul>', 8);
        $html .= formatHTMLLineBreak('      </nav>', 8);
        $html .= formatHTMLLineBreak('      <div id="topbox-profil">', 8);
        $html .= formatHTMLLineBreak('        <a href="/' . $username . '">Mein Profil <img src="images/design/profil.png" alt="Profil"></a>', 8);
        $html .= formatHTMLLineBreak('      </div>', 8);
        $html .= formatHTMLLineBreak('    </div>', 8);
        $html .= formatHTMLLineBreak('    <div id="profilbox" style="visibility: hidden;">', 8);
        $html .= formatHTMLLineBreak('      <p><a href="/einstellungen">Einstellungen</a></p>', 8);
        $html .= formatHTMLLineBreak('      <p><a href="logout.php">Abmelden</a></p>', 8);
        $html .= formatHTMLLineBreak('      <p><a href="/' . $username . '">Profil ansehen</a></p>', 8);
        $html .= formatHTMLLineBreak('    </div>', 8);
        $html .= formatHTMLLineBreak('  </div>', 8);
        $html .= formatHTMLLineBreak('</div>', 8);
        return $html;
    }

    function getDocumentHeaderLoggedOff() {
        // format header
        $html = formatHTMLLineBreak('<div id="topbox" class="no-print">', 0);
        // $html .= formatHTMLLineBreak('  <div class="wrapper">', 8);
        //$html .= formatHTMLLineBreak('    <div id="topbox-column">', 8);
        //$html .= formatHTMLLineBreak('      <div id="topbox-profil">', 8);
        // $html .= formatHTMLLineBreak('        <a href="#" onclick="showContentBox(' . "'" . 'loginbox' . "'" . ');">', 8);
        // $html .= formatHTMLLineBreak('          Login', 8);
        //  $html .= formatHTMLLineBreak('          <img alt="Profil" src="images/design/profil.png">', 8);
        //  $html .= formatHTMLLineBreak('        </a>', 8);
        //  $html .= formatHTMLLineBreak('      </div>', 8);
        //  $html .= formatHTMLLineBreak('    </div>', 8);
        //  $html .= formatHTMLLineBreak('    <div id="loginbox">', 8);
        //  $html .= formatHTMLLineBreak('      <form class="login-form" enctype="multipart/form-data" action="login.php" method="post">', 8);
        // $html .= formatHTMLLineBreak('        <p>Logindaten eingeben</p>', 8);
//    $html .= formatHTMLLineBreak('        <fieldset class="login-fieldset">', 8);
//    $html .= formatHTMLLineBreak('          <legend class="login-legend">Formulardaten</legend>', 8);
        //   $html .= formatHTMLLineBreak('          <label class="login-label" for="loginEMail">Email-Adresse:</label><br>', 8);
        //   $html .= formatHTMLLineBreak('          <input id="loginEMail" class="login-field" type="email" style=" width:200px;" name="EMail" value="" required=""><br>', 8);
        //   $html .= formatHTMLLineBreak('          <label class="login-label" for="loginPassword">Passwort:</label><br>', 8);
        //  $html .= formatHTMLLineBreak('          <input id="loginPassword" class="login-field" type="password" style="width:200px;" name="Password" value="" required=""><br>', 8);
        //   $html .= formatHTMLLineBreak('          <input class="" type="submit" style=" width: 70px; height:30px;" value="login" name="">', 8);
        //  $html .= formatHTMLLineBreak('        </fieldset>', 8);
        //  $html .= formatHTMLLineBreak('        <p><a class="fancyboxpw fancybox.iframe" target="_new" href="passwortvergessen.php">Passwort vergessen</a></p>', 8);
        //   $html .= formatHTMLLineBreak('      </form>', 8);
        //   $html .= formatHTMLLineBreak('    </div>', 8);
        //   $html .= formatHTMLLineBreak('  </div>', 8);
        $html .= formatHTMLLineBreak('</div> ', 8);
        return $html;
    }

    function getDocumentLogin() {
        $html = '<div style="  float: right;width: 600px; margin-top: -55px; text-align: right;">

                                    <form  enctype="multipart/form-data" action="login.php" method="post">

                                        <input id="loginEMail" class="login-field" type="email" placeholder="E-Mail" style=" width:200px; height: 23px;" name="EMail" value="" required="" >
                                        <input id="loginPassword" class="login-field" type="password" placeholder="Passwort" style="width:200px; height: 23px;" name="Password" value="" required="">
                                        <input id="button_allgemein" type="submit" name="" value="Login"/>

                                    </form>
                                    <p><a class="fancyboxpw fancybox.iframe" target="_new" href="passwortvergessen.php">Passwort vergessen?</a> <a href="start">Hier Registieren</a></p>
                                </div>';
        return $html;
    }

    function getPapersOfUser($userid, $connection, $selectedpaperid) {
        $paperOptions = '';
        try {
            // get paper
            $stmt = $connection->prepare('SELECT paper_id, label FROM paper WHERE creator = :id');
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute(array(':id' => $userid));
            while ($row = $stmt->fetch()) {
                $paperid = $row->paper_id;
                $label = $row->label;
                $selected = '';
                if ($selectedpaperid == $paperid)
                    $selected = 'selected';
                $paperOptions .= formatHTMLLineBreak('<option ' . $selected . ' value="' . $paperid . '">' . $label . '</option>', 28);
            }
        } catch (PDOException $e) {
            // TODO: display error
            //echo 'ERROR: ' . $e->getMessage();
        }
        // format output
        $html .= formatHTMLLineBreak('<form id="select-paper-form" class="select-paper-form" method="get" action="paper.php" enctype="multipart/form-data" name="select-paper-form">', 24);
        $html .= formatHTMLLineBreak('  <select name="paper_id" onchange="this.form.submit();" style="min-width: 200px;">', 24);
        $html .= formatHTMLLineBreak('    <option value="-1"></option>', 24);
        $html .= $paperOptions;
        $html .= formatHTMLLineBreak('  </select>', 24);
        $html .= formatHTMLLineBreak('</form>', 24);
        return $html;
    }

    function getDocumentFooter() {
        $html = formatHTMLLineBreak('', 0);
        $html .= formatHTMLLineBreak('<div id="footer-content">', 20);
        $html .= '  <a href="impressum.php">Impressum</a> | ';
        $html .= '  <a href="agb.php">AGBs</a> | ';
//    $html .= '  <a href="#">paperly Blog</a> | ';
        $html .= '  <a href="datenschutzbestimmungen.php">Datenschutzbestimmungen</a> | ';
        $html .= '  <a href="index.php">© 2013 paperly UG (haftungsbeschränkt)</a>';
        $html .= '</div>';
        return $html;
    }

?>