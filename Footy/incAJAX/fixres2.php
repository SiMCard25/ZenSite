<?php

$CSSdir="../CSS/";
$imgdir="../images/";
$incdir="../../../FootyBits/includes/";
$qrydir="../../../FootyBits/queries/";

include($incdir.'functions.php');
require_once($incdir.'Footy_logon.inc');
include($incdir.'setdefaults.php');

/* run the query to get all the fixture / result data */
// print "fixres2.php says Hello";

include($qrydir.'fixres.sql');

// echo "<font size=-2>\n";
print "<table border=0 cellspacing=1 cellpadding=3 bgcolor=DarkGreen><tr>\n";

// echo "<td bgcolor=".$SameTeamCol.">\n";
print "<td>\n";

while ($col = mysql_fetch_assoc($tmlist)) {
	print "<th>".team_anchor($col['TID'] ,$col['TTg']);
}
print "\n";

mysql_data_seek($tmlist ,0);

$row2 = mysql_fetch_assoc($gmdets);
while ($row1 = mysql_fetch_assoc($tmlist)) {
	print "<tr><th>".team_anchor($row1['TID'] ,$row1['TSN'])."\n";
	$doneself=false;
	while ($row2['T1I']==$row1['TID']) {
      if (!$doneself && strtoupper($row2['T2F'])>strtoupper($row2['T1F'])) {
      echo "<td class=resSame>\n";
			$doneself=true;
		}
  	echo "<td class=".$row2['CCl'].">".game_anchor($row2['GID'] ,$row2['FxR']);
		$row2 = mysql_fetch_assoc($gmdets);	
	}
  echo "\n";
}
echo "<td class=resSame>\n";

echo "</table>\n";
echo "</font>\n";

?>