PHP-Projekt "kalender"

Im Projekt-Unterverzeichnis "bilder" werden 12 Bilder in jpg-Format abgelegt, die anzuzeigen
sind.

Wichtig! Die ersten 8 Stellen der Dateinamen muessen "kalender" sein und die Dateiendungen 
muessen ".jpg" sein. Z.B. kalender01.jpg, kalender02.jpg, ....., kalender12.jpg

Hinweis!
Fuer eine gute Ausgabe, sollten die Bilder in ein einheitliches und in eine fuer dem 
Bildschirm passenden Groesse abgespeichert sein. Dafuer gut geeignet ist das Windows-
Programm IrfanView (Benutze dabei:  File / Batch Conversion... / Advanced / Resize / 
Set long side to ...). Dabei bekommen alle Bilder fuer die lange Seite eine einheitliche
Laenge (z.B. 500 Pixel, wie auf meinem Homepage).

kalender.php
------------
Hier wird ein Bild aus der Projekt-Unterverzeichnis "bilder" passend zum Monat ausgegeben. 
Die Bilder werden nach der Dateiname sortiert. Das erste Bild wird im Monat Januar gezeigt, 
das zweite Bild im Monat Februar, etc. Es wird z.B. in Januar das Bild kalender01.jpg und
in Februar das Bild kalender02.jpg angezeigt, u.s.w.

Ausserdem wird Datum, Uhrzeit, Monatsname und die fuer den Tag passenden Eintraege aus der 
Tabelle 'kalender' ausgegeben. Das koennen Geburtstage, Feiertage und sonstige Eintraege sein.

kalender_pflege.php
-------------------
Das Programm listet alle Kalendereintraege auf und bietet die Loeschung bzw. Aenderung
der einzelnen Eintraege an. Ausserdem bietet es ein Link an das Programm zur Erfassung 
eines neuen Kalendereintrags bzw. die Anzeige aller Kalenderbilder.

kalender_insert.php
-------------------
Erfassung eines neuen Kalendereintrags.

kalender_delete.php
-------------------
Loescht ein ausgewaehlter Kalendereintrag.

kalender_update.php
-------------------
aendert ein ausgewaehlter Kalendereintrag. ### BISHER NUR DUMMY  ###

kalender_show.php
-----------------
Zeigt alle Kalender-Bild zusammen, ein Bild fuer jeden Monat
