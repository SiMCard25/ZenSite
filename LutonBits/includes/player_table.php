<?php

print "<FONT size=-2>\n";
print "<TABLE border=0 cellspacing=1 cellpadding=2>\n";
print "<tr><th><b>Squad No</b><th><b>Full Name</b>\n";
		
require($qrydir.'PlayerList.sql');

$AS="<a href=\"LTFC.php?view=1&season=".$season."&playerid=";
$bg="r1";

print "<tr class=".$bg.">";
print "<td align=center colspan=2><a href=\"LTFC.php?playerid=999&season=".$season."\">Luton Town</a>\n";

while ($row = mysql_fetch_assoc($result)) {
	$bg=($bg=="r1" ? "r2" : "r1"); 		
	$cl=($row['PID']==$playerid ? "sel" : $bg); 		
  print "<tr class=".$cl.">";
  print "<div onMouseOver=\"new Effect.Pulsate(this)\"><td>".$AS.$row['PID']."\">".$row['SNo']."</a>";
  print "<td class=lj>".$AS.$row['PID']."\">".$row['FlN']."</a></div>";
  print "\n";
}

 echo '</FONT></TABLE>';

?>
