<?php

echo '<font size=-2>';
print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>\n";
print "<th><b>Day</b><th><b>Date</b><th><b>Opposition</b>";
print "<th><b>Competition</b><th><b>Ven</b>";
print "<th><b>Score</b>\n";

require($qrydir.'GameList.sql');

while ($row = mysql_fetch_assoc($gmlist)) {
  $bg=($row['Ven']=="H" ? "r1" : "r2");
  $cl=($row['GID']==$gameid ? "sel" : $bg);
	print "<tr class=".$cl.">";
print "<!-- Score = >>".$row['Scr']."<< -->\n";
	if ("-"==$row['Scr'] AND 0==$_SESSION['LTFCPW']) {
		print "<td>".$row['GDy'];
		print "<td>".$row['GDt'];
		print "<td class=lj>".$row['Opp'];
	}
	else {
		print "<td><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['GDy']."</a>";
		print "<td><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['GDt']."</a>";
		print "<td class=lj><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['Opp']."</a>";
	}
	print "<td class=lj>".$row['Cmp'];
	print "<td>".$row['Ven'];
	print "<td bgcolor=\"".$row['RsC']."\">".$row['Scr'];
  print "\n";
 }
echo '</font>';
echo '</TABLE>';

?>
