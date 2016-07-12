<?php

// print "<!-- \$_POST Array:\n";
// foreach ($_POST AS $k => $v) {
// 	print "Key: ".$k." has value: ".$v.".\n";
// }
// print "-->\n";

$_SESSION['FootyEditRef'] = $referrer;

include ($qrydir.'editgame.sql');
$gd=mysql_fetch_assoc($ge);

print "<h2>Edit Game: ".$gameid." from Season: ".$season."</h2>\n";
print "<hr>";

print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<th colspan=5>Existing Details\n";
print "<tr>\n";
print "<th>Game Date";
print "<th>Home Team";
print "<th colspan=2>Score";
print "<th>Away Team\n";
print "<tr bgcolor=DarkOliveGreen>\n";
print "<td align=center>".$gd['FGD'];
print "<td align=right>".$gd['T1FN'];
print "<td align=center>".$gd['T1Gl'];
print "<td align=center>".$gd['T2Gl'];
print "<td align=left>".$gd['T2FN'];
print "\n";
print "</table>";
print "<hr>";

echo "<form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."&view=93\" method=\"post\">\n";
print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<th colspan=5>Edit Details\n";
print "<tr>\n";
print "<th>Game Date";
print "<th>Home Team";
print "<th colspan=2>Score";
print "<th>Away Team\n";
print "<tr bgcolor=DarkCyan>\n";
print "<td align=center><input type=\"text\" name=\"EDt\" size=10 maxlength=10 value=".$gd['FGD']." />\n";
print "<td align=right>".$gd['T1FN']."\n";
print "<td align=center><input type=\"text\" name=\"EG1\" size=2 maxlength=2 value=".$gd['T1Gl']." />\n";
print "<td align=center><input type=\"text\" name=\"EG2\" size=2 maxlength=2 value=".$gd['T2Gl']." />\n";
print "<td align=left>".$gd['T2FN']."\n";
print "</table>\n";
print "<input type=\"hidden\" name=\"GID\" value=".$gd['GID']." />";
print "<hr>";
print "<input type=submit Value=\"OK\">\n";
print "</form>\n";

?>
