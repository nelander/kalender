<!DOCTYPE html>
<html lang="de">
 <head>
  <meta charset="UTF-8">
  <title>Webcam erfassen</title>

  <style>
  body {
   background: #94D7F8;
   font-family: Verdana, Sans-Serif;
   font-size: 14px;
   }
  </style>

 </head>
<body>

<?php
$monate = array(
		"Januar",
		"Februar",
		"M&auml;rz",
		"April",
		"Mai",
		"Juni",
		"Juli",
		"August",
		"September",
		"Oktober",
		"November",
		"Dezember");
echo "<font size=\"5\" face=\"Arial\">";
//
// Alle jpg-files die mit 'kalender' beginnen aus dem Verzeichnis    
// auslesen und in den Array $bilderdateinamen abspeichern  
//
$verzeichnis = "../bilder/";

if (is_dir($verzeichnis))
{
    if ( $handle = opendir($verzeichnis) )
    {
        while (($file = readdir($handle)) !== false)
        {   
        	// Alle Dateinamen muessen lower case sein
        	$lowfile = strtolower($file);
        	$adrfile = $verzeichnis . $lowfile;
            // Pruefe, ob ein File kalender___.jpg vorliegt
            if ( filetype( $adrfile) == "file"
    			AND substr( $lowfile, 0, 8 ) == "kalender"
    			AND substr( $lowfile, -4 ) == ".jpg" )
            {
                // Dateiname wird im Array gespeichert
                $bilderdateinamen[] = $adrfile;
            }
        }
        closedir($handle);
    }
}
//
// Der Array wird nach Dateinamen sortiert
//
sort($bilderdateinamen);
//
// In eine Schleife ueber alle Array-Eintraege die Bilder ausgeben
//
echo "<hr />";		// Trennlinie ausgeben
$index = 0;
foreach ( $bilderdateinamen AS $dateiname )
{
	$exif = exif_read_data($dateiname, 'ANY_TAG', true, true);
	echo "<img src=\"$dateiname\" ";
    echo $exif['COMPUTED']['html'];
    echo ' > ';
    
    echo "&nbsp;&nbsp;&nbsp; $monate[$index]";
    
    echo "<hr />";	// Trennlinie ausgeben
    $index = $index + 1;
}
$jahr = date("Y");
echo "</font>";
echo "<p><font size=\"1\" face=\"Arial\">&copy; Bengt Nelander " . $jahr . "</font></p>";
?>

</body>
</html>
