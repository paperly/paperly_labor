<?

// get db connection
include "config.php";

// get main level navigation
$result = mysql_query("SELECT name, theme_id, super_theme FROM theme WHERE theme_level=1 ORDER BY theme_id;") or die(mysql_error());
echo 'var navLevelMain = new Array();';
$int = 0;
while ($row = mysql_fetch_row($result)) {
    echo 'navLevelMain[' . $int . '] = new Array();';
    echo 'navLevelMain[' . $int . '][0] = "' . $row[0] . '";';
    echo 'navLevelMain[' . $int . '][1] = "' . $row[1] . '";';
    echo 'navLevelMain[' . $int . '][2] = "' . $row[2] . '";';
    $int++;
}
mysql_free_result($result);

// get first level navigation
$result = mysql_query("SELECT name, theme_id, super_theme FROM theme WHERE theme_level=2 ORDER BY theme_id;") or die(mysql_error());
echo 'var navLevelOne = new Array();';
$int = 0;
while ($row = mysql_fetch_row($result)) {
    echo 'navLevelOne[' . $int . '] = new Array();';
    echo 'navLevelOne[' . $int . '][0] = "' . $row[0] . '";';
    echo 'navLevelOne[' . $int . '][1] = "' . $row[1] . '";';
    echo 'navLevelOne[' . $int . '][2] = "' . $row[2] . '";';
    $int++;
}
mysql_free_result($result);

// get second level navigation
$result = mysql_query("SELECT name, theme_id, super_theme FROM theme WHERE theme_level=3 ORDER BY theme_id;") or die(mysql_error());
echo 'var navLevelTwo = new Array();';
$int = 0;
while ($row = mysql_fetch_row($result)) {
    echo 'navLevelTwo[' . $int . '] = new Array();';
    echo 'navLevelTwo[' . $int . '][0] = "' . $row[0] . '";';
    echo 'navLevelTwo[' . $int . '][1] = "' . $row[1] . '";';
    echo 'navLevelTwo[' . $int . '][2] = "' . $row[2] . '";';
    $int++;
}
mysql_free_result($result);

?>