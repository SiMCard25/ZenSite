<?php

// echo 'This will show the league table for CompetitionID: '.$comp;

include($qrydir.'leaguetable.sql');
include($qrydir.'predictions_ssn.sql');

print "<table border=0 cellpadding=3 cellspacing=10>";

print "<td><table class=\"FixRes\">\n";
print "<tr class=\"DataHead\">";
print "<th rowspan=2>Team";
print "<th rowspan=2>Pld";
print "<th colspan=5>Home";
print "<th colspan=5>Away";
print "<th colspan=7>Total";
print "\n";
print "<tr class=\"DataHead\">";
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
//print "<th>Pos";
print "\n";

$noteams = mysql_num_rows($ltb);
$ct1=$cnames['Tp1'];
$ct2=$cnames['Tp2']+$ct1;
$cbm=$noteams - ($cnames['Btm']+1);

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
//	echo "<td>".$row['TPos'];
	echo "\n";
	$pos++;
}

print "</table>\n";

print "<td><td><table  class=\"FixRes\">\n";
print "<tr class=\"DataHead\"><th colspan=2>Pred. Final Table\n";
print "<tr class=\"DataHead\">";
print "<th>Team";
print "<th>Pts";
//print "<th>Delta";
print "\n";
$pos=0;
while ($row = mysql_fetch_assoc($pl)) {
	if ($pos<$ct1) { $rc="t1";}
	elseif  ($pos<$ct2) { $rc="t2";}
	elseif  ($pos>$cbm) { $rc="b1";}
	else { $rc=($rc=='r1' ? 'r2' : 'r1'); }
	print "<tr class=".$rc.">";
	print "<td class=tl>".team_anchor($row['TID'] ,$row['TSN']);
	print "<td>".$row['Pts'];
//	print "<td>".$row['Delta'];
	print "\n";
	$pos++;
}
print "</table>\n";

echo "</table>\n";
?>