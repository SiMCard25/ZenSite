<?php

print "<form action=\"".$_SESSION['LTFCRef']."\" method=\"post\">\n";
print "<input type=\"hidden\" name=\"EPG\" value=\"TRUE\" />\n";

print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<th colspan=10>Edit Player Detail\n";

print "<tr><th>Squad No<th>Player Name<th>Starting Position<th>On<th>Off<th>Goals<th>Y<th>R\n";

while ($pl = mysql_fetch_assoc($plrlist)) {
  mysql_data_seek($poslist ,0);
  print "<tr><th>".$pl['SqN'];
  print "<th>".$pl['PFN'];
  print "<td><select name=\"optPPs".$pl['PID']."\">";
  while ($psl = mysql_fetch_assoc($poslist)) {
    print "<option value=".$psl['PID'];
    if ($pl['PosID']==$psl['PID']) {
      print " selected=\"selected\"";
    }
    print ">".$psl['PFN']."</option>";
  }
  print "</select>\n";
  print "<td><input  type=\"text\" name=\"txtOnMin".$pl['PID']."\" value=\"".$pl['OnMin']."\" size=3 maxlength=3>\n";
  print "<td><input  type=\"text\" name=\"txtOffMin".$pl['PID']."\" value=\"".$pl['OffMin']."\" size=3 maxlength=3>\n";
  print "<td><input  type=\"text\" name=\"txtGoals".$pl['PID']."\" value=\"".$pl['Goals']."\" size=2 maxlength=2>\n";
  print "<td><input  type=\"text\" name=\"txtYC".$pl['PID']."\" value=\"".$pl['YCard']."\" size=1 maxlength=1>\n";
  print "<td><input  type=\"text\" name=\"txtRC".$pl['PID']."\" value=\"".$pl['RCard']."\" size=1 maxlength=1>\n";
}

print "<tr>";
print "<td align=center colspan=3><input type=submit name =\"UpdateGamePlayer\" value=\"Apply Update to Players\">";
print "<td align=center colspan=4><input type=submit name =\"CloneLastGame\" value=\"Copy Squad from Last Game\">";
print "\n";

print "</table>\n";
print "</form>\n";

?>