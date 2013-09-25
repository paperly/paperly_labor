/* 
 * Timeline Class Library - Paperly v1.2
 * Contains: All core methods of generating timeline items
 */

// properties
var divTimelineNavigation = "header-navbox";
var divTimelineArticel = "";

// methods
function loadTimeLineNavigation(selectedItem, parentItem) {

    // name[0], theme_id[1], super_theme[2]

    var html = '';
    // TODO: dynamic location navigation
 //  html += '<nav role="navigation" id="nav-filter">';
    //html += '<span class="nav-filter-desc">Ich m&ouml;chte Nachrichten aus:</span>';
	//html += ' <div class="location-box"><div id="location-box-search"><input id="searchLocation" class="field" type="text" value="" name="Location"></div><div id="location-box-result"><div id="location-box-result-links"><!--selectedLocations--></div><div id="location-box-result-info"><!--infoContainer--></div><input id="location-box-result-input" type="hidden" name="selectedLocations" value=""></div></div>  ';
  //  html += '</nav>';

    // load theme navigation
    if (navLevelMain != null && navLevelMain.length > 0) {

        // get activeated item
        var activeElementMain = -1, activeElementLevelOne = -1, activeElementLevelTwo = -1;
        if (selectedItem != undefined) {
            var foundItem = 0;
            // search main level
            for (var i = 0; i < navLevelMain.length; i++) {
                if (navLevelMain[i][1] == selectedItem) {
                    activeElementMain = selectedItem;
                    foundItem = 1;
                }
            }
            // search level one
            if (foundItem == 0 && navLevelOne != null && navLevelOne.length > 0) {
                for (var j = 0; j < navLevelOne.length; j++) {
                    if (navLevelOne[j][1] == selectedItem) {
                        activeElementLevelOne = selectedItem;
                        activeElementMain = navLevelOne[j][2];
                        foundItem = 1;
                    }
                }
            }
            // search level three
            if (foundItem == 0 && navLevelTwo != null && navLevelTwo.length > 0) {
                for (var k = 0; k < navLevelTwo.length; k++) {
                    if (navLevelTwo[k][1] == selectedItem) {
                        activeElementLevelTwo = selectedItem;
                        activeElementLevelOne = navLevelTwo[k][2];
                        // get main level of parent item
                        for (var l = 0; l < navLevelOne.length; l++) {
                            if (navLevelOne[l][1] == navLevelTwo[k][2]) activeElementMain = navLevelOne[l][2];
                        }
                    }
                }
            }
        }

        // load main level navigation
        html += '<nav role="navigation" id="nav-main">';
        html += '  <ul>';
        var count = 1;
        for (var i = 0; i < navLevelMain.length; i++) {
            // set list item
            if (count == 1 && count == navLevelMain.length) html += '<li class="single">';
            if (count == 1) html += '<li class="first">';
            else if (count == navLevelMain.length) html += '<li class="last">';
            else html += '<li>';
            // set link
            html += '<a ';
            if (activeElementMain == navLevelMain[i][1]) html += 'class="selected" ';
            html += 'href="javascript:selectNavigationItem(' + navLevelMain[i][1] + ');">' + this.normalizeString(navLevelMain[i][0]);
            html += '</a>';
            // end list item
            html += '</li>';
            count++;
        }
        html += '  </ul>';
        html += '</nav>';

        // load sublevel navigation on selected item at main level
        if (activeElementMain != -1 && navLevelOne != null && navLevelOne.length > 0) {
            // get submenu item count
            var countSubMenu = 0;
            for (var j = 0; j < navLevelOne.length; j++) {
                if (activeElementMain == navLevelOne[j][2]) countSubMenu++;
            }
            // load level one navigation
            if (countSubMenu > 0) {
                html += '<nav role="navigation" id="nav-main-levelone">';
                html += '  <ul>';
                var count = 1;
                for (var j = 0; j < navLevelOne.length; j++) {
                    // add item is parent is selected
                    if (activeElementMain == navLevelOne[j][2]) {
                        // set list item
                        if (count == 1 && count == countSubMenu) html += '<li class="single">';
                        if (count == 1) html += '<li class="first">';
                        else if (count == countSubMenu) html += '<li class="last">';
                        else html += '<li>';
                        // set link
                        html += '<a ';
                        if (activeElementLevelOne == navLevelOne[j][1]) html += 'class="selected" ';
                        html += 'href="javascript:selectNavigationItem(' + navLevelOne[j][1] + ');">' + this.normalizeString(navLevelOne[j][0]); 
                        html += '</a>';
                        // end list item
                        html += '</li>';
                        count++;
                    }
                }
                html += '  </ul>';
                html += '</nav>';

                // load sublevel navigation on selected item at main level
                if (activeElementLevelOne != -1 && navLevelTwo != null && navLevelTwo.length > 0) {
                    // get submenu item count
                    var countSubMenu = 0;
                    for (var k = 0; k < navLevelTwo.length; k++) {
                        if (activeElementLevelOne == navLevelTwo[k][2]) countSubMenu++;
                    }
                    // load level two navigation
                    if (countSubMenu > 0) {
                        html += '<nav role="navigation" id="nav-main-leveltwo">';
                        html += '  <ul>';
                        var count = 1;
                        for (var k = 0; k < navLevelTwo.length; k++) {
                            // add item is parent is selected
                            if (activeElementLevelOne == navLevelTwo[k][2]) {
                                // set list item
                                if (count == 1 && count == countSubMenu) html += '<li class="single">';
                                else if (count == 1) html += '<li class="first">';
                                else if (count == countSubMenu) html += '<li class="last">';
                                else html += '<li>';
                                // set link
                                html += '<a ';
                                if (activeElementLevelTwo == navLevelTwo[k][1]) html += 'class="selected" ';
                                html += 'href="javascript:selectNavigationItem(' + navLevelTwo[k][1] + ');">' + this.normalizeString(navLevelTwo[k][0]);
                                html += '</a>';
                                // end list item
                                html += '</li>';
                                count++;
                            }
                        }
                        html += '  </ul>';
                        html += '</nav>';
                    }
                }
            }
        }
    }
    else {
        // TODO: check missing main level navigation
    }
    // set output
    document.getElementById(divTimelineNavigation).innerHTML = html;
}


// theme select + submit
function selectNavigationItem(selectedItem) {

    // TODO: load selected articles (submit article form)

    document.formArtikelFilter.selectedNavItem.value = selectedItem;

    // submit values
    document.formArtikelFilter.submit();
}

// location select + submit
function selectNavigationItemLocation(selectedItem) {

    // TODO: load selected articles (submit article form)

    //document.formArtikelFilter.selectedNavItemLocation.value = selectedItem;

    // submit values
    document.formArtikelFilter.submit();
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