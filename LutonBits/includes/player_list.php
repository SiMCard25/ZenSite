<?php

print "<FONT size=-2>\n";
//print "<TABLE border=0 cellspacing=1 cellpadding=2>\n";
//print "<tr><th><b>Squad No</b><th><b>Full Name</b>\n";
		
require($qrydir.'PlayerList.sql');

$lm="<center><H1>Loading Data...</H1></center>";

print "<div id=\"PLContainer\" style=\"width:100%; margin:0; auto;\">\n";
  print "<div class=\"PLH\" style=\"width:".("N"==$wn ? "15" : "20")."%;\">No</div>\n"; // close PLHNo
  print "<div class=\"PLH\" style=\"width:80%;\">Name</div>\n";                         // close PLHName
  print "<div class=\"PLLT\" onClick=\"callAHAH('".$incdir."player_info2.php?season=".$season."&playerid=999','InfoPanel','".$lm."')\">\n";
  print "Luton Town";
  print "</div>\n"; // close PLHName
  while ($row = mysql_fetch_assoc($result)) {
    $PNm = ("N"==$wn ? $row['SNm'] : $row['FlN']);
    $bg=($bg=="Orange" ? "Gainsboro" : "Orange");
    $bg=($row['PID']==$playerid ? "ForestGreen" : $bg);
    print "<div class=\"PLPCont\" onClick=\"callAHAH('".$incdir."player_info2.php?season=".$season."&playerid=".$row['PID']."','InfoPanel','".$lm."')\">";
    print "<div class=\"PLNo\" style=\"background-color:".$bg."; width: 15%;\" onclick='this.style=\"background-color:\"ForestGreen\"'>".("99"=$row['SNo'] ? "TBC" ,$row['SNo'])."</div>";
    print "<div class=\"PLNm\" style=\"background-color:".$bg."; width: 80%;\">".$PNm."</div>";
    print "</div>\n";
    print "\n";
  }
print "</div>\n"; // close PLContainer

//$AS="<a href=\"LTFC.php?view=1&season=".$season."&playerid=";
//$bg="r1";

//print "<tr class=".$bg.">";
//print "<td align=center colspan=2><a href=\"LTFC.php?playerid=999&season=".$season."\">Luton Town</a>\n";

//while ($row = mysql_fetch_assoc($result)) {
//	$bg=($bg=="r1" ? "r2" : "r1"); 		
//	$cl=($row['PID']==$playerid ? "sel" : $bg); 		
//  print "<tr class=".$cl.">";
//  print "<div onMouseOver=\"new Effect.Pulsate(this)\"><td>".$AS.$row['PID']."\">".$row['SNo']."</a>";
//  print "<td class=lj>".$AS.$row['PID']."\">".$row['FlN']."</a></div>";
//  print "\n";
//}

print "</font>\n";

?>
