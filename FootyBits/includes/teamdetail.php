<?php

$today=date('Y-m-d');

if (0==$teamid) {
  echo "<h2>No Team Selected - Choose from the List below:</h2>\n";
//  echo "<table class=\"FixRes\">\n";
  echo "<table>\n";
  echo "<tr class=\"DataHead\"><th>Select Team\n";
  include($qrydir.'fullteamlist.sql');
  $c='2';
  while($row=mysql_fetch_assoc($result)) {
    $c=($c=='1' ? '2' : '1');
    echo "<tr class=\"r".$c."\"><td>".team_anchor($row['TID'] , $row['TFN'])."\n";
  }
}
else {
  include($qrydir.'updateform.sql');
  include($qrydir.'teamdetail.sql');
  include($qrydir.'teamform.sql');

  $tdets=mysql_fetch_assoc($td);

  print "<table border=0 cellspacing=0 cellpadding=3>\n";
//  print "<tr><th><font size=+2>".$tdets['TFN']."</font>\n";
  print "<tr><th><font size=+2";
  print " color='".$tdets['Cl1']."'\n";
  print ">".$tdets['TFN']."</font>\n";
//  print "<th rowspan=2><img src=\"".$imgdir.$tdets['LNm']."\" height=100>\n";
  print "<th rowspan=2><img src=\"".$tdets['LLk']."\" width=100 height=100>\n";

  print "<tr><th>Team Details as at: ".date('l, j F Y')."\n";

  print "<tr><td><table class=\"FixRes\">\n";
  print "<tr class=\"DataHead\"><th colspan=5><font size=+1>Fixture List</font>\n";
  if (0<mysql_num_rows($reslist)) {
    print "<tr class=\"DataHead\"><th colspan=5>Games Played\n";
    print "<tr class=\"DataHead\"><th>Date<th>Ven<th align=left>Opposition<th>F - A<th>Points\n";
    $ChartData='0';
    $Pld=0;
    while($res=mysql_fetch_assoc($reslist)) {
      print "<tr class=\"r".('H'==$res['Ven'] ? '2' : '1')."\">";
      print "<td>".$res['GDt'];
      print "<td align=center>".$res['Ven'];
      print "<td align=left>".team_anchor($res['OID'] ,$res['ONm']);
      $rcol=('W'==$res['Res'] ? $WinCol : ('L'==$res['Res'] ? $LoseCol : ('N'==$res['Res'] ? $NDrawCol : $SDrawCol ) ) );
      print "<td align=center class=\"res".$res['Res']."\">".$res['GlF']." - ".$res['GlA'];
      print "<td align=center>".$res['Pts']."\n";
      $Pts=$res['Pts'];
      $ChartData=$ChartData.','.$Pts;
      $Pld=$Pld + 1;
    }
    $ChartMax=$Pts + (0==($Pts % 4) ? 0 : 4-($Pts % 4));
  }

  $GetNext = true;
  if (0<mysql_num_rows($fixlist)) {
    print "<tr class=\"DataHead\"><th colspan=5>Remaining Fixtures\n";
    print "<tr class=\"DataHead\"><th>Date<th>Ven<th align=left>Opposition<th>Pred<th>Points\n";
    while($fix=mysql_fetch_assoc($fixlist)) {
      if ($GetNext) {
          $NextFix = $fix;
          $GetNext=false;
      }
      print "<tr class=\"r".('H'==$fix['Ven'] ? '2' : '1')."\">";
      $c = ($fix['FGD']==$today ? ' class=\"resToday\"' : ($fix['FGD']<$today ? ' class=\"resLate\"' : ''));
      print "<td".$c.">".$fix['GDt'];
      print "<td align=center>".$fix['Ven'];
      print "<td align=left>".team_anchor($fix['OID'] ,$fix['OFN']);
      // ##############
      // predict result
      // ##############
      $formscore = ($fix['TVFm']*2) + $fix['TOFm'] - ($fix['OVFm']*2) - $fix['OOFm'];
      print "\n<!-- Form score = ".$formscore." -->\n";
      $predres = ($formscore > 25 ? 'W' : ($formscore < -25 ? 'L' : 'D'));
      $TGF = ROUND((($fix['TVGP']*2) + $fix['TOGP'] + ($fix['OVLF']*2) + $fix['OOLF']) / 30);
      $TGA = ROUND((($fix['TVLF']*2) + $fix['TOLF'] + ($fix['OVGP']*2) + $fix['OOGP']) / 30);
      print "\n<!-- F-A = ".$TGF." - ".$TGA." -->\n";
      $predres = ('D'==$predres ? (5>$TGF ? 'N' : 'D') : $predres);
      $rcol='res'.$predres;
      print "<td align=center class=\"".$rcol."\">".$predres;
      $Pts = $Pts + ('W'==$predres ? 3 : ('L'==$predres ? 0 : 1));
      print "<td align=center>".$Pts."\n";
    }
  }

  print "</table>\n";

  // Right column  
  print "<td align=center valign=top>\n";

// * * * * * * * * * *  
// Current form table
// * * * * * * * * * *
  print "<table width=\"100%\">\n";
  print "<tr class=\"DataHead\"><th colspan=11><font size=+1>Current Form</font>\n";
  print "<tr class=\"DataHead\"><th><th colspan=7>Last 6 Games<th colspan=3>Factors\n";
  print "<tr class=\"DataHead\"><th>Ven<th>W<th>D<th>L<th>F<th>A<th>+/-<th>Pts<th>Form<th>GPw<th>LkF\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr class=\"r2\" align=center><th>H";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['Frm']."<td>".$frm['GPw']."<td>".$frm['LkF']."\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr class=\"r1\" align=center><th>A";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['Frm']."<td>".$frm['GPw']."<td>".$frm['LkF']."\n";
  $frm=mysql_fetch_assoc($tf);
  print "<tr class=\"r2\" align=center><th>OA";
  print "<td>".$frm['Won']."<td>".$frm['Drn']."<td>".$frm['Lst'];
  print "<td>".$frm['GlF']."<td>".$frm['GlA']."<td>".($frm['GDf']>0 ? '+' : '').$frm['GDf']."<td>".$frm['Pts'];
  print "<td>".$frm['Frm']."<td>".$frm['GPw']."<td>".$frm['LkF']."\n";
  print "</table>\n";

// * * * * * * * * * *  
// Next Game Details
// * * * * * * * * * *
  print "<table width=\"100%\">\n";
  if ($GetNext) {
      print "<tr class=\"DataHead\"><th colspan=11><font size=+1>No more games this season</h3>\n";
  }
  else {
      print "<tr class=\"DataHead\"><th colspan=11><font size=+1>Next Game</font>\n";
      print "<tr class=\"DataHead\"><th colspan=3>";
      print "<th colspan=3>".("A"==$NextFix['Ven'] ? "Home" : "Away");
      print "<th colspan=3>Overall";
      print "<th colspan=2>Prediction\n";
      print "<tr class=\"DataHead\"><th>Date<th>Venue<th>Opposition";
      print "<th>Form<th>Gpw<th>LkF";
      print "<th>Form<th>Gpw<th>LkF";
      print "<th>Result<th>Score\n";
      print "<tr class=r1><td>".$NextFix['GDt'];
      print "<td>".$NextFix['Ven'];
      print "<td>".team_anchor($NextFix['OID'] ,$NextFix['OFN'])."\n";
      print "<td>".$NextFix['OVFm'];
      print "<td>".$NextFix['OVGP'];
      print "<td>".$NextFix['OVLF'];
      print "<td>".$NextFix['OOFm'];
      print "<td>".$NextFix['OOGP'];
      print "<td>".$NextFix['OOLF'];
      print "\n";
      // ##############
      // predict result
      // ##############
      $formscore = ($NextFix['TVFm']*2) + $NextFix['TOFm'] - ($NextFix['OVFm']*2) - $NextFix['OOFm'];
      print "\n<!-- Form score = ".$formscore." -->\n";
      $predres = ($formscore > 25 ? 'W' : ($formscore < -25 ? 'L' : 'D'));
      $TGF = ROUND((($NextFix['TVGP']*2) + $NextFix['TOGP'] + ($NextFix['OVLF']*2) + $NextFix['OOLF']) / 70);
      $TGA = ROUND((($NextFix['TVLF']*2) + $NextFix['TOLF'] + ($NextFix['OVGP']*2) + $NextFix['OOGP']) / 70);
      $predres = ('D'==$predres ? (0==$TGF ? 'N' : 'D') : $predres);
      $rcol='res'.$predres;
      print "<td align=center class=\"".$rcol."\">".$predres;
      print "<td>".$TGF." - ".$TGA."\n";
  }
  print "</table>\n";

// * * * * * * * * * *  
// Points Chart
// * * * * * * * * * *
  print "<table width=\"100%\">\n";
  print "<tr><td align=center><img border='0' ";
  print "src='http://chart.apis.google.com/chart?";
  print "cht=lc";
  print "&chf=bg,s,EFEFEF00|c,lg,90,FF000050,0,00FF0050,1";
  print "&chco=CC6600,FF3333,33CC99,00CC33";
  print "&chls=1|1,2,2|1,2,2|1,2,2";
  print "&chd=t:".$ChartData;

  $topbot=mysql_fetch_assoc($ttb);
  print "|0,".ROUND($topbot['B1'] * $Pld);
  print "|0,".ROUND($topbot['T2'] * $Pld);
  $T1 = ROUND($topbot['T1'] * $Pld);
  print "|0,".$T1;
  
  $ChartMax=($ChartMax > $T1 ? $ChartMax : $T1 + (0==($T1 % 4) ? 0 : 4-($T1 % 4)));

  print "&chds=0,".$ChartMax.",0,".$ChartMax.",0,".$ChartMax.",0,".$ChartMax;
  print "&chg=100,25";
  print "&chs=500x300";
  print "&chxt=x,y,x,y";
  print "&chxl=";
  print "0:|0|";
  $GameIncrement = ceil($Pld / 5);
  for ($i = $GameIncrement;$i < $Pld;print $i."|", $i += $GameIncrement);
  print $Pld."|";
  $tick1=$ChartMax / 4;
  $tick2=$tick1 * 2;
  $tick3=$tick1 * 3;
  print "1:|0|".$tick1;
  print "|".$tick2;
  print "|".$tick3;
  print "|".$ChartMax."|";
  print "2:|Games Played|";
  print "3:|Points|";
  print "&chxp=";
  print "0,0,";
  for ($i = $GameIncrement;$i < $Pld; print round(($i / $Pld) * 100).",", $i += $GameIncrement);
  print "100";
  print "|2,50";
  print "|3,50";
//  print "&chxs=0,<label_color>,<font_size>,<alignment>,<axis_or_tick>,<tick_color>"
  print "&chxs=0,00000080,10,0,lt,00000050";
  print "|2,0000FFCC,12,0,lt,00000050";
  print "|3,0000FFCC,12,0,lt,00000050";
  print "&chxtc=0,-500";
  print "'>\n";
  print "</table>\n";

// * * * * * * * * * * * 
// Season Records Table
// * * * * * * * * * * *
  print "<table class=\"FixRes\">\n";

  print "<tr class=\"DataHead\"><th colspan=3><font size=+1>Season Records</font>\n";
  print "<tr class=\"DataHead\"><th colspan=3>Home\n";
  if (0==mysql_num_rows($hrec)) {
    print "<tr class=\"r1\"><td colspan=3>No Home Games Available.";
  }
  else {
    while($hr=mysql_fetch_assoc($hrec)) {
      print "<tr class=\"r1\"><th>";
      print recordRow($hr['VRs'])."<td align=left>".$hr['ResText']."\n";
    }
  }

  print "<tr class=\"DataHead\"><th colspan=3>Away\n";
  if (0==mysql_num_rows($arec)) {
    print "<tr class=\"r2\"><td colspan=3>No Away Games Available.";
  }
  else {
    while($ar=mysql_fetch_assoc($arec)) {
      print "<tr class=\"r2\"><th>";
      print recordRow($ar['VRs'])."<td align=left>".$ar['ResText']."\n";
    }
  }

  print "<tr class=\"DataHead\"><th colspan=3>Overall\n";
  if (0==mysql_num_rows($orec)) {
    print "<tr class=\"r1\"><td colspan=3>No Games Available.";
  }
  else {
    while($or=mysql_fetch_assoc($orec)) {
      print "<tr class=\"r1\"><th>";
      print recordRow($or['VRs'])."<td align=left>".$or['ResText']."\n";
    }
  }

  print "</table>\n";

}

print "</table>\n";

?>