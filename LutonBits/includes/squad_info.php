<?php

require($qrydir.'SquadDetail.sql');

print "<hr>";

print "<table border=0 cellpadding=2 cellspacing=1 width=\"100%\">\n";
print "\n";
print "<td width=\"30%\" class=lj><img src=\"".$imgdir."LutonTown.gif\" style=\"height: 100px;\">";
print "<td width=\"40%\"><h2>Squad Summary - ".$SeasonFullName[$season]."</h2>\n";
print "<td width=\"30%\" class=rj><img src=\"".$imgdir."LutonTown.gif\" style=\"height: 100px;\">";
print "</TABLE>\n";
echo '<hr>';
echo '<font size=-2>';
print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>\n";
print "'<tr bgcolor=silver>\n";

print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=0\">No</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=1\">Name</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=2\">MCSP</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=3\">Pld(Sub)</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=4\">Mins</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=5\">Won</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=6\">Drawn</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=7\">Lost</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=8\">Goals</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=9\">Team GF</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=10\">Team GA</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=11\">Clean Sheets</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=12\">Yellow Cards</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=13\">Red Cards</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=14\">Points</a>\n";

/* NB: $sqtot = Squad Summary            */
/*     $cdtot = Card Summary             */
/*     $pltot = Player Summaries         */

 $row1 = mysql_fetch_assoc($sqtot);
 $row2 = mysql_fetch_assoc($cdtot);
  
 $bg="Gainsboro";

echo '<tr bgcolor="'.$bg.'">';
echo '<td colspan=3><b>Luton Town</b>';
echo '<td><b>'.$row1['FGm'].'</b>';
echo '<td><b>'.number_format($row1['MPl'],0).'</b>';
echo '<td><b>'.$row1['Won'].'</b>';
echo '<td><b>'.$row1['Drn'].'</b>';
echo '<td><b>'.$row1['Lst'].'</b>';
echo '<td><b>'.$row1['PGl'].'</b>';
echo '<td><b>'.$row1['TGF'].'</b>';
echo '<td><b>'.$row1['TGA'].'</b>';
echo '<td><b>'.$row1['CSh'].'</b>';
echo '<td><b>'.$row2['YCd'].'</b>';
echo '<td><b>'.$row2['RCd'].'</b>';
echo '<td><b>n/a</b>';
 print "\n";
   
 while ($row = mysql_fetch_assoc($pltot)) {
   $bg=($bg=="Gainsboro" ? "Orange" : "Gainsboro");
 	echo '<tr bgcolor="'.$bg.'">';
 	print "<td><a href=\"LTFC.php?view=1&playerid=".$row['PID']."&season=".$season."\">".$row['SNo']."</a>";
 	print "<td class=lj><a href=\"LTFC.php?view=1&playerid=".$row['PID']."&season=".$season."\">".$row['PNm']."</a>";
  $playerid=$row['PID'];
  require($qrydir.'MCSP.sql');
  $MCSProw = mysql_fetch_assoc($MCSP);
 	echo '<td>'.$MCSProw['Tag'];
 	echo '<td>'.$row['FGm'].'('.$row['SGm'].')';
 	echo '<td>'.number_format($row['MPl'],0);
 	echo '<td>'.$row['Won'];
 	echo '<td>'.$row['Drn'];
 	echo '<td>'.$row['Lst'];
 	echo '<td>'.$row['PGl'];
 	echo '<td>'.$row['TGF'];
 	echo '<td>'.$row['TGA'];
  	echo '<td>'.$row['CSh'];
  	echo '<td>'.$row['YCd'];
  	echo '<td>'.$row['RCd'];
  	echo '<td>'.number_format($row['PPt'],0);
   print "\n";
 }
 echo '</font>';
 echo '</TABLE>';
 print "\n";

echo '<hr>';
print "<table border=0 cellpadding=2 cellspacing=1 width=\"100%\">\n";
print "\n";
print "<td ><h2>Squad Summary - since 2004-05 Season</h2>\n";
print "</TABLE>\n";
echo '<hr>';

echo '<font size=-2>';
print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>\n";
print "'<tr bgcolor=silver>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=1\">Name</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=2\">MCSP</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=3\">Pld(Sub)</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=4\">Mins</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=5\">Won</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=6\">Drawn</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=7\">Lost</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=8\">Goals</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=9\">Team GF</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=10\">Team GA</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=11\">Clean Sheets</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=12\">Yellow Cards</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=13\">Red Cards</a>\n";
print "<td><a href=\"LTFC.php?view=1&season=".$season."&so=14\">Points</a>\n";

/* NB: $sqtot = Squad Summary            */
/*     $cdtot = Card Summary             */
/*     $pltot = Player Summaries         */

 $row1 = mysql_fetch_assoc($sqAllTime);
 $row2 = mysql_fetch_assoc($cdAllTime);
  
$bg="Gainsboro";

echo '<tr bgcolor="'.$bg.'">';
echo '<td colspan=2><b>Luton Town</b>';
echo '<td><b>'.$row1['FGm'].'</b>';
echo '<td><b>'.number_format($row1['MPl'],0).'</b>';
echo '<td><b>'.$row1['Won'].'</b>';
echo '<td><b>'.$row1['Drn'].'</b>';
echo '<td><b>'.$row1['Lst'].'</b>';
echo '<td><b>'.$row1['PGl'].'</b>';
echo '<td><b>'.$row1['TGF'].'</b>';
echo '<td><b>'.$row1['TGA'].'</b>';
echo '<td><b>'.$row1['CSh'].'</b>';
echo '<td><b>'.$row2['YCd'].'</b>';
echo '<td><b>'.$row2['RCd'].'</b>';
echo '<td><b>n/a</b>';
 print "\n";
   
 while ($row = mysql_fetch_assoc($plAllTime)) {
   $bg=($bg=="Gainsboro" ? "Orange" : "Gainsboro");
 	echo '<tr bgcolor="'.$bg.'">';
 	print "<td class=lj><a href=\"LTFC.php?view=1&playerid=".$row['PID']."&season=".$row['MSID']."\">".$row['PNm']."</a>";
  $playerid=$row['PID'];
  require($qrydir.'MCSP.sql');
  $MCSProw = mysql_fetch_assoc($MCSPAllTime);
 	echo '<td>'.$MCSProw['Tag'];
 	echo '<td>'.$row['FGm'].'('.$row['SGm'].')';
 	echo '<td>'.number_format($row['MPl'],0);
 	echo '<td>'.$row['Won'];
 	echo '<td>'.$row['Drn'];
 	echo '<td>'.$row['Lst'];
 	echo '<td>'.$row['PGl'];
 	echo '<td>'.$row['TGF'];
 	echo '<td>'.$row['TGA'];
  	echo '<td>'.$row['CSh'];
  	echo '<td>'.$row['YCd'];
  	echo '<td>'.$row['RCd'];
  	echo '<td>'.number_format($row['PPt'],0);
   print "\n";
 }
 echo '</font>';
 echo '</TABLE>';
 print "\n";
?>
