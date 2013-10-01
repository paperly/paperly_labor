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
        echo getHeaderConfig('Profil');
        echo getMetaTags();
        ?>
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
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
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <?php
        $art_id = $_GET["artid"];
        if (!empty($art_id)) {
            //echo'<title>hallo welt</title>';
            echo'';
            // echo '<meta property="og:url" content="http://prebeta.paperly.de/index.php?artid='.$art_id.'" />';
            echo "<a  class='fancybox fancybox.iframe' href='article.php?artid=" . $art_id . "' target='_new' >weiffter</a>";
        }
        // passwort vergessen ..
        $pwcode = $_GET["pwcode"];
        $userid = $_GET["userid"];
        if (!empty($pwcode) && !empty($userid)) {
            $result = mysql_query("SELECT * FROM user WHERE user_id = '" . $userid . "'");
            if ($row = mysql_fetch_object($result)) {
                $email = $row->email;
                $passwort = $row->password;
                echo "Dir wurde ein bestätigungslink geschickt!!<br/>";

                $str = $email . $passwort . $userid;
                $hashcode = md5($str);

                if ($hashcode == $pwcode) {

                    echo "<a  class='fancybox fancybox.iframe' href='passwortvergessen.php?pwcode=" . $pwcode . "&userid=" . $userid . "' target='_new' >weiffter</a>";
                }
            }
        }
        ?>
    </head> 
    <body id="start" onLoad="$('.fancybox').trigger('click');">

        <?php /* set docuemnt header, check functions.php */ echo getDocumentHeaderLoggedOff(); ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"> <a href="index.php"><img src="images/design/logo.png"  height="70" alt="paperly"></a> </div>
                            <div id="header-papercontrolbox"> </div>
                        </div>
                        <div id="header-navbox"> </div>
                    </div>
                </div>
            </header>
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                    <div id="notificationbox">Bitte fülle folgendes Formular aus</div>
                    <div id="content-column">
                        <section>
                            <?php
                            if (!empty($_POST["EMail"]) && !empty($_POST["Password"])) {

                                $email = $_POST["EMail"];
                                $passwort = $_POST["Password"];
                                //$passwort1 = $_POST["Password"];
                                $check = false;
                                if (isset($_POST["AGB"])) {
                                    $check = true;
                                }


                                $passwort = md5($passwort);
                                $result = mysql_query("SELECT user_id FROM user WHERE email = '$email'");
                                $menge = mysql_num_rows($result);


                                /* function checkmail($email) {
                                  if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) {
                                  $i = 1;
                                  echo "ganz";
                                  } else {
                                  $i = 0;
                                  echo "nuuuuul";
                                  }
                                  return $i;
                                  }

                                  $e = checkmail($email);
                                 */

                                if ($menge == 0 && $check == true) {


                                    $name_array = array("RotEiche", "BergAhorn", "HolzApfel", "WeißBirke", "RotBuche", "SchwarzErle", "Eberesche", "RotFichte", "RossKastanie", "SommerLinde", "Stechpalme", "WinterLinde", "Schwarzdorn", "WeißTanne", "Wacholder", "BergUlme");


                                    $nickname = $name_array[rand(0, count($name_array))];



                                    $eintrag = "INSERT INTO user (email, password) VALUES ('$email', '$passwort');";

                                    $eintragen = mysql_query($eintrag, $verbindung);
                                    mysql_query("SELECT LAST_INSERT_ID()");
                                    $user_id = mysql_insert_id();
                                    $_SESSION["user_id"] = $user_id;
                                    $eintrag = "UPDATE  user SET nickname = '" . $nickname .$user_id. "' WHERE user_id = " . $user_id . "";
                                    mysql_query($eintrag);


                                    if ($eintragen == true) {
                                        // hier wird mail versand

                                        $empfaenger = $email;
                                        $betreff = "paperly.de Anmeldung";
                                        $text = "<p>Hallo,</p>
<p>willkommen bei paperly, Deinem lokalen Nachrichtennetzwerk! Wir haben Dir einen Spitznamen zugewiesen und hoffen, dass er Dir gefällt! Wenn das nicht der Fall ist, kannst Du Ihn gerne in Deinem Profil ändern. </p>

<p>Auf paperly findest Du nicht nur lokale Nachrichten aus Deiner Stadt, Du hast ebenfalls die Möglichkeit eigene Artikel zu veröffentlichen!</p>
<p>Ob Du Mitglied in einem Sportverein bist und über Eure letzte Veranstaltung berichtest, auf ein Defizit in der Altenpflege hinweisen möchtest, oder über ein neues Restaurant informieren willst – auf paperly bist du goldrichtig!</p>
<p>Solltest Du Fragen haben, kannst Du Dich gerne an uns wenden. Schreibe eine E-Mail an </br>
fragen@paperly.de</p>
<p>oder kontaktiere uns über unsere Facebook-Seite</br>
https://www.facebook.com/paperlyde</p>
<p>Wir freuen uns bereits auf Deinen ersten Artikel!</p>
<p>Dein paperly-Team</p>
";
                                        $from = "From: paperly Server <info@paperly.de>\n";
                                        //$from .= "Reply-To: mail@paperly.de\n";
                                        $from .= "Content-type: text/html; charset=utf-8" . "\r\n";






                                        mail($empfaenger, $betreff, $text, $from);

                                        echo "<div class='start_green'>Ihnen wurde eine Email mit Ihren Zugangsdaten geschickt</div>";


                                        echo "<script language='javascript'>";
                                        echo "window.location.href='index.php'";
                                        echo "</script>";
                                    } else {

                                        echo "<div class='start_red'>Fehler beim Speichern des Benutzernames</div>";
                                    }
                                } else {

                                    echo "<div class='start_red'>Fehler</div>";
                                }
                            }
                            ?>
                             <div class="content-box clearfix">
                                <article id="loginbox_top">

                                    <form  enctype="multipart/form-data" action="login.php" method="post">

                                        <input id="loginEMail" class="login-field" type="email" placeholder="E-Mail Adresse" style=" width:200px; height: 23px;" name="EMail" value="" required="" >
                                        <input id="loginPassword" class="login-field" type="password" placeholder="Passwort" style="width:200px; height: 23px;" name="Password" value="" required="">
                                        <input id="button_allgemein" type="submit" name="" value="Login"/>

                                    </form>
                                    <p><a class="fancyboxpw fancybox.iframe" target="_new" href="passwortvergessen.php">Passwort vergessen?</a></p>
                                </article>
                               
                             </div>


                            <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
                            <script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
                            <script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
                            <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.2" media="screen" />
                            <script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
                            <script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>
                            <link rel="stylesheet" type="text/css" href="js/libs/fancybox/jquery.fancybox.css?v=2.1.2" media="screen" />
                            <script type="text/javascript">
            $(document).ready(function() {
                //  Simple image gallery. Uses default settings
                $('.fancybox').fancybox({
                    'padding': 0,
                    'margin': 0,
                    'width': 875,
                    'height': '95%',
                    fitToView: false,
                    autoSize: false
                });
            });
                            </script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    //  Simple image gallery. Uses default settings
                                    $('.fancyboxpw').fancybox({
                                        'padding': 0,
                                        'width': 500,
                                        'height': 300,
                                        fitToView: false,
                                        autoSize: false

                                    });
                                });
                            </script>
                            <style type="text/css">
                                .fancybox-custom .fancybox-skin {
                                    box-shadow: 0 0 50px #222;
                                }
                            </style>
                            <script type="text/_javascript_"> 

                                $(document).ready(function () {
                                $.fancybox({
                                'width': '40%',
                                'height': '40%',
                                'autoScale': true,
                                'transitionIn': 'fade',
                                'transitionOut': 'fade',
                                'type': 'iframe',
                                'href': 'http://www.example.com'
                                });
                                });
                            </script> 
                           
                            <div class="content-box clearfix">
                                <article class="text-box float-left" style="margin-left:35px;" >
                                    <h1 style="font-size:24px;">Deine News aus Deiner Stadt.</h1>
                                    <p style="font-size:18px;">Lies Artikel aus Deiner Stadt. Schreibe Artikel und bewege Menschen. Werde Teil des lokalen Nachrichtennetzwerks. Sei paperly!
                                    </p>
                                </article>
                                <article class="image-box float-right"> <img src="images/design/baldauchalsapp.png" width="305" height="164" alt="alle news im Überblick"> </article>
                            </div>

                            <div class="content-box clearfix">
                                <article class="image-box float-left"> <img src="images/design/bepaperly.jpg"  width="391" height="413" alt="alle news im Überblick"> </article>
                                <article class="text-box float-right">
                             
                                <article class="login-box float-left" style="margin-left:-40px; margin-top: 60px;">
                                    <h1 class="csc-firstHeader" style="font-size:24px;" >Neu bei paperly?</h1>
                                    <form class="login-form" method="post" action="start.php" enctype="multipart/form-data">
                                        <p style="font-size:18px;">Registriere dich Kostenlos!</p>
                                        <fieldset class="login-fieldset">
                                            <legend class="login-legend">Formulardaten</legend>
                                            <div class="login-fieldwrap">
                                                <label class="login-label" for="loginEMail">Email-Adresse:</label>
                                                <input id="loginEMail" class="login-field" type="email" required value="" name="EMail" autofocus>
                                            </div>
                                            <div class="login-fieldwrap">
                                                <label class="login-label" for="loginPassword">Passwort:</label>
                                                <input id="loginPassword" class="login-field" type="password" required value="" name="Password">
                                            </div>
                                            <div class="login-fieldwrap">
                                                <input id="loginCheckBoxAGB" class="login-checkbox" type="checkbox" checked="checked" value="" name="AGB">
                                                <label for="loginCheckBoxAGB">Mit der Registrierung gelten unsere <a href="agb.php" target="_new">Nutzungsbedingungen</a> und <a href="datenschutzbestimmungen.php" target="_new">Datenschutzbestimmungen</a></label>
                                            </div>
                                            <div class="login-fieldwrap">
                                                <input class="login-submit css3button" type="submit" name="" value="Kostenlos Registrieren" >
                                            </div>
                                        </fieldset>
                                    </form>
                                </article>
                            </div>

                         

                         
                         
                       



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
