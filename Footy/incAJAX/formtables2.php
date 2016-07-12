<?php
print "<table border=0 cellpadding=10 cellspacing=0><tr>\n";

include($qrydir.'formtabs.sql');

$bg="DarkCyan";
print "<td><table border=0 cellpadding=2 cellspacing=1>\n";
print "<tr><th colspan=8><h3>Last 6 Home Games</h3>\n";
print "<tr><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($hf)) {
	// Put the teams in the table
	$bg=($bg=="DarkCyan" ? "DarkSlateGray" : "DarkCyan");
	print "<tr bgcolor=".$bg."><td>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
	print "<td align=right width=20>".$r['Won']."\n";
	print "<td align=right width=20>".$r['Drn']."\n";
	print "<td align=right width=20>".$r['Lst']."\n";
	print "<td align=right width=20>".$r['GlF']."\n";
	print "<td align=right width=20>".$r['GlA']."\n";
	print "<td align=right width=20>".($r['GDf']>0 ? "+" : "").$r['GDf']."\n";
  print "<td align=right width=20>".$r['Pts']."\n";
}

print "</table>\n";

$bg="DarkCyan";
print "<td><table border=0 cellpadding=2 cellspacing=1>\n";
print "<tr><th colspan=8><h3>Last 6 Away Games</h3>\n";
print "<tr><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($af)) {
	// Put the teams in the table
$bg=($bg=="DarkCyan" ? "DarkSlateGray" : "DarkCyan");
	print "<tr bgcolor=".$bg."><td>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
	print "<td align=right width=20>".$r['Won']."\n";
	print "<td align=right width=20>".$r['Drn']."\n";
	print "<td align=right width=20>".$r['Lst']."\n";
	print "<td align=right width=20>".$r['GlF']."\n";
	print "<td align=right width=20>".$r['GlA']."\n";
	print "<td align=right width=20>".($r['GDf']>0 ? "+" : "").$r['GDf']."\n";
  print "<td align=right width=20>".$r['Pts']."\n";
}

print "</table>\n";

$bg="DarkCyan";
print "<td><table border=0 cellpadding=2 cellspacing=1>\n";
print "<tr><th colspan=8><h3>Last 6 Games</h3>\n";
print "<tr><th>Team<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts\n";
while ($r=mysql_fetch_assoc($of)) {
	// Put the teams in the table
	$bg=($bg=="DarkCyan" ? "DarkSlateGray" : "DarkCyan");
	print "<tr bgcolor=".$bg."><td>".team_anchor($r['TID'] ,$r['TSN'] ,$comp ,$season)."\n";
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