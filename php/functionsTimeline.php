<?php

//include "config.php";




function stripArticleText($articletext, $maxlength, $articleid) {
    // check length
    //if ($maxlength != -1 && strlen($articletext) > $maxlength) {
    // crop text	
    $strippedtext = substr($articletext, 0, $maxlength);
    $strippedtext = $strippedtext . '';
    // add detail link
    // prüfen ob extern oder soo#
    $sql = "SELECT * FROM article WHERE article_id = " . $articleid;
    $result = mysql_query($sql);
    $row = mysql_fetch_object($result);
    $creator = $row->creator;
    $link = $row->source;
    //echo $creator;

    if ($creator == -1) {
        $strippedtext = $strippedtext . "<a href='redirect.php?id=" . $articleid . "' target='_new' >weiterlesen</a>";
    } else {
        //$strippedtext = $strippedtext."<a class='fancybox fancybox.iframe' href='article.php?name=1232' target='_new' >weiter</a>";



        $strippedtext = $strippedtext . "<a class='fancybox fancybox.iframe' href='/articleopen/" . $articleid . "' target='_new' ></a>";
    }






    // $strippedtext = $strippedtext . ' <a class="fancybox fancybox.iframe" href="article.php?tut=656' . $articleid . '" target="_blank">weiterlesen</a>';
    // return cropped text
    return $strippedtext;
    //}
    //else {
    //  return $articletext;
    // }
}

function stripArticleLink($articlelink, $maxlength) {
    // strip 'http://'
    $strippedurllink = str_replace('http://', '', $articlelink);
    // strip '/...'
    $slashPos = stripos($strippedurllink, '/');
    $strippedlink = substr($strippedurllink, 0, $slashPos);
    // crop link if max length is set, -1: null;
    if ($maxlength != -1 && strlen($strippedlink) > $maxlength) {
        $strippedlink = substr($strippedlink, 0, $maxlength);
        $strippedlink = $strippedlink . '...';
    }
    // return link
    return $strippedlink;
}

function load_article_html($title,$text,$art_id,$link,$creator_id,$bild,$date) {
    $articleTextLength = 0;
    $articleLinkLength = 18;

   
    $sql2 = 'SELECT nickname FROM user WHERE user_id = '.$creator_id.'';
 
    $result2 = mysql_query($sql2);
    $row2 = mysql_fetch_object($result2);
    
    
    
    $creator_name = $row2->nickname;


    // TODO: strip text, add 'weiterlesen' --> shadowbox
    //$text = substr($row->article_text, 0, 150);
    $text = stripArticleText(strip_tags($text), $articleTextLength, $art_id);
    // format link
    
    $strippedlink = stripArticleLink($link, -1);
    $strippedlink_cropped = stripArticleLink($link, $articleLinkLength);
    // get timestamp
    $date = strtotime($date);
    //$timestamp = $row->timestamp_event;
    //$atime = date("d.m.Y H:i");
    $atime = strtotime("now");
    //$btime = strtotime($timestamp);
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
        // $time = "am ".date('d.m.Y H:i', $date);
        $time = "" . date('d.m.Y ', $date);
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
        $bild_html = "<a  class='fancybox fancybox.iframe' href='/articleopen/" . $art_id . "' target='_new' ><img src='upload/timeline/$bild'  id='timeline' alt='paperly'></a>";
    } else {
        $bild_html = "<a href='redirect.php?id=" . $art_id . "' target='_new' ><img src='upload/timeline/$bild' width='300' ' alt='paperly'></a>";
    }



$user_id = @$_SESSION["user_id"];
    $like = load_likebox($user_id, $art_id);


$commentbox =load_commentbox_html($art_id);



    $html = '
                                    <article class="timeline-article">  <div class="article-subbox">
                                    <div>' . $bild_html . '</div>
                                        <p id="article_town">Mannheim</p>
                                        <p id="article_time">'.$time.'</p>
                                         <p id="article_title">'.$title.'</p>
                                  <div class="likebox" id="likebox_' . $art_id . '">' . $like . ' </div>
                                   </div>
                                
                                    </article>';

    return $html;
}

?>