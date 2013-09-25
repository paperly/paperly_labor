<?php
session_start();
// get db connection
include "config.php";
include "functions.php";
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
        echo getHeaderConfig('Themen wählen');
        echo getMetaTags();
        ?>
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <script src="js/libs/theme/themeClass.js"></script>
        <script src="php/getThemes.php" type="text/javascript"></script>
    </head>
    <?
    // format values: see themeClass.js, loadSubThemeElements(themeid, chosenthemes, formatstring, themeboxid, multiplethemeselection)
    $values = '';
    // get selected themeid
    $theme_id = $_GET["themeid"];
    if (!empty($theme_id)) {
        $values = $values . $theme_id;
    } else {
        $values = $values . 'null';
    }
    // get chosen themes
    $selected_themes = $_GET["selectedthemes"];
    if (!empty($selected_themes)) {
        $values = $values . ",'" . $selected_themes . "'";
    } else {
        $values = $values . ',null';
    }
    // add identifier for GET values, to identify string values
    $values = $values . ',true';
    // add themeboxid
    $themeboxid = $_GET["themeboxid"];
    if (!empty($themeboxid)) {
        $values = $values . ",'" . $themeboxid . "'";
    } else {
        $values = $values . ',null';
    }
    // add themeselectionflag
    $themeselectionflag = $_GET["themeselectionflag"];
    if (!empty($themeselectionflag)) {
        $values = $values . ",'" . $themeselectionflag . "'";
    } else {
        $values = $values . ',null';
    }
    ?>
    <body id="select-subtheme" onLoad="javascript:loadSubThemeElements(<? echo $values; ?>);">
        <div id="subtheme-selectbox"></div>
    </body>    
</html>