<?php

// echo 'This will show the league table for CompetitionID: '.$comp;

include($qrydir.'leaguetable.sql');

print "<table border=0 cellpadding=3 cellspacing=1>";
print "\n";
print "<tr>";
print "<th rowspan=2>Team";
print "<th rowspan=2>Pld";
print "<th colspan=5>Home";
print "<th colspan=5>Away";
print "<th colspan=7>Total";
print "\n";
print "<tr>";
print "<th>W";
print "<th>D";
print "<th>L";
print "<th>F";
print "<th>A";
print "<th>W";
print "<th>D";
print "<th>L";
print "<th>F";
print "<th>A";
print "<th>W";
print "<th>D";
print "<th>L";
print "<th>F";
print "<th>A";
print "<th>+/-";
print "<th>Pts";
print "\n";

$noteams = mysql_num_rows($ltb);
$ct1=$cnames['Tp1'];
$ct2=$cnames['Tp2']+$ct1;
$cbm=$noteams - ($cnames['Btm']+1);

/*
$pos=0;
while ($row = mysql_fetch_assoc($result)) {
	if ($pos<$ct1) { $bg='ForestGreen';}
	elseif  ($pos<$ct2) { $bg='DarkGreen';}
	elseif  ($pos>$cbm) { $bg='FireBrick';}
	else { $bg=($bg=='DarkCyan' ? 'DarkSlateGray' : 'DarkCyan'); }
	echo "<tr bgcolor=".$bg.">";
	echo "<td>".team_anchor($row['TID'] ,$row['TFN']);
	echo "<td align=center>".$row['TPld'];
	echo "<td align=center>".$row['HWon'];
	echo "<td align=center>".$row['HDrn'];
	echo "<td align=center>".$row['HLst'];
	echo "<td align=center>".$row['HGF'];
	echo "<td align=center>".$row['HGA'];
	echo "<td align=center>".$row['AWon'];
	echo "<td align=center>".$row['ADrn'];
	echo "<td align=center>".$row['ALst'];
	echo "<td align=center>".$row['AGF'];
	echo "<td align=center>".$row['AGA'];
	echo "<td align=center>".$row['TWon'];
	echo "<td align=center>".$row['TDrn'];
	echo "<td align=center>".$row['TLst'];
	echo "<td align=center>".$row['TGF'];
	echo "<td align=center>".$row['TGA'];
	echo "<td align=center>".($row['TDif']>0 ? "+" : "").$row['TDif'];
	echo "<td align=center>".$row['TPts'];
	echo "\n";
	$pos++;
}
*/

$pos=0;
while ($row = mysql_fetch_assoc($ltb)) {
	if ($pos<$ct1) { $rc="t1";}
	elseif  ($pos<$ct2) { $rc="t2";}
	elseif  ($pos>$cbm) { $rc="b1";}
	else { $rc=($rc=='r1' ? 'r2' : 'r1'); }
	echo "<tr class=".$rc.">";
	echo "<td class=tl>".team_anchor($row['TID'] ,$row['TFN']);
	echo "<td>".$row['TPld'];
	echo "<td>".$row['HWon'];
	echo "<td>".$row['HDrn'];
	echo "<td>".$row['HLst'];
	echo "<td>".$row['HGF'];
	echo "<td>".$row['HGA'];
	echo "<td>".$row['AWon'];
	echo "<td>".$row['ADrn'];
	echo "<td>".$row['ALst'];
	echo "<td>".$row['AGF'];
	echo "<td>".$row['AGA'];
	echo "<td>".$row['TWon'];
	echo "<td>".$row['TDrn'];
	echo "<td>".$row['TLst'];
	echo "<td>".$row['TGF'];
	echo "<td>".$row['TGA'];
	echo "<td>".($row['TDif']>0 ? "+" : "").$row['TDif'];
	echo "<td>".$row['TPts'];
	echo "\n";
	$pos++;
}

echo "</table>\n";

?>