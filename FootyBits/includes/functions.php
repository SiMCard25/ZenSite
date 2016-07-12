<?php

function show_sql_error($SQL ,$SQLError ,$SQLFile) {
	print "<!-- SQL Error in: ".$SQLFile.":\n";
	print "SQL  : ".$SQL."\n";
	print "Error: ".$SQLError."\n";
	print "-->\n";
}

function team_anchor ($TeamID ,$TeamName) {
	GLOBAL $season ,$comp;
	$Ret="<a href=\"".$_SERVER['PHP_SELF']."?season=".$season."&comp=".$comp."&view=3&teamid=".$TeamID."\">".$TeamName."</a>";
	return $Ret;
}

function game_anchor ($GameID ,$FixRes) {
	GLOBAL $season;
	if (1!=$_SESSION['FootyUD']) {
		$Ret=$FixRes;
	}
	else {
		$Ret="<a href=\"".$_SERVER['PHP_SELF']."?season=".$season."&gameid=".$GameID."&view=92\"><font size=-1>".$FixRes."</font></a>";
	}
	return $Ret;
}

function view_menu_item ($ViewID) {

	GLOBAL $view ,$season ,$comp ,$imgdir;

  switch ($ViewID) {
    case 0:  $ViewText = "Fixtures / Results";
             $ViewImage = "FR";
             break;
    case 1:  $ViewText = "League Table";
             $ViewImage = "LT";
             break;
    case 2:  $ViewText = "Form Tables";
             $ViewImage = "FT";
             break;
    case 3:  $ViewText = "Team Details";
             $ViewImage = "TD";
             break;
    case 4:  $ViewText = "Awaited Results";
             $ViewImage = "AR";
             break;
    case 5:  $ViewText = "Predictions";
             $ViewImage = "PD";
             break;
  }

  include($incdir.'menucolors.php');

  $Ret  = "<tr><td align=center>";
  $Ret .= "<a href=\"".$_SERVER['PHP_SELF']."?season=".$season."&comp=".$comp."&view=".$ViewID."\">";
//  $Ret .= <img src=\"".$imgdir.$ViewImage."_menu_".($view==$ViewID ? "selected" : "normal").".gif\" ALT=\"".$ViewText."\"></a>\n";
// No idea how annoying this is - images disabled as I'm naughty... Hmmm...
  $Ret .= $ViewText."</a>\n";

  return $Ret;

}

function find_game ($ArrayToSort ,$SortOrder="A") {

  if ("A"==$SortOrder) { asort($ArrayToSort); }
  else { arsort($ArrayToSort); }

  $i=0;
  foreach ($ArrayToSort as $k => $v) {
  	$g=($i==0 ? $k : $g);
  	$i++;
  }
  
  return $g;

}

function recordRow ($RowLabel) {
  
  $r = "Eh?";
  switch ($RowLabel) {
    case '1B':  $r="Best";
                break;
    case '2W':  $r="Worst";
                break;
    case '3A':  $r="Aggregate";
                break;
  }

  return $r;

}

?>