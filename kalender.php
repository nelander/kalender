<?php
	//
	// Konstanten fuer den MySQL-Server und die Zugangsdaten
	//
	require_once 'Zugangsdaten.php';
	//
	// Konstanten fuer die Monate und Wochentage
	//
	$monate = array(
		1=>"Januar",
		2=>"Februar",
		3=>"M&auml;rz",
		4=>"April",
		5=>"Mai",
		6=>"Juni",
		7=>"Juli",
		8=>"August",
		9=>"September",
		10=>"Oktober",
		11=>"November",
		12=>"Dezember");
	$tage = array(
		"Sonntag",
		"Montag",
		"Dienstag",
		"Mittwoch",
		"Donnerstag",
		"Freitag",
		"Samstag");
	
	// 
	// Datum, Uhrzeit, Monat und Wochentag ermitteln und ausgeben
	//
	date_default_timezone_set("Europe/Berlin");
	$timestamp 	= time();
	$datum     	= date("d.m.Y",$timestamp);	// Datum 	tt.mm.jjjj
	$uhrzeit   	= date("H:i",$timestamp);	// Uhrzeit 	hh:mm 
    $monat     	= date("n",$timestamp);		// Nummer des Monats
    $tag		= date("j",$timestamp);		// Tag des Monats
    $wochentag 	= date("w",$timestamp);		// Wochentag (0=Sonntag)
    
    echo "<font size=\"5\">";
    echo $tage[$wochentag] . "&nbsp;&nbsp;" . 
    	 $datum . "&nbsp;&nbsp;" . $uhrzeit; 
    
    //
    // Alle jpg-files die mit "kalender" beginnen aus dem Verzeichnis
	// auslesen und in den Array $bilderdateinamen abspeichern
	//
    $verzeichnis = ".";
    
    if (is_dir($verzeichnis))
    {
    	if ( $handle = opendir($verzeichnis) )
    	{
    		while (($file = readdir($handle)) !== false)
    		{
    			// Test, ob ein File kalender___.jpg vorliegt
    			if ( filetype( $file) == "file"
    					AND substr( $file, 0, 8 ) == "kalender"
    					AND substr( $file, -4 ) == ".jpg" )
    			{
    				// Dateiname wird im Array gespeichert
    				$bilderdateinamen[] = $file;
    			}
    		}
    		closedir($handle);
    	}
    }
    
    //
    // Der Array wird nach dem Dateinamen sortiert und der Monatsbild 
    // ausgeben (Bild 1 fuer Monat 1, Bild 2 fuer Monat 2  u.s.w.    
    //
    sort($bilderdateinamen);
    
    $n    = $monat - 1;		// Bildindex 0, 1, 2, ..., 11	
    $exif = exif_read_data($bilderdateinamen[$n], 'ANY_TAG', true, true);
    
    echo "<br />\n ";
    echo "<img src=\"$bilderdateinamen[$n]\" " . 
    	 $exif['COMPUTED']['html'] . ' > ';
    echo "<br />\n $monate[$monat]";
    echo "</font>";
    
    //
    // Hier werden Geburtstage, Feiertage, etc. furr den aktuellen Tag aus
    // der MySQL-Tabelle 'kalender' gelesen und falls vorhanden ausgegeben
    //
    echo "<font size=\"4\">";
    
    // Aktuelles Datum ermitteln
    $heute_yyyy = date("Y");    // aktuelles Jahr in Format yyyy
    $heute_mmdd = date("md");	// aktuelles Datum in Format mmdd
    $kein_jahr  = "0000";		// leeres Jahr in Format yyyy
    
    // Verbindungsaufbau mit der Datenbank
    try {
    	$db = new MySQLi($db_server, $db_benutzer, $db_passwort, $db_name);
    	
    	$sql = "SET NAMES 'utf8'";
    	$db->query($sql);
    
    	// Kalendereintraege fuer aktuelles Datum aus Tabelle 'kalender' lesen
    	$sql="SELECT * FROM `kalender` WHERE `kalender_datum` LIKE '____" . 
    		$heute_mmdd . "' ORDER BY `kalender_art`, `kalender_datum`";
    	$ergebnis = $db->query($sql);
    
    	// Kalendereintraege pruefen und bearbeiten (Zeilen ausgeben)
    	while ($zeile = $ergebnis->fetch_assoc()) {
    		$datum_yyyy = substr($zeile["kalender_datum"], 0, 4);
    		$satzart    = htmlspecialchars($zeile["kalender_art"]);
    		$eintrag    = htmlspecialchars($zeile["kalender_eintrag"]);
    		switch ($satzart) {
    			case "G":	//---- Satzart "G": Geburtstagseintrag
    				if ($datum_yyyy == $kein_jahr) {
    					echo  "<br \>" . "Heute hat " . 
      						htmlspecialchars($eintrag) . " Geburtstag";
    				} else {
    					$alter = $heute_yyyy - $datum_yyyy;
    					echo  "<br \>" . "Heute ist der " . $alter . 
      						". Geburtstag von ". htmlspecialchars($eintrag);
    				}
    				break;
    			case "F":	//---- Satzart "F": Feiertagseintrag
    				echo "<br \>". "Heute ist ". htmlspecialchars($eintrag);
    				break;
    			case "S":	//---- Satzart "S": Sonstiger Eintrag
    				if ($datum_yyyy == $heute_yyyy or 
    					$datum_yyyy == $kein_jahr) {
    					echo "<br \>" . htmlspecialchars($eintrag);
    				}
    				break;
    			default:	//---- Satzart unbekannt
    				echo "<br \>" . "Die Tabelle 'kalender' beinhaltet " . 
      					"den fehlerhaften Satzart '" . $satzart . "'";
    		}
    	}
    
    	// Verbindung zur Datenbank beenden
    	$db->close();
    
	// Fehlerhandling zur Datenbank-Verbindungsaufbau
	} catch (Exception $ex) {
     	echo "<br \>Fehler beim Zugriff auf der Tabelle 'kalender': " . 
     		$ex->getMessage();
    } 
    echo "</font>";
?>