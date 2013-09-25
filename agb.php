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
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
    </head>
    <body id="start">
        <?php
        // set docuemnt header, check functions.php
        if (isset($_SESSION["user_id"]))
            echo getDocumentHeaderLoggedIn('impressum', $_SESSION["user_id"], $pdoConnection);
        else
            echo getDocumentHeaderLoggedOff();
        ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"> <a href="index.php"><img src="images/design/logo.png" width="205" height="54" alt="paperly"></a> </div>
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

                            <div class="content-box clearfix">
                               <h1>Allgemeine Geschäftsbedingungen</h1><p
                                <p>Der  folgende Abschnitt beschreibt die Nutzungsbedingungen, die die Interaktion zwischen paperly und seinen Nutzern regelt. Durch die Nutzung der Dienste von paperly wird diesen Bedingungen zugestimmt.
Die Nutzungsbedingungen, samt den Datenschutzbestimmungen stellen die alleinige Vereinbarung zwischen paperly und seinen Nutzern dar. Ausgeschlossen hiervon sind Vereinbarungen, die paperly mit Drittanbietern, Partnern, Sponsoren oder anderen Geschäftspartner getroffen hat.
Der Nutzer versichert, dass sämtliche von ihm publizierten Inhalte mit allen auf sie zutreffenden lokalen, regionalen, nationalen und internationalen Gesetzen konform sind.
Da paperly fortschreitend optimiert und um Funktionen erweitert wird, behält sich paperly das Recht vor, Änderungen der angebotenen Dienste ohne Vorankündigung durchzuführen.
Des Weiteren ist paperly dazu berechtigt, die Dienste für einzelne oder mehrere Nutzer temporär oder permanent unzugänglich zu machen.
</p>
                                <h2>Datenschutz</h2>
                                <p>WIn der heutigen Zeit ist es vielen Nutzern wichtig, dass ihre Daten geheim bleiben und nicht missbraucht werden. Wir sehen es als unsere Aufgabe mit Ihren personenbezogenen Daten verantwortungsvoll umzugehen. In unseren Datenschutzbestimmungen können Sie sich alle Einzelheiten zur Ermittlung und Verwendung und Speicherung ihrer Daten seitens paperly nachlesen. Durch die Nutzung von paperly werden die Datenschutzbestimmungen anerkannt. Falls erforderlich, erhalten Nutzer Mitteilungen, wie Bekanntmachungen Serviceinformationen oder Änderungen der Allgemeinen Geschäftsbedingungen. Die Übermittlung dieser Mitteilungen ist Teil der Dienste von paperly und kann nicht vom Nutzer abgestellt werden. paperly ist jedoch darauf bedacht, dass diese Mitteilungen so selten wie möglich erfolgen, damit diese vom Nutzer nicht als störend empfunden werden.</p>
                                <h2>Kennwörter</h2>
                                <p>Der Nutzer trägt die Verantwortung, sein Kennwort selbst zu schützen. Es ist daher sinnvoll, ein Kennwort zu wählen, das sowohl aus Groß- und Kleinbuchstaben, als auch aus Zahlen und Sonderzeichen besteht. paperly übernimmt keine Verantwortung für Schäden oder Verluste, die durch einen Kennwortverlust entstehen.</p>
                                <h2>Inhalte</h2>
                                <p>Der Zugang zu den Diensten und den Inhalten sowie deren Nutzung findet auf eigene Gefahr statt. paperly übernimmt keine Haftung für die Richtigkeit der über die Dienste bereitgestellten Informationen. Durch die Nutzung der Dienste erklärt der Nutzer sich damit einverstanden, eventuell unangenehmen, anstößigen, irreführenden, rechtswidrigen, falschen oder in anderer Weise unangebrachten Informationen ausgesetzt zu sein. paperly haftet in keinem Fall für durch seine Inhalte entstandene Schäden.</p>
                                <h2>Rechte des Nutzers</h2>
                                <p>Die Rechte für über paperly übermittelte Informationen liegen beim Nutzer. Der Nutzer ist Eigentümer seiner Inhalte. Durch Übermittlung, Publizierung oder Aufrufen von Inhalten über die Dienste erteilt der Nutzer paperly eine weltweite, nicht exklusive, kostenfreie Lizenz, diese Inhalte in allen Medien und über alle Verbreitungswege zu verwenden, zu vervielfältigen, zu reproduzieren, sowie anzupassen, anzuzeigen und zu verbreiten. Die über die Dienste bereitgestellten Informationen können von paperly und seinen Partnern verwendet werden, ohne, dass der Nutzer eine Vergütung erhält.</p>
                                <h2>Publizieren von Informationen</h2>
                                <p>Mit dem Veröffentlichen von Informationen versichert der Nutzer, dass er dazu befugt ist, diese Informationen zu kommunizieren und keine Rechte verletzt. Dies gilt sowohl für Bilder, als auch für Texte. Des Weiteren versichert der Nutzer, dass die veröffentlichten Informationen mit der deutschen Rechtsprechung vereinbar sind.</p>
                                <h2>Rechte von paperly</h2>
                                <p>Alle Rechte, Rechtstitel und Nutzungsrechte an den bereitgestellten Diensten sind und bleiben mit Ausnahme der von den Nutzern übermittelten Informationen alleiniges Eigentum von paperly und seinen Lizenzgebern. Die vorliegenden Nutzungsbedingungen räumen Nutzern nicht das Recht ein, den Namen paperly oder alle dazugehörigen Logos, Slogans, Marken und weitere charakteristische Markenzeichen von paperly zu verwenden.</p>
                                <h2>Schlusswort</h2>
                                <p>Die vorliegenden Nutzungsbedingungen sind solange gültig, bis sie vom Nutzer oder paperly gekündigt werden.
Der Nutzer hat die Möglichkeit, sein Konto zu deaktivieren und die Nutzung der Dienste somit einzustellen. 
Wird ein Konto längere Zeit nicht genutzt, behält sich paperly das Recht vor, den Status dieses Accounts auf inaktiv zu setzen, oder ihn bei entsprechend langer Inaktivität komplett zu kündigen, um die Serverkapazitäten zu schonen. 
</p>
                                <p>Trotz Anerkennung der Nutzungsbedingungen unterliegt jeder Nutzer zuerst den Gesetzen, die für Ihn gültig sind – gleiches gilt auch für paperly. Sollten Inhalte der vorliegenden Bedingungen teilweise nicht gesetzeskonform sein, ist dies als Versäumnis seitens paperly anzusehen. In einem solchen Fall sind entsprechende Inhalte der Nutzungsbedingungen nichtig.
Die vorliegenden Nutzungsbedingungen und alle damit verbundenen Handlungen seitens paperly und der Nutzer unterliegen der Rechtssprechung der Bundesrepublik Deutschland. Dienstleistungen werden betrieben von paperly UG (haftungsbeschränkt) Lenzhalde 4, 87534 Oberstaufen, Deutschland. Bei Rückfragen stehen wir gerne unter info@paperly.de zur Verfügung.
</p>
                             
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
