<?php

$today=date('Y-m-d');

if (0==$teamid) {
  echo "<h2>No Team Selected - Choose from the List below:</h2>\n";
  echo "<table border=0 cellspacing=1 cellpadding=3>\n";
  echo "<th>Select Team\n";
  include($qrydir.'fullteamlist.sql');
  $bg='DarkCyan';
  while($row=mysql_fetch_assoc($result)) {
    $bg=($bg=='DarkCyan' ? 'DarkSlateGray' : 'DarkCyan');
    echo "<tr bgcolor=".$bg."><td>".team_anchor($row['TID'] , $row['TFN'])."\n";
  }
  echo "</table>\n";
}
else {
  include($qrydir.'updateform.sql');
  include($qrydir.'teamdetail.sql');
  include($qrydir.'teamform.sql');

  $tdets=mysql_fetch_assoc($td);

  print "<table border=0 cellspacing=0 cellpadding=3>\n";
  print "<tr><th><font size=+2>".$tdets['TFN']."</font>\n";
  print "<th rowspan=2><img src=\"".$imgdir.$tdets['LNm']."\" height=100>\n";
  print "<tr><th>Team Details as at: ".date('l, j F Y')."\n";

  print "<tr><td><table border=0 cellspacing=1 cellpadding=3>\n";
  print "<tr><th colspan=5><font size=+1>Fixture List</font>\n";
  if (0<mysql_num_rows($reslist)) {
    print "<tr><th colspan=5>Games Played\n";
    print "<tr><th>Date<th>Ven<th align=left>Opposition<th>F - A<th>Points\n";
    while($res=mysql_fetch_assoc($reslist)) {
      print "<tr bgcolor=".('H'==$res['Ven'] ? 'DarkCyan' : 'DarkSlateGray').">";
      print "<td>".$res['GDt'];
      print "<td align=center>".$res['Ven'];
      print "<td>".team_anchor($res['OID'] ,$res['ONm']);
      $rcol=('W'==$res['Res'] ? $WinCol : ('L'==$res['Res'] ? $LoseCol : ('N'==$res['Res'] ? $NDrawCol : $SDrawCol ) ) );
      print "<td align=center bgcolor=".$rcol.">".$res['GlF']." - ".$res['GlA'];
      print "<td align=right>".$res['Pts']."\n";
      $Pts=$res['Pts'];
    }
  }

  if (0<mysql_num_rows($fixlist)) {
    print "<tr><th colspan=5>Remaining Fixtures\n";
    print "<tr><th>Date<th>Ven<th align=left>Opposition<th>Pred<th>Points\n";
    while($fix=mysql_fetch_assoc($fixlist)) {
      print "<tr bgcolor=".($fix['FGD']==$today ? 'LimeGreen' : ($fix['FGD']<$today ? 'IndianRed' : ('H'==$fix['Ven'] ? 'DarkCyan' : 'DarkSlateGray'))).">";
      print "<td>".$fix['GDt'];
      print "<td align=center>".$fix['Ven'];
      print "<td>".team_anchor($fix['OID'] ,$fix['OFN']);
      // ##############
      // predict result
      // ##############
      $formscore = ($fix['TVFm']*2) + $fix['TOFm'] - ($fix['OVFm']*2) - $fix['OOFm'];
      print "\n<!-- Form score = ".$formscore." -->\n";
      $predres = ($formscore > 25 ? 'W' : ($formscore < -25 ? 'L' : 'D'));
      $TGF = ROUND((($fix['TVGP']*2) + $fix['TOGP'] + ($fix['OVLF']*2) + $fix['OOLF']) / 30);
      $TGA = ROUND((($fix['TVLF']*2) + $fix['TOLF'] + ($fix['OVGP']*2) + $fix['OOGP']) / 30);
      print "\n<!-- F-A = ".$TGF." - ".$TGA." -->\n";
      $predres = ('D'==$predres ? (5>$TGF ? 'N' : 'S') : $predres);
      $rcol=('W'==$predres ? $WinCol : ('L'==$predres ? $LoseCol : ('N'==$predres ? $NDrawCol : $SDrawCol ) ) );
      print "<td align=center bgcolor=".$rcol.">".$predres;
      $Pts = $Pts + ('W'==$predres ? 3 : ('L'==$predres ? 0 : 1));
      print "<td align=right>".$Pts."\n";
    }
  }

  print "</table>\n";

  // Right column  
  print "<td align=center valign=top>\n";

  // Season records
  print "<table border=0 cellspacing=1 cellpadding=3>\n";

  print "<tr><th colspan=3><h3>Season Records</h3>\n";
  print "<tr><th colspan=3>Home\n";
  $bg=('DarkCyan'==$bg ? 'DarkSlateGray' : 'DarkCyan');
  if (0==mysql_num_rows($hrec)) {
    print "<tr bgcolor=".$bg."><td colspan=3>No Home Games Available.";
  }
  else {
    while($hr=mysql_fetch_assoc($hrec)) {
      print "<tr bgcolor=".$bg."><th>";
      print recordRow($hr['VRs'])."<td>".$hr['ResText']."\n";
    }
  }

  print "<tr><th colspan=3>Away\n";
  $bg=('DarkCyan'==$bg ? 'DarkSlateGray' : 'DarkCyan');
  if (0==mysql_num_rows($arec)) {
    print "<tr bgcolor=".$bg."><td colspan=3>No Away Games Available.";
  }
  else {
    while($ar=mysql_fetch_assoc($arec)) {
      print "<tr bgcolor=".$bg."><th>";
      print recordRow($ar['VRs'])."<td>".$ar['ResText']."\n";
    }
  }

  print "<tr><th colspan=3>Overall\n";
  $bg=('DarkCyan'==$bg ? 'DarkSlateGray' : 'DarkCyan');
  if (0==mysql_num_rows($orec)) {
    print "<tr bgcolor=".$bg."><td colspan=3>No Games Available.";
  }
  else {
    while($or=mysql_fetch_assoc($orec)) {
      print "<tr bgcolor=".$bg."><th>";
      print recordRow($or['VRs'])."<td>".$or['ResText']."\n";
    }
  }

  echo "</table>\n";
  
  print "<br />\n";
  print "<table width=\"100%\">\n";
  print "<tr><th colspan=11><h3>Current Form</h3>\n";
  print "<tr><th><th colspan=7>Last 6 Games<th colspan=3>Factors\n";
  print "<tr><th>Ven<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts<th>GPw<th>LkF<th>Form\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr bgcolor=\"Teal\" align=center><th>H";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['GPw']."<td>".$frm['LkF']."<td>".$frm['Frm']."\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr bgcolor=\"DarkSlateGrey\" align=center><th>A";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['GPw']."<td>".$frm['LkF']."<td>".$frm['Frm']."\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr bgcolor=\"Teal\" align=center><th>OA";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['GPw']."<td>".$frm['LkF']."<td>".$frm['Frm']."\n";
  print "</table>\n";

  print "<br />\n";
/*
  print "<h5>vvv Section Under Development vvv</h5>\n";
  print "<table width=\"100%\">\n";
  print "<tr><th colspan=4><h3>Next Game</h3>\n";
  print "<tr><th>Opposition<th>Ven<th>Prediction<th>Score\n";
  print "<tr bgcolor=\"Teal\" align=center><td>Wolverhampton Wanderers<td>H<td>Draw<td>99-99\n";
  print "</table>\n";
*/

  echo "</table>\n";
}

?>