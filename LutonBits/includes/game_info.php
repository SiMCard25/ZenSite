<?php

if ($_POST['EGD']) {
  include($incdir.'apply_game_edit.php');
}

if ($_POST['EPG']) {
  include($incdir.'apply_game_player_edit.php');
}

if ($_POST['AG']) {
//  print "Game will be added.\n";
  include($incdir.'add_game.php');
}

if ($_POST['DG']) {
//  print "Game will be removed.\n";
  include($incdir.'delete_game.php');
}

$tlogo="LutonTown.gif";
$tname="Luton Town";
$compdate = date('Ymd');

// set kit image directory
$kitimg = $imgdir.'Kit/'.$season.'/';

/* NB: $gmdet  = Basic Game Details       */
/*     $plgam  = Player Game Details      */
/*     $posct  = Position Counts          */
/*     $posdet = Starting Player Details  */
/*     $subdet = Substitute Details       */
require($qrydir."GameDetail.sql");

$row1 = mysql_fetch_assoc($gmdet);

$PicRS = 2;
$PicRS = ($row1['ET_Scr']=='' ? $PicRS : $PicRS+1);
$PicRS = ($row1['Pn_Scr']=='' ? $PicRS : $PicRS+1);

//goal timings
// goals for
if ($row1['GF01']=="") {
	$FTims= "-";
}
else {
	for ($i=1; $i<=10;$i++) {
		$g=($i==10 ? "GF10" : "GF0".$i);
		if ($row1[$g]!="") {
			$FTims .= ($i>1 ? ', '.$row1[$g] : $row1[$g]);
		}
	}
}
// goals against
if ($row1['GA01']=="") {
	$ATims= "-";
}
else {
	for ($i=1; $i<=10;$i++) {
		$g=($i==10 ? "GA10" : "GA0".$i);
		if ($row1[$g]!="") {
			$ATims .= ($i>1 ? ', '.$row1[$g] : $row1[$g]);
		}
	}
}

// Sort out home / away differences...
// Is it away...
if ("A"==$row1['Ven']) {
	$HImg = "\"".$imgdir.$row1['PIC']."\"";
	$HAlt = "\"".$row1['Opp']." Logo\"";
	$HNam = $row1['Opp'];
	$AImg = "\"".$imgdir.$tlogo."\"";
	$AAlt = "\"".$tname." Logo\"";
	$ANam = $tname;
	$FTSc = strrev($row1['FT_Scr']);
	$ETSc = strrev($row1['ET_Scr']);
	$PnSc = strrev($row1['Pn_Scr']);
	$HTim = $ATims;
	$ATim = $FTims;
}
// ...or home?
else  {
	$HImg = "\"".$imgdir.$tlogo."\"";
	$HAlt = "\"".$tname." Logo\"";
	$HNam = $tname;
	$AImg = "\"".$imgdir.$row1['PIC']."\"";
	$AAlt = "\"".$row1['Opp']." Logo\"";
	$ANam = $row1['Opp'];
	$FTSc = $row1['FT_Scr'];
	$ETSc = $row1['ET_Scr'];
	$PnSc = $row1['Pn_Scr'];
	$HTim = $FTims;
	$ATim = $ATims;
}

// set up game scores table
print "<table border=0 cellspacing=1 cellpadding=5>";
print "\n";
print "<tr>";
print "<td ROWSPAN=".$PicRS." valign=top><IMG SRC=".$HImg." WIDTH=100 ALT=".$HAlt.">";
print "\n";
print "<td><h2>".$HNam."</h2>";
print "<td><h2>".$FTSc."</h2>";
print "<td><h2>".$ANam."</h2>";
print "\n";
print "<td ROWSPAN=".$PicRS." valign=top><IMG SRC=".$AImg." WIDTH=100 ALT=".$HAlt.">";
print "\n";
// was there any extra time?
if ($ETSc != '') {
	print "<tr>";
	print "<td><h4>Extra Time:</h4>";
	print "<td><h3>".$ETSc."</h3>";
	print "<td>";
	print "\n";
}
// did it go to penalties?
if ($PnSc != '') {
	print "<tr>";
	print "<td><h4>Penalties:</h4>";
	print "<td><h3>".$PnSc."</h3>";
	print "<td>";
	print "\n";
}
// goal timings
print "<tr>";
print "<td class=rj><h4>".$HTim."</h4>";
print "<td><h4>:</h4>";
print "<td class=lj><h4>".$ATim."</h4>";
print "\n";
print "</table>";
print "\n";
// end of game scores table

print "<hr>";
print "\n";

// game data table
print "<table border=0 cellspacing=3 cellpadding=2>";
print "\n";
print "<tr>";
print "<th align=left>Competition (Round):";
print "<th align=left>Date:";
print "<th align=left>Game Length (Mins):";
print "\n";
print "<tr class=r1>";
print "<td>".$row1['Cmp'];
print "<td>".$row1['GDy'].", ".$row1['GDt'];
print "<td>".$row1['GMn'];
print "\n";
print "</table>";
print "\n";
// end of game data table

print "<hr>";
print "\n";

// put in editable details if edits enabled
if ($_SESSION['LTFCPW'] AND 1==$_SESSION['LTFCPW']) {
  include($incdir.'game_edit.php');
}

// start of player detail table
// enclosing table
print "<table border=0 cellspacing=15 cellpadding=0>";
print "\n";

print "<tr>";
print "<td colspan=2><h2>Squad Details:</h2>";
print "\n";
print "<tr>";
print "<td valign=top>";

if (0<mysql_num_rows($plgam)) {

  // start of player data table
  print "<table border=0 cellspacing=1 cellpadding=2>";
  print "\n";
  print "<tr>";
  print "<th>Pos";
  print "<th>No";
  print "<th class=lj>Name";
  print "<th>Mins";
  print "<th>Goals";
  print "<th>Yellow";
  print "<th>Red";
  print "<th>Points";
  print "\n";
  while ($row2 = mysql_fetch_assoc($plgam)) {
  	$PAnc = "<a href=\"LTFC.php?view=1&playerid=".$row2['PlID']."&season=".$season."\">";
  	print "<tr class=".$row2['PClass'].">";
  	print "<td>".$row2['PTg'];                                      // Position Tag
  	print "<td>".$PAnc.$row2['SNo']."<a>";                          // Squad Number
  	print "<td class=lj>".$PAnc.$row2['PNm']."<a>";                 // Player Name
  	print "<td>".$row2['PMn'];                                      // Minutes played
  	print "<td".(0<$row2['PGl'] ? " class=GS>" : ">").$row2['PGl']; // Goals
  	print "<td".(0<$row2['YCd'] ? " class=YC>" : ">").$row2['YCd']; // Yellow Cards
  	print "<td".(0<$row2['RCd'] ? " class=RC>" : ">").$row2['RCd']; // Red Card
  	print "<td class=rj>".number_format($row2['PPt'],0);            // Player Points
    print "\n";
  }
  print "</table>";
  print "\n";
  // end of player data table
  
  // get the positional LCMs
  $BigPos=0;
  $NumPos=0;
  // how many in each position area?
  while ($row3 = mysql_fetch_assoc($posct)) {
  	$PosCount[$row3['PTp']]=$row3['PCt'];
  	$BigPos=($row3['PCt']>$BigPos ? $row3['PCt'] : $BigPos);
  	$NumPos++;
  }
  // get the lowest common multiple for each position type
  for ($i=1; $i<=20; $i++) {
  	$LCM=$i * $BigPos;
  	$OK=0;
  	foreach ($PosCount as $k => $v) {
  		$OK+=($LCM % $v);
  	}
  	$i=($OK==0 ? 21 : $i);
  }
  
  // colour the cell background
  print "<td class=TL>\n";
  // start of squad layout table
  $secspan=$LCM - 2;
  print "<table border=0 cellspacing=0 cellpadding=0>\n";
  print "<tr><td colspan=".$LCM."><hr>\n";
  print "<tr>\n";
  print "<td><IMG src=\"".$kitimg.$row1['KitPic']."\">\n";
  print "<td colspan=".$secspan."><font size=+2 color=white><b>Starting Formation</font></b>\n";
  print "<td><IMG src=\"".$kitimg.$row1['KitPic']."\">\n";
  print "<tr><td colspan=".$LCM."><hr>\n";
  // starting players
  $curpostype=FALSE;
  while ($row4 = mysql_fetch_assoc($posdet)) { 
  	// was player subbed?
	$sbd=($row4['OfM']<$row4['GMn']);
  	// are we still on the same position type (PTp)?
  	if ($curpostype!=$row4['PTp']) { // no...start new set of position data
  		if (isset($pics)) { // we have data to write
  			print "<tr>\n";
  			foreach($pics as $o) {
  				print $o."\n";
  			}
  		}
  		// clear out, create the arrays and populate the first elements
      $pics=array();

  		$curpostype=$row4['PTp'];
  		$colspan=$LCM / $PosCount[$curpostype];
  	}

	array_push ($pics,playerPicAnc($row4['PlID'], $sqdir.$row4['PicID'],$colspan,$season,$sbd,$row4['YCd']+($row4['RCd']*2)));
  }
  if (isset($pics)) { // we have data to write
  	print "<tr>\n";
  	foreach($pics as $o) {
  		print $o."\n";
  	}
  }
  // subs
  print "<tr><td colspan=".$LCM."><hr>\n";
  print "<tr>\n";
  print "<td><IMG src=\"".$kitimg.$row1['KitPic']."\">\n";
//  print "<tr><td><IMG src=\"".$kitimg."ShirtOrange.gif\" style=\"vertical-align:bottom; align: center;\" />\n";
//  print "<br /><IMG src=\"".$kitimg."ShortBlue.gif\" style=\"vertical-align:top; align: center;\" />\n";
  print "<td colspan=".$secspan."><font size=+1 color=white><b>Substitutes</font></b>\n";
  print "<td><IMG src=\"".$kitimg.$row1['KitPic']."\">\n";
//  print "<td><IMG src=\"".$kitimg."ShirtOrange.gif\" style=\"vertical-align:bottom; align: center;\" />\n";
//  print "<br /><IMG src=\"".$kitimg."ShortBlue.gif\" style=\"vertical-align:top; align: center;\" />\n";
  print "<tr><td colspan=".$LCM."><hr>\n";
  $pics=array();
  $Subs=0;
  while ($row5 = mysql_fetch_assoc($subdet)) {
    // Did the player play?
    $pld=(0<$row5['OnM']);
    // clear out, create the arrays and populate the first elements
    array_push ($pics,playerPicAnc($row5['PlID'], $sqdir.$row5['PicID'],$LCM/5,$season,$pld,$row5['YCd']+($row5['RCd']*2)));
    $Subs++;
  }
  print "<tr>\n";
  $Subs=0;
  foreach($pics as $o) {
    $Subs++;
	if ($Subs==5) { print "<tr>\n"; }
    print $o."\n";
  }
  echo '</font>';
  echo '</table>';
  print "\n";
  }
else {
 print "<td><h3>Squad Details Not Available</h3>\n"; 
}

print "</font></TABLE>\n";

// put in editable details if edits enabled
if ($_SESSION['LTFCPW'] AND 1==$_SESSION['LTFCPW']) {
  print "<hr>\n";
  include($incdir.'game_player_edit.php');
  print "<hr>\n";
}

?>
