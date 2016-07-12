<?php

foreach ($_GET as $k => $v) {
  print "<!-- \$_GET element:".$k." is: ".$v." -->\n";
}

/// if no player set, use 999
if ((isset($_GET['playerid'])) && (is_numeric($_GET['playerid']))) {
  $playerid = $_GET['playerid'];
	}
else {
	$playerid = 999;
	}

// if no season set, use current season
if ((isset($_GET['season'])) && (is_numeric($_GET['season']))) {
	$season = $_GET['season'];
}
else {
    $season = date("Y") - (7>date("n") ? 1 : 0);
}

$CSSdir="./CSS/";
$imgdir="./images/";
$incdir="../../LutonBits/includes/";
$qrydir="../../LutonBits/queries/";
$srcdir="/src/";

require_once($incdir.'LTFC_logon.inc');
include($incdir.'functions.php');
include($incdir.'setdefaults.php');

// Establish Squad Image Directory
$sqdir = $imgdir."Squad/".$season."/";

  if ($playerid==999) {
    /* This is the default whole squad stats */
    include($incdir.'squad_info2.php');
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

    print "<div id=\"PlrHdr\" style=\"border-style:outset; background-color:Navy; color:Ivory; text-align:center; padding: 5px;\"><h1>".$pnam."</h1></div>\n";
    print "<div id=\"PlrTot\" style=\"border-style:outset; background-color:SteelBlue; color:Navy; padding:2px; text-align:center; \">\n";
      print "<center><table border=0 cellspacing=1 cellpadding=2>\n";
      print "<tr><th colspan=20>".$season." Totals";
      print "<tr><td rowspan=10><img src=\"".$sqdir.$row['PID']."\",  HEIGHT=\"1".("W"==$wn ? "5" : "0" )."0px\" ALT=\"Picture of ".$row['PNm']."(".$sqdir.$row['PID'].")\"></td>\n";
      if ("W"==$wn) {
        print "<th colspan=3>Squad Number:<th colspan=2>".$row['SNo']."<th colspan=6>Most Common Starting Position:<th colspan=2>".$mcsp;
        print "<tr><th>Competition<th>Pld<br />(Sub)<th>Mins<th>Won<th>Drawn<th>Lost<th>Goals<th>Team<br />GF<th>Team<br />GA<th>Clean<br />Sheets<th>Yellow<br />Cards<th>Red<br />Cards<th>Points\n";
      }
      else {
        print "<th colspan=3>Shirt:<th colspan=2>".$row['SNo']."<th colspan=6>MCSP:<th colspan=2>".$mcsp;
        print "<tr><th>Comp<th>P(S)<th>Mins<th>Won<th>Drn<th>Lst<th>Gls<th>TGF<th>TGA<th>CSh<th>YC<th>RC<th>Pts\n";
      }
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
      print "</table></center>\n";
    print "</div>\n"; // close PlrTot
    print "<div id=\"PlrGames\" style=\"border-style:outset; background-color:Teal; color:Navy; padding:2px; text-align:center; \">\n";

      require($qrydir.'PlayerGames.sql');
      
      print "<center><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>";
      print "<tr><th colspan=14>Games where ".$pnam." was in the Squad";
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
      	print "<td class=lj><a href=\"LTFC2.php?view=2&gameid=".$row['GID']."&season=".$season."\">".$row['Opp']."</a>";
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
      echo '</TABLE></center>';
    print "</div>\n"; // close PlrGames

}
?>
