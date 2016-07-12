<?php
echo "<h1>Predictions</h1>\n";

include($qrydir.'updateform.sql');
include($qrydir.'predictions.sql');

if ($pl && 0 < mysql_num_rows($pl)) {
  print "<font size=-1>\n";
  print "<table border=0 cellspacing=1 cellpadding=10>\n";
  print "<tr><th>All Games<th>Best By Competition\n";
  print "<tr><td>\n";
  print "<table border=0 cellspacing=1 cellpadding=3>\n";
  $CID=-1;
  $bg="DarkCyan";
  while ($r=mysql_fetch_assoc($pl)) {
    if ($r['CID']!=$CID) {
      print (0<=$CID ? "<tr><td colspan=6><hr>\n" : "");
      $CID=$r['CID'];
      print "<tr><th colspan=6>".$r['CFN']."\n";
      print "<tr><th>Game Date<th>Home Team<th>Prediction<th>Away Team<th>Cert%<th>Score\n";
    }
    $bg=($bg=="DarkCyan" ? "DarkSlateGray" : "DarkCyan" );
    switch ($r['Res']) {
//      case 'HW': $rescol=$WinCol;
      case 'HW': $rescol="W";
                 break;
//      case 'AW': $rescol=$LoseCol;
      case 'AW': $rescol="L";
                 break;
//      case 'SD': $rescol=$SDrawCol;
      case 'SD': $rescol="D";
                 break;
//      case 'ND': $rescol=$NDrawCol;
      case 'ND': $rescol="D";
                 break;
     }
     $predPC=$r['PPc'];
	   $rc=($rc=='r1' ? 'r2' : 'r1');
	   print "<tr class=".$rc.">";
//     print "<tr bgcolor=".$bg.">";
     print "<td align=left>".$r['GDt'];
//     $comp=$r['CID'];
     print "<td align=right>".team_anchor($r['HID'] ,$r['HSN']);
//     print "<td align=center bgcolor=".$rescol.">".$r['Res'];
     print "<td align=center class=res".$rescol.">".$r['Res'];
     print "<td align=left>".team_anchor($r['AID'] ,$r['ASN']);
     print "<td align=center>".$predPC."%";
//     print "<td align=center bgcolor=".$rescol.">".$r['HGP']."-".$r['AGP'];
     print "<td align=center class=res".$rescol.">".$r['HGP']."-".$r['AGP'];
     print "\n";
   }
  
   print "</table>\n";

   print "<td align=center valign=top>\n";
  
   $CID=-1;
   print "<table border=0 cellspacing=1 cellpadding=3>\n";
   while ($r=mysql_fetch_assoc($br)) {
     if ($r['CID']!=$CID) {
       print (0<=$CID ? "<tr><td colspan=3><hr>\n" : "");
       print "<tr><th colspan=3>".$r['CFN']."\n";
       print "<tr><th>Res<th>Home Team<th>Certainty\n";
       $CID=$r['CID'];
     }
//     $bg=($bg=="DarkCyan" ? "DarkSlateGray" : "DarkCyan" );
//     print "<tr bgcolor=".$bg."><th>".$r['Res'];
	   $rc=($rc=='r1' ? 'r2' : 'r1');
	   print "<tr class=".$rc."><th>".$r['Res'];
     print "<td>".team_anchor($r['HID'] ,$r['HSN']);
     print "<td align=right>".(100<$r['PPc'] ? 100 : $r['PPc'])."%\n";
   }
  
   print "</table>\n";
   print "<hr>\n";
  
   print "<table border=0 cellspacing=1 cellpadding=3>\n";
   print "<tr><th colspan=9>Union Jack (18 bets)\n";
   print "<tr><th>Home Team<th>Res<th>Cert%<th>Home Team<th>Res<th>Cert%<th>Home Team<th>Res<th>Cert%\n";
  
   while ($r=mysql_fetch_assoc($uj)) {
    switch ($r['Res']) {
      case 'HW': $rescol="W";
                 break;
      case 'AW': $rescol="L";
                 break;
      case 'SD': $rescol="D";
                 break;
      case 'ND': $rescol="D";
                 break;
     }
     $rc=($rc=='r1' ? 'r2' : 'r1');
     print ($r['Pos']%3==1 ? "<tr class=".$rc.">" : "");
     print "<td>".team_anchor($r['HID'] ,$r['HSN']);
     print "<td class=res".$rescol." align=center>".$r['Res'];
     print "<td class=res".$rescol." align=right>".(100<$r['PPc'] ? 100 : $r['PPc'])."%\n";
   }
   print "</table>\n";
   print "<hr>\n";
  
   print "<table border=0 cellspacing=1 cellpadding=3>\n";
   print "<tr><th colspan=3>Top 7 (99 Bets)\n";
   print "<tr><th colspan=3>(35x3, 35x4, 21x5, 7x6, 1x7)\n";
   print "<tr><th>Home Team<th>Res<th>Cert%\n";
  
   while ($r=mysql_fetch_assoc($t7)) {
    switch ($r['Res']) {
      case 'HW': $rescol="W";
                 break;
      case 'AW': $rescol="L";
                 break;
      case 'SD': $rescol="D";
                 break;
      case 'ND': $rescol="D";
                 break;
     }
     $rc=($rc=='r1' ? 'r2' : 'r1');
     print "<tr class=".$rc."><td>".team_anchor($r['HID'] ,$r['HSN']);
     print "<td class=res".$rescol." align=center>".$r['Res'];
     print "<td class=res".$rescol." align=right>".(100<$r['PPc'] ? 100 : $r['PPc'])."%\n";
   }
   print "</table>\n";
   print "</table>\n";
   print "</font>\n";
  
}
else {
  echo "<h3>*** No games to be played in the next 7 days ***</h3>\n";
}

?>