<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
// get db connection
include "php/config.php";
include "php/functions.php";
include "php/image_functions.php";
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
        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
        <!-- search locations -->
        <script src="php/getFilterLocations.php" type="text/javascript"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <!-- document ready functions --> 
        <script type="text/javascript" src="js/libs/profil/jquery-pack.js"></script>
        <script type="text/javascript" src="js/libs/profil/jquery.imgareaselect.min.js"></script>
        <script type="text/javascript" src="js/libs/profil/jquery.ocupload-packed.js"></script>
        <script type="text/javascript">
            //<![CDATA[

            //create a preview of the selection
            function preview(img, selection) {
                //get width and height of the uploaded image.
                var current_width = $('#uploaded_image').find('#thumbnail').width();
                var current_height = $('#uploaded_image').find('#thumbnail').height();

                var scaleX = <?php echo $thumb_width; ?> / selection.width;
                var scaleY = <?php echo $thumb_height; ?> / selection.height;

                $('#uploaded_image').find('#thumbnail_preview').css({
                    width: Math.round(scaleX * current_width) + 'px',
                    height: Math.round(scaleY * current_height) + 'px',
                    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                });
                $('#x1').val(selection.x1);
                $('#y1').val(selection.y1);
                $('#x2').val(selection.x2);
                $('#y2').val(selection.y2);
                $('#w').val(selection.width);
                $('#h').val(selection.height);
            }

            //show and hide the loading message
            function loadingmessage(msg, show_hide) {
                if (show_hide == "show") {
                    $('#loader').show();
                    $('#progress').show().text(msg);
                    $('#uploaded_image').html('');
                } else if (show_hide == "hide") {
                    $('#loader').hide();
                    $('#progress').text('').hide();
                } else {
                    $('#loader').hide();
                    $('#progress').text('').hide();
                    $('#uploaded_image').html('');
                }
            }

            //delete the image when the delete link is clicked.
            function deleteimage(large_image, thumbnail_image) {
                loadingmessage('Please wait, deleting images...', 'show');
                $.ajax({
                    type: 'POST',
                    url: '<?= $image_handling_file ?>',
                    data: 'a=delete&large_image=' + large_image + '&thumbnail_image=' + thumbnail_image,
                    cache: false,
                    success: function(response) {
                        loadingmessage('', 'hide');
                        response = unescape(response);
                        var response = response.split("|");
                        var responseType = response[0];
                        var responseMsg = response[1];
                        if (responseType == "success") {
                            $('#upload_status').show().html('<h1>Success</h1><p>' + responseMsg + '</p>');
                            $('#uploaded_image').html('');
                        } else {
                            $('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>' + response);
                        }
                    }
                });
            }

            $(document).ready(function() {
                $('#loader').hide();
                $('#progress').hide();
                var myUpload = $('#upload_link').upload({
                    name: 'image',
                    action: '<?= $image_handling_file ?>',
                    enctype: 'multipart/form-data',
                    params: {upload: 'Upload'},
                    autoSubmit: true,
                    onSubmit: function() {
                        $('#upload_status').html('').hide();
                        loadingmessage('Please wait, uploading file...', 'show');
                    },
                    onComplete: function(response) {
                        loadingmessage('', 'hide');
                        response = unescape(response);
                        var response = response.split("|");
                        var responseType = response[0];
                        var responseMsg = response[1];
                        if (responseType == "success") {
                            var current_width = response[2];
                            var current_height = response[3];
                            //display message that the file has been uploaded
                            $('#upload_status').show().html('<h1>Success</h1><p>The image has been uploaded</p>');
                            //put the image in the appropriate div
                            $('#uploaded_image').html('<div style=" border-color:#676767;border-style:solid; border-width:1px; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width; ?>px; height:<?php echo $thumb_height; ?>px;"><img src="' + responseMsg + '" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div><img src="' + responseMsg + '" style="float: left; margin-right: 10px;border-color:#676767;border-style:solid; border-width:1px;" id="thumbnail" alt="Create Thumbnail" />')
                            //find the image inserted above, and allow it to be cropped
                            $('#uploaded_image').find('#thumbnail').imgAreaSelect({aspectRatio: '1:<?php echo $thumb_height / $thumb_width; ?>', onSelectChange: preview});
                            //display the hidden form
                            $('#thumbnail_form').show();
                        } else if (responseType == "error") {
                            $('#upload_status').show().html('<h1>Error</h1><p>' + responseMsg + '</p>');
                            $('#uploaded_image').html('');
                            $('#thumbnail_form').hide();
                        } else {
                            $('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>' + response);
                            $('#uploaded_image').html('');
                            $('#thumbnail_form').hide();
                        }
                    }
                });

                //create the thumbnail
                $('#save_thumb').click(function() {
                    var x1 = $('#x1').val();
                    var y1 = $('#y1').val();
                    var x2 = $('#x2').val();
                    var y2 = $('#y2').val();
                    var w = $('#w').val();
                    var h = $('#h').val();
                    if (x1 == "" || y1 == "" || x2 == "" || y2 == "" || w == "" || h == "") {
                        alert("You must make a selection first");
                        return false;
                    } else {
                        //hide the selection and disable the imgareaselect plugin
                        $('#uploaded_image').find('#thumbnail').imgAreaSelect({disable: true, hide: true});
                        loadingmessage('Please wait, saving thumbnail....', 'show');
                        $.ajax({
                            type: 'POST',
                            url: '<?= $image_handling_file ?>',
                            data: 'save_thumb=Save Thumbnail&x1=' + x1 + '&y1=' + y1 + '&x2=' + x2 + '&y2=' + y2 + '&w=' + w + '&h=' + h,
                            cache: false,
                            success: function(response) {
                                loadingmessage('', 'hide');
                                response = unescape(response);
                                var response = response.split("|");
                                var responseType = response[0];
                                var responseLargeImage = response[1];
                                var responseThumbImage = response[2];
                                if (responseType == "success") {
                                    $('#upload_status').show().html('<h1>Success</h1><p>The thumbnail has been saved!</p>');
                                    //load the new images
                                    $('#uploaded_image').html('<img id="profilbild" src="' + responseThumbImage + '" alt="Thumbnail Image"/>');
                                    //hide the thumbnail form
                                    $('#thumbnail_form').hide();
                                } else {
                                    $('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>' + response);
                                    //reactivate the imgareaselect plugin to allow another attempt.
                                    $('#uploaded_image').find('#thumbnail').imgAreaSelect({aspectRatio: '1:<?php echo $thumb_height / $thumb_width; ?>', onSelectChange: preview});
                                    $('#thumbnail_form').show();
                                }
                            }
                        });

                        return false;
                    }
                });
            });


            //]]>
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
    <body id="profil">
<?php /* set docuemnt header, check functions.php */ if (isset($_SESSION["user_id"])) echo getDocumentHeaderLoggedIn('profil', $_SESSION["user_id"], $pdoConnection); ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"> <a href="index.php"><img src="images/design/logo.png"  height="54" alt="paperly"></a> </div>
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
$user_id = $_SESSION["user_id"];
// Prüfen ob schon vorhanden
if (!empty($_POST[Nickname])) {
    
      
   $sql = "SELECT nickname FROM  `user`  WHERE nickname = '" . $_POST[Nickname]. "' AND NOT user_id = '$user_id'";
    $result = mysql_query($sql);
   $row = mysql_fetch_object($result);
   $nickname = $row->nickname;
   
   if($nickname != $_POST[Nickname])
   {
          
    $sql = "UPDATE user SET nickname = '$_POST[Nickname]'  WHERE user_id = '$user_id';";
    $result = mysql_query($sql);
    echo "<div class='start_green'>Persönliche Daten wurden geändert</div>";
   }
   else{
        echo "<div class='start_green'>Nickname schon vorhanden</div>";
   }
       
    
    
 
}
if (!empty($_POST[Beschreibung]) ) {
    $sql = "UPDATE user SET description = '".$_POST[Beschreibung]."' WHERE user_id = $user_id;";
     $result = mysql_query($sql);

}
if (!empty($_POST[AktuellesPasswort]) && !empty($_POST[NeuesPasswort]) && !empty($_POST[Passwortwiederholen])) {
    if ($_POST[NeuesPasswort] == $_POST[Passwortwiederholen]) {
        $sql = "SELECT password FROM  `user`   WHERE user_id = " . $user_id . "";
        $result = mysql_query($sql);
        $row = mysql_fetch_object($result);
        $pw = $row->password;
        $pw_old = $_POST[AktuellesPasswort];
        $pw_old = md5($pw_old);
        echo $pw;
        echo "---";
        echo $pw_old;
        if ($pw_old == $pw) {
            $newpw = md5($_POST[Passwortwiederholen]);
            $sql = "UPDATE user SET password = '$newpw'  WHERE user_id = '$user_id';";
            $result = mysql_query($sql);
            echo "<div class='start_green'>Passwort wurde geändert</div>";
        } else {
            echo "<div class='start_red'>Passwort wurde nicht geändert nicht gleich</div>";
        }
    } else {
        echo "<div class='start_red'>Passwort wurde nicht geändert leer</div>";
    }
}
if (!empty($_POST[NeueEmail]) && !empty($_POST[Emailwiederholen])) {
    if ($_POST[NeueEmail] == $_POST[Emailwiederholen] && checkmail($_POST[Emailwiederholen]) == 0) {
        $newmail = $_POST[Emailwiederholen];
        $result = mysql_query("SELECT user_id FROM user WHERE email = '$newmail'");
        $menge = mysql_num_rows($result);
        if ($menge == 0) {
            $sql = "UPDATE user SET email = '$newmail'  WHERE user_id = '$user_id';";
            $result = mysql_query($sql);
            echo "<div class='start_green'>Email Adresse wurde erfolgreich geändert</div>";
        } else {
            echo "<div class='start_red'>Email Adresse konnte nicht geändert werden.</div>";
        }
    } else {
        echo "<div class='start_red'>Email Adresse konnte nicht geändert werden.</div>";
    }
}
// Ende if Post
$sql = "SELECT * FROM  `user` WHERE user_id = $user_id;";
$result = mysql_query($sql);
$row = mysql_fetch_object($result);
$nickname = $row->nickname;
$forname = $row->forename;
$email = $row->email;
$description = $row->description;
$name = $row->name;
 $picture = $row->picture;
 $picture = $row->picture;

// get name of selected hometown
$hometownName = '';
if ($hometown != '') {
    try {
        // get paper title
        $stmtHometownName = $pdoConnection->prepare('SELECT name FROM location WHERE location_id = :id');
        $stmtHometownName->setFetchMode(PDO::FETCH_OBJ);
        $stmtHometownName->execute(array(':id' => $hometown));
        while ($row = $stmtHometownName->fetch()) {
            $hometownName = $row->name;
        }
        // set controls
    } catch (PDOException $e) {
        // TODO: display error
        //echo 'ERROR: ' . $e->getMessage();
    }
}
?>
                            <h1><img src="images/Profil_Icon.png" width="60" height="50" alt="Profil">Dein Profil</h1>
                            <hr>
                            <article class="profil-left">
                                <h2>Persönliche Daten</h2>
                                <form class="profil-form" method="post" action="profil.php" enctype="multipart/form-data">
                                    <fieldset class="profil-fieldset">
                                        <legend class="profil-legend">Formulardaten</legend>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilNickname">Spitzname:</label>
                                            <input id="profilNickname" class="profil-field" type="text" required value="<?php echo $nickname; ?>" name="Nickname">
                                        </div>
                                       
                                        <div class="profil-fieldwrap_long" >
                                            <label class="profil-label"  >Beschreibung:</label>
                                       
                                            <textarea id="profil-textarea" maxlength="200" class="profil-field" name="Beschreibung" ><?php echo $description; ?></textarea> 
                                            
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <input class="profil-submit profil_css3button" type="submit" name="" value="Änderungen speichern" >
                                        </div>
                                    </fieldset>
                                </form>
                                <h2>Profilbild ändern</h2>


                                <!--<div id="upload_status" style="font-size:12px; width:80%; margin:10px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>!-->
                                <div class="profil-fieldwrap" >
                                           <div id="thumbnail_form" style="display:none;">
                                    <form name="form" action="" method="post">
                                        <input type="hidden" name="x1" value="" id="x1" />
                                        <input type="hidden" name="y1" value="" id="y1" />
                                        <input type="hidden" name="x2" value="" id="x2" />
                                        <input type="hidden" name="y2" value="" id="y2" />
                                        <input type="hidden" name="w" value="" id="w" />
                                        <input type="hidden" name="h" value="" id="h" />
                                        <input type="submit" class="profil-submit profil_css3button" name="save_thumb" value="Bild speichern" id="save_thumb" />
                                    </form>
                                </div>
                                    <p class="profil-submit profil_css3button" style="margin-top: 0px; margin-right: 10px; "><a id="upload_link" style="color: white;" href="#">Bild auswählen</a></p>
                                </div><div class="profil-fieldwrap"><p>
                             
                                    </p></div>
                               
                                <span id="loader" style="display:none;"><img src="loader.gif" alt="Loading..."/></span> <span id="progress"></span>
                                
                                <div id="uploaded_image"> <img id="profilbild" src="<?php echo $picture; ?>" height="250" width="250"/></div>
                                

                            </article>
                            <article class="profil-right">
                                <h2>Passwort ändern</h2>
                                <form class="profil-form" method="post" action="profil.php" enctype="multipart/form-data">
                                    <fieldset class="profil-fieldset">
                                        <legend class="profil-legend">Formulardaten</legend>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilAktuellesPasswort">Aktuelles Passwort:</label>
                                            <input id="profilAktuellesPasswort" class="profil-field" type="password" required value="" name="AktuellesPasswort">
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilNeuesPasswort">Neues Passwort:</label>
                                            <input id="profilNeuesPasswort" class="profil-field" type="password" required value="" name="NeuesPasswort">
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilPasswortWiederholen">Passwort wiederholen:</label>
                                            <input id="profilPasswortWiederholen" class="profil-field" type="password" required value="" name="Passwortwiederholen">
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <input class="profil-submit profil_css3button" type="submit" name="" value="Passwort speichern" >
                                        </div>
                                    </fieldset>
                                </form>
                                <h2>Email-Adresse ändern</h2>
                                <form class="profil-form" method="post" action="profil.php" enctype="multipart/form-data">
                                    <fieldset class="profil-fieldset">
                                        <legend class="profil-legend">Formulardaten</legend>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilNeueEmail">Neue Email:</label>
                                            <input id="profilNeueEmail" class="profil-field" type="email" required value="" name="NeueEmail">
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <label class="profil-label" for="profilEmailWiederholen">Email wiederholen:</label>
                                            <input id="profilEmailWiederholen" class="profil-field" type="email" required value="" name="Emailwiederholen">
                                        </div>
                                        <div class="profil-fieldwrap">
                                            <input class="profil-submit profil_css3button" type="submit" name="" value="Email aktualisieren" >
                                        </div>
                                    </fieldset>
                                </form>
                            </article>
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
