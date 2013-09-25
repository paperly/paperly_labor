/* 
 * Filter Class Library - Paperly v2.6
 * Contains: All core methods of generating Filter items
 */

// properties
var selectedThemeArray = new Array();
var valueSeparator = ';';
// must be different to valueSeparator
var locationSeparator = ',';
var themeLevelMain = 1;
var themeLevelOne = 2;
var themeLevelTwo = 3;
// index of theme array; see: getThemes.php, arrayThemes
var themeIndexName = 0;
var themeIndexID = 1;
var themeIndexSuperTheme = 2;
var themeIndexThemeLevel = 3;
var themeFlagOpenThemeBox = 'OpenThemeBox';
var themeFlagOpenSubThemeBox = 'OpenSubThemeBox';
var themeFlagNulled = '';
var cssClassLinkSelectedThemes = 'selectedThemes';
var cssClassLinkSelected = 'selected';
var cssClassLinkFancyboxThemes = 'fancybox-themes fancybox.iframe';
var cssClassLinkFancyboxSubThemes = 'fancybox-subthemes fancybox.iframe';
// parent: set write_article (single) / filter (multiple)
var themeSelectionFlag = '';
var themeSelectionFlagWriteArticle = 'writearticle';
var themeSelectionFlagFilter = 'filter';
// parent: settings
var divThemeBoxID = '';
var getValueIdentifierThemeBoxID = 'themeboxid';
var inputSelectedThemesName = '';
var getValueIdentifierThemeSelectionFlag = 'themeselectionflag';
// select link --> open fancybox themes (write_article.php)
var linkThemeSelect = '';
// selected theme input --> submit values
var inputSelectedThemes = '';
// pre selected theme input --> openening fancybox subthemes
var inputPreSelectedThemes = '';
// set selected location id --> set theme corresponding location id (filter.php)
var inputSelectedLocationID = '';
// set selected location name --> set theme corresponding location name (filter.php)
var inputSelectedLocationName = '';
// set opening fancybox flag --> themes / subthemes
var inputThemeFlag = '';
// set selected theme id --> for opening corresponding subthemes
var inputSubThemeID = '';
// submit link theme fancybox
var linkThemeSubmit = '';
// submit link subtheme fancybox
var linkSubThemeSubmit = '';
// themes
var targetURLThemeSubmit = 'php/selectThemes.php';
var divThemeSelection = 'theme-selectbox';
var getValueIdentifierThemeSubmitSelectedThemes = 'selectedthemes';
// subthemes
var targetURLSubThemeSubmit = 'php/selectSubThemes.php';
var divSubThemeSelection = 'subtheme-selectbox';
var getValueIdentifierSubThemeSubmitThemeID = 'themeid';
var getValueIdentifierSubThemeSubmitSelectedThemes = 'selectedthemes';

// parent: get specific controls for write_article.php; set themebox, submit name of values
function generateWriteArticleControls(themeboxid, submitvaluesinputname) {
    if (themeboxid != null && themeboxid != '') {
        var html = '';
        // set themebox id
        if (themeboxid != null && themeboxid != '') divThemeBoxID = themeboxid;
        else divThemeBoxID = 'theme-box';
        // set submit name of input values
        if (submitvaluesinputname != null && submitvaluesinputname != '') inputSelectedThemesName = submitvaluesinputname;
        else inputSelectedThemesName = 'selectedThemes';
        // set theme selection for write_article
        themeSelectionFlag = themeSelectionFlagWriteArticle;
        // set id vars
        this.setWriteArticleControlIDs(divThemeBoxID);
        // select box
        html += '<div id="' + divThemeBoxID + '-select">';
        html += '  <a id="' + linkThemeSelect + '" href="javascript:openThemeSelect(true);">Themen auswählen</a>';
        html += '  <input id="' + inputSelectedThemes + '" type="hidden" name="' + inputSelectedThemesName + '" value="">';
        html += '  <input id="' + inputPreSelectedThemes + '" type="hidden" value="">';
        html += '  <input id="' + inputThemeFlag + '" type="hidden" value="">';
        html += '  <input id="' + inputSubThemeID + '" type="hidden" value="">';
        html += '</div>';
        // submit box
        html += '<div id="' + divThemeBoxID + '-submit">';
        html += '  <a id="' + linkThemeSubmit + '"></a>';
        html += '  <a id="' + linkSubThemeSubmit + '"></a>';
        html += '</div>';
        // set output
        document.getElementById(divThemeBoxID).innerHTML = html;
    }
}

// parent: get specific controls for filter.php; set themebox, submit name of values
function generateFilterControls(themeboxid, submitvaluesinputname) {
    if (themeboxid != null && themeboxid != '') {
        var html = '';
        // set themebox id
        if (themeboxid != null && themeboxid != '') divThemeBoxID = themeboxid;
        else divThemeBoxID = 'theme-box';
        // set submit name of input values
        if (submitvaluesinputname != null && submitvaluesinputname != '') inputSelectedThemesName = submitvaluesinputname;
        else inputSelectedThemesName = 'selectedThemes';
        // set theme selection for filter
        themeSelectionFlag = themeSelectionFlagFilter;
        // set id vars
        this.setFilterControlIDs(divThemeBoxID);
        // select box
        html += '<div id="' + divThemeBoxID + '-select">';
        html += '  <input id="' + inputSelectedThemes + '" type="hidden" name="' + inputSelectedThemesName + '" value="">';
        html += '  <input id="' + inputPreSelectedThemes + '" type="hidden" value="">';
        html += '  <input id="' + inputSelectedLocationID + '" type="hidden" value="">';
        html += '  <input id="' + inputSelectedLocationName + '" type="hidden" value="">';
        html += '  <input id="' + inputThemeFlag + '" type="hidden" value="">';
        html += '  <input id="' + inputSubThemeID + '" type="hidden" value="">';
        html += '</div>';
        // submit box
        html += '<div id="' + divThemeBoxID + '-submit">';
        html += '  <a id="' + linkThemeSubmit + '"></a>';
        html += '  <a id="' + linkSubThemeSubmit + '"></a>';
        html += '</div>';
        // set output
        document.getElementById(divThemeBoxID).innerHTML = html;
    }
}

// parent: display filter result
// TODO: set lecation level variable!
function displayFilterSelectedPaper(divresultbox, selectedthemesinputvalue) {

    // set location level
    // TODO: check database level_location
    var locationLevelArray = new Array();
    locationLevelArray.push(3);
    locationLevelArray.push(4);
    locationLevelArray.push(5);
    locationLevelArray.push(6);


    // TODO: get name by id
    var locationLevelNameArray = new Array();
    locationLevelNameArray.push('Staat');
    locationLevelNameArray.push('Bundesland');
    locationLevelNameArray.push('Landkreis');
    locationLevelNameArray.push('Stadt');


    // get formated locations
    if (divresultbox != null && divresultbox != '') {
        var selectedpaperitems = new Array();
        // get unique location id array
        var uniqueLocationIDArray = this.getUniqueLocationIDArray(selectedthemesinputvalue);
        // get location inforamtion
        for (var i = 0; i < uniqueLocationIDArray.length; i++) {
            var locationid = uniqueLocationIDArray[i];
            // get location name
            var locationname = this.getLocationName(locationid);
            // get selected theme count of location id
            var themecount = this.getThemeCountOfSelectedLocation(selectedthemesinputvalue, locationid);
            // get location level
            var locationlevel = this.getLocationLevel(locationid);
            // format fancybox link
            var formatedlink = this.getLocationSelectLink(locationid, locationname, themecount);
            // append paper item
            var paperitem = new Array();
            paperitem.push(locationlevel);
            paperitem.push(formatedlink);
            selectedpaperitems.push(paperitem);

            // TODO: sort by locationid

        }

        // result container
        var html = '';
        html += '<h1>Gewählte Regionen:</h1>';
        html += '<div class="filter_orte_container" >';

        for (var i = 0; i < locationLevelArray.length; i++) {

            // TODO: set image by class
            var locationimage = '<img src="images/filter_pic_' + (i + 1) + '.png"width="30" height="30">';

            // TODO: get name by location level
            var locationname = locationLevelNameArray[i];

            // TODO: simplify htmls
            if (i == 0) html += '  <div class="filter_orte_container_liste_top">';
            else html += '  <div class="filter_orte_container_liste">';
            html += '    <div class="filter_orte_container_liste_bild">' + locationimage + '</div>';
            html += '    <div class="filter_orte_container_liste_text">' + locationname + '</div>';
            html += '    <div class="filter_orte_container_liste_content">';

            for (var j = 0; j < selectedpaperitems.length; j++) {
                if (selectedpaperitems[j][0] == locationLevelArray[i]) html += selectedpaperitems[j][1];
            }

            html += '    </div>';
            html += '  </div>';

        }

        // result container - END
        html += '</div>';
        // set output
        document.getElementById(divresultbox).innerHTML = html;
    }
}

// parent: opene selected location fancybox
function openLocationSelect(locationid, locationname, clickedbyparent) {
    // set selected location id / name
    if (locationid != null && locationid != '') setParentSelectedLocationID(locationid);
    if (locationname != null && locationname != '') setParentSelectedLocationName(locationname);
    // open fancybox
    openThemeSelect(clickedbyparent);
}

// form: Themes
function openThemeSelect(clickedbyparent) {
    // get values, decide event --> load selected / preselected values
    var arraySelectedValues = new Array();
    if (clickedbyparent) {
        if (themeSelectionFlag == themeSelectionFlagFilter) {
            // filter corresponding values by location id
            var locationid = this.getParentSelectedLocationID();
            arraySelectedValues = this.getSelectedLocationThemesInputValue(locationid);
        }
        else arraySelectedValues = this.getSelectedThemesInputValue();
    }
    else arraySelectedValues = this.getPreSelectedThemesInputValue();
    // format target, append selected themes / themebox id / multiple theme selection
    var linkHREF = targetURLThemeSubmit
        + '?' + getValueIdentifierThemeSubmitSelectedThemes + '=' + arraySelectedValues
        + '&' + getValueIdentifierThemeBoxID + '=' + divThemeBoxID
        + '&' + getValueIdentifierThemeSelectionFlag + '=' + themeSelectionFlag;
    // execute submit link
    this.executeSubmitLink(linkThemeSubmit, linkHREF, cssClassLinkFancyboxThemes);
}

//function loadThemeElements(chosenthemes, formatstring) {
function loadThemeElements(chosenthemes, formatstring, themeboxid, themeselectionflag) {
    // set themebox id
    if (themeboxid != null && themeboxid != '') divThemeBoxID = themeboxid;
    else divThemeBoxID = 'theme-box';
    // set single / multiple selection of themes
    themeSelectionFlag = themeselectionflag;
    // set id vars by multiple selection setting
    if (themeSelectionFlag == themeSelectionFlagFilter) this.setFilterControlIDs(themeboxid);
    else this.setWriteArticleControlIDs(themeboxid);
    // get parent locationname
    var locationname = '';
    if (themeSelectionFlag == themeSelectionFlagFilter) locationname = this.getParentSelectedLocationName();
    // get chosenThemes
    selectedThemeArray = this.getFormatedChosenThemes(chosenthemes, formatstring);
    // add header, check selected location
    var selectedlocation = '';
    if (locationname != '') selectedlocation = 'für ' + locationname;
    var html = '';
    html += '<div class="theme-selectbox-header">';
    html += '  <h1>Bitte wähle die Themen ' + selectedlocation + ' aus</h1>';
    html += '</div>';
    // add themes
    if (arrayThemes != null && arrayThemes.length > 0) {
        var themeCount = 1;
        for (var i = 0; i < arrayThemes.length; i++) {
            if (arrayThemes[i][themeIndexThemeLevel] == themeLevelMain) {
                var name = this.normalizeString(arrayThemes[i][themeIndexName]);
                var id = arrayThemes[i][themeIndexID];
                var themeClass = 'theme-' + themeCount;
                // theme container - start tag, add theme class
                html += '<div class="main-theme ' + themeClass + '">';
                // add theme level main
                html += '<div class="main-theme-title">';
                html += '  <h2>' + name + '</h2>';
                html += '</div>';
                // add theme level 1
                html += this.getThemesLevelOne(id);
                // theme container - end tag
                html += '</div>';
                // increase theme count
                themeCount++;
            }
        }
    }
    // add controls
    html += '<div class="theme-selectbox-footer">';
    html += '<span class="theme-selectbox-footer-buttons">';
    html += '  <a href="javascript:selectAllThemes();">Alle anwählen</a>';
    html += '  <a href="javascript:nullAllThemes();">Alle abwählen</a>';
    html += '  <a href="javascript:cancelThemes();">Abbrechen</a>';
    html += '</span>';
    html += '<span class="theme-selectbox-footer-submit">';
    html += '<a href="javascript:submitSelectedThemes();">Themen speichern</a>';
    html += '</span>';
    html += '</div>';
    // set output
    document.getElementById(divThemeSelection).innerHTML = html;
}

function getThemesLevelOne(themeid) {
    var themes = '';
    var linkClass = '';
    var linkHREF = '';
    if (themeid != null && themeid != '') {
        // subtheme container - start tag
        themes += '<div class="main-theme-sublevel">';
        // check for existing sub themes
        if (this.checkSubThemes(themeid)) {
            // add sub themes
            for (var i = 0; i < arrayThemes.length; i++) {
                // add theme, filter by supertheme
                if (arrayThemes[i][themeIndexSuperTheme] == themeid) {
                    var name = this.normalizeString(arrayThemes[i][themeIndexName]);
                    var id = arrayThemes[i][themeIndexID];
                    // check subthemes
                    if (this.checkSubThemes(id)) {
                        // get select sub theme count, formated output
                        name = name + this.getSelectedSubThemeCount(id, true) + ' +';
                        // check if selected sub themes
                        var subthemecount = this.getSelectedSubThemeCount(id, false);
                        if (subthemecount > 0) linkClass = this.formatLinkClass(cssClassLinkSelected);
                        else linkClass = '';
                    }
                    else {
                        // check selected theme
                        if (this.SelectedTheme(id)) linkClass = this.formatLinkClass(cssClassLinkSelected);
                        else linkClass = '';
                    }
                    // format link
                    linkHREF = this.formatLinkHREF('javascript:selectTheme(' + id + ');');
                    themes += '<a id="' + id + '" ' + linkClass + ' ' + linkHREF + '>' + name + '</a>';
                }
            }
        }
        else {
            // add select all of main theme
            if (this.SelectedTheme(themeid)) linkClass = this.formatLinkClass(cssClassLinkSelected);
            else linkClass = '';
            linkHREF = this.formatLinkHREF('javascript:selectTheme(' + themeid + ');');
            themes += '<a id="' + themeid + '" ' + linkClass + ' ' + linkHREF + '>Alle Themen</a>';
        }
        // subtheme container - end tag
        themes += '</div>';
    }
    return themes;
}

// form: SubThemes
function openSubThemeSelect(themeid) {
    if (themeid != null && themeid != '') {
        // get preselected themes
        var arraySelectedValues = this.getPreSelectedThemesInputValue();
        // format target, append selected theme id / selected themes / themebox id / multiple theme selection
        var linkHREF = targetURLSubThemeSubmit
            + '?' + getValueIdentifierSubThemeSubmitThemeID + '=' + themeid
            + '&' + getValueIdentifierSubThemeSubmitSelectedThemes + '=' + arraySelectedValues
            + '&' + getValueIdentifierThemeBoxID + '=' + divThemeBoxID
            + '&' + getValueIdentifierThemeSelectionFlag + '=' + themeSelectionFlag;
        // execute submit link
        this.executeSubmitLink(linkSubThemeSubmit, linkHREF, cssClassLinkFancyboxSubThemes);
    }
    else {
        // do nothing
    }
}

//function loadSubThemeElements(themeid, chosenthemes, formatstring) {
function loadSubThemeElements(themeid, chosenthemes, formatstring, themeboxid, themeselectionflag) {
    // set themebox id
    if (themeboxid != null && themeboxid != '') divThemeBoxID = themeboxid;
    else divThemeBoxID = 'theme-box';
    // set single / multiple selection of themes
    themeSelectionFlag = themeselectionflag;
    // set id vars by multiple selection setting
    if (themeSelectionFlag == themeSelectionFlagFilter) this.setFilterControlIDs(themeboxid);
    else this.setWriteArticleControlIDs(themeboxid);
    // get chosenThemes
    selectedThemeArray = this.getFormatedChosenThemes(chosenthemes, formatstring);
    // get theme name, add to header
    var themeString = this.getNameOfThemeID(themeid);
    // add header
    var html = '';
    html += '<div class="theme-selectbox-header">';
    html += '  <h1>Bitte wähle die Unterthemen von ' + themeString + ' aus</h1>';
    html += '</div>';
    // theme container - start tag, add theme class
    html += '<div class="main-theme">';
    // add themes
    var themes = '';
    var linkClass = '';
    var linkHREF = '';
    if (themeid != null && themeid != '') {
        // subtheme container - start tag
        themes += '<div class="main-theme-sublevel">';
        // add sub themes
        for (var i = 0; i < arrayThemes.length; i++) {
            // add theme, filter by supertheme
            if (arrayThemes[i][themeIndexSuperTheme] == themeid) {
                var name = this.normalizeString(arrayThemes[i][themeIndexName]);
                var id = arrayThemes[i][themeIndexID];
                // check selected theme
                if (this.SelectedTheme(id)) linkClass = this.formatLinkClass(cssClassLinkSelected);
                else linkClass = '';
                // format link
                linkHREF = this.formatLinkHREF('javascript:selectTheme(' + id + ');');
                themes += '<a id="' + id + '" ' + linkClass + ' ' + linkHREF + '>' + name + '</a>';
            }
        }
        // subtheme container - end tag
        themes += '</div>';
    }
    html += themes;
    // theme container - end tag
    html += '</div>';
    // add controls
    html += '<div class="theme-selectbox-footer">';
    html += '<span class="theme-selectbox-footer-buttons">';
    html += '  <a href="javascript:selectAllSubThemes(' + themeid + ');">Alle anwählen</a>';
    html += '  <a href="javascript:nullAllSubThemes(' + themeid + ');">Alle abwählen</a>';
    html += '  <a href="javascript:cancelSubThemes();">Abbrechen</a>';
    html += '</span>';
    html += '<span class="theme-selectbox-footer-submit">';
    html += '  <a href="javascript:submitPreSelectedThemes();">Themen speichern</a>';
    html += '</span>';
    html += '</div>';
    // set output
    document.getElementById(divSubThemeSelection).innerHTML = html;
}

// controls
function selectAllThemes() {
    // get all available themes
    var themes = new Array();
    for (var i = 0; i < arrayThemes.length; i++) {
        themes.push(arrayThemes[i][themeIndexID]);
    }
    // sort array
    themes.sort(themeSort);
    // reload filter
    this.loadThemeElements(themes, false, divThemeBoxID, themeSelectionFlag);
}

function selectAllSubThemes(themeid, themes) {
    if (themeid != null && themeid != '') {
        // get selected themes
        var themes = new Array();
        if (selectedThemeArray != null && selectedThemeArray.length > 0) themes = selectedThemeArray;
        // add sub themes of selected themeid, check preselected subtheme
        for (var i = 0; i < arrayThemes.length; i++) {
            if (arrayThemes[i][themeIndexSuperTheme] == themeid && this.getIndexOfTheme(arrayThemes[i][themeIndexID]) == -1) themes.push(arrayThemes[i][themeIndexID]);
        }
        // sort array
        themes.sort(themeSort);
        // reload filter
        this.loadSubThemeElements(themeid, themes, false, divThemeBoxID, themeSelectionFlag);
    }
}

function nullAllThemes() {
    // reload nulled filter
    this.loadThemeElements(null, false, divThemeBoxID, themeSelectionFlag);
}

function nullAllSubThemes(themeid) {
    if (themeid != null && themeid != '') {
        // get selected themes
        var themes = new Array();
        if (selectedThemeArray != null && selectedThemeArray.length > 0) themes = selectedThemeArray;
        // delete sub themes of selected themeid
        for (var i = 0; i < arrayThemes.length; i++) {
            if (arrayThemes[i][themeIndexSuperTheme] == themeid) {
                var indexoftheme = this.getIndexOfTheme(arrayThemes[i][themeIndexID]);
                if (indexoftheme != -1) themes.splice(indexoftheme, 1);
            }
        }
        // sort array
        themes.sort(themeSort);
        // reload filter
        this.loadSubThemeElements(themeid, themes, false, divThemeBoxID, themeSelectionFlag);
    }
}

function cancelThemes() {
    // null pre selected themes / 
    this.setPreSelectedThemes('');
    // null location id / location name
    if (themeSelectionFlag == themeSelectionFlagFilter) {
        this.setSelectedLocationID('');
        this.setSelectedLocationName('');
    }
    // null theme flag / id on cancel
    this.setThemeFlag(themeFlagNulled);
    this.setThemeID('');
    //close shadowbox
    this.closeFancyBox();
}

function cancelSubThemes() {
    // set theme box flag / null themeid
    this.setThemeFlag(themeFlagOpenThemeBox);
    this.setThemeID('');
    //close shadowbox
    this.closeFancyBox();
}

function submitSelectedThemes() {
    // format values
    var values = '';
    if (themeSelectionFlag == themeSelectionFlagFilter) {
        // get parent locationid
        var locationid = this.getParentSelectedLocationID();
        values = this.formatSelectedLocationInputValue(locationid);
    }
    else values = this.formatSelectedInputValue();
    // store selected themes on parent
    this.setSelectedThemes(values);
    // null theme flag / themeid
    this.setPreSelectedThemes('');
    // null location id / location name
    if (themeSelectionFlag == themeSelectionFlagFilter) {
        this.setSelectedLocationID('');
        this.setSelectedLocationName('');
    }
    this.setThemeFlag(themeFlagNulled);
    this.setThemeID('');
    //close shadowbox
    this.closeFancyBox();
}

function submitPreSelectedThemes(themeid) {
    // format values
    var values = this.formatSelectedInputValue();
    // store pre selected themes on parent
    this.setPreSelectedThemes(values);
    // set theme flag, themeid
    if (themeid != null && themeid != '') {
        this.setThemeFlag(themeFlagOpenSubThemeBox);
        this.setThemeID(themeid);
    }
    else {
        this.setThemeFlag(themeFlagOpenThemeBox);
        this.setThemeID('');
    }
    //close shadowbox
    this.closeFancyBox();
}

// public methods
function executeSubmitLink(linkid, linkhref, linkclass) {
    // set link, values
    document.getElementById(linkid).href = linkhref;
    // set class opening fancybox
    document.getElementById(linkid).className = linkclass;
    // trigger opening fancybox
    document.getElementById(linkid).click();
}

function getFormatedChosenThemes(themes, formatstring) {
    var themearray = new Array();
    if (formatstring) {
        //format string values
        if (themes != null && themes != '') themearray = themes.split(',');
        else themearray = new Array();
    }
    else {
        //get current array
        if (themes != null && themes.length > 0) themearray = themes;
        else themearray = new Array();
    }
    return themearray;
}

function checkSubThemes(themeid) {
    if (themeid != null && themeid != '') {
        // search for corresponding theme, check first found item
        for (var i = 0; i < arrayThemes.length; i++) {
            if (arrayThemes[i][themeIndexSuperTheme] == themeid) return true;
        }
    }
    return false;
}

function getSelectedSubThemeCount(themeid, formatoutput) {
    var subthemecount = 0;
    var maxsubthemes = 0;
    // get selected themes
    if (themeid != null && themeid != '') {
        // search for corresponding selected theme
        for (var i = 0; i < arrayThemes.length; i++) {
            // get max subthemes
            if (arrayThemes[i][themeIndexSuperTheme] == themeid) maxsubthemes++;
            // get selected subthemes
            if (arrayThemes[i][themeIndexSuperTheme] == themeid && this.getIndexOfTheme(arrayThemes[i][themeIndexID]) != -1) subthemecount++;
        }
    }
    // check formating output
    if (formatoutput) {
        var output = '';
        if (subthemecount != 0) {
            if (maxsubthemes != 0 && subthemecount == maxsubthemes) output = 'Alle Arten';
            else if (subthemecount == 1) output = subthemecount + ' Art';
            else output = subthemecount + ' Arten';
            output = ' | ' + output
        }
        return output;
    }
    else return subthemecount;
}

function selectTheme(themeid) {
    if (themeid != null && themeid != '') {
        // check for subthemes
        if (this.checkSubThemes(themeid)) {
            // store current selected values
            this.submitPreSelectedThemes(themeid);
        }
        else {
            // check selected theme
            if (!this.SelectedTheme(themeid)) {
                // add theme
                selectedThemeArray.push(themeid);
                selectedThemeArray.sort(themeSort);
                // change class of selected link
                document.getElementById(themeid).className = cssClassLinkSelected;
            }
            else {
                // remove theme
                var themeIndex = this.getIndexOfTheme(themeid);
                if (themeIndex != -1) selectedThemeArray.splice(themeIndex, 1);
                selectedThemeArray.sort(themeSort);
                // change class of selected link
                document.getElementById(themeid).className = '';
            }
        }
    }
}

function formatSelectedInputValue() {
    var values = '';
    for (var i = 0; i < selectedThemeArray.length; i++) {
        if (i < selectedThemeArray.length - 1) values += selectedThemeArray[i] + valueSeparator;
        else values += selectedThemeArray[i];
    }
    return values;
}

function formatSelectedLocationInputValue(locationid) {
    var values = '';
    if (locationid != null && locationid != '') {
        // get parent selected themes        
        var selectedthemearray = this.getParentSelectedThemesInputValue();
        // splice former selected values by corresponding locationid
        var foreignthemearray = new Array();
        for (var i = 0; i < selectedthemearray.length; i++) {
            // split location
            var locationarray = selectedthemearray[i].split(locationSeparator);
            // filter by locationid
            if (locationarray[0] != locationid) foreignthemearray.push(selectedthemearray[i]);
        }
        // append formated values to former selected values
        for (var i = 0; i < selectedThemeArray.length; i++) {
            // append locationid
            var value = locationid + locationSeparator + selectedThemeArray[i];
            foreignthemearray.push(value);
        }
        // format selected values
        for (var i = 0; i < foreignthemearray.length; i++) {
            if (i < foreignthemearray.length - 1) values += foreignthemearray[i] + valueSeparator;
            else values += foreignthemearray[i];
        }
    }
    return values;
}

function setSelectedThemes(themes) {
    parent.document.getElementById(inputSelectedThemes).value = themes;
}

function getSelectedThemesInputValue() {
    var valueArray = '';
    // get values
    var selectedValues = document.getElementById(inputSelectedThemes).value;
    // parse array
    var valueArray = this.convertThemeString(selectedValues, valueSeparator);
    // return array
    return valueArray;
}

function getParentSelectedThemesInputValue() {
    var valueArray = '';
    // get values
    var selectedValues = parent.document.getElementById(inputSelectedThemes).value;
    // parse array
    var valueArray = this.convertThemeString(selectedValues, valueSeparator);
    // return array
    return valueArray;
}

function getSelectedLocationThemesInputValue(locationid) {
    var valueArray = '';
    if (locationid != null && locationid != '') {
        // get values
        var selectedValues = document.getElementById(inputSelectedThemes).value;
        // parse array
        var valueArray = this.convertLocationThemeString(selectedValues, valueSeparator, locationid, locationSeparator);
    }
    // return array
    return valueArray;
}

function setPreSelectedThemes(themes) {
    parent.document.getElementById(inputPreSelectedThemes).value = themes;
}

function getPreSelectedThemesInputValue() {
    var valueArray = '';
    // get values
    var selectedValues = document.getElementById(inputPreSelectedThemes).value;
    // parse array
    var valueArray = this.convertThemeString(selectedValues, valueSeparator);
    // return array
    return valueArray;
}

function setSelectedLocationID(locationid) {
    parent.document.getElementById(inputSelectedLocationID).value = locationid;
}

function setParentSelectedLocationID(locationid) {
    document.getElementById(inputSelectedLocationID).value = locationid;
}

function getParentSelectedLocationID() {
    var locationid = '';
    locationid = parent.document.getElementById(inputSelectedLocationID).value;
    return locationid;
}

function setSelectedLocationName(locationname) {
    parent.document.getElementById(inputSelectedLocationName).value = locationname;
}

function setParentSelectedLocationName(locationname) {
    document.getElementById(inputSelectedLocationName).value = locationname;
}

function getParentSelectedLocationName() {
    var locationname = '';
    locationname = parent.document.getElementById(inputSelectedLocationName).value;
    return locationname;
}

function setThemeFlag(themeflag) {
    parent.document.getElementById(inputThemeFlag).value = themeflag;
}

function setThemeID(themeid) {
    parent.document.getElementById(inputSubThemeID).value = themeid;
}

function closeFancyBox() {
    parent.jQuery.fancybox.close();
}

function updateThemeSelectInformation(values) {
    if (values != null && values != '') {
        var count = values.length;
        // format select link
        document.getElementById(linkThemeSelect).className = cssClassLinkSelectedThemes;
        if (count > 1) document.getElementById(linkThemeSelect).innerHTML = count + ' Themen gewählt +';
        else document.getElementById(linkThemeSelect).innerHTML = count + ' Thema gewählt +';
    }
    else {
        // null select link
        document.getElementById(linkThemeSelect).className = '';
        document.getElementById(linkThemeSelect).innerHTML = 'Themen auswählen';
    }
}

function getUniqueLocationIDArray(selectedthemes) {
    var uniquelocationidarray = new Array();
    if (selectedthemes != null) {
        for (var i = 0; i < selectedthemes.length; i++) {
            // get location id
            var selectedtheme = selectedthemes[i].split(locationSeparator);
            var locationid = selectedtheme[0];
            // check unique id
            if (this.getIndexOf(uniquelocationidarray, locationid) == -1) {
                uniquelocationidarray.push(locationid);
            }
        }
    }
    return uniquelocationidarray;
}

function getLocationName(locationid) {
    var name = '';
    if (location != null && location != '') {
        if (availableLocationsByID != null) {
            for (var i = 0; i < availableLocationsByID.length; i++) {
                if (availableLocationsByID[i][0] == locationid) return availableLocationsByID[i][1];
            }
        }
    }
    return name;
}

function getThemeCountOfSelectedLocation(selectedthemes, selectedlocationid) {
    var themecount = 0;
    if (selectedthemes != null) {
        if (selectedlocationid != null && selectedlocationid != '') {
            for (var i = 0; i < selectedthemes.length; i++) {
                var selectedtheme = selectedthemes[i].split(locationSeparator);
                var locationid = selectedtheme[0];
                // increase count on matching location id
                if (locationid == selectedlocationid) themecount++;
            }
        }
    }
    return themecount;
}

function getLocationLevel(locationid) {
    var locationlevel = -1;
    if (location != null && location != '') {
        if (availableLocationsByID != null) {
            for (var i = 0; i < availableLocationsByID.length; i++) {
                if (availableLocationsByID[i][0] == locationid) return availableLocationsByID[i][2];
            }
        }
    }
    return locationlevel;
}

function getLocationSelectLink(locationid, locationname, themecount) {
    // set id
    var linkid = '';
    if (locationid != null && locationid != '') linkid = 'id="' + locationid + '"';
    // set class
    var linkclass = 'class="selectedThemes"';
    // set href
    var linkhref = 'href="javascript:openLocationSelect(' + "'" + locationid + "'" + ', ' + "'" + locationname + "'" + ', true);"';
    // set name
    var linkname = locationname;
    if (themecount != null && themecount != '') {
        linkname += ' | ' + themecount;
        if (themecount == 1) linkname += ' Thema';
        else linkname += ' Themen';
        linkname += ' +';
    }
    // format link
    return '<a ' + linkid + ' ' + linkclass + ' ' + linkhref + '>' + linkname + '</a>';
}

// array methods
function getIndexOf(array, value) {
    var index = -1;
    if (array != null && value != null) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == value) index = i;
        }
    }
    return index;
}

function SelectedTheme(themeid) {
    var selected = false;
    if (themeid != null && themeid != '') {
        if (this.getIndexOfTheme(themeid) != -1) selected = true;
        else selected = false;
    }
    return selected;
}

function getIndexOfTheme(themeid) {
    var index = -1;
    if (themeid != null && themeid != '') {
        for (var i = 0; i < selectedThemeArray.length; i++) {
            if (selectedThemeArray[i] == themeid) index = i;
        }
    }
    return index;
}

function getNameOfThemeID(themeid) {
    var name = '';
    for (var i = 0; i < arrayThemes.length; i++) {
        if (arrayThemes[i][themeIndexID] == themeid) name = arrayThemes[i][themeIndexName];
    }
    return name;
}

function themeSort(a, b) {
    return a - b;
}

function convertThemeString(theme_string, separator) {
    var array = null;
    if (theme_string != null && separator != null) {
        array = theme_string.split(separator);
    }

    // TODO: check empty array on nulled split
    if (array.length == 1) {
        // return nulled array
        if (array[0] == '') return new Array();
    }

    return array;
}

function convertLocationThemeString(theme_string, separator, locationid, locationseparator) {
    var array = null;
    // get selected themes
    var themearray = null;
    if (theme_string != null && separator != null) {
        themearray = theme_string.split(separator);
    }
    // get corresponding themes
    array = new Array();
    for (var i = 0; i < themearray.length; i++) {
        // split location
        var locationarray = themearray[i].split(locationseparator);
        // filter by locationid
        if (locationarray[0] == locationid) array.push(locationarray[1]);
    }
    return array;
}

// private methods
function setWriteArticleControlIDs(themeboxid) {
    // set private setting vars
    linkThemeSelect = themeboxid + '-select-link';
    inputSelectedThemes = themeboxid + '-selectedthemes-input';
    inputPreSelectedThemes = themeboxid + '-preselectedthemes-input';
    inputThemeFlag = themeboxid + '-themeflag-input';
    inputSubThemeID = themeboxid + '-subthemeid-input';
    linkThemeSubmit = themeboxid + '-theme-submit-link';
    linkSubThemeSubmit = themeboxid + '-subtheme-submit-link';
}

function setFilterControlIDs(themeboxid) {
    // set private setting vars
    inputSelectedThemes = themeboxid + '-selectedthemes-input';
    inputPreSelectedThemes = themeboxid + '-preselectedthemes-input';
    inputSelectedLocationID = themeboxid + '-selectedlocationid-input';
    inputSelectedLocationName = themeboxid + '-selectedlocationname-input';
    inputThemeFlag = themeboxid + '-themeflag-input';
    inputSubThemeID = themeboxid + '-subthemeid-input';
    linkThemeSubmit = themeboxid + '-theme-submit-link';
    linkSubThemeSubmit = themeboxid + '-subtheme-submit-link';
}

function formatLinkClass(linkclass) {
    formatedlinkclass = '';
    if (linkclass != null && linkclass != '') {
        formatedlinkclass = 'class="' + linkclass + '"';
    }
    else formatedlinkclass = '';
    return formatedlinkclass;
}

function formatLinkHREF(linkhref) {
    formatedlinkhref = '';
    if (linkhref != null && linkhref != '') {
        formatedlinkhref = 'href="' + linkhref + '"';
    }
    return formatedlinkhref;
}

function normalizeString(text) {
    var strippedText = text;
    // trim
    strippedText = strippedText.replace(/^\s+|\s+$/g, '');
    // replace common used UTF-8
    strippedText = strippedText.replace(/ä/g, '&auml;');
    strippedText = strippedText.replace(/Ä/g, '&Auml;');
    strippedText = strippedText.replace(/ü/g, '&uuml;');
    strippedText = strippedText.replace(/Ü/g, '&Uuml;');
    strippedText = strippedText.replace(/ö/g, '&ouml;');
    strippedText = strippedText.replace(/Ö/g, '&Ouml;');
    strippedText = strippedText.replace(/ß/g, '&szlig;');
    return strippedText;
}