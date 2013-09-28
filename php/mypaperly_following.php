<?php
session_start();
// get db connection
include "config.php";
include "php/functions.php";
include "php/functionsTimeline.php";

// set current paper id
$user_id = $_SESSION["user_id"];
?>


<?php
if (!isset($_SESSION["user_id"])) {
    echo "Nicht eingeloggt";
} else {
    ?>
    
    <!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
<!--<![endif]--><head>
        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<meta charset="utf-8">
</head>

<link rel="stylesheet" href="../css/style_shadowbox.css" media="screen,projection">

           <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40911491-1', 'paperly.de');
  ga('send', 'pageview');

</script>

  <!-- social functions -->
      
<script src="../js/libs/profil/followClass.js"></script>

<body>
    
    <div id="titlebox"><h1>my paperly bearbeiten</h1></div>
    <section>
  
    <div id="content_box"><h1>Towns</h1></div>

    <?php
    $sql = "SELECT location.location_id as location_id,name FROM  location_follow,location WHERE location.location_id = location_follow.location_id AND location_follow.user_id_self = $user_id";

    $result = mysql_query($sql);


    // format result
    while ($row = mysql_fetch_object($result)) {

        $location_id = $row->location_id;
        $location_name = $row->name;
        
        
        $sql_b ="SELECT name FROM `location` WHERE location_id = (SELECT super_location FROM `location` WHERE location_id = (SELECT super_location FROM `location` WHERE location_id = $location_id))";
        $restult_b = mysql_query($sql_b);
        $row_b = mysql_fetch_object($restult_b);
        $location_level_3 = $row_b->name;
        $sql_b ="SELECT name FROM `location` WHERE location_id = (SELECT super_location FROM `location` WHERE location_id = $location_id)";
        $restult_b = mysql_query($sql_b);
        $row_b = mysql_fetch_object($restult_b);
        $location_level_5 = $row_b->name;
        
        
        echo ' <div id="content_box">
        <div id="follow_box_left_location"><b>'.$location_name.'</b> ('.$location_level_5.' &rarr; '.$location_level_3.' &rarr; Deutschland)</div>
        <div id="follow_box_right_location"><a href="javascript:follow_add_location_byid(' . $location_id . ');"><input id="location_' . $location_id . '" class="follow_button_location" type="submit" name="" value="Entfolgen"/>
</a></div>
        
    </div>';
        
        
        
       // echo' <li>' . $location_name . ' - <a href="javascript:follow_add_location_byid(' . $location_id . ');"><input id="location_' . $location_id . '" class="follow_button_location" type="submit" name="" value="Entfolgen"/>
//</a></li>';
    }
    ?>



    <hr>
      <div id="content_box"> <h1>Menschen</h1></div>
   
    <?php
    $sql ="SELECT user.description, user.picture, user.user_id as user_id, user.nickname FROM  user_follow, user WHERE user_follow.user_id_other = user.user_id AND user_follow.user_id_self = $user_id";

    $result = mysql_query($sql);


    // format result
    while ($row = mysql_fetch_object($result)) {

        $user_id_other = $row->user_id;
        $nickname = $row->nickname;
         $description = $row->description;
        $picture = $row->picture;
       // echo' <li>' . $nickname . ' - <a href="javascript:follow_add_user_byid(' . $user_id_other . ');"><input id="user_' . $user_id_other. '" class="follow_button_location" type="submit" name="" value="Entfolgen"/>
//</a></li>';
        
        echo ' <div id="content_box">
        <div id="follow_box_left">
        <div id="user_name">'.$nickname.'</div>
<div id="profilbild_box"><img id="profilbild"  height="50" src="'.$picture.'"></div><div id="user_text">'.$description.'</div></div>
        <div id="follow_box_right"><a href="javascript:follow_add_user_byid(' . $user_id_other . ');"><input id="user_' . $user_id_other . '" class="follow_button_location" type="submit" name="" value="Entfolgen"/>
</a></div>
        
    </div>';
    }
    
    ?>
    </section>
    </body>
    
    <?php
}
?>

