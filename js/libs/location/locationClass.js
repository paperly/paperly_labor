/* 
 * Select Location Class Library - Paperly v1.3
 * Contains: All core methods of selecting Location items
 */

// properties
var divLinkContainer = '';
var divInfoContainer = '';
var inputLinkValues = '';
var infoContainerText = '';
var idStringLink = 'location_';
var valueSeparator = ';';

function setLocationProperties(divlinkcontainer, divinfocontainer, infocontainertext, inputlinkvalues, valueseparator) {
    // set values
    if (divlinkcontainer != null && divlinkcontainer != '') divLinkContainer = divlinkcontainer;
    if (divinfocontainer != null && divinfocontainer != '') divInfoContainer = divinfocontainer;
    if (infocontainertext != null && infocontainertext != '') infoContainerText = infocontainertext;
    if (inputlinkvalues != null && inputlinkvalues != '') inputLinkValues = inputlinkvalues;
    if (valueseparator != null && valueseparator != '') valueSeparator = valueseparator;
}

// add multiple selected locations, display result links
function addSelectedLocationLink(locationID, locationName) {
    if (locationID != null && locationName != null && locationID != '') {
        if (divLinkContainer != null && divLinkContainer != '') {
            // get existing links
            var selectedLinks = document.getElementById(divLinkContainer).innerHTML;
            // format link
            var link = '';
            link += '<a '
                + 'id="' + idStringLink + locationID + '" '
                + 'href="javascript:deleteSelectedLocation(' + locationID + ');">'
                + locationName
                + '</a>';
            // check existing location
            var selectedValues = document.getElementById(inputLinkValues).value;
            if (selectedValues != '') {
                var uniqueLocation = this.SelectedLocation(selectedValues, locationID);
                // add unique location link
                if (uniqueLocation) {
                    // add link
                    selectedLinks += link;
                }
            }
            else selectedLinks += link;
            // set output
            document.getElementById(divLinkContainer).innerHTML = selectedLinks;
            // display search info    
            this.setInfoContainerText(infoContainerText);
        }
    }
}

// add single selected location, display result links
function addSelectedLocationLinkSingle(locationID, locationName) {
    if (locationID != null && locationName != null && locationID != '') {
        if (divLinkContainer != null && divLinkContainer != '') {
            // get existing links
            var selectedLinks = document.getElementById(divLinkContainer).innerHTML;
            // format link
            var link = '';
            link += '<a '
                + 'id="' + idStringLink + locationID + '" '
                + 'href="javascript:deleteSelectedLocation(' + locationID + ');">'
                + locationName
                + '</a>';
            // check existing location
            var selectedValues = document.getElementById(inputLinkValues).value;
			/*
            if (selectedValues != '') {
                var uniqueLocation = this.SelectedLocation(selectedValues, locationID);
                // add unique location link
                if (uniqueLocation) {
                    // add link
                    selectedLinks += link;
                }
            }
            else selectedLinks += link;
			*/
			selectedLinks = link;
            // set output
            document.getElementById(divLinkContainer).innerHTML = selectedLinks;
            // display search info    
            this.setInfoContainerText(infoContainerText);
        }
    }
}

// add Single location to imput
function addSelectedLocationInputValueSingle(locationID) {
    if (locationID != null && locationID != '') {
        if (inputLinkValues != null && inputLinkValues != '') {
            // get selected values
            var selectedValues = document.getElementById(inputLinkValues).value;
            // append value, check first value
           selectedValues = locationID;
            
            // set output
            document.getElementById(inputLinkValues).value = selectedValues;
        }
    }
}
// add multiple location to imput
function addSelectedLocationInputValue(locationID) {
    if (locationID != null && locationID != '') {
        if (inputLinkValues != null && inputLinkValues != '') {
            // get selected values
            var selectedValues = document.getElementById(inputLinkValues).value;
            // append value, check first value
            if (selectedValues == '') selectedValues = locationID;
            else {
                // check existing value
                var uniqueLocation = this.SelectedLocation(selectedValues, locationID);
                if (uniqueLocation) selectedValues += valueSeparator + locationID;
            }
            // set output
            document.getElementById(inputLinkValues).value = selectedValues;
        }
    }
}

function deleteSelectedLocation(locationID) {
    if (locationID != null && locationID != '') {
        // delete selected link
        if (divLinkContainer != null && divLinkContainer != '') {
            // get existing links
            var selectedLinkContainer = document.getElementById(divLinkContainer);
            // get selected link
            var selectedLink = document.getElementById(idStringLink + locationID);
            // delete selected link
            selectedLinkContainer.removeChild(selectedLink);
        }
        // delete selected input values
        if (inputLinkValues != null && inputLinkValues != '') {
            // get existing values
            var selectedValues = document.getElementById(inputLinkValues).value;
            // get value array
            var arraySelectedValues = this.convertLocationString(selectedValues, valueSeparator);
            // get value index
            var locationIndex = this.getIndexOf(arraySelectedValues, locationID);
            // remove selected value
            if (locationIndex != -1) arraySelectedValues.splice(locationIndex, 1);
            // format values
            var values = '';
            for (var i = 0; i < arraySelectedValues.length; i++) {
                if (i < arraySelectedValues.length - 1) values += arraySelectedValues[i] + valueSeparator;
                else values += arraySelectedValues[i];
            }
            // set output
            document.getElementById(inputLinkValues).value = values;
            // null search info          
            if (values == '') this.setInfoContainerText(values);
        }
    }

}

function convertLocationString(location_string, separator) {
    var array = null;
    if (location_string != null && separator != null) {
        array = location_string.split(separator);
    }
    return array;
}

function getIndexOf(array, value) {
    var index = -1;
    if (array != null && value != null) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == value) index = i;
        }
    }
    return index;
}

function SelectedLocation(location_string, location) {
    var unique = false;
    if (location_string != null && location != null) {
        var array = convertLocationString(location_string, valueSeparator);
        if (this.getIndexOf(array, location) != -1) unique = false;
        else unique = true;
    }
    return unique;
}

function setInfoContainerText(text) {
    if (divInfoContainer != null && divInfoContainer != '') {
        document.getElementById(divInfoContainer).innerHTML = text;
    }
}