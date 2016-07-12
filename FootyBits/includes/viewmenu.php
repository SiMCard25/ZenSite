<?php

include($incdir.'menucolors.php');

// echo "<table border=1 cellpadding=2 cellspacing=0>\n";
//echo "<table border=0 cellpadding=0 cellspacing=0>\n";
//echo "<th><img src=\"".$imgdir."view_menu_header.gif\" alt=\"View\">\n";

echo "<table>\n";
echo "<tr><th>View\n";

for ($iv=0 ; $iv<=5 ; $iv++ ) {
  echo view_menu_item($iv);
  }

echo "</table>\n";

?>