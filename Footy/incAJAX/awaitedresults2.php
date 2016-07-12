<?php

include($qrydir.'awaitedresults.sql');

echo "<form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."&view=90\" method=\"post\">\n";
$rc=mysql_num_rows($result);
echo "<fieldset><legend align=center><font size=3 color=White><b> ".(0==$rc ? "No" : $rc)." result".(1==$rc ? '' : 's')." outstanding </b></font></legend>\n";

echo "<table border=0 cellspacing=1 cellpadding=3>\n";
echo "<tr><th>Game Date<th>Home Team<th colspan=2>Score<th>Away Team<th>Postponed?\n";

$dbg='DarkCyan';
$tbg='DarkSlateGray';
$sbg='DarkOliveGreen';

while ($row=mysql_fetch_assoc($result)) {
	echo "<tr><td align=center bgcolor=".$dbg.">".$row['GDy'].", ".$row['GDt'];
	echo "<td align=right bgcolor=".$tbg."><font color=white>".$row['T1FN']."</font>";
	echo "<td align=center bgcolor=".$sbg."><input type=\"text\" name=\"HG".$row['GID']."\" size=2 maxlength=2/>";
	echo "<td align=center bgcolor=".$sbg."><input type=\"text\" name=\"AG".$row['GID']."\" size=2 maxlength=2/>";
	echo "<td align=left bgcolor=".$tbg."><font color=white>".$row['T2FN']."</font>";
	echo "<td align=center bgcolor=".$tbg."><input type=\"checkbox\" name=\"PP".$row['GID']."\" value=\"Postponement\"".($row['PpI']==1 ? " checked=\"checked\"" : "")."/>";
	echo "\n";
}

// echo "<tr bgcolor=".$sbg."><td colspan=3 align=right>Enter Update Password:<td colspan=4 align=left><input type=\"password\" name=\"PW\" size=10 maxlength=8/>";
echo "<tr><td colspan=7 align=center><input type=submit Value=\"Submit Scores\">\n";

echo "</table>\n";
echo "</fieldset>\n";
echo "</form>\n";

?>