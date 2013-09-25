<?

// get db connection
include "config.php";

// get themes, exclude nulled theme: theme_level>0
$query = "SELECT name, theme_id, super_theme, theme_level
    FROM theme
    WHERE theme_level>0
    ORDER BY theme_level, theme_id;";
$result = mysql_query($query) or die(mysql_error());

// get result
echo 'var arrayThemes = new Array();';
$int = 0;
while ($row = mysql_fetch_row($result)) {
    echo 'arrayThemes[' . $int . '] = new Array();';
    echo 'arrayThemes[' . $int . '][0] = "' . $row[0] . '";';
    echo 'arrayThemes[' . $int . '][1] = "' . $row[1] . '";';
    echo 'arrayThemes[' . $int . '][2] = "' . $row[2] . '";';
    echo 'arrayThemes[' . $int . '][3] = "' . $row[3] . '";';
    $int++;
}
mysql_free_result($result);

?>