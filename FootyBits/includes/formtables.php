<?php
print "<table><tr>\n";

include($qrydir.'formtabs.sql');

$c="2";
print "<td><table class=\"FixRes\">\n";
print "<tr class=\"DataHead\"><th colspan=8><h3>Last 6 Home Games</h3>\n";
print "<tr class=\"DataHead\"><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($hf)) {
	// Put the teams in the table
	$c=($c=="1" ? "2" : "1");
	print "<tr class=\"r".$c."\"><td align=left>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
	print "<td align=right width=20>".$r['Won']."\n";
	print "<td align=right width=20>".$r['Drn']."\n";
	print "<td align=right width=20>".$r['Lst']."\n";
	print "<td align=right width=20>".$r['GlF']."\n";
	print "<td align=right width=20>".$r['GlA']."\n";
	print "<td align=right width=20>".($r['GDf']>0 ? "+" : "").$r['GDf']."\n";
  print "<td align=right width=20>".$r['Pts']."\n";
}

print "</table>\n";

print "<td><table class=\"FixRes\">\n";
print "<tr class=\"DataHead\"><th colspan=8><h3>Last 6 Away Games</h3>\n";
print "<tr class=\"DataHead\"><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($af)) {
	// Put the teams in the table
	$c=($c=="1" ? "2" : "1");
	print "<tr class=\"r".$c."\"><td align=left>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
	print "<td align=right width=20>".$r['Won']."\n";
	print "<td align=right width=20>".$r['Drn']."\n";
	print "<td align=right width=20>".$r['Lst']."\n";
	print "<td align=right width=20>".$r['GlF']."\n";
	print "<td align=right width=20>".$r['GlA']."\n";
	print "<td align=right width=20>".($r['GDf']>0 ? "+" : "").$r['GDf']."\n";
  print "<td align=right width=20>".$r['Pts']."\n";
}

print "</table>\n";

print "<td><table class=\"FixRes\">\n";
print "<tr class=\"DataHead\"><th colspan=8><h3>Last 6 Games</h3>\n";
print "<tr class=\"DataHead\"><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($of)) {
	// Put the teams in the table
	$c=($c=="1" ? "2" : "1");
	print "<tr class=\"r".$c."\"><td align=left>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
	print "<td align=right width=20>".$r['Won']."\n";
	print "<td align=right width=20>".$r['Drn']."\n";
	print "<td align=right width=20>".$r['Lst']."\n";
	print "<td align=right width=20>".$r['GlF']."\n";
	print "<td align=right width=20>".$r['GlA']."\n";
	print "<td align=right width=20>".($r['GDf']>0 ? "+" : "").$r['GDf']."\n";
  print "<td align=right width=20>".$r['Pts']."\n";
}

print "</table>\n";
?>