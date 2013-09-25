<?php
session_start();
// get db connection
include "php/config.php";
include "php/functions.php";
// global vars
$nulledCreatorID = -1;
$creatorID = $nulledCreatorID;
$nulledPaperID = -1;
$selectedPaperID = $nulledPaperID;
$selectedPaperTitle = '';
$submitControlButtonSavePaper = '';
$submitControlButtonEditPaper = '';
$inputControlPaperTitle = '';
// flag vars
$selectedFlagParameter = '';
$flagSelectpaper = 'SelectPaper';
$flagUpdatePaper = 'UpdatePaper';
$flagSavePaper = 'SavePaper';
$flagNewPaper = 'NewPaper';
$flagChangePaperName = 'ChangePaperName';
$flagViewPaper = 'ViewPaper';
$flagDeletePaper = 'DeletePaper';
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
        echo getHeaderConfig('Filter');
        echo getMetaTags();
        ?>
        <link rel="stylesheet" href="css/style.css" media="screen,projection">
        <link rel="stylesheet" href="css/filter.css" media="screen,projection">
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <!-- template functions -->
        <script src="js/libs/template/templateClass.js"></script>
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
        <script>
            $(document).ready(function() {
                // generate theme controls
                // TODO: rename inputName --> check php vars
                generateFilterControls('filter-form-box', 'selectedThemesArray');
                // set former chosen items, load on select paper
                document.getElementById('filter-form-box-selectedthemes-input').value = formerSelectedThemesFromPaper;
                // display result
                var selectedThemes = getSelectedThemesInputValue();
                displayFilterSelectedPaper('context-box-selected-themes', selectedThemes);

                // set control options
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
                        // set selected location id / name
                        setParentSelectedLocationID(locationID);
                        setParentSelectedLocationName(lacationName);
                        // open theme shadowbox
                        openThemeSelect(true);
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
                            // display result
                            var selectedThemes = getSelectedThemesInputValue();
                            displayFilterSelectedPaper('context-box-selected-themes', selectedThemes);
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

            function submitFilterForm(formid, formflagid, parameter) {
                // set flag parameter for submit
                document.getElementById(formflagid).value = parameter;
                // progess on selected flag
                switch (parameter) {
                    case "SelectPaper":
                        {
                            // submit form
                            document.forms[formid].submit();
                        }
                        break;
                    case "UpdatePaper":
                        {
                            // check selected theme items
                            var selectedthemearray = document.getElementById('filter-form-box-selectedthemes-input').value;
                            if (selectedthemearray == '')
                                alert("Paper speichern: Bitte wählen Sie gülte Filter-Elemente aus.");
                            else {
                                // submit form
                                document.forms[formid].submit();
                            }
                        }
                        break;
                    case "SavePaper":
                        {
                            // check paper title
                            var papertitle = document.getElementById('paperTitle').value;
                            if (papertitle == '')
                                alert("Paper speichern: Bitte füllen Sie einen gültigen Paper-Titel ein.");
                            else {
                                // set title value for submiting form      
                                document.getElementById('filter-form-paper-title').value = papertitle;
                                // check selected theme items
                                var selectedthemearray = document.getElementById('filter-form-box-selectedthemes-input').value;
                                if (selectedthemearray == '')
                                    alert("Paper speichern: Bitte wählen Sie gülte Filter-Elemente aus.");
                                else {
                                    // submit form
                                    document.forms[formid].submit();
                                }
                            }
                        }
                        break;
                    case "NewPaper":
                        // not implemented
                        break;
                    case "ChangePaperName":
                        // not implemented
                        break;
                    case "ViewPaper":
                        {
                            // get paper id
                            var viewpaperid = document.getElementById('filter-form-selectedpaper').value;
                            if (viewpaperid != '') {
                                window.open('paper.php?paper_id=' + viewpaperid, '_self');
                            }
                        }
                        break;
                    case "DeletePaper":
                        {
                            var papertitle = document.getElementById('filter-form-paper-title').value;
                            if (confirm('Wollen Sie das Paper "' + papertitle + '" löschen?')) {
                                // submit form
                                document.forms[formid].submit();
                            }
                        }
                        break;
                    default:
                        // TODO: show exception
                        break;
                }
            }

        </script>
    </head>
    <?php
    // get creator id
    if (isset($_SESSION["user_id"]))
        $creatorID = $_SESSION["user_id"];

    // get session paper id
    if (isset($_SESSION["paper_id"])) {
        if ($_SESSION["paper_id"] != -1) {
//            // check creator of paper, hide upda / delete on foreign current creator
//            $papercreator = getCreatorOfPaper($pdoConnection, $selectedPaperID);
//            // set update controls, prevent update on foreign user
//            if ($creatorID == $papercreator) {
                $selectedPaperID = $_SESSION["paper_id"];
//            }
        }
        // null after selection
        $_SESSION["paper_id"] = -1;
    }

    // get selected paperid
    if (!empty($_POST["selected_paper"]))
        $selectedPaperID = $_POST["selected_paper"];

    // get selected flag parameter
    if (!empty($_POST["filter_form_flag"]))
        $selectedFlagParameter = $_POST["filter_form_flag"];

    // progress on selected flags
    switch ($selectedFlagParameter) {
        case $flagSavePaper: {
                // get label, if nulled set paperid
                if (!empty($_POST["filter_form_paper_title"]))
                    $papertitle = $_POST["filter_form_paper_title"];
                // get selected theme array
                if (!empty($_POST["selectedThemesArray"]))
                    $paperthemearray = $_POST["selectedThemesArray"];
                else
                    $paperthemearray = array();
                // execute insert
                try {
                    // create paper
                    if ($papertitle == '')
                        $papertitle = 'paper';
                    $stmtInsertPaper = $pdoConnection->prepare('INSERT INTO paper (label, creator) VALUES(:label, :creator)');
                    $stmtInsertPaper->bindParam(':label', $papertitle);
                    $stmtInsertPaper->bindParam(':creator', $creatorID);
                    $stmtInsertPaper->execute();
                    // set id of created paper
                    $selectedPaperID = $pdoConnection->lastInsertId();
                    // insert selected themes
                    insertSelectedThemeArray($pdoConnection, $selectedPaperID, $paperthemearray);
                } catch (PDOException $e) {
                    // TODO: display error
                    echo 'ERROR: ' . $e->getMessage();
                }
            }
            break;
        case $flagUpdatePaper: {
                if ($selectedPaperID != $nulledPaperID) {
                    // get label, if nulled set paperid
                    if (!empty($_POST["filter_form_paper_title"]))
                        $papertitle = $_POST["filter_form_paper_title"];
                    else
                        $papertitle = $selectedPaperID;
                    // get selected theme array
                    if (!empty($_POST["selectedThemesArray"]))
                        $paperthemearray = $_POST["selectedThemesArray"];
                    else
                        $paperthemearray = array();
                    // execute update
                    try {
                        // update paper label
                        $stmtUpdateLabel = $pdoConnection->prepare('UPDATE paper SET label = :label WHERE paper_id = :id');
                        $stmtUpdateLabel->bindParam(':label', $papertitle);
                        $stmtUpdateLabel->bindParam(':id', $selectedPaperID);
                        $stmtUpdateLabel->execute();
                        // null former selected themes
                        $stmtDeleteThemes = $pdoConnection->prepare('DELETE FROM subscription WHERE paper_id = :id');
                        $stmtDeleteThemes->bindParam(':id', $selectedPaperID);
                        $stmtDeleteThemes->execute();
                        // insert selected themes
                        insertSelectedThemeArray($pdoConnection, $selectedPaperID, $paperthemearray);
                    } catch (PDOException $e) {
                        // TODO: display error
//                        echo 'ERROR: ' . $e->getMessage();
                    }
                }
            }
            break;
        case $flagDeletePaper: {
                if ($selectedPaperID != $nulledPaperID && $creatorID != $nulledCreatorID) {
                    try {
                        // delete subscription
                        $stmtDeleteThemes = $pdoConnection->prepare('DELETE FROM subscription WHERE paper_id = :id');
                        $stmtDeleteThemes->bindParam(':id', $selectedPaperID);
                        $stmtDeleteThemes->execute();
                        // delete paper
                        $stmtDeletePaper = $pdoConnection->prepare('DELETE FROM paper WHERE paper_id = :id');
                        $stmtDeletePaper->bindParam(':id', $selectedPaperID);
                        $stmtDeletePaper->execute();
                        // null selected paper
                        $selectedPaperID = $nulledPaperID;
                    } catch (PDOException $e) {
                        // TODO: display error
                        //echo 'ERROR: ' . $e->getMessage();
                    }
                }
            }
        default:
            break;
    }

    // get available papers, format option, set nulled first object
    $paperSelectOptions = '<option value="' . $nulledPaperID . '">Neues Paper erstellen</option>';
    if ($creatorID != $nulledCreatorID) {
        try {
            $stmt = $pdoConnection->prepare('SELECT paper_id, label FROM paper WHERE creator = :id');
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute(array(':id' => $creatorID));
            while ($row = $stmt->fetch()) {
                $paperid = $row->paper_id;
                $label = $row->label;
                // check select
                if ($selectedPaperID == $paperid)
                    $selected = 'selected';
                else
                    $selected = '';
                // format option
                $paperSelectOptions = $paperSelectOptions . '<option ' . $selected . ' value="' . $paperid . '">' . $label . '</option>';
            }
        } catch (PDOException $e) {
            // TODO: display error
            //echo 'ERROR: ' . $e->getMessage();
        }
    }

    // set vars of selected paper
    echo "<script>var formerSelectedThemesFromPaper='';</script>";
    if ($selectedPaperID != $nulledPaperID) {
        try {
            // get selected themes
            $stmtThemes = $pdoConnection->prepare('SELECT location, theme FROM subscription WHERE paper_id = :id');
            $stmtThemes->setFetchMode(PDO::FETCH_OBJ);
            $stmtThemes->execute(array(':id' => $selectedPaperID));
            while ($row = $stmtThemes->fetch()) {
                // format: [lid,tid];
                $formatedSelectedThemes = $formatedSelectedThemes . $row->location . ',' . $row->theme . ';';
            }
            // remove last ';'
            $formatedSelectedThemes = substr($formatedSelectedThemes, 0, -1);
            echo "<script>formerSelectedThemesFromPaper='" . $formatedSelectedThemes . "';</script>";
            // get paper title
            $stmtLabel = $pdoConnection->prepare('SELECT label FROM paper WHERE paper_id = :id');
            $stmtLabel->setFetchMode(PDO::FETCH_OBJ);
            $stmtLabel->execute(array(':id' => $selectedPaperID));
            while ($row = $stmtLabel->fetch()) {
                $selectedPaperTitle = $row->label;
            }
            // set controls
        } catch (PDOException $e) {
            // TODO: display error
            //echo 'ERROR: ' . $e->getMessage();
        }
    }

    // set controls
    if ($selectedPaperID != $nulledPaperID) {
        // check creator of paper, hide upda / delete on foreign current creator
        $papercreator = getCreatorOfPaper($pdoConnection, $selectedPaperID);
        // set update controls, prevent update on foreign user
        if ($creatorID == $papercreator)
            $submitControlButtonSavePaper = formatControlSubmitButton('Änderung speichern', $flagUpdatePaper);
        // set edit controls
        $submitControlButtonEditPaper = '';
//        $submitControlButtonEditPaper .= formatControlSubmitButton('Neues Paper', $flagNewPaper);
//        $submitControlButtonEditPaper .= formatControlSubmitButton('Name ändern', $flagChangePaperName);
        $submitControlButtonEditPaper .= formatControlSubmitButton('Paper ansehen', $flagViewPaper);
        // prevent delete on foreign user
        if ($creatorID == $papercreator)
            $submitControlButtonEditPaper .= formatControlSubmitButton('Paper löschen', $flagDeletePaper);
    } else {
        // set save controls
        $submitControlButtonSavePaper = formatControlSubmitButton('Speichern', $flagSavePaper);
        // set title input
        $inputControlPaperTitle = formatPaperTitleInput();
    }

    function formatControlSubmitButton($title, $parameter) {
        $class = 'css3button';
        $type = 'button';
        $value = $title;
        $onclick = "submitFilterForm('filter-form', 'filter-form-flag', '" . $parameter . "');";
        return '<input class="' . $class . '" type="' . $type . '" value="' . $value . '" onClick="' . $onclick . '">';
    }

    function formatPaperTitleInput() {
        $html = '<div class="paper-title-box-container float-left">';
        $html .= '  <h2>Paper-Titel: </h2>';
        $html .= '  <div class="paper-title-box">';
        $html .= '    <input id="paperTitle" class="field" type="text" value="" name="paperTitle">';
        $html .= '  </div>';
        $html .= '</div>';
        return $html;
    }

    function insertSelectedThemeArray($connection, $paperid, $themearray) {
        try {
            // insert selected themes
            $locationID = -1;
            $themeID = -1;
            $stmtInsertThemes = $connection->prepare('INSERT INTO subscription (paper_id, location , theme) VALUES (:id, :locationID, :themeID)');
            $stmtInsertThemes->bindParam(':id', $paperid);
            $stmtInsertThemes->bindParam(':locationID', $locationID);
            $stmtInsertThemes->bindParam(':themeID', $themeID);
            // split formated values: lid1,tid1;lid2,lid2;lid3,lid3
            $array = str_getcsv($themearray, ";");
            for ($i = 0; $i < sizeof($array); ++$i) {
                $theme = str_getcsv($array[$i], ",");
                if ($theme[0] != '' && $theme[1] != '') {
                    $locationID = $theme[0];
                    $themeID = $theme[1];
                    $stmtInsertThemes->execute();
                }
            }
        } catch (PDOException $e) {
            // TODO: display error
//            echo 'ERROR: ' . $e->getMessage();
        }
    }

    function getCreatorOfPaper($connection, $paperid) {
        try {
            $createrid = -1;
            $stmt = $connection->prepare('SELECT creator FROM paper WHERE paper_id = :id');
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute(array(':id' => $paperid));
            while ($row = $stmt->fetch()) {
                $createrid = $row->creator;
            }
            return $createrid;
        } catch (PDOException $e) {
            // TODO: display error
            //echo 'ERROR: ' . $e->getMessage();
        }
    }
    ?>
    <body id="filter">
        <?php /* set docuemnt header, check functions.php */ if (isset($_SESSION["user_id"])) echo getDocumentHeaderLoggedIn('filter', $_SESSION["user_id"], $pdoConnection); ?>
        <div id="container">
            <div id="header-designwrapper-left"></div>
            <div id="header-designwrapper-right"></div>
            <header class="no-print">
                <div class="wrapper clearfix">
                    <div id="header-column">
                        <div id="header-topbox">
                            <div id="logo"> <a href="index.html"><img src="images/design/logo.png"  height="54" alt="paperly"></a> </div>
                            <div id="header-papercontrolbox"> </div>
                        </div>
                        <div id="header-navbox"> </div>
                    </div>
                </div>
            </header>
            <div id="main" role="main" class="clearfix">
                <div class="wrapper clearfix">
                    <div id="notificationbox"></div>
                    <div id="content-column">
                        <section>
                            <div class="content-box clearfix">
                                <form name="filter-form" class="filter-form" enctype="multipart/form-data" action="filter.php" method="post">
                                    <div id="filter-form-box" style="display: none">loading filter controls...</div>
                                    <fieldset class="filter-fieldset">
                                        <h1>Paper bearbeiten:</h1>
                                        <legend class="filter-legend">Formulardaten</legend>
                                        <div id="filter-form-flag-box" style="display: none">
                                            <input id="filter-form-flag" type="hidden" name="filter_form_flag" value="">
                                            <input id="filter-form-selectedpaper" type="hidden" name="filter_form_selectedpaper" value="<?php echo $selectedPaperID; ?>">
                                            <input id="filter-form-paper-title" type="hidden" name="filter_form_paper_title" value="<?php echo $selectedPaperTitle; ?>">
                                        </div>
                                        <div class="filter-fieldwrap">
                                            <select name="selected_paper" onChange="submitFilterForm('filter-form', 'filter-form-flag', '<?php echo $flagSelectpaper; ?>');">
                                                <?php echo $paperSelectOptions; ?>
                                            </select>
                                        </div>
                                        <div class="filter-fieldwrap"><?php echo $submitControlButtonSavePaper; ?></div>
                                        <div class="filter-fieldwrap"><?php echo $submitControlButtonEditPaper; ?></div>
                                    </fieldset>
                                </form>
                            </div>
                            <hr>
                            <div class="content-box clearfix"><?php echo $inputControlPaperTitle; ?></div>
                            <div class="content-box clearfix">
                                <div class="location-box-container float-left">
                                    <h2>Ort oder Region hinzufügen: </h2>
                                    <div id="location-box">
                                        <div id="location-box-search">
                                            <input id="searchLocation" class="field" type="text" value="" name="Location">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-box clearfix">
                                <div id="context-box-selected-themes"><!-- fill selected filter elements --></div>
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
