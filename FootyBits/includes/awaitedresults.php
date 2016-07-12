<?php

include($qrydir.'updateform.sql');
include($qrydir.'predictions.sql');
include($qrydir.'awaitedresults.sql');

echo "<form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."&view=90\" method=\"post\">\n";
$rc=mysql_num_rows($result);
echo "<fieldset><legend align=center><font size=3><b> ".(0==$rc ? "No" : $rc)." result".(1==$rc ? '' : 's')." outstanding </b></font></legend>\n";

echo "<table border=0 cellspacing=1 cellpadding=3>\n";
echo "<tr><th>Game Date<th>Home Team<th colspan=2>Score<th>Away Team<th>Postponed?<th>Prediction\n";

//$dbg='DarkCyan';
//$tbg='DarkSlateGray';
//$sbg='DarkOliveGreen';

while ($row=mysql_fetch_assoc($result)) {
  $rowcol=($rowcol=='r1' ? 'r2' : 'r1');
	echo "<tr class=".$rowcol."><td align=center>".$row['GDy'].", ".$row['GDt'];
	echo "<td align=right>".$row['T1FN'];
	echo "<td align=center><input type=\"text\" name=\"HG".$row['GID']."\" size=1 maxlength=2/>";
	echo "<td align=center><input type=\"text\" name=\"AG".$row['GID']."\" size=1 maxlength=2/>";
	echo "<td align=left>".$row['T2FN'];
	echo "<td align=center><input type=\"checkbox\" name=\"PP".$row['GID']."\" value=\"Postponement\"/>";
	$resClass = ('D'==substr($row['Pred'],1,1) ? 'D' : ('H'==substr($row['Pred'],0,1) ? 'W' : 'L'));
	echo "<td align=center class=res".$resClass.">".$row['Pred'];
	echo "\n";
}

echo "<tr><td colspan=7 align=center><input type=submit Value=\"Submit Scores\">\n";

echo "</table>\n";
echo "</fieldset>\n";
echo "</form>\n";

?>