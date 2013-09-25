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
                            <div id="logo"> <a href="index.php"><img src="images/design/logo.png" height="54" alt="paperly"></a> </div>
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
                                <h1>Datenschutzbestimmungen</h1><p
                                <p>paperly ist eine Plattform die jedem seiner Nutzer die Möglichkeit bietet, sich nur mit den Informationen zu versorgen, die ihm wirklich wichtig sind. Jedem registrierten Mitglied steht es offen ein Paper zu erstellen oder zu abonnieren. Wir möchten, dass sich unsere Nutzer bezüglich des Schutzes ihrer personenbezogenen Daten sicher fühlen. Der Nutzer muss zu jeder Zeit darüber Bescheid wissen, welche Daten von ihm erhoben werden und wie diese verwendet werden. Dass paperly sich hierbei im Rahmen des Bundesdatenschutzgesetzes bewegt ist dafür eine Grundvoraussetzung. 
                                </p>
                                <h2>Sicherheit</h2>
                                <p>Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.</p>
                                <h2>Personenbezogene Daten</h2>
                                <p>Für die Registrierung bei paperly werden ein Benutzername, eine E-Mail-Adresse und ein Passwort benötigt. Ihr Benutzername ist öffentlich zugänglich. Alle weiteren Daten, wie beispielweise der Name, der Wohnort oder das Geschlecht sind freiwillige Angaben und es liegt im Ermessen des Nutzers, ob er diese Daten angeben möchte. Diese Daten werden vorwiegend verwendet, um das Nutzererlebnis zu verbessern. Auf Wunsch können diese Daten aber auch öffentlich zugänglich gemacht werden, die Entscheidung hierüber trifft jedoch der Nutzer allein. 
Unter Umständen werden auch Daten gespeichert und verarbeitet, die automatisch beim Besuch von paperly erhoben werden, wie z.B. die IP-Adresse, der verwendete Browser, das Betriebssystem oder Datum und Uhrzeit des Zugangs.
</p>
                                <h2>Verwendung von Personenbezogenen Daten</h2>
                                <p>paperly verwendet personenbezogene Daten ausschließlich, um das Erlebnis des Nutzers auf der Plattform zu optimieren. Es werden keine Daten an Dritte weitergegeben oder gar verkauft. Eine Ausnahme stellt hierbei jedoch die Übermittlung an Auskunftsberechtigte staatliche Institutionen und Behörden dar, dies geschieht jedoch nur im Rahmen der gesetzlichen Regelungen und nur, falls paperly dazu verpflichtet ist.</p>
                                <h2>Papers, Badges und andere öffentliche Daten</h2>
                                <p>Der Nutzer hat die Möglichkeit, seine Papers, Badges, Follows und andere nicht-personenbezogene Daten über sein Profil öffentlich zu machen, muss dies jedoch nicht.</p>
                                <h2>Löschung von Daten</h2>
                                <p>Gemäß § 20 Bundesdatenschutzgesetz haben Nutzer jederzeit das Recht, persönliche Daten löschen zu lassen. Falls vom Nutzer gewünscht, werden die persönlichen Daten umgehend aus der Datenbank von paperly entfernt.</p>
                                <h2>Minderjährige</h2>
                                <p>Personen, die das 18. Lebensjahr nicht vollendet haben, sollten ohne Zustimmung ihrer Erziehungsberechtigten keine personenbezogenen Daten an paperly übermitteln.</p>
                                <h2>Änderung der Datenschutzbestimmungen</h2>
                                <p>paperly behält sich das Recht vor, Datenschutzmaßnahmen im Rahmen der fortschreitenden technischen Entwicklung  zu verändern. Selbstverständlich werden die Datenschutzbestimmungen in diesem Fall angepasst und der Nutzer wird über die Änderungen informiert.</p>
                                <h2>Verlinkungen</h2>
                                <p>Die Datenschutzbestimmungen beziehen sich nur auf die Plattform paperly. Sobald ein Nutzer die Seite verlässt, gelten die Datenschutzbestimmungen der Zieladresse. </p>
                                <h2>Datenschutzerklärung für die Nutzung von Facebook-Plugins (Like-Button)</h2>
                                <p>Auf unseren Seiten sind Plugins des sozialen Netzwerks Facebook, 1601 South California Avenue, Palo Alto, CA 94304, USA integriert. Die Facebook-Plugins erkennen Sie an dem Facebook-Logo oder dem "Like-Button" ("Gefällt mir") auf unserer Seite. Eine Übersicht über die Facebook-Plugins finden Sie hier: http://developers.facebook.com/docs/plugins/.
Wenn Sie unsere Seiten besuchen, wird über das Plugin eine direkte Verbindung zwischen Ihrem Browser und dem Facebook-Server hergestellt. Facebook erhält dadurch die Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Facebook "Like-Button" anklicken während Sie in Ihrem Facebook-Account eingeloggt sind, können Sie die Inhalte unserer Seiten auf Ihrem Facebook-Profil verlinken. Dadurch kann Facebook den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der übermittelten Daten sowie deren Nutzung durch Facebook erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von Facebook unter http://de-de.facebook.com/policy.php
Wenn Sie nicht wünschen, dass Facebook den Besuch unserer Seiten Ihrem Facebook-Nutzerkonto zuordnen kann, loggen Sie sich bitte aus Ihrem Facebook-Benutzerkonto aus.
</p>
<h2>Google Analytics</h2>
<p>Diese Website benutzt Google Analytics, einen Webanalysedienst der Google Inc. („Google“). Google Analytics verwendet sog. „Cookies“, Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite, wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum zuvor gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Die IP-Anonymisierung ist auf dieser Website aktiv. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt. Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und installieren: http://tools.google.com/dlpage/gaoptout?hl=de.
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
