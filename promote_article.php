<?php
session_start();
$user_id = $_SESSION["user_id"];

include "php/config.php";
// prüfen ob im iframe
//prüfen ob user eingeloggt





$article_id = $_GET["id"];

?>
<script src="js/libs/modernizr-2.0.6.min.js"></script>
<!-- jquery -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<!-- theme lib --> 
<script src="js/libs/promotion/promotionClass.js"></script>
</style>
<!-- search locations -->
<script src="php/getFilterLocations_full.php" type="text/javascript"></script>
<script src="js/libs/location/locationClass_Calculate.js" type="text/javascript"></script>
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
                load_promotioncalcalation();
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



<h1>Artikel Promoten</h1>



<form id="someform" action="promote_article.php" method="post">

    <label>Monate</label>&nbsp;<input type="number" onchange="load_promotioncalcalation();" id="months" name="months" value="1" min="1" max="6"><br/>
    <div class="write_left_list_ort">
        <!-- TODO: required location id -->
        <h7>Stadt:</h7><b style=" color:#F00"> *</b>
        <div id="location-box">
            <div id="location-box-search">
                <input id="searchLocation" class="write"  type="text" value="" name="Location" >
            </div>
            <div id="location-box-result">                                                
                <div id="location-box-result-links" ><!--selectedLocations--></div>
                <div id="location-box-result-info"><!--infoContainer--></div>
                <input id="location-box-result-input" onchange="load_promotioncalcalation();" type="hidden" name="selectedLocations" value="">                      
            </div>
        </div>                                        
    </div>



    <input type="hidden" name="article_id"  value="<?php echo $article_id; ?>"/>

    <input type="submit" id="btnsubmit" value="bestellen" />
</form>





<?php
$article_id = $_POST["article_id"];
$start_date = $_POST["date"];
$sql = "INSERT INTO article_promotion(article_id,start) VALUES ('$article_id','$start_date');";
//echo $sql;
// $eintragen = mysql_query($sql);


echo $_POST["article_id"];




if (isset($_POST["article_id"]) && isset($_POST["months"])) {

    // Datum heute
    $date_start = date("d.m.Y", strtotime('+ 1 day'));
    $months = $_POST["months"];
    $date_end = date("d.m.Y", strtotime('+ ' . $months . ' months'));
    ?>


    <h1>Rechner</h1>

    <p>Start: <?php echo $date_start; ?></p>
    <p>Ende: <?php echo $date_end; ?></p>
    <p>Anzahl Monate: <?php echo $months; ?></p>
    <p>Netto 100€</p>
    <p>Brutto 119€</p>

    <?php
}
?>



<div id="calculation">1</div>


