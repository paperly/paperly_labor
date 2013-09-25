<?

// get db connection
include "config.php";

// get locations
$query = "SELECT location.name, level_location.name, location.location_id, location.location_level
    FROM location 
    INNER JOIN level_location on location.location_level = level_location.level_location_id
    WHERE location.location_id > 0";
$result = mysql_query($query) or die(mysql_error());

echo 'var availableLocations = new Array();';
echo 'var availableLocationsByID = new Array();';

$int = 0;
while ($row = mysql_fetch_row($result)) {
    echo 'availableLocations[' . $int . '] = "' . $row[0] . '";';
    echo 'availableLocationsByID[' . $int . '] = new Array();';
    echo 'availableLocationsByID[' . $int . '][0] = "' . $row[2] . '";';
    echo 'availableLocationsByID[' . $int . '][1] = "' . $row[0] . '";';
    echo 'availableLocationsByID[' . $int . '][2] = "' . $row[3] . '";';
    $int++;
}
//mysql_free_result($result);

?>