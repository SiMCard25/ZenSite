<?php

// Establish Squad Image Directory
$sqdir = $imgdir."Squad/".$season."/";

if ($playerid==999) {
  /* This is the default whole squad stats */
  include($incdir."squad_info.php");
}
else {

    require($qrydir.'MCSP.sql');

    $row = mysql_fetch_assoc($MCSP);
    $mcsp=$row['Tag'];
    $mcsp=($mcsp=="" ? "n/a" : $mcsp);
    
    /* NB: $pldet = Basic Player Details     */
    /*     $pltot = Totals by competition    */
    require($qrydir.'PlayerDetail.sql');

    $row = mysql_fetch_assoc($pldet);
    
    $pnam=$row['PNm'];
            
    print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>";
    print "\n";
//    print "<tr><th ROWSPAN=3><IMG SRC=\"".$sqdir.$row['PID']."\", WIDTH=50 ALT=\"Picture of ".$row['PNm']."\">";
    print "<tr><th colspan=2><IMG SRC=\"".$sqdir.$row['PID']."\", WIDTH=\"320px\" HEIGHT=\"320px\" ALT=\"Picture of ".$row['PNm']."\"><tr>\n";
    print "<th>Name:<th>".$pnam;
    print "<tr><th>Squad Number:<th>".$row['SNo'];
    print "<tr><th>Most Common Starting Position:<th>".$mcsp;
    print "</TABLE>";
    print "\n";
    
    echo '<hr>';
    print "\n";
    
    print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>";
    print "<tr><th colspan=13>".$SeasonFullName[$season]." Totals for ".$pnam;
    print "<tr><th>Competition";
    print "<th>Pld(Sub)";
    print "<th>Mins";
    print "<th>Won";
    print "<th>Drawn";
    print "<th>Lost";
    print "<th>Goals";
    print "<th>Team GF";
    print "<th>Team GA";
    print "<th>Clean Sheets";
    print "<th>Yellow Cards";
    print "<th>Red Cards";
    print "<th>Points";
    print "\n";
    
    $bg="Gainsboro";
    $FGm=0;
    $SGm=0;
    $MPl=0;
    $Won=0;
    $Drn=0;
    $Lst=0;
    $Gls=0;
    $TGF=0;
    $TGA=0;
    $CSh=0;
    $YCd=0;
    $RCd=0;
    $Pts=0;
    
    while ($row = mysql_fetch_assoc($pltot)) {
    	echo '<tr bgcolor="'.$bg.'">';
    	echo '<td>'.$row['CSN'];
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
    	$FGm=$FGm+$row['FGm'];
    	$SGm=$SGm+$row['SGm'];
    	$MPl=$MPl+$row['MPl'];
    	$Won=$Won+$row['Won'];
    	$Drn=$Drn+$row['Drn'];
    	$Lst=$Lst+$row['Lst'];
    	$Gls=$Gls+$row['PGl'];
    	$TGF=$TGF+$row['TGF'];
    	$TGA=$TGA+$row['TGA'];
    	$CSh=$CSh+$row['CSh'];
    	$YCd=$YCd+$row['YCd'];
    	$RCd=$RCd+$row['RCd'];
    	$Pts=$Pts+$row['PPt'];
      $bg=($bg=="Gainsboro" ? "Orange" : "Gainsboro");
     }
    echo '<tr bgcolor="'.$bg.'">';
    echo '<td>Totals';
    echo '<td>'.$FGm.'('.$SGm.')';
    echo '<td>'.number_format($MPl,0);
    echo '<td>'.$Won;
    echo '<td>'.$Drn;
    echo '<td>'.$Lst;
    echo '<td>'.$Gls;
    echo '<td>'.$TGF;
    echo '<td>'.$TGA;
    echo '<td>'.$CSh;
    echo '<td>'.$YCd;
    echo '<td>'.$RCd;
    echo '<td>'.number_format($Pts,0);
    echo '</font>';
    echo '</TABLE>';
    
    echo '<hr>';

    print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>";
    print "<tr><th colspan=13>Totals from 2004/05 Season to date for ".$pnam;
    print "<tr><th>Competition";
    print "<th>Pld(Sub)";
    print "<th>Mins";
    print "<th>Won";
    print "<th>Drawn";
    print "<th>Lost";
    print "<th>Goals";
    print "<th>Team GF";
    print "<th>Team GA";
    print "<th>Clean Sheets";
    print "<th>Yellow Cards";
    print "<th>Red Cards";
    print "<th>Points";
    print "\n";
    
    $bg="Gainsboro";
    $FGm=0;
    $SGm=0;
    $MPl=0;
    $Won=0;
    $Drn=0;
    $Lst=0;
    $Gls=0;
    $TGF=0;
    $TGA=0;
    $CSh=0;
    $YCd=0;
    $RCd=0;
    $Pts=0;
    
    while ($row = mysql_fetch_assoc($plAllTime)) {
    	echo '<tr bgcolor="'.$bg.'">';
    	echo '<td>'.$row['CSN'];
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
    	$FGm=$FGm+$row['FGm'];
    	$SGm=$SGm+$row['SGm'];
    	$MPl=$MPl+$row['MPl'];
    	$Won=$Won+$row['Won'];
    	$Drn=$Drn+$row['Drn'];
    	$Lst=$Lst+$row['Lst'];
    	$Gls=$Gls+$row['PGl'];
    	$TGF=$TGF+$row['TGF'];
    	$TGA=$TGA+$row['TGA'];
    	$CSh=$CSh+$row['CSh'];
    	$YCd=$YCd+$row['YCd'];
    	$RCd=$RCd+$row['RCd'];
    	$Pts=$Pts+$row['PPt'];
      $bg=($bg=="Gainsboro" ? "Orange" : "Gainsboro");
     }
    echo '<tr bgcolor="'.$bg.'">';
    echo '<td>Totals';
    echo '<td>'.$FGm.'('.$SGm.')';
    echo '<td>'.number_format($MPl,0);
    echo '<td>'.$Won;
    echo '<td>'.$Drn;
    echo '<td>'.$Lst;
    echo '<td>'.$Gls;
    echo '<td>'.$TGF;
    echo '<td>'.$TGA;
    echo '<td>'.$CSh;
    echo '<td>'.$YCd;
    echo '<td>'.$RCd;
    echo '<td>'.number_format($Pts,0);
    echo '</font>';
    echo '</TABLE>';
    
    echo '<br><hr><br>';
    
    require($qrydir.'PlayerGames.sql');
    
    print "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>";
    print "<tr><th colspan=14>Games where ".$pnam." was in the Squad (".$SeasonFullName[$season].")";
    print "<tr><th>Day";
    print "<th>Date";
    print "<th>Opposition";
    print "<th>Ven";
    print "<th>Comp";
    print "<th>F-A";
    print "<th>SP";
    print "<th>Mins";
    print "<th>Gls";
    print "<th>TGF";
    print "<th>TGA";
    print "<th>Yel";
    print "<th>Red";
    print "<th>Points";
    
    while ($row = mysql_fetch_assoc($plgam)) {
           if ($row['MPl']==0) {
               $bg="Silver";
              }
           elseif ($row['MPl']<$row['GmL']) {
               $bg="Gainsboro";
              }
           else {
               $bg="White";
              }
    	echo '<tr bgcolor="'.$bg.'">';
    	print "<td><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['GDy']."</a>";
    	print "<td><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['GDt']."</a>";
    	print "<td class=lj><a href=\"LTFC.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['Opp']."</a>";
    	echo '<td>'.$row['Ven'];
    	echo '<td>'.$row['Cmp'];
    	echo '<td bgcolor="'.$row['RsC'].'">'.$row['Scr'];
    	echo '<td>'.$row['SPn'];
    	echo '<td>'.$row['MPl'];
    	$cc=($row['PGl']>0 ? "LimeGreen" : $bg);
            echo '<td bgcolor="'.$cc.'">'.$row['PGl'];
    	echo '<td>'.$row['TGF'];
    	echo '<td>'.$row['TGA'];
    	$cc=($row['YCd']>0 ? "Yellow" : $bg);
            echo '<td bgcolor="'.$cc.'">'.$row['YCd'];
    	$cc=($row['RCd']>0 ? "Red" : $bg);
            echo '<td bgcolor="'.$cc.'">'.$row['RCd'];
    	echo '<td calss=rj>'.number_format($row['PPt'],0);
    	print "\n";
     }
    echo '</font>';
    echo '</TABLE>';
}
?>
